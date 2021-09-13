<?php

namespace App\Notifications\channels;
use Ghasedak\Exceptions\ApiException;
use Illuminate\Notifications\Notification;
use \Ghasedak\Exceptions\HttpException;

class GhasedakChannels
{

    public function send($notifiable ,Notification $notification)
    {
        if (! method_exists($notification,'toGhasedakSms')){
            throw new \Exception('toGhasedakSms not found');
        }

        $data=$notification->toGhasedakSms($notifiable);
        $message=$data['text'];
        $receptor=$data['number'];
        $apikey=config('services.ghasedak.key');
        try
        {
            $lineNumber = "10008566";
            $api = new \Ghasedak\GhasedakApi($apikey);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(ApiException $e){
            throw $e;
        }
        catch(HttpException $e){
            throw $e->errorMessage();
        }

    }
}
