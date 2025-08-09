<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class SysServices
{
    public static function sendSMS($phone, $message){

        $baseUrl = 'https://mshastra.com/sendurl.aspx';
        $query = [
            'user'       => 'ZOESOMA',
            'pwd'        => 'zoe@1909',
            // 'senderid'   => 'Mobishastra',
            'senderid'   => 'ZoesomaLtd',
            'mobileno'   => $phone,
            'msgtext'    => $message,
            'CountryCode'=> '+255',
        ];

        // disable SSL verification if needed (equivalent to curl -k)
        $response = Http::withOptions(['verify' => false])
                        ->get($baseUrl, $query);

        if ($response->successful()) {
            return 'SMS sent: ' . $response->body();
            dd($response->body());
        }

        return 'Error: ' . $response->status() . ' - ' . $response->body();
    }
}
