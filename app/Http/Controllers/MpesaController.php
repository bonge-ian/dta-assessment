<?php

namespace App\Http\Controllers;

use App\Http\Requests\MpesaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{
    public function tokenize()
    {
        return Http::withBasicAuth(env('MPESA_KEY'), env('MPESA_SECRET'))
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate', 'grant_type=client_credentials')
            ->json()['access_token'];
    }

    public function lipa(MpesaRequest $request)
    {
        $time = \now()->tz('Africa/Nairobi')->format('YmdHis');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Host' => 'sandbox.safaricom.co.ke'
        ])
            ->withToken($this->tokenize())
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                "BusinessShortCode" => \env('MPESA_CODE'),
                "Password" => $this->hash(\env('MPESA_CODE'), \env('MPESA_PASSKEY'), $time),
                "Timestamp" => $time,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $request->input('amount'),
                "PartyA" => $request->input('mchwa'),
                "PartyB" => env('MPESA_CODE'),
                "PhoneNumber" => $request->input('mchwa'),
                "CallBackURL" => "https://bonge.co.ke/mpesa/callback",
                "AccountReference" => "account",
                "TransactionDesc" => "test",
            ])->json();

        if (\array_key_exists('ResponseCode', $response) && $response['ResponseCode'] == 0) {
            // success

           return \back()->with('success', 'Request is being processed');
        }

        return \back()->with('error', 'There was an error processing');
    }

    public function callback()
    {
        Storage::exists('mpesalogs.txt')
            ? Storage::prepend('mpesalogs.txt', \json_encode(file_get_contents('php://input')))
            : Storage::put('mpesalogs.txt', \json_encode(file_get_contents('php://input')));

        return response()->json(["C2BPaymentConfirmationResult" => "Success"]);
    }

    protected function hash($code, $passkey, $time)
    {
        return \base64_encode(
            \sprintf('%s%s%s', $code, $passkey, $time)
        );
    }
}
