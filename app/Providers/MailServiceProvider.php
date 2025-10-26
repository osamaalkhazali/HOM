<?php

namespace App\Providers;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Exception\TransportException;

class MailServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Log when emails are about to be sent
    Event::listen(MessageSending::class, function (MessageSending $event) {
      if (config('app.debug')) {
        Log::info('Attempting to send email', [
          'subject' => $event->message->getSubject(),
          'to' => collect($event->message->getTo())->map(fn($addr) => $addr->getAddress())->toArray(),
        ]);
      }
    });

    // Log successful email sends
    Event::listen(MessageSent::class, function (MessageSent $event) {
      Log::info('Email sent successfully', [
        'subject' => $event->message->getSubject(),
        'to' => collect($event->message->getTo())->map(fn($addr) => $addr->getAddress())->toArray(),
      ]);
    });

    // Handle mail transport exceptions globally
    $this->app->singleton('mail.transport.error_handler', function () {
      return function (TransportException $e) {
        Log::error('Mail transport exception caught', [
          'message' => $e->getMessage(),
          'code' => $e->getCode(),
          'debug' => $e->getDebug(),
        ]);

        // Don't throw the exception - log it and continue
        return false;
      };
    });
  }
}
