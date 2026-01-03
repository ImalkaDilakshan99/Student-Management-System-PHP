# 🎓 Student Management System - PHP

A comprehensive web-based student course management system built with PHP, MySQL, and Bootstrap. This platform allows students to register for courses and enables administrators to manage students and courses efficiently.

## ✨ Features

- **Student Management**
  - User registration and authentication
  - Secure login system
  - View and manage enrolled courses
  - Course registration and deregistration

- **Course Management**
  - Browse available courses
  - View course details
  - Real-time course availability
  - Course catalog management

- **Admin Dashboard**
  - Student management interface
  - Course management tools
  - User activity monitoring
  - Admin controls and permissions

- **Security**
  - Secure password handling
  - Session management
  - Protected admin routes
  - Input validation

## 📋 Prerequisites

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Apache Web Server (XAMPP)
- Bootstrap 4.x
- Modern web browser

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ImalkaDilakshan99/Student-Management-System-PHP.git
   cd course_registration
   ```

2. **Setup Database**
   - Import the database schema (if available)
   - Update `config.php` with your database credentials
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'course_registration');
   ```

3. **Place files in XAMPP**
   ```bash
   cp -r . C:\xampp\htdocs\course_registration
   ```

4. **Start XAMPP**
   - Start Apache and MySQL servers
   - Access the application at `http://localhost/course_registration/`

## 📂 Project Structure

```
course_registration/
├── index.php              # Home/Welcome page
├── login.php              # User login
├── register.php           # Student registration
├── logout.php             # Logout functionality
├── courses.php            # Course listing
├── my_courses.php         # Student's enrolled courses
├── admin.php              # Admin dashboard
├── config.php             # Database configuration
└── Screenshots/           # Application screenshots
```

## 🖥️ Screenshots

### Welcome Page
![Welcome Page](Screenshots/Welcome%20Page.png)

### Student Registration
![Student Registration](Screenshots/Student%20Registration%20Page.png)

### Courses Page
![Courses Page](Screenshots/Courses%20Page.png)

### My Courses
![My Courses](Screenshots/Course%20Management%20Page.png)

### Admin - Student Management
![Admin Student Management](Screenshots/Admin%20Student%20Management%20Page.png)

### Admin - Course Management
![Admin Course Management](Screenshots/Admin%20Course%20Management%20Page.png)

## 🔐 User Roles

### Student
- Register for available courses
- View enrolled courses
- Manage course enrollments
- View course information

### Administrator
- Manage student accounts
- Add, edit, and delete courses
- Monitor registrations
- Control system settings

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3, Bootstrap 4
- **Backend:** PHP 7.x
- **Database:** MySQL
- **Server:** Apache
- **Version Control:** Git

## 📝 Configuration

Edit `config.php` to configure:
- Database host, username, and password
- Database name
- Connection settings

## 🤝 Contributing

Contributions are welcome! Feel free to:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open source and available under the MIT License.

## 👨‍💻 Author

**Imalka Dilakshan**
- GitHub: [@ImalkaDilakshan99](https://github.com/ImalkaDilakshan99)

## 📧 Support

For support, email or open an issue on GitHub.

---

⭐ If you find this project helpful, please consider giving it a star!
