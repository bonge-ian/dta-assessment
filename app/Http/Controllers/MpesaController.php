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
                "TransactionType" => "CustomerPayBillOnline ",
                "Amount" => $request->input('amount'),
                "PartyA" => $request->input('mchwa'),
                "PartyB" => "174379",
                "PhoneNumber" => $request->input('mchwa'),
                "CallBackURL" => "https://bonge.co.ke/mpesa/confirm",
                "AccountReference" => "account",
                "TransactionDesc" => "test",
            ])->json();

        if (\array_keys('ResponseCode', $response) && $response['ResponseCode'] == 0) {
            // success
           return \back('success', 'Request is being processed');
        }
        return \back('error', 'There was an error processing');
    }

    public function confirm(Request $request)
    {
        Storage::exists('mpesalogs.txt')
            ? Storage::prepend('mpesalogs.txt', $request->json())
            : Storage::put('mpesalogs.txt', $request->json());

        return response()->json(["C2BPaymentConfirmationResult" => "Success"]);
    }

    public function register()
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])
            ->withToken($this->tokenize())
            ->post('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl', [
                'ShortCode' => "600610",
                'ResponseType' => 'Completed',
                'ConfirmationURL' => "http://aab3612595b5.ngrok.io/api/transaction/confirm",
                'ValidationURL' => "http://aab3612595b5.ngrok.io/api/url/validate"
            ])->json();
    }

    public function validation(Request $request)
    {
        return $this->createValidResponse(0, 'Accepted validation request');
    }

    protected function createValidResponse($code, $description)
    {
        return response()->json([
            'ResultCode' => $code,
            'ResultDesc' => $description
        ]);
    }

    protected function hash($code, $passkey, $time)
    {
        return \base64_encode(
            \sprintf('%s%s%s', $code, $passkey, $time)
        );
    }
}
