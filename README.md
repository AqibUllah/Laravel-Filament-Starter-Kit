<p align="center">
  <img src="public/images/demo.png" alt="Laravel Filament SaaS Starter Kit Screenshot" />
</p>
<h1 align="center">🚀 Laravel Filament SaaS Starter Kit</h1>

<p align="center">
  A powerful and extendable multi-tenant SaaS starter built with <strong>Laravel 12</strong> and <strong>Filament</strong> 4.x.
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-^8.2-blue">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-red">
  <img alt="Filament" src="https://img.shields.io/badge/Filament-^4.x-orange">
  <img alt="License" src="https://img.shields.io/badge/license-MIT-blue">
</p>

<p align="center">
  <a href="https://github.com/AqibUllah/Laravel-Filament-Starter-Kit/stargazers">
    <img src="https://img.shields.io/github/stars/AqibUllah/Laravel-Filament-Starter-Kit?style=social" alt="Stars">
  </a>
  <a href="https://github.com/AqibUllah/Laravel-Filament-Starter-Kit/network/members">
    <img src="https://img.shields.io/github/forks/AqibUllah/Laravel-Filament-Starter-Kit?style=social" alt="Forks">
  </a>
  <a href="https://github.com/AqibUllah/Laravel-Filament-Starter-Kit/issues">
    <img src="https://img.shields.io/github/issues/AqibUllah/Laravel-Filament-Starter-Kit" alt="Issues">
  </a>
</p>


## 📚 Table of Contents
- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Getting Started](#-getting-started)
- [License & Usage](#️-license-and-usage)
- [Contributing](#-contributing)
- [Support](#-support)


---

## ⚖️ License

This project is licensed under the **MIT License**.

### Summary

- Permission is granted to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software.
- Include the original copyright notice and this permission notice in all copies or substantial portions of the Software.
- The Software is provided "as is", without warranty of any kind.

See the `LICENSE` file for the full text of the MIT License.

## 🧩 Overview

This project is a **tenant-based SaaS web application** built using Laravel and Filament. It's designed to help you kickstart your own Software as a Service platform with built-in team support, roles, permissions, charts, task management, and more.

Ideal for developers looking for a **clean, extensible foundation** with multi-tenancy already configured out of the box.

---

## ✨ Features

- 🔐 **Authentication System**
  - Login, Register, Forgot Password
  - Email verification support
  - Invite-based user onboarding (future)
  
- 👥 **Multi-Tenant Architecture**
  - Team-based tenancy using Filament multi-tenancy
  - Users can belong to multiple teams
  - Switch between teams easily
  
- ✅ **Task Management**
  - Create, update, assign tasks
  - Track task status: Pending, In Progress, Completed
  - Due dates, priority levels

- 📊 **Dashboards & Analytics**
  - Charts and graphs to analyze tasks
  - Team stats overview
  - Progress tracking

- 🔐 **Roles & Permissions**
  - Powered by Spatie Laravel Permission (team-aware)
  - Admin, Super Admin, User, and custom roles
  - Fine-grained access control per team

- 🧰 **Developer-Friendly**
  - Uses Laravel's latest features (v12+)
  - Built with Filament (v4+) — fast, beautiful admin UI
  - Easily extendable with custom widgets, panels, and resources

- 🌐 **Future-Proof**
  - Ready for modular plugins like billing, notifications, team invites, chat
  - Roadmap planned for many more features (see below)

---

## 🤝 Contributing
Contributions, issues, and feature requests are welcome!  
Feel free to fork this repository and submit a pull request.

If you like this project, **please give it a ⭐** — it really helps others find it!



## 🛠 Tech Stack

- **Laravel** 12+
- **Filament** 4.x (Admin UI)
- **Spatie Laravel Permission** (Roles & Permissions)
- **Filament Shield** (Permission generator)
- **Livewire** (Dynamic components)
- **Tailwind CSS** (Frontend)
- **MySQL / PostgreSQL** (DB)

---

## 🚀 Getting Started

### 📦 Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL or PostgreSQL

### 🧾 Installation


```bash
# Clone the repo
git clone https://github.com/AqibUllah/Laravel-Filament-Starter-Kit

cd laravel-filament-saas-kit

# Install dependencies
composer install
npm install && npm run build

# Copy and configure environment
cp .env.example .env
php artisan key:generate

# Set up your DB credentials in .env
# Then run migrations and seeders
php artisan migrate:fresh
php artisan shield:generate --panel=tenant --option=permissions --all
php artisan db:seed

# Start local development server
php artisan serve

# admin panel
Email: superadmin@example.com
Password: password

# tenant panel
Email: teamadmin@example.com
Password: password

```

---

## 💬 Support

If you found this project helpful, consider giving it a ⭐  
For commercial licensing or support:
📧 **aqibullah3312@gmail.com**
