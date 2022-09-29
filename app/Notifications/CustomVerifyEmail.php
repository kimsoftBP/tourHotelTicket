<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

use Carbon\Carbon;
use Config;
//use Carbon;
use Lang;

class CustomVerifyEmail extends  VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable );//http://localhost:828/email/verify/42/0b5f4bbcd09e1ac5277ef51c60f38317ad44f787?expires=1627575092&signature=b27f13a6099046a9448c390c3dd668dab61c91221bd2ef36724856c66c4e8bda
        //$verificationUrl="";

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(__('messages.Verify Your Email Address') )
            //->subject(Lang::get('Verify Your Email Address') )
            ->line(__('messages.Please click the button below to verify your email address.'))
            //->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(__('messages.Verify Email Address'), $verificationUrl)
            //->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(__('messages.If you did not create an account, no further action is required.'));
            //->line(Lang::get('If you did not create an account, no further action is required.'));

            //->salutation(config('app.name'))

    }


    protected function verificationUrl($notifiable)
    {/*
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }*/

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
                'locale'=>app()->getLocale(),
            ]
        );
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
