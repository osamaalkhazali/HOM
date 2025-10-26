<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

class CheckMailConfiguration extends Command
{
  protected $signature = 'mail:check';
  protected $description = 'Check if mail configuration is working correctly';

  public function handle()
  {
    $this->info('Checking mail configuration...');

    $config = [
      'Driver' => config('mail.default'),
      'Host' => config('mail.mailers.smtp.host'),
      'Port' => config('mail.mailers.smtp.port'),
      'Username' => config('mail.mailers.smtp.username'),
      'Encryption' => config('mail.mailers.smtp.encryption'),
      'From Address' => config('mail.from.address'),
      'From Name' => config('mail.from.name'),
    ];

    $this->table(['Configuration', 'Value'], collect($config)->map(fn($value, $key) => [$key, $value])->values());

    $this->newLine();
    $this->info('Testing mail transport...');

    try {
      // Try to get the mailer instance
      $mailer = Mail::mailer();

      // Get the Swift Transport
      $transport = $mailer->getSymfonyTransport();

      $this->info('✓ Mail transport initialized successfully');

      // Test sending (to a test address if provided)
      if ($this->confirm('Do you want to send a test email?', false)) {
        $testEmail = $this->ask('Enter test email address');

        if ($testEmail) {
          Mail::raw('This is a test email from HOM application.', function ($message) use ($testEmail) {
            $message->to($testEmail)
              ->subject('HOM Test Email - ' . now()->format('Y-m-d H:i:s'));
          });

          $this->info('✓ Test email sent successfully to: ' . $testEmail);
        }
      }

      $this->newLine();
      $this->info('✓ Mail configuration is working correctly!');

      return Command::SUCCESS;
    } catch (TransportException $e) {
      $this->error('✗ Mail transport error: ' . $e->getMessage());
      $this->newLine();
      $this->warn('Common issues:');
      $this->line('  - Check MAIL_USERNAME and MAIL_PASSWORD in .env');
      $this->line('  - Verify MAIL_HOST and MAIL_PORT are correct');
      $this->line('  - Ensure MAIL_ENCRYPTION matches server requirements');
      $this->line('  - Check if firewall is blocking the connection');

      return Command::FAILURE;
    } catch (\Throwable $e) {
      $this->error('✗ Unexpected error: ' . $e->getMessage());
      $this->line('  File: ' . $e->getFile());
      $this->line('  Line: ' . $e->getLine());

      return Command::FAILURE;
    }
  }
}
