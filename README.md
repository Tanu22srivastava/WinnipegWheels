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


Images (User Interface) :

![Screenshot 2024-11-29 142449](https://github.com/user-attachments/assets/6830b904-01ac-4efd-b088-7a6613e4deef)
![Screenshot 2024-11-29 142501](https://github.com/user-attachments/assets/c2cb6ef7-357b-4bce-83eb-38ec4cb5b3ff)
![Screenshot 2024-11-29 142527](https://github.com/user-attachments/assets/35b6d9fa-224d-4aa6-8201-9ff7a2fb87a6)
![Screenshot 2024-11-29 142803](https://github.com/user-attachments/assets/f7f33b13-e105-486e-9d49-65e3bf6df88d)
![Screenshot 2024-11-29 142817](https://github.com/user-attachments/assets/b39c0536-d59a-4c88-a5c0-81f90df9bfea)
![Screenshot 2024-11-29 142831](https://github.com/user-attachments/assets/65f1cf2d-64d3-4502-a73c-5397b158c502)
![Screenshot 2024-11-29 142845](https://github.com/user-attachments/assets/26be56e8-d5b4-439f-9634-a649917c5675)
![Screenshot 2024-11-29 142859](https://github.com/user-attachments/assets/6b024222-e1b9-4e42-b53f-8a9b5bf3bba3)



Images (Admin Interface) :

![Screenshot 2024-11-29 144618](https://github.com/user-attachments/assets/6068fd7a-44f3-4312-9c0b-0edb592f67c5)
![Screenshot 2024-11-29 144639](https://github.com/user-attachments/assets/55170c9b-545a-4997-abe2-78f8a8c649fb)
![Screenshot 2024-11-29 144656](https://github.com/user-attachments/assets/403caddf-6ff6-4392-9a05-579a14f77c81)
![Screenshot 2024-11-29 144710](https://github.com/user-attachments/assets/e89e8076-8fb2-49d0-8b0b-3f162ea7547a)

    

