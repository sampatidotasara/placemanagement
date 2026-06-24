# 🎯 Placement Tracker System

A modern Placement Management System built using **PHP, MySQL, Bootstrap, JavaScript, and Chart.js**.

This project helps students track placement applications, company details, recruitment progress, and placement analytics through an interactive dashboard.

---

## 🚀 Features

### 🔐 Authentication

* User Registration
* User Login
* Secure Session Management
* Logout Functionality

### 🏢 Company Management

* Add Company
* Update Company
* Delete Company
* View Company Details

### 📄 Application Management

* Add Student Application
* Upload Resume
* Update Application Status
* Delete Application
* Track Placement Progress

### 🎯 Placement Pipeline

* Applied
* OA Scheduled
* OA Cleared
* Interview Scheduled
* HR Interview
* Selected
* Rejected
* Offer Accepted

### 📊 Dashboard Analytics

* Total Companies
* Total Applications
* Selected Students
* Rejected Students
* Offer Accepted
* Highest Package
* Average Package
* Placement Success Rate

### 📈 Charts

* Placement Status Distribution
* Monthly Application Trends

### ⏰ Additional Features

* Upcoming Deadlines
* Recent Applications
* Selected Students List
* Rejected Students List
* Placement Tips
* Motivation Corner

---

## 🛠️ Tech Stack

### Frontend

* HTML5
* CSS3
* Bootstrap 5
* JavaScript
* Chart.js

### Backend

* PHP

### Database

* MySQL

---

## 📁 Project Structure

```text
placement-tracker/

├── assets/
│   ├── css/
│   │   └── dashboard.css
│   ├── js/
│   │   └── dashboard.js
│
├── uploads/
│   └── resumes/
│
├── dashboard.php
├── companies.php
├── applications.php
├── addCompany.php
├── updateCompany.php
├── deleteCompany.php
├── updateApplication.php
├── selected_students.php
├── rejected_students.php
├── login.php
├── register.php
├── logout.php
├── auth.php
├── db.php
└── README.md
```

---

## 🗄️ Database Tables

### users

Stores registered users.

### companies

Stores company information.

### applications

Stores placement applications and status.

---

## ⚙️ Installation

### Clone Repository

```bash
git clone https://github.com/sampatidotasara/placemanagement.git
```

### Move Project

```bash
sudo mv placemanagement /var/www/html/
```

### Create Database

```sql
CREATE DATABASE placement_tracker;
```

### Configure Database

Update `db.php`:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "placement_tracker";
```

### Run Project

Open:

```text
http://localhost/placemanagement/
```

---

## 📸 Dashboard Modules

* Dashboard Overview
* Placement Pipeline
* Status Analytics
* Recent Applications
* Company Tracking
* Placement Statistics

---

## 🎯 Future Improvements

* Email Notifications
* Resume Download
* CSV Export
* Search & Filters
* Admin Roles
* Student Profiles
* Interview Scheduling
* Dark Mode

---

## 👨‍💻 Author

**Sampati Dotasara**

B.Tech CSE Student

GitHub:
https://github.com/sampatidotasara

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub.
<img width="1800" height="944" alt="image" src="https://github.com/user-attachments/assets/9457a264-b3f7-43df-982a-5051ffe1db78" />

<img width="1800" height="944" alt="image" src="https://github.com/user-attachments/assets/6c3ce0dd-7ebd-484d-be11-a8eb73c82c81" />

