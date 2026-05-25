 
## 📁 1. The GitHub `README.md` File

Create or overwrite the `README.md` file in your root directory with this clean, well-formatted markdown:

```markdown
# 🎓 Learning Management System (LMS) - Micro-Kernel Architecture

A highly scalable, performant, and completely decoupled Learning Management System (LMS) built with **Laravel 11**, **PostgreSQL**, and **Laravel Reverb (WebSockets)** using a customized Micro-Kernel software architecture.

---

## 🏗️ Architectural Overview

The entire application relies on a rigid separation of concerns. The **Core Kernel** manages application lifecycles and global configurations, while isolated, modular **Plugins** handle distinct domain logic. 

To achieve **Zero Tight-Coupling**, plugins have absolutely *no direct class imports* between each other. Instead, communication across domains happens asynchronously and synchronously via a **Shared Event Bus Matrix**.

### Key Architectural Specifications:
* **Decoupled Architecture:** Plugins (Auth, Course, Media, Quiz, Progress, Notifications) can be turned on or off safely via `PluginRegistry`.
* **Database Design:** Optimized for **PostgreSQL** using non-sequential **UUIDv4** primary keys across all modules for physical abstraction, alongside relational indexes to guarantee low-latency indexing.
* **Dynamic Schema Storage:** Leverages PostgreSQL's native **JSONB** datatype to store polymorphic datasets (e.g., dynamic Quiz questions and multiple-choice options layouts).
* **Real-time Event Broadcasting:** Built-in WebSockets driven by **Laravel Reverb** to pipe immediate reactive triggers directly to the client browser.

---

## 🚀 Installation & System Setup

### 1. Prerequisites
Ensure you have the following installed on your machine:
* PHP >= 8.2
* Composer
* PostgreSQL Server
* Node.js & NPM

### 2. Local Setup Steps
```bash
# Clone the repository
git clone [https://github.com/Shi7ab/LMS-micro-kernal.git](https://github.com/Shi7ab/LMS-micro-kernal.git)
cd LMS-micro-kernal

# Install PHP backend dependencies
composer install

# Install Frontend and Asset tools
npm install

# Prepare environment configurations
cp .env.example .env

```

### 3. Environment Configurations (`.env`)

Open your `.env` file and correctly specify your **PostgreSQL** and **Laravel Reverb** connection parameters:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lms_micro_kernel
DB_USERNAME=your_postgres_user
DB_PASSWORD=your_postgres_password

CACHE_STORE=file

BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-reverb-app-id
REVERB_APP_KEY=your-reverb-key
REVERB_APP_SECRET=your-reverb-secret
REVERB_HOST="127.0.0.1"
REVERB_PORT=8080
REVERB_SCHEME=http

```

### 4. Database Migrations

```bash
php artisan migrate

```

### 5. Running the Application Engine

You will need to open two terminal windows to run both servers concurrently:

```bash
# Terminal 1: Starts the PHP Local Application server
php artisan serve

# Terminal 2: Starts the Real-time WebSockets Reverb engine
php artisan reverb:start

```

### 6. Executing Unit Tests

To verify the structural integrity of the Micro-Kernel (Registry, Event Bus, and Auth Pipeline), run:

```bash
php artisan test --testsuite=Unit

```

```

---

## 🚀 2. Postman API Reference Summary

You can mirror this endpoint summary inside your Postman Collection configuration. Save it as `Postman_Collection.json` inside a `postman/` root directory in your repository.

### 🔐 1. Authentication Plugin (`Auth`)
* **`POST /api/v1/auth/register`**
  * **Description:** Registers a new user account as either a Student or Instructor.
  * **Payload (JSON):** ```json
    {
      "name": "John Doe",
      "email": "john@lms.com",
      "password": "SecurePassword123",
      "role": "instructor" 
    }
    ```
* **`POST /api/v1/auth/login`**
  * **Description:** Authenticates user credentials and signs a unique bearer token.
  * **Response:** Returns JSON containing the authenticated `access_token`, `role`, and user `UUID`.

### 📚 2. Course & Lesson Plugin (`Course`)
* **`POST /api/v1/courses`** `[Header: Authorization Bearer Token | Role: Instructor/Admin]`
  * **Description:** Creates a brand-new training course.
* **`GET /api/v1/courses/{id}`** `[Header: Authorization Bearer Token]`
  * **Description:** Fetches unified course metrics along with structural sub-lessons using direct eager loading.

### 📁 3. Media Asset Management Plugin (`Media`)
* **`POST /api/v1/media/upload`** `[Header: Authorization Bearer Token | Role: Instructor]`
  * **Description:** Uploads file binary assets (Video/Docs) mapping a weak reference key to a specific lesson UUID.
  * **Body (form-data):** `file` (File Binary), `lesson_id` (UUID string)
* **`GET /api/v1/media/lesson/{lessonId}`** `[Header: Authorization Bearer Token]`
  * **Description:** Fetches all available streaming metadata resources tied to a specific lesson.

### 🧠 4. Interactive Quiz Plugin (`Quiz`)
* **`POST /api/v1/quizzes`** `[Header: Authorization Bearer Token | Role: Instructor]`
  * **Description:** Compiles an interactive evaluation test. Questions and multiple-choice fields are parsed natively as a dynamic JSONB tree.
  * **Payload (JSON):**
    ```json
    {
      "lesson_id": "4a71fb98-0c2d-4bfb-936b-d8b5e6704b2a",
      "title": "Database Architecture Midterm",
      "passing_score": 70,
      "questions": [
        {
          "question_text": "Which datatype is best suited for polymorphic option trees in PostgreSQL?",
          "options": {"A": "VARCHAR", "B": "TEXT", "C": "JSONB"},
          "correct_option": "C"
        }
      ]
    }
    ```
* **`POST /api/v1/quizzes/{quizId}/submit`** `[Header: Authorization Bearer Token | Role: Student]`
  * **Description:** Evaluates a student's submission instantly via automated grading logic. If the calculated percentage crosses the threshold score, it dispatches a `quiz.passed` system event.

### 📈 5. Student Progress Tracking Plugin (`Progress`)
* **`POST /api/v1/progress/lessons/{lessonId}/complete`** `[Header: Authorization Bearer Token | Role: Student]`
  * **Description:** Marks a distinct lesson block as explicitly consumed and finalized.
* **`GET /api/v1/progress/courses/{courseId}`** `[Header: Authorization Bearer Token | Role: Student]`
  * **Description:** Executes mathematical computations aggregating completed lesson matrices against overall core indexes. Returns the student's dynamic completion metric (e.g., `85.5%`).

---

## 📦 3. Git Command Sequence for the Final Push

Open your system terminal and execute these standard, well-structured commands to cleanly commit your work to GitHub:

```bash
# Track all changes
git add .

# Multi-layered precise commits for tracking
git commit -m "feat: design scalable Quiz Auto-Grading using JSONB layout and Progress tracking services"
git commit -m "feat: establish low-latency WebSocket streams using Laravel Reverb linked to Shared Event Bus"
git commit -m "test: write fully mocked Unit tests covering Kernel Registry, Event Bus, and Auth Middleware pipelines"
git commit -m "docs: generate formal project English README and Postman API reference matrices"

# Push to the remote master branch
git push origin main

```

postman collection : "https://web.postman.co/workspace/2dc1925f-b75c-41f9-86e9-3d85e5c272b3/documentation/38688994-ff886e8c-4e59-44cb-944b-9b199a36bc18"
