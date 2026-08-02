# CeylonByte • Employee Leave Management System

> An enterprise-grade, role-aware Single Page Application (SPA) built with **Laravel 13**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**.

---

## Executive Summary

The **Employee Leave Management System** is an internal enterprise portal designed for **CeylonByte** teams. It streamlines employee time-off requests and managerial approval workflows into a fast, highly responsive SPA experience-eliminating page reloads and API boilerplate while maintaining strict MVC and backend security practices.

---

## Technology Stack & Architecture

| Layer | Technology | Key Architectural Responsibility |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 13 (PHP 8.3+)** | Handles routing, Eloquent ORM relationships, authentication, and authorization. |
| **Frontend UI** | **Vue 3 (Composition API)** | Reactive `<script setup>` SPA components with high-contrast Dark/Light mode support. |
| **Bridge / Routing** | **Inertia.js v2** | Modern Monolith bridge connecting Laravel controllers directly to Vue page components. |
| **Styling & Design** | **Tailwind CSS v3** | Utility-first styling with sleek dark mode, glowing accents, and enterprise typography. |
| **Database** | **MySQL 8** | Relational schema enforcing foreign key integrity and enum status constraints. |
| **Bundler** | **Vite 8** | High-performance frontend bundler with Hot Module Replacement (HMR). |

---

## Architectural Highlights

The application is structured around core software engineering principles to ensure scalability, database performance, and maintainability:

### 1. Zero N+1 Query Architecture
- In the manager dashboard view, leave requests are retrieved using explicit eager loading (`LeaveRequest::with('user')->latest()->get()`).
- This guarantees a flat **2-query database execution** regardless of whether there are 10 or 10,000 leave requests.

### 2. Strict Single Responsibility Principle (Skinny Controllers)
- Controllers never contain inline validation rules.
- Input verification is decoupled into a dedicated **Form Request** (`App\Http\Requests\StoreLeaveRequest`), enforcing date progression rules (`after_or_equal:today`, `after_or_equal:start_date`) and maximum character bounds before hitting controller logic.

### 3. Role-Aware Query Scoping & Authorization
- Users are assigned roles via the `is_manager` boolean attribute.
- The `LeaveRequestController@index` method dynamically scopes data retrieval:
  - **Managers:** Inspect full company-wide leave requests with employee attribution.
  - **Employees:** View only their personal leave history (`$user->leaveRequests()`).
- Manager-only actions (`PATCH /leave-requests/{id}/status`) enforce server-side 403 authorization checks (`! $request->user()->is_manager`).

### 4. Seamless SPA State Mutations
- Approval and denial workflows use Inertia's asynchronous `router.patch` method.
- State changes update instantly in the UI with zero page flicker or manual page reloads.

---

## Features Overview

### For Employees
- **Streamlined Leave Submission:** Select start and end dates with a clear reason using an intuitive Vue form.
- **Client & Server Validation:** Immediate inline error feedback for invalid dates or empty fields.
- **Real-Time Status Tracking:** Beautiful status badges indicating whether a request is `PENDING`, `APPROVED`, or `DENIED`.

### For Managers
- **Enterprise Review Table:** View all submitted employee leave requests in an organized, centered table.
- **Employee Identification:** Highlighted employee names (`text-indigo-400`) for quick scanning.
- **Instant Decision Actions:** 1-click **Approve** and **Deny** action buttons that resolve pending requests instantly.

---

## Getting Started (Local Development)

Follow these steps to run the application locally on your machine:

### 1. Clone the Repository & Install Dependencies
```bash
# Install PHP backend dependencies
composer install

# Install Node.js frontend dependencies
npm install
```

### 2. Configure Environment & Database
```bash
# Copy the example environment file
cp .env.example .env

# Generate your unique Laravel application encryption key
php artisan key:generate
```

Open `.env` and ensure your MySQL database credentials are configured:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_leave_management
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Database Migrations
```bash
# Build the tables and relationships in MySQL
php artisan migrate
```

### 4. Start the Application Servers
Open **two separate terminal tabs**:

**Terminal Tab 1 (Frontend Bundler):**
```bash
npm run dev
```

**Terminal Tab 2 (Laravel PHP Server):**
```bash
php artisan serve
```

Visit **`http://127.0.0.1:8000`** in your browser to explore the **CeylonByte Employee Leave Management System**!

---

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
