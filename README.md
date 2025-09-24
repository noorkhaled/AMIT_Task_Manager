# Task Manager — Native PHP (OOP + MVC, PDO, Bootstrap)

A lightweight **Task Management** web app built with **plain PHP** (no frameworks), using **OOP**, **MVC**, **PDO (MySQL)**, **Bootstrap 5**, CSRF protection, session-based auth, a service/repository layer, and Laravel-style **Form Request** validation.

---

## ✨ Features

- User auth: **register / login / logout**
- Authenticated **CRUD** for tasks (title, description, status, due date)
- Users can manage **only their own** tasks
- **Pagination** for task listing
- **PSR-4 autoloading**, front controller & simple router
- **Repository layer (PDO)** + **Service layer** (DI-friendly)
- **CSRF** for all forms, **password_hash()** for passwords
- **Bootstrap 5** UI + **Flash messages** (toasts & alerts)
- **Form Request** validation (required, email, min/max, in, date, nullable, sometimes)
- Centralized logging to `logs/app.log`

---

## 🧱 Tech Stack

- PHP **8.1+**
- MySQL **5.7+** / MariaDB **10.3+**
- PDO (MySQL)
- Bootstrap 5 (CDN)
- Composer (PSR-4 autoload)

---

## ✅ Requirements

- PHP **8.1+** with: `pdo_mysql`
- MySQL **5.7+**
- Composer

---
- git clone https://github.com/noorkhaled/AMIT_Task_Manager.git task-manager
- cd task-app
- composer dump-autoload
----
## Run It
1) Run Sql inside schema.sql to setup your DB
2) php -S localhost:8080 -t public

