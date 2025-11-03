<?php

namespace App\Notifications;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAccountCreated extends Notification
{
    use Queueable;

    protected string $password;
    protected string $loginUrl;

    public function __construct(
        protected Admin $admin,
        string $password
    ) {
        $this->password = $password;
        $this->loginUrl = route('admin.login');
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $brand = config('app.name', 'HOM');
        $roleLabel = match($this->admin->role) {
            'super' => 'Super Admin',
            'client_hr' => 'Client HR',
            default => 'Admin',
        };

        return (new MailMessage)
            ->subject("Your {$roleLabel} Account Has Been Created")
            ->greeting("Hello {$this->admin->name},")
            ->line("Your {$roleLabel} account has been created for {$brand}.")
            ->line("Here are your login credentials:")
            ->line("**Email:** {$this->admin->email}")
            ->line("**Password:** {$this->password}")
            ->line("**Role:** {$roleLabel}")
            ->when($this->admin->isClientHr() && $this->admin->client, function($mail) {
                return $mail->line("**Client:** {$this->admin->client->name}");
            })
            ->action('Login to Admin Panel', $this->loginUrl)
            ->line('For security reasons, we recommend changing your password after your first login.')
            ->line('If you have any questions or need assistance, please contact the system administrator.')
            ->salutation("Best regards,\n{$brand} Team");
    }

    public function toArray(object $notifiable): array
    {
        $roleLabel = match($this->admin->role) {
            'super' => 'Super Admin',
            'client_hr' => 'Client HR',
            default => 'Admin',
        };

        return [
            'title_en' => "Your {$roleLabel} Account Has Been Created",
            'title_ar' => "تم إنشاء حساب {$roleLabel} الخاص بك",
            'message_en' => "Your login credentials have been sent to your email address.",
            'message_ar' => "تم إرسال بيانات تسجيل الدخول إلى عنوان بريدك الإلكتروني.",
            'title' => "Your {$roleLabel} Account Has Been Created",
            'message' => "Your login credentials have been sent to your email address.",
            'admin_id' => $this->admin->id,
            'role' => $this->admin->role,
            'client_id' => $this->admin->client_id,
            'link' => route('admin.login'),
            'created_at' => now()->toISOString(),
        ];
    }
}
