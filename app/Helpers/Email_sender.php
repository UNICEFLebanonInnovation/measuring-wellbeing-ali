<?php

namespace App\Helpers;

use Config;
use Mail;

class Email_sender
{

    /*CONNECT WEB*/

    public static function sendEmail($view = null, $settings = null)
    {
        if (!empty($settings) && $view != null) {
            $sent = Mail::send($view, $settings, function ($message) use ($settings) {
                $message->from($settings['from'], $settings['sender']);
                $message->to($settings['to'], $settings['receiver'])->subject($settings['subject']);
            });

            /*$sent_to_admin = Mail::send($view, $settings, function ($message) use ($settings) {
                $message->from($settings['from'], $settings['sender']);
                $message->to('test1.cosmonautgroup@gmail.com', 'Connect')->subject($settings['subject']);
            });*/
        }
    }


    public static function sendAccountVerification($data = null)
    {
        if ($data != null)
        {
            $settings                 = [];
            $settings['data']         = $data;
            $settings["subject"]      = "Connect - Account Verification";
            $settings['emailType']    = 'Connect - Account Verification';
            $settings['from']         = "test.cosmonautgroup@gmail.com";
            $settings['to']           = $data['receiver_email'];
            $settings['sender']       = 'Connect';
            $settings['receiver']     = $data['user_name'];
            $settings['txtBody']      = view('emails.verification', $settings)->render();
            unset($settings['txtBody']);
            Self::sendEmail('emails.verification', $settings);
        }
    }


    public static function sendForgotPasswordEmail($data = null)
    {
        if ($data != null) {
            $settings                 = [];
            $settings['data']         = $data;
            $settings["subject"]      = env('APP_NAME', 'Leb Statistics')." - Forgot Password";
            $settings['emailType']    = env('APP_NAME', 'Leb Statistics')." - Forgot Password";
            $settings['from']         = "test.cosmonautgroup@gmail.com";
            $settings['to']           = $data['email'];
            $settings['sender']       = env('APP_NAME', 'Leb Statistics');
            $settings['receiver']     = $data['user_name'];
            $settings['txtBody']      = view('emails.forgot_password', $settings)->render();
            unset($settings['txtBody']);
            Self::sendEmail('emails.forgot_password', $settings);
        }
    }

    public static function sendSetupProfileEmail($data = null)
    {
        if ($data != null) {
            $settings                 = [];
            $settings['data']         = $data;
            $settings["subject"]      = env('APP_NAME', 'Leb Statistics')." - Invitation To Setup Profile";
            $settings['emailType']    = env('APP_NAME', 'Leb Statistics')." - Invitation To Setup Profile";
            $settings['from']         = "test.cosmonautgroup@gmail.com";
            $settings['to']           = $data['receiver_email'];
            $settings['sender']       = env('APP_NAME', 'Leb Statistics');
            $settings['receiver']     = $data['user_name'];
            $settings['txtBody']      = view('emails.setup_profile', $settings)->render();
            unset($settings['txtBody']);
            Self::sendEmail('emails.setup_profile', $settings);
        }
    }

    public static function sendLimitReachedEmail($data = null)
    {
        if ($data != null) {
            $settings                 = [];
            $settings['data']         = $data;
            $settings["subject"]      = env('APP_NAME', 'Leb Statistics')." - Max Application Limit Reached";
            $settings['emailType']    = env('APP_NAME', 'Leb Statistics')." - Max Application Limit Reached";
            $settings['from']         = "test.cosmonautgroup@gmail.com";
            $settings['to']           = $data['email'];
            $settings['sender']       = env('APP_NAME', 'Leb Statistics');
            $settings['receiver']     = $data['user_name'];
            $settings['txtBody']      = view('emails.limit', $settings)->render();
            unset($settings['txtBody']);
            Self::sendEmail('emails.limit', $settings);
        }
    }

    /*END CONNECT WEB*/

}
