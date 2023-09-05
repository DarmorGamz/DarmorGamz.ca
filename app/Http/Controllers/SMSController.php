<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use AWS;
class SMSController extends Controller {
     public static function sendSMS($message) {
        if (empty($message)) return;
        $sms = AWS::createClient('sns');

        for($i=0; $i<20; $i++) {
            $sms->publish([
                'Message' => $message,
                'PhoneNumber' => "+12267475331",
//                'PhoneNumber' => "+15196359586",
            ]);
        }

    }
}
