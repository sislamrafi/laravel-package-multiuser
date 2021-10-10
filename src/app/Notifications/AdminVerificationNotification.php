<?php

namespace Sislamrafi\Multiuser\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public static $createUrlCallback;
    public static $toMailCallback;

    public function __construct($pass)
    {
        //
        $this->token = $pass;
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
        $verifyUrl = URL::temporarySignedRoute(
            'multiuser.verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey() , 
            'hash' => sha1($notifiable->getEmailForVerification()), ],
            
        );
        return (new MailMessage)
        ->line('You are receiving this email because we received registration request for your account.')
        ->action('Verify Email', $verifyUrl)
        ->line('If you did not register, no further action is required.');
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
