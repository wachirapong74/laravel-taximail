<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Taximail;
use Config;

class TestController extends Controller
{
    public function sendMail()
    {
        // get taximail session id
        $taximailAuth = Taximail::authen();
        $message_id = Taximail::generateMessageId();
        $subject = 'Test Send Email from Taximail';
        $toName = 'aaa bbb';
        $email = 'biw@i3gateway.com';
        $fileAttachments = [];

        $mailData = [];
        $mailData['session_id'] = $taximailAuth->session_id;
        $mailData['message_id'] = $message_id;
        $mailData['transactional_group_name'] = Config::get('constants.TAXIMAIL.TRANSACTIONAL_GROUP_NAME');
        $mailData['subject'] = $subject;
        $mailData['to_name'] = $toName;
        $mailData['to_email'] = $email;
        $mailData['from_name'] = Config::get('constants.TAXIMAIL.FROM_NAME');
        $mailData['from_email'] = Config::get('constants.TAXIMAIL.FROM_EMAIL');
        $mailData['content_html'] = view('email')->render();

        // dd($mailData);
        $resultMail = Taximail::sendTransactionalEmail($mailData);

        if (isset($resultMail->status) && $resultMail->status == 'success') 
        {
            echo 'Email has been Sent';
        } 

        dd($resultMail);
    }
}
