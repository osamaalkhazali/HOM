<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.password.reset', ['token' => $this->token, 'email' => $notifiable->email]);
        $brand = config('app.name', 'HOM');
        $expireMinutes = config('auth.passwords.admins.expire');

        return (new MailMessage)
            ->subject("Reset Your Admin Password - {$brand}")
            ->greeting("Hello {$notifiable->name},")
            ->line('You are receiving this email because we received a password reset request for your admin account.')
            ->action('Reset Password', $url)
            ->line("This password reset link will expire in {$expireMinutes} minutes.")
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation("Best regards,\n{$brand} Team");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
