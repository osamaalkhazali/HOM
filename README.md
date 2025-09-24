<div align="center">

<img src="public/assets/images/HOM-logo.png" alt="HOM Logo" width="300">

# 🌐 HOM - House of Management
### *For Studies and Consultations*

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql)](https://mysql.com)

*A comprehensive management consulting platform and job portal built with modern web technologies*

[🚀 Live Demo](#) • [📖 Documentation](#installation) • [💬 Support](#support)

</div>

---

## ✨ About HOM

**House of Management for Studies and Consultations (HOM)** is a leading management consultancy that delivers comprehensive financial advisory, commercial strategy, project management, and construction consulting services to organizations across **industry, government, real estate, healthcare, tourism, and NGO sectors**.

### 🎯 Our Mission
Empowering businesses with strategic excellence through proactive financial advisory, strategic project management, and qualified business partnerships.

### 🏢 Core Expertise
- **Financial Analysis & Advisory** - Maximum value optimization and risk identification
- **Project Development & Management** - End-to-end project lifecycle management  
- **Strategic Business Consulting** - Commercial strategy and market positioning
- **Construction & Real Estate** - Specialized consulting for construction projects
- **Organizational Development** - Capacity building and operational excellence
- **Technology Integration** - Digital transformation and process optimization

### 🌍 Industry Focus
HOM serves diverse sectors including **Industry, Government, Real Estate, Healthcare, Tourism, and NGO sectors** with tailored solutions delivered through our flexible staff base and qualified business partners.

---

## 🚀 Key Features

<table>
<tr>
<td width="50%">

### 👥 **For Job Seekers**
- 🔍 **Smart Job Search** - Advanced filtering and search
- 📄 **Profile Management** - Complete professional profiles
- 📋 **Application Tracking** - Real-time status updates
- 🔔 **Smart Notifications** - Email alerts and in-app notifications
- 💼 **CV Management** - Secure document upload and management

</td>
<td width="50%">

### 🏢 **For Organizations**
- 📊 **Admin Dashboard** - Comprehensive management interface
- 📝 **Job Management** - Create and manage job postings
- 👤 **User Management** - Advanced user administration
- 📈 **Analytics** - Detailed reporting and insights
- 🎯 **Application Processing** - Streamlined hiring workflow

</td>
</tr>
</table>

### 🌟 **Management Consulting Features**
- 📋 **Financial Analysis & Advisory** - Maximum value optimization and comprehensive risk assessment
- 🤝 **Strategic Project Management** - End-to-end project lifecycle management and delivery
- 📄 **Commercial Strategy Development** - Market positioning and business strategy consulting
- 🎯 **Construction & Real Estate Consulting** - Specialized expertise in construction project management
- � **Organizational Development** - Capacity building and operational excellence initiatives
- 💼 **Business Partnership Development** - Strategic alliances and partnership management

---

## �️ Technology Stack

<div align="center">

| **Backend** | **Frontend** | **Database** | **Tools** |
|-------------|--------------|--------------|-----------|
| ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white) Laravel 11 | ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white) Bootstrap 5 | ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) MySQL 8.0+ | ![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite&logoColor=white) Vite |
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white) PHP 8.2+ | ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) Vanilla JS | ![Database](https://img.shields.io/badge/Database-Production-003B57?style=flat-square&logo=database&logoColor=white) Optimized | ![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white) Composer |

</div>

---

## 📋 Prerequisites

<table>
<tr>
<td>

**🔧 System Requirements**
- PHP 8.2+ with extensions
- Composer 2.0+
- Node.js 18+ & NPM
- MySQL 8.0+ or SQLite
- Web Server (Apache/Nginx)

</td>
<td>

**📦 PHP Extensions**
- BCMath, Ctype, JSON
- Mbstring, OpenSSL, PDO
- Tokenizer, XML, GD
- Fileinfo, Curl

</td>
</tr>
</table>

---

## � Installation Guide

### **Step 1: Clone Repository**
```bash
git clone https://github.com/osamaalkhazali/HOM.git
cd HOM
```

### **Step 2: Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### **Step 3: Environment Setup**
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Configure Environment**
Edit your `.env` file with the following configuration:

```env
APP_NAME="HOM - House of Management"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hom_platform
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@hom.com
MAIL_FROM_NAME="HOM Platform"
```

### **Step 5: Database Setup**
```bash
# Run migrations with sample data
php artisan migrate --seed

# Create storage symbolic link
php artisan storage:link
```

### **Step 6: Build Assets**
```bash
# Development build
npm run dev

# Production build
npm run build
```

### **Step 7: Launch Application**
```bash
php artisan serve
```

🎉 **Your application is now running at:** `http://localhost:8000`

---

## 👥 Default Access Credentials

<div align="center">

### 🔐 **Admin Dashboard Access**
| Field | Value |
|-------|--------|
| **Email** | `admin@hom.com` |
| **Password** | `password123` |
| **Role** | Super Administrator |

### 👤 **Test User Account**
| Field | Value |
|-------|--------|
| **Email** | `john@example.com` |
| **Password** | `password` |
| **Role** | Job Seeker |

</div>

---

## 🏗️ Project Architecture

```
HOM/
├── 📁 app/
│   ├── Http/Controllers/      # Application logic controllers
│   ├── Models/               # Eloquent data models
│   ├── Notifications/        # Email & app notifications
│   └── Providers/           # Service providers
├── 📁 database/
│   ├── migrations/          # Database schema migrations
│   ├── seeders/            # Sample data generators
│   └── factories/          # Model factories
├── 📁 resources/
│   ├── views/              # Blade template files
│   │   ├── admin/          # Admin panel views
│   │   ├── auth/           # Authentication pages
│   │   ├── jobs/           # Job-related pages
│   │   └── landing/        # Homepage sections
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── 📁 public/
│   ├── assets/             # Static assets (images, etc.)
│   ├── storage/            # Uploaded files symlink
│   └── hom-favicon.png     # Custom favicon
└── 📁 storage/
    └── app/public/         # File uploads (CVs, documents)
```

---

## 🎯 Feature Highlights

<table>
<tr>
<td align="center" width="33%">

### 🔔 **Smart Notifications**
Real-time notifications for job applications, status updates, and admin activities with both email and in-app delivery.

</td>
<td align="center" width="33%">

### � **Advanced Dashboard**
Comprehensive admin dashboard with analytics, user management, and system monitoring capabilities.

</td>
<td align="center" width="33%">

### 🔒 **Security First**
Built with Laravel's security features including CSRF protection, input validation, and secure file uploads.

</td>
</tr>
<tr>
<td align="center">

### 📱 **Responsive Design**
Mobile-first design with Bootstrap 5, ensuring perfect experience across all devices.

</td>
<td align="center">

### ⚡ **Performance Optimized**
Optimized database queries, asset compilation with Vite, and efficient caching strategies.

</td>
<td align="center">

### 🎨 **Modern UI/UX**
Clean, professional interface with smooth animations and intuitive user experience.

</td>
</tr>
</table>

---

## 📊 System Statistics

<div align="center">

![GitHub repo size](https://img.shields.io/github/repo-size/osamaalkhazali/HOM?style=for-the-badge)
![GitHub last commit](https://img.shields.io/github/last-commit/osamaalkhazali/HOM?style=for-the-badge)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/osamaalkhazali/HOM?style=for-the-badge)

</div>

---

## 🔧 Development Commands

<table>
<tr>
<td width="50%">

### **🏃 Development**
```bash
# Start development server
php artisan serve

# Watch assets for changes
npm run dev

# Run migrations
php artisan migrate

# Seed fresh data
php artisan migrate:fresh --seed
```

</td>
<td width="50%">

### **🚀 Production**
```bash
# Optimize for production
php artisan optimize

# Cache configurations
php artisan config:cache
php artisan route:cache

# Build production assets
npm run build
```

</td>
</tr>
</table>

### **🧹 Maintenance Commands**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Storage management
php artisan storage:link
php artisan queue:work    # For job queues
```

---

## 📞 Support & Contact

<div align="center">

**Need Help?** We're here to assist you!

[![Email](https://img.shields.io/badge/Email-support%40hom.com-D14836?style=for-the-badge&logo=gmail)](mailto:support@hom.com)
[![GitHub Issues](https://img.shields.io/badge/GitHub-Issues-181717?style=for-the-badge&logo=github)](https://github.com/osamaalkhazali/HOM/issues)
[![Documentation](https://img.shields.io/badge/Documentation-Read%20More-blue?style=for-the-badge&logo=read-the-docs)](https://laravel.com/docs)

</div>

### 🆘 **Troubleshooting Guide**

<details>
<summary><strong>🔧 Common Issues & Solutions</strong></summary>

**Storage Permission Issues:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Asset Compilation Problems:**
```bash
npm run build
php artisan view:clear
```

**Database Connection Issues:**
- Verify database credentials in `.env`
- Ensure MySQL/SQLite service is running
- Check if database exists

**Email Configuration:**
- Use app-specific passwords for Gmail
- Configure SMTP settings correctly
- Test with Mailtrap for development

</details>

---

## 📄 License & Credits

<div align="center">

**© 2025 House of Management for Studies and Consultations**

Built with ❤️ using Laravel Framework

---

### 🌟 **Star this repository if you find it helpful!**

*This project represents modern web development practices and provides a robust foundation for management consulting platforms and job portals.*

</div>
