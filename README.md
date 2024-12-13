# **Water Jar Management System**

## **Overview**
The **Water Jar Management System** is a web-based application designed to efficiently manage the delivery of water jars. This project provides a streamlined process for customers, delivery personnel, and administrators. Built with **HTML**, **CSS**, **JavaScript**, **PHP**, and **MySQL**, it aims to simplify water delivery management for small-to-medium-sized businesses.

---

## **Features**

### **Admin Dashboard**
- Manage customers and delivery personnel (CRUD operations).
- Track order statuses and delivery schedules.
- Generate reports and analytics.
- View real-time data for customer orders and delivery updates.

### **Customer Dashboard**
- Place orders for water jars.
- Track order statuses and view order history.
- Manage profile and contact information.
- Browse available water jar sizes and pricing.

### **Delivery Boy Dashboard**
- View assigned deliveries.
- Update delivery statuses (pending/delivered).
- Track delivery progress and completion.

---

## **Technologies Used**
- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Tools**: XAMPP/WAMP for local server setup

---

## **How to Run the Project**

### **Prerequisites**
- **XAMPP/WAMP**: A local server environment for running PHP and MySQL.
- **Web Browser**: Any modern browser like Google Chrome or Mozilla Firefox.

### **Set Up the Server**
1. **Start Local Server**: Open XAMPP/WAMP and start the **Apache** and **MySQL** services.
2. **Add Project Files**: Navigate to the `htdocs` folder in XAMPP or the `www` folder in WAMP and place the cloned project folder there.

### **Database Setup**
1. Open **phpMyAdmin** and create a new database named `water_jar_management`.
2. Import the `database.sql` file from the project folder into the newly created database.

### **Database Configuration**
1. Open the `config.php` file located in the root directory of the project.
2. Update the database connection details to match your local environment:
   ```php
   $host = 'localhost';
   $username = 'root';  // Your MySQL username
   $password = '';      // Your MySQL password (leave blank for XAMPP default)
   $database = 'water_jar_management';


### **Access the Application **
1. Open your browser and navigate to:
   ```bash
   URL
   http://localhost/Water-Jar-Management-System

This will load the homepage of the Water Jar Management System.
### **Contributing** 
We welcome contributions from developers! Follow these steps to contribute:

1. Fork the Repository: Click the fork button on GitHub to create your copy of the repository.

2. Clone the Repository:
git clone: https://github.com/Aayushstha1/Water-jar-management-system.git


   
