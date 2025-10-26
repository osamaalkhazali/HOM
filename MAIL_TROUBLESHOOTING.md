# Mail Configuration Troubleshooting Guide

## Overview

The HOM application has been configured to continue functioning even when email services are unavailable or misconfigured. All critical user actions (registration, applications, etc.) will complete successfully, with notifications stored in the database for in-app viewing.

## Mail Error Handling Features

### 1. **Graceful Degradation**

-   ✅ Registration continues even if verification email fails
-   ✅ Applications are saved even if status emails fail
-   ✅ Database notifications are always created
-   ✅ Users can view notifications in-app regardless of email status

### 2. **Comprehensive Error Logging**

All mail errors are logged with full context:

-   Error message and code
-   User information
-   Request details
-   Stack trace

Check logs at: `storage/logs/laravel.log`

### 3. **Mail Configuration Check Command**

Test your mail setup:

```bash
php artisan mail:check
```

This will:

-   Display current mail configuration
-   Test SMTP connection
-   Optionally send a test email

## Common Mail Issues & Solutions

### Issue 1: SMTP Authentication Error (535)

**Error Message:**

```
Expected response code "235" but got code "535"
Message: "535 Incorrect authentication data"
```

**Solutions:**

1. **Verify credentials in `.env`:**

    ```env
    MAIL_USERNAME=hr@hom-intl.com
    MAIL_PASSWORD=your-actual-password
    ```

2. **Check if using App Password (Gmail, Outlook):**

    - Gmail: Enable 2FA and create an App Password
    - Outlook: Create an App Password in account security settings

3. **Verify account is not locked:**
    - Too many failed login attempts may lock the account
    - Contact your email provider

### Issue 2: Connection Timeout

**Solutions:**

1. **Check firewall/antivirus:**

    - Allow outbound connections on SMTP ports
    - Ports: 587 (TLS), 465 (SSL), 25 (plain)

2. **Verify SMTP host and port:**

    ```env
    MAIL_HOST=smtp.office365.com
    MAIL_PORT=587
    MAIL_ENCRYPTION=tls
    ```

3. **Test from command line:**
    ```bash
    telnet smtp.office365.com 587
    ```

### Issue 3: SSL/TLS Certificate Error

**Solutions:**

1. **Verify encryption setting matches server:**

    ```env
    # For port 587
    MAIL_ENCRYPTION=tls

    # For port 465
    MAIL_ENCRYPTION=ssl
    ```

2. **Update CA certificates:**

    ```bash
    # Windows (Laravel Homestead/VM)
    apt-get update && apt-get install ca-certificates

    # Update PHP cacert.pem
    ```

## Recommended Mail Configuration

### For Office 365 / Outlook

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=hr@hom-intl.com
MAIL_PASSWORD=your-password-or-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hr@hom-intl.com
MAIL_FROM_NAME="${APP_NAME}"
```

### For Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Important for Gmail:**

1. Enable 2-Factor Authentication
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Use the 16-character App Password (no spaces)

### For SendGrid API (Recommended for Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@hom-intl.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Testing Mail Configuration

### Quick Test

```bash
php artisan mail:check
```

### Send Test Email

```bash
php artisan tinker
```

```php
Mail::raw('Test email from HOM', function ($message) {
    $message->to('test@example.com')->subject('HOM Test Email');
});
```

### Check if emails are queued

```bash
php artisan queue:work --stop-when-empty
```

## Monitoring Mail Health

### 1. Check Laravel Logs

```bash
tail -f storage/logs/laravel.log | grep -i mail
```

### 2. Check for Failed Jobs

```bash
php artisan queue:failed
```

### 3. Retry Failed Mail Jobs

```bash
php artisan queue:retry all
```

## Production Recommendations

### 1. Use a Dedicated Mail Service

-   ✅ SendGrid
-   ✅ Mailgun
-   ✅ Amazon SES
-   ✅ Postmark

### 2. Enable Queue for Emails

In `.env`:

```env
QUEUE_CONNECTION=database
```

Then run queue worker:

```bash
php artisan queue:work --tries=3 --backoff=3
```

### 3. Set Up Mail Monitoring

-   Configure SendGrid/Mailgun webhooks
-   Monitor bounce rates
-   Track delivery failures

### 4. Configure Retry Logic

In `config/queue.php`:

```php
'connections' => [
    'database' => [
        'retry_after' => 90,
    ],
],
```

## Emergency Procedures

### If Mail Server is Down

1. **Application will continue to work** ✅
2. **Users will see in-app notifications** ✅
3. **Errors are logged for monitoring** ✅

### To Disable Email Temporarily

In `.env`:

```env
MAIL_MAILER=log
```

All emails will be written to `storage/logs/laravel.log` instead.

### To Resend Failed Notifications

Query failed notifications and trigger re-send:

```php
$user = User::find(123);
$user->notify(new ApplicationStatusNotification($application, 'pending', 'user'));
```

## Support Contacts

For mail configuration issues:

-   Technical Support: support@hom-intl.com
-   System Administrator: admin@hom-intl.com
-   Hosting Provider: [Your hosting support]

## Additional Resources

-   [Laravel Mail Documentation](https://laravel.com/docs/11.x/mail)
-   [Symfony Mailer Documentation](https://symfony.com/doc/current/mailer.html)
-   [Office 365 SMTP Settings](https://support.microsoft.com/en-us/office/pop-imap-and-smtp-settings-8361e398-8af4-4e97-b147-6c6c4ac95353)
