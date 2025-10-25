<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected const USER_MAIL_STATUSES = [
        'pending',
        'shortlisted',
        'documents_requested',
        'rejected',
        'hired',
    ];

    protected const ADMIN_MAIL_STATUSES = [
        'pending',
        'documents_submitted',
    ];

    public function __construct(
        protected Application $application,
        protected string $status,
        protected string $audience = 'user'
    ) {
        $this->audience = $audience === 'admin' ? 'admin' : 'user';
    }

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($this->shouldSendMail($notifiable)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    protected function shouldSendMail(object $notifiable): bool
    {
        if (!method_exists($notifiable, 'routeNotificationForMail') && empty($notifiable->email)) {
            return false;
        }

        if ($this->audience === 'user') {
            return in_array($this->status, self::USER_MAIL_STATUSES, true);
        }

        if ($this->audience === 'admin') {
            return in_array($this->status, self::ADMIN_MAIL_STATUSES, true);
        }

        return false;
    }

    protected function resolveMailLocale(object $notifiable): string
    {
        if ($this->audience === 'admin') {
            return 'en';
        }

        $available = config('app.available_locales', [config('app.locale', 'en')]);
        $preferred = $notifiable->preferred_language ?? null;

        if ($preferred && in_array($preferred, $available, true)) {
            return $preferred;
        }

        return config('app.locale', 'en');
    }

    protected function contextForLocale(string $locale): array
    {
        $job = optional($this->application->job);
        $user = optional($this->application->user);

        $deletedJob = trans('site.notifications_center.applications.common.deleted_job', [], $locale);
        $deletedUser = trans('site.notifications_center.applications.common.deleted_user', [], $locale);

        $jobTitle = $locale === 'ar'
            ? ($job->title_ar ?: $job->title ?: $deletedJob)
            : ($job->title ?: $job->title_ar ?: $deletedJob);

        $applicantName = $user->name ?: $deletedUser;

        $statusKey = 'site.application_statuses.' . $this->status;
        $statusLabel = trans($statusKey, [], $locale);
        if ($statusLabel === $statusKey) {
            $statusLabel = Str::headline(str_replace('_', ' ', $this->status));
        }

        return [
            'job_title' => $jobTitle,
            'applicant_name' => $applicantName,
            'status_label' => $statusLabel,
        ];
    }

    protected function resolveCopy(): array
    {
        $contextEn = $this->contextForLocale('en');
        $contextAr = $this->contextForLocale('ar');

        $keyBase = "site.notifications_center.applications.{$this->audience}.{$this->status}";
        $titleKey = $keyBase . '.title';
        $messageKey = $keyBase . '.message';

        $titleEn = trans($titleKey, [
            'job' => $contextEn['job_title'],
            'applicant' => $contextEn['applicant_name'],
            'status' => $contextEn['status_label'],
        ], 'en');

        if ($titleEn === $titleKey) {
            $titleEn = trans('site.notifications_center.applications.common.fallback_title', [
                'status' => $contextEn['status_label'],
                'job' => $contextEn['job_title'],
            ], 'en');
        }

        $titleAr = trans($titleKey, [
            'job' => $contextAr['job_title'],
            'applicant' => $contextAr['applicant_name'],
            'status' => $contextAr['status_label'],
        ], 'ar');

        if ($titleAr === $titleKey) {
            $titleAr = trans('site.notifications_center.applications.common.fallback_title', [
                'status' => $contextAr['status_label'],
                'job' => $contextAr['job_title'],
            ], 'ar');
        }

        $messageEn = trans($messageKey, [
            'job' => $contextEn['job_title'],
            'applicant' => $contextEn['applicant_name'],
            'status' => $contextEn['status_label'],
        ], 'en');

        if ($messageEn === $messageKey) {
            $messageEn = trans('site.notifications_center.applications.common.fallback_message', [
                'status' => $contextEn['status_label'],
                'job' => $contextEn['job_title'],
                'applicant' => $contextEn['applicant_name'],
            ], 'en');
        }

        $messageAr = trans($messageKey, [
            'job' => $contextAr['job_title'],
            'applicant' => $contextAr['applicant_name'],
            'status' => $contextAr['status_label'],
        ], 'ar');

        if ($messageAr === $messageKey) {
            $messageAr = trans('site.notifications_center.applications.common.fallback_message', [
                'status' => $contextAr['status_label'],
                'job' => $contextAr['job_title'],
                'applicant' => $contextAr['applicant_name'],
            ], 'ar');
        }

        return [
            'title_en' => $titleEn,
            'title_ar' => $titleAr,
            'message_en' => $messageEn,
            'message_ar' => $messageAr,
            'title' => $titleEn,
            'message' => $messageEn,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $locale = $this->resolveMailLocale($notifiable);
        $brand = config('app.name', 'HOM');
        $context = $this->contextForLocale($locale);

        $segment = $this->audience === 'admin' ? 'admin' : 'user';
        $baseKey = "emails.applications.{$segment}.{$this->status}";

        $replacements = [
            'job' => $context['job_title'],
            'applicant' => $context['applicant_name'],
            'status' => $this->status,
            'status_label' => $context['status_label'],
            'brand' => $brand,
        ];

        $subject = Lang::get("{$baseKey}.subject", $replacements, $locale);
        if ($subject === "{$baseKey}.subject") {
            $subject = Lang::get('emails.common.subject_fallback', $replacements, $locale);
        }

        $preheader = Lang::get("{$baseKey}.preheader", $replacements, $locale);
        if ($preheader === "{$baseKey}.preheader") {
            $preheader = Lang::get('emails.common.preheader_fallback', $replacements, $locale);
        }

        $intro = Lang::get("{$baseKey}.intro", $replacements, $locale);
        if ($intro === "{$baseKey}.intro") {
            $intro = '';
        }

        $lines = Lang::get("{$baseKey}.lines", $replacements, $locale);
        if (!is_array($lines)) {
            $lines = $lines === "{$baseKey}.lines" ? [] : [$lines];
        }
        $lines = array_values(array_filter($lines, fn($line) => (string) $line !== ''));

        $actionText = Lang::get("{$baseKey}.action", $replacements, $locale);
        if ($actionText === "{$baseKey}.action" || trim($actionText) === '') {
            $actionText = null;
        }

        $actionUrl = $actionText ? $this->resolveActionUrl() : null;

        $support = Lang::get("{$baseKey}.support", $replacements, $locale);
        if ($support === "{$baseKey}.support") {
            $support = '';
        }

        $name = $notifiable->name
            ?? Lang::get('emails.auth.common.fallback_name', [], $locale);

        $greeting = Lang::get('emails.auth.common.greeting', ['name' => $name], $locale);
        if ($greeting === 'emails.auth.common.greeting') {
            $greeting = 'Hello,';
        }

        $buttonFallback = $actionText && $actionUrl
            ? Lang::get('emails.auth.common.button_fallback', ['button' => $actionText], $locale)
            : '';

        $signature = Lang::get('emails.auth.common.signature', [], $locale);
        if ($signature === 'emails.auth.common.signature') {
            $signature = 'Kind regards,';
        }

        $team = Lang::get('emails.auth.common.team', ['app' => $brand], $locale);
        if ($team === 'emails.auth.common.team') {
            $team = $brand . ' Team';
        }

        $footer = Lang::get('emails.auth.common.footer', [
            'year' => date('Y'),
            'app' => $brand,
        ], $locale);
        if ($footer === 'emails.auth.common.footer') {
            $footer = '© ' . date('Y') . ' ' . $brand . '. All rights reserved.';
        }

        $data = [
            'subject' => $subject,
            'preheader' => $preheader,
            'greeting' => $greeting,
            'intro' => $intro,
            'lines' => $lines,
            'actionText' => $actionText,
            'actionUrl' => $actionUrl,
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
            ->view('emails.applications.status', $data)
            ->text('emails.applications.status_plain', $data);
    }

    protected function resolveActionUrl(): string
    {
        $path = $this->audience === 'admin'
            ? route('admin.applications.show', $this->application, false)
            : route('applications.index', [], false);

        return $this->makeFrontendUrl($path);
    }

    protected function makeFrontendUrl(?string $path = null): string
    {
        $base = rtrim(config('app.frontend_url', 'https://www.hom-intl.com'), '/');
        $normalizedPath = $path ? '/' . ltrim($path, '/') : '';

        return $base . $normalizedPath;
    }

    public function toArray(object $notifiable): array
    {
        $copy = $this->resolveCopy();

        return [
            'title_en' => $copy['title_en'],
            'title_ar' => $copy['title_ar'],
            'message_en' => $copy['message_en'],
            'message_ar' => $copy['message_ar'],
            'title' => $copy['title'],
            'message' => $copy['message'],
            'status' => $this->status,
            'audience' => $this->audience,
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => optional($this->application->job)->title,
            'applicant_name' => optional($this->application->user)->name,
            'link' => $this->audience === 'admin'
                ? route('admin.applications.show', $this->application)
                : route('applications.index'),
            'created_at' => now()->toISOString(),
        ];
    }
}
