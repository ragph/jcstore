<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Log;
use Request;
class TwoFactorCode extends Notification
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
        // Log::debug($notifiable);
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->username . ',')
            ->subject('Two factor authentication')
            ->line('It looks like you tried to sign in.')
            ->line('Date: ' . date("F d, Y H:i A"))
            ->line('Account: ' . $notifiable->email)
            ->line('IP Address: ' . Request::ip())
            ->line('Your two factor code is ' . $notifiable->two_factor_code)
            ->action('Verify Here', route('verify.index', ['code' => $notifiable->two_factor_code]))
            ->line('The code will expire in 10 minutes')
            ->line('If you have not tried to login, ignore this message.');
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
