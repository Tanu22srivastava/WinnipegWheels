<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }

        /* Navigation Bar */
        nav {
            background-color: #333;
            padding: 10px 20px;
            text-align: left;
            display: flex;
            justify-content: space-between; /* Distributes items in navbar */
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Search Form in the Navbar */
        .search-container {
            display: flex;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 250px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-container button {
            padding: 8px 16px;
            margin-left: 10px;
            font-size: 14px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .search-container button:hover {
            background-color: #45a049;
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

   <!-- Header -->
   <header>
        <h1>Winnipeg Wheels</h1>
    </header>

    <!-- Navigation Bar with Search in the Right Corner -->
    <nav>
        <ul>
            <li><a href="read.php">View All Vehicles</a></li>
            <li><a href="comments.php">Comments</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <!-- Search Form on the Right -->
        <div class="search-container">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search for pages..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>

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
