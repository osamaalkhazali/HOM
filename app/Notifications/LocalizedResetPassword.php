<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class LocalizedResetPassword extends ResetPassword
{
  use Queueable;

  /**
   * Hold the notifiable instance for use inside buildMailMessage.
   */
  protected $notifiableContext;

  /**
   * Store the notifiable before building the mail message.
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

    $subject = Lang::get('emails.auth.reset.subject', ['app' => $brand], $locale);
    $preheader = Lang::get('emails.auth.reset.preheader', ['app' => $brand], $locale);
    $greeting = Lang::get('emails.auth.common.greeting', ['name' => $name], $locale);
    $intro = Lang::get('emails.auth.reset.intro', locale: $locale);
    $actionText = Lang::get('emails.auth.reset.action', locale: $locale);
    $expires = Lang::get('emails.auth.reset.expires', ['count' => $this->linkExpirationMinutes()], $locale);
    $support = Lang::get('emails.auth.reset.support', locale: $locale);
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
      'expires' => $expires,
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
      ->view('emails.auth.reset', $data)
      ->text('emails.auth.reset_plain', $data);
  }

  protected function linkExpirationMinutes(): int
  {
    $broker = config('auth.defaults.passwords');

    return (int) config("auth.passwords.$broker.expire", 60);
  }
}
