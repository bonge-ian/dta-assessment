<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SMSController extends Controller
{
    public function sendOne(SMSRequest $request)
    {
        if (!$this->send($request->only('message', 'number'))) {
            return back()->with('error', 'Sorry. We could not process this request');
        }

        return back()->with('success', 'A message has been successfully sent to ' . $request->get('number'));

    }

    public function sendMany(Request $request)
    {
        $data = $request->validate([
            'numbers' => 'required',
            'messages' => 'required|max:140'
        ]);

        $numbers = explode(',', $request->input('numbers'));

        foreach ($numbers as $number) {
            if (!verifySafaricomPhoneNo($number)) {
                return back()->with('error', 'One of the numbers entered is not a safaricom number');
            }
        }

        $data['number'] = implode(', ', $numbers);
        $data['message'] = $data['messages'];
        Arr::forget($data,'data.numbers');
        Arr::forget($data, 'data.messages');

        if (!$this->send($data)) {
            return back()->with('error', 'Sorry. We could not process this request');
        }

        return back()->with('success', 'A message has been successfully sent');
    }

    protected function send($data)
    {
        $response = Http::post('https://sms.textsms.co.ke/api/services/sendsms/', [
            'apikey' => env('STRAT_KEY'),
            'partnerID' => env('STRAT_PARTNERID'),
            'shortcode' => env('STRAT_CODE'),
            'mobile' => $data['number'],
            'message' => $data['message'],
        ]);

        Storage::exists('smslogs.txt')
            ? Storage::prepend('smslogs.txt', $response->body())
            : Storage::put('smslogs.txt', $response->body());

        return (array_key_exists('responses', $response->json()));
    }


}
