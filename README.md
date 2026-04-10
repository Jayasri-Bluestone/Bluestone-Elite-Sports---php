# Bluestone Elite Sports - Project Guide

This project is a high-end sports academy website built with a **PHP Frontend** and a **Node.js/Express Backend**.

## 🚀 Getting Started

To run this project locally, follow these steps:

### 1. Requirements
Ensure you have the following installed:
- **Node.js** (for the Backend API)
- **PHP** (v7.4 or later, for the Frontend)
- **MySQL** (The project is pre-configured to connect to your existing database)

---

### 2. Run the Backend API (Node.js)
The backend handles dynamic content like sports cards, gallery images, and enrollments.

1.  Open your terminal/command prompt.
2.  Navigate to the `Backend` directory:
    ```bash
    cd Backend
    ```
3.  Install the required dependencies:
    ```bash
    npm install
    ```
4.  Start the backend server:
    ```bash
    node server.js
    ```
    *The API will be live at `http://localhost:5004`.*

---

### 3. Run the Frontend (PHP)
The frontend fetches data from the backend and displays the modern layout.

#### Option A: Using XAMPP/WAMP (Recommended)
1.  Copy the entire `Bluestone Elite Sports - php` folder into your `htdocs` (XAMPP) or `www` (WAMP/MAMP) directory.
2.  Open your browser and go to `http://localhost/Bluestone Elite Sports - php/Frontend/index.php`.

#### Option B: Using PHP Built-in Server
1.  Open a **new** terminal window.
2.  Navigate to the `Frontend` directory:
    ```bash
    cd Frontend
    ```
3.  Start the PHP server:
    ```bash
    php -S localhost:8000
    ```
4.  Visit `http://localhost:8000` in your browser.

---

### 4. Admin Panel 🛠️
You can manage the website content dynamically through the admin dashboard.

-   **URL**: `http://localhost/[path-to-folder]/Frontend/admin.php`
-   **Password**: `elite123`
-   **Features**: Add/Delete sports cards, Update statistics (Athletes trained, etc.), and manage the gallery.

---

## 🏗️ Folder Structure
-   `/Frontend`: Contains the PHP files, components, and assets.
-   `/Backend`: Contains the Node.js API, database configuration, and image uploads.

---
> [!IMPORTANT]
> **Database Note**: The `server.js` file is currently using the remote database credentials found in your environment. If you want to use a local database, update the `pool` configuration in `Backend/server.js`.
