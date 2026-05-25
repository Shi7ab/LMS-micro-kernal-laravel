# 🚀 Minimal Learning Management System (LMS) - Micro-Kernel Architecture

A lightweight, highly scalable Learning Management System (LMS) backend built with **Laravel** and **PostgreSQL**. The entire system is engineered following the **Micro-Kernel (Plugin) Architecture pattern**, where the core framework remains completely isolated, and all business features are hot-pluggable modules.

---

## 🏛️ Architectural Overview

This project bypasses the traditional monolithic structure in favor of a **Micro-kernel architecture**. 

* **The Kernel (Core):** Responsible only for bootstrapping the application, managing global configurations, routing registrations, database connections, and driving the Event Bus.
* **The Plugins:** Independent functional units encapsulating their own Routes, Controllers, Requests, Models, and Migrations.

### 📁 Directory Structure
```text
LMS-micro-kernal/
├── app/                  # Application Core (The Kernel)
├── config/               # Global Configurations
├── database/             # Core System Migrations (Shared/System-wide)
├── plugins/              # Hot-Pluggable Domain Modules
│   ├── Auth/             # Authentication & User Management Plugin
│   │   └── src/
│   │       ├── Http/
│   │       │   ├── Controllers/   # e.g., AuthController.php
│   │       │   └── Requests/      # e.g., RegisterRequest.php
│   │       ├── Models/
│   │       └── Providers/         # AuthServiceProvider (Local bootstrapper)
│   └── Courses/          # Course & Enrollment Management Plugin
└── routes/               # Core routing registration



postman collection : "https://web.postman.co/workspace/2dc1925f-b75c-41f9-86e9-3d85e5c272b3/documentation/38688994-ff886e8c-4e59-44cb-944b-9b199a36bc18"
