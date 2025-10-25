<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class LocalizedVerifyEmail extends VerifyEmail
{
    use Queueable;

    /**
     * Hold the notifiable instance for use inside buildMailMessage.
     */
    protected $notifiableContext;

    /**
     * Store the notifiable for later use.
     */
    public function toMail($notifiable)
    {
        $this->notifiableContext = $notifiable;

        return parent::toMail($notifiable);
    }

    /**
     * Build the mail representation of the notification.
     */
    protected function buildMailMessage($url)
    {
        $notifiable = $this->notifiableContext;
        $preferred = $notifiable?->preferred_language;
        $locale = $this->locale ?? $preferred ?? app()->getLocale();

        $brand = config('app.name', 'HOM');
        $name = $notifiable?->name ?: Lang::get('emails.auth.common.fallback_name', locale: $locale);

        $subject = Lang::get('emails.auth.verify.subject', ['app' => $brand], $locale);
        $preheader = Lang::get('emails.auth.verify.preheader', ['app' => $brand], $locale);
        $greeting = Lang::get('emails.auth.common.greeting', ['name' => $name], $locale);
        $intro = Lang::get('emails.auth.verify.intro', ['app' => $brand], $locale);
        $actionText = Lang::get('emails.auth.verify.action', locale: $locale);
        $support = Lang::get('emails.auth.verify.support', locale: $locale);
        $buttonFallback = Lang::get('emails.auth.common.button_fallback', ['button' => $actionText], $locale);
        $signature = Lang::get('emails.auth.common.signature', locale: $locale);
        $team = Lang::get('emails.auth.common.team', ['app' => $brand], $locale);
        $footer = Lang::get('emails.auth.common.footer', ['year' => date('Y'), 'app' => $brand], $locale);

        $data = [
            'subject' => $subject,
            'preheader' => $preheader,
            'greeting' => $greeting,
            'intro' => $intro,
            'actionText' => $actionText,
            'actionUrl' => $url,
            'support' => $support,
            'buttonFallback' => $buttonFallback,
            'signature' => $signature,
            'team' => $team,
            'footer' => $footer,
            'brand' => $brand,
            'logoUrl' => asset('assets/images/HOM-logo.png'),
            'primaryColor' => '#18458f',
            'locale' => $locale,
        ];

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.auth.verify', $data)
            ->text('emails.auth.verify_plain', $data);
    }
}
