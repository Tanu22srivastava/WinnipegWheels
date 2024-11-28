# User Registration and Login System

This project implements a simple user registration and login system using PHP and MySQL. It allows users to register with a username and password, and upon successful registration, they can log in to the system. The password is securely stored using password hashing.

## Features

- User registration with unique usernames
- Password storage using `bcrypt` hashing
- Login functionality to authenticate users
- Redirection based on user roles (admin/user)
- User-friendly design for both registration and login forms

## Requirements

- PHP 7.4 or higher
- MySQL database
- Web server (e.g., Apache, Nginx)

How to Set Up the Project
1. Clone the repository

Clone the project to your local machine:

git clone https://github.com/your-username/user-registration-login.git
cd user-registration-login

2. Configure Database

Ensure the MySQL database and table are set up as mentioned above. Edit the db.php file with your own database connection details.
3. Upload Files to the Server

Upload the project files to your web server, or use a local development environment such as XAMPP or MAMP to run the project locally.
4. Run the Application

   - Open the register.php page in your browser and fill out the registration form to create a new user.
   - After successful registration, you will be redirected to the login.php page where you can log in using your registered username and password.

5. Logging In

   - Upon successful login, the user will be redirected to a different page based on their role (admin.php for admins, index.php for regular users).

How It Works
Registration Process

    User enters a username and password.
    The system checks if the username is already taken.
    If the username is available, the password is hashed using bcrypt.
    The new user is inserted into the Users table in the database.
    The user is then redirected to the login page.

Login Process

    User enters their username and password.
    The system retrieves the hashed password from the database.
    The entered password is compared with the hashed password using password_verify().
    If the credentials match, the user is authenticated and redirected to their appropriate page (admin.php for admins or index.php for users).

Future Improvements

    Implement user role management with different privileges for admin and regular users.
    Add email verification during registration.
    Implement password reset functionality.
    Improve the UI with a modern design and more user-friendly features.


Important:
for Admin Interface
username is admin1
and password is admin1234
    

