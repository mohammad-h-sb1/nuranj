<?php

namespace App\Notifications;


use App\Notifications\channels\GhasedakChannels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginUserNotification extends Notification
{
    use Queueable;

    public $code;
    public $mobile;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code,$mobile)
    {
        $this->code=$code;
        $this->mobile =$mobile;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [GhasedakChannels::class];
    }

    public function toGhasedakSms($notifiable)
    {
        return [
            'text'=>"کد رود{$this->code} \nوب سایت نارنج",
            'number'=>$this->mobile,
        ];

    }

}
