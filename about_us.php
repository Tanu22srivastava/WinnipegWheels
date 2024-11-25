<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Navbar Styling */
        nav {
            background-color: #333;
            padding: 10px 20px;
        }
        
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* About Us Section Styling */
        .about-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .about-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .about-container p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .about-container ul {
            margin-top: 20px;
        }

        .about-container ul li {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .about-container .cta-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .cta-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <!-- <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="comments.php">Comments</a></li>
        </ul>
    </nav> -->

    <!-- About Us Section -->
    <div class="about-container">
        <h2>About Us</h2>
        <p>Welcome to <strong>Winnipeg Wheels </strong>! We are a team dedicated to providing you with the best services and information. Whether you are looking for detailed vehicle listings, want to connect with us via our contact page, or simply want to explore, we are here to assist you at every step.</p>

        <p>Our mission is simple: to connect people with the information they need, and to make their browsing experience as seamless and enjoyable as possible. We aim to offer a user-friendly platform with reliable content, and we continually strive to improve our services for our users.</p>

        <h3>Our Values</h3>
        <ul>
            <li><strong>Integrity:</strong> We value honesty and transparency in everything we do.</li>
            <li><strong>Customer-Centric:</strong> Our users are at the heart of our services, and we aim to always prioritize your needs.</li>
            <li><strong>Innovation:</strong> We embrace new ideas and continuously work to improve our platform.</li>
            <li><strong>Excellence:</strong> We strive to maintain high-quality standards in all of our offerings.</li>
        </ul>

        <h3>Why Choose Us?</h3>
        <p>We provide you with accurate, up-to-date information about various vehicles, and our contact page allows you to reach out to us easily. Whether you're looking to buy, sell, or simply get more information, our website is designed to serve your needs.</p>

        <a href="contact_us.php" class="cta-button">Get in Touch</a>
    </div>

</body>
</html>
