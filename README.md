# 🎟️ Event Booking System (Laravel 10)

## 🚀 How to Work with the Project

### 🛠️ Step 1: Create the Database

Create a new database manually from MySQL or phpMyAdmin:

```
Name: event_booking
User: root
Password: [leave it empty]
```

---

### 💻 Step 2: Set up Local Server (using Laragon)

> 💡 You can use Laragon or any similar tool (e.g., XAMPP, MAMP)

#### ✅ Download & Setup Laragon:

1. **Download Laragon:**  
   [Laragon v8.1.0](https://github.com/leokhoa/laragon/releases/download/8.1.0/laragon-wamp.exe)

2. **Install Laragon**

3. Open Laragon → **Settings** → **General** → **Document Root** → set the path to your project folder

4. Click **Stop** → then **Start All**

5. Click **Web**

6. Visit in browser:  
   `http://localhost:8000/your-project/public`

## If you have any problem opening the project, try this URL (HOST):

`http://booking.byethost18.com/Booking/public/`

Note 1: Please make sure to open the link using HTTP (http://booking.byethost18.com/Booking/public/) and not HTTPS, as the site does not support HTTPS. Note that some browsers now default to HTTPS automatically, so double-check the protocol.

Note 2: If the link doesn't work, it may be due to a hosting issue. Please try again later or contact us for assistance.

---

### 📦 Step 3: Install Dependencies

```bash
composer install
npm install
cd Booking  # name-project 
```

---

### 🧱 Step 4: Run Migrations, Seeders, Roles & Permissions

```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=CreateAdminUserSeeder
```

## "The SQL file event_booking.sql containing the required data is attached in case any issue occurs during the seeder data upload."

---

### 🛠️ Step 5: Review

Visit the project in your browser:  
`http://localhost:8000/your-project/public`

#### 🔐 Login Credentials

**Admin Login:**

-   Email: `omar@gmail.com`
-   Password: `11111111`

**User Login:**

-   Email: `user@gmail.com`
-   Password: `22222222`

> 💡 **Tip:** It’s recommended to open each user role (Admin & User) in a separate browser to avoid session conflicts.

---

### 🌐 Alternative Access (Online Host)

If you have any problem opening the project locally, you can access the live version via the following URL:  
`http://booking.byethost18.com/Booking/public/`

Note: If the link doesn't work, it may be due to a hosting issue. Please try again later or contact us for assistance.

---

## 👥 Features for All Users

-   🔐 Register / Login (same page for all user types)
-   🌟 View events (featured and regular)
-   ✅ Book an event with a single click
-   📄 View your booking details
-   🔍 Filter your bookings (confirmed / canceled)
-   🖨️ Download or print your booking confirmation

---

## 🛡️ ✅ Admin / Owner Dashboard

-   🔐 Secure login (all roles use the same login page)
-   🧩 Manage:
    -   🎯 Event Categories
    -   🎟 Events
    -   👥 Users
    -   🔐 Roles & Permissions
    -   📑 All Bookings (with advanced filters)
-   📊 Dashboard Overview:
    -   Total number of events
    -   Upcoming events
    -   Today's bookings
    -   Top event
    -   Recent 5 bookings
-   🔔 Real-time notifications for new bookings
-   🔍 Advanced event search and filtering
-   🖥️ Fullscreen mode support
-   🚪 Logout button

---

## Contact Me

-   📧 Email: omar.mohamed11221@gmail.com
-   📱 WhatsApp / Phone: +20 1024456408
