<p align="center">
  <img src="public/images/demo.png" alt="Laravel Filament SaaS Starter Kit Screenshot" width="100%" />
</p>
<h1 align="center">🚀 Laravel Filament SaaS Starter Kit</h1>

<p align="center">
  A powerful and extendable multi-tenant SaaS starter built with <strong>Laravel 12</strong> and <strong>Filament</strong> 4.x.
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-^8.2-blue">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-red">
  <img alt="Filament" src="https://img.shields.io/badge/Filament-^4.x-orange">
</p>

---

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


## 📸 Demo

> 📷 **Demo Screenshot**
>
### 🏠 Dashboard
![Dashboard Screenshot](public/images/demo.png)

### 🏠 Team Profile
![Team Screenshot](public/images/11.JPG)

### 📋 Create Task
![Create Task Screenshot](public/images/33.JPG)

### ⚙️ Roles & Permissions
![Roles Screenshot](public/images/55.JPG)

### 📋 Tasks
![Tasks Screenshot](public/images/44.JPG)

### ⚙️ Theme Manager
![Theme Manager Screenshot](public/images/66.JPG)

---


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
php artisan shield:generate --all
php artisan db:seed

# Start local development server
php artisan serve

Email: superadmin@example.com
Password: password
