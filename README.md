# CardioPatient-Manager

A Laravel-based cardiovascular workflow and reminder management system designed to improve clinical coordination, patient tracking, and operational efficiency in healthcare environments.

---

## 🏥 Overview

CardioPatient-Manager is a clinical dashboard system built to streamline cardiovascular-related workflows within a healthcare setting.

It enables structured reminder tracking, status management, and operational visibility through a clean and responsive interface.

This project demonstrates real-world healthcare system architecture using Laravel.

---

## ✨ Features

- Reminder status tracking (Queued, Sent, etc.)
- Dashboard-based workflow visibility
- Clean Bootstrap UI components
- Status update logic
- Responsive layout for clinical environments
- Scalable Laravel backend structure

---

## 🧠 Technical Stack

- **Framework:** Laravel
- **Backend Language:** PHP
- **Frontend:** Blade + Bootstrap
- **Database:** MySQL
- **Architecture:** MVC pattern

---

## 🖥️ System Highlights

- Structured controller logic
- Route-based action handling
- Scalable folder organization
- Clean separation of concerns
- Production-ready architecture foundation

---

## 🚀 Future Improvements

- Email & SMS API integration
- Real-time status updates
- Role-based authentication
- Reporting & analytics module
- API layer for mobile integration

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/henryhkb/CardioPatient-Manager.git

##Install dependencies
composer install
npm install

## Copy Environment Variable
cp .env.example .env

## Generate App Key
php artisan key:generate

# Run Migrations
php artisan:migrate

# Start Server
php artisan serve
