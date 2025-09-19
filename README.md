# HOM - Job Portal Application

A modern job portal application built with Laravel 11 and Bootstrap 5, featuring job listings, user applications, profile management, and admin dashboard.

## 🚀 Features

- **Job Management**: Browse, search, and filter job listings
- **User Profiles**: Complete profile management with CV upload
- **Application System**: Apply for jobs with CV and cover letters
- **Admin Dashboard**: Manage jobs, users, and applications
- **Responsive Design**: Modern UI with Bootstrap 5
- **File Upload**: CV and resume management
- **Email Verification**: Secure user registration

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** with required extensions
- **Composer** (PHP dependency manager)
- **Node.js & NPM** (for frontend assets)
- **MySQL 8.0+** or compatible database
- **Web Server** (Apache/Nginx) or use Laravel's built-in server

## 🛠️ Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/osamaalkhazali/HOM.git
cd HOM
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the environment file and configure your settings:

```bash
copy .env.example .env
```

Edit `.env` file with your database and mail configuration:

```env
APP_NAME="HOM Job Portal"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hom_jobportal
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yoursite.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Database Setup

Create your database and run migrations with seeders:

```bash
php artisan migrate --seed
```

### 7. Storage Setup

Create storage symbolic link for file uploads:

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 9. Start the Development Server

```bash
php artisan serve
```

Your application will be available at: `http://localhost:8000`

## 👥 Default Accounts

### Admin Account
- **Email**: `admin@jobportal.com`
- **Password**: `password123`
- **Role**: Super Admin
- **Access**: Full admin dashboard access

### Test User Account
- **Email**: `john@example.com`
- **Password**: `password`
- **Role**: Regular User
- **Features**: Can browse jobs, apply, manage profile

### Additional Test Users
The system includes 10+ additional test users with the email pattern:
- `jane@example.com`, `michael@example.com`, etc.
- All use password: `password`

## 📁 Project Structure

```
HOM/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── ...
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── storage/
│   └── app/public/         # File uploads (CVs, resumes)
└── public/                 # Web accessible files
```

## 🔧 Key Commands

### Development Commands
```bash
# Start development server
php artisan serve

# Watch and compile assets
npm run dev

# Run migrations
php artisan migrate

# Refresh database with fresh data
php artisan migrate:fresh --seed

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Production Commands
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build production assets
npm run build
```

## 📱 Features Overview

### For Job Seekers
- **Browse Jobs**: Search and filter job listings
- **Profile Management**: Complete profile with CV upload
- **Application Tracking**: Track application status
- **Email Notifications**: Receive updates on applications

### For Admins
- **Job Management**: Create, edit, and manage job postings
- **User Management**: View and manage registered users
- **Application Monitoring**: Review and process applications
- **Analytics Dashboard**: View system statistics

## 🛡️ Security Features

- **Email Verification**: Required for account activation
- **File Upload Validation**: Secure CV/resume uploads
- **CSRF Protection**: Built-in Laravel security
- **Input Validation**: Comprehensive form validation
- **Password Hashing**: Secure password storage

## 📧 Email Configuration

For email functionality (verification, notifications), configure your `.env` file with valid SMTP settings. For development, you can use services like:

- **Mailtrap** (recommended for testing)
- **Gmail SMTP**
- **SendGrid**
- **Mailgun**

## 🐛 Troubleshooting

### Common Issues

**Storage Link Issues:**
```bash
php artisan storage:link
```

**Permission Issues (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
```

**Asset Compilation Issues:**
```bash
npm run build
```

**Database Connection Issues:**
- Verify database credentials in `.env`
- Ensure MySQL service is running
- Check database name exists

## 📞 Support

For issues and questions:
- Check Laravel documentation: https://laravel.com/docs
- Review the code for implementation details
- Ensure all dependencies are properly installed

## 🏗️ Built With

- **Laravel 11** - PHP Framework
- **Bootstrap 5** - CSS Framework
- **MySQL** - Database
- **Vite** - Asset Building
- **Font Awesome** - Icons

---

**Happy Coding! 🎉**

*This project demonstrates modern web development practices with Laravel and provides a solid foundation for job portal applications.*
