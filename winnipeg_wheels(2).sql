-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 10:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `winnipeg_wheels`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Sedan'),
(2, 'SUV'),
(3, 'Truck'),
(4, 'Convertible'),
(5, 'Uncategorized');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `VehicleID` int(10) UNSIGNED NOT NULL,
  `CommentText` text NOT NULL,
  `CommentDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `VehicleID`, `CommentText`, `CommentDate`) VALUES
(7, 5, 'very nice carrrr', '2024-11-25 18:37:37'),
(8, 4, 'good work', '2024-11-25 18:38:23'),
(9, 7, 'what a carr!!!!!!!!!!!!!!!!!!!!!!', '2024-11-25 19:05:26'),
(11, 15, 'great car', '2024-11-26 13:01:24'),
(12, 36, 'nice car', '2024-11-28 18:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ContactId` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Query` text NOT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ContactId`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Query`, `SubmissionDate`) VALUES
(1, 'Tanu', 'Srivastava', '123456789', 'tanu@mail.com', 'bla blaa', '2024-11-25 07:06:44'),
(2, 'dan', 'humphery', '123456789', 'dan@mail.com', 'none', '2024-11-25 18:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `PageId` int(11) NOT NULL,
  `PageName` varchar(255) NOT NULL,
  `PageContent` text NOT NULL,
  `PageURL` varchar(255) NOT NULL,
  `Keywords` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`PageId`, `PageName`, `PageContent`, `PageURL`, `Keywords`) VALUES
(1, 'Vehicles', 'This page contains information about various vehicles.', 'read.php', 'Vehicles, Manufacturer, Specification, Automatic, Model, Gasoline, speed, Hybrid, Sedan, Compact, Truck, Manual'),
(2, 'About Us', 'Learn more about our company, mission, and vision.', 'about_us.php', 'Vehicles, About, Contact, mission, Company'),
(3, 'Contact Us', 'Get in touch with us through this page.', 'contact_us.php', 'Vehicles, Manufacturer, Specification, contact, query, customer, services, touch');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Role_id` int(11) NOT NULL,
  `Role_name` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Role_id`, `Role_name`, `Description`) VALUES
(1, 'Admin', 'Administrator role');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `User_name` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role_id` int(11) NOT NULL,
  `Role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `User_name`, `Password`, `Email`, `Role_id`, `Role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@winnipeg.com', 1, 'user'),
(2, 'admin_user', 'admin123', 'user@mail.com', 2, 'user'),
(3, 'admin1', 'admin1234', 'user@mail.com', 3, 'admin'),
(4, 'tanu', '$2y$10$OIPQcKmLwjmfcFkw.IL/B.zO2vaCChfc0xjOqjBlDU47J24.oZAmm', '', 0, 'user'),
(5, 'Aditya', '$2y$10$B4v7ZaGbSJkA7mCDtULchOdO7A9JRYfvJhynrmLNvBi9v0tmWATri', '', 0, 'user'),
(7, 'Admin12', '$2y$10$4gI75vE4ZV6EF51y4idPAuQ58hfofQjLhFWQTuQD372cL0.hUJS3e', 'admin@mail.com', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `VehicleID` int(10) UNSIGNED NOT NULL,
  `Manufacturer` varchar(100) DEFAULT NULL,
  `Model` varchar(100) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Specifications` text DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`VehicleID`, `Manufacturer`, `Model`, `Year`, `Price`, `Specifications`, `CategoryID`, `Image`) VALUES
(4, 'Toyota', 'Camry', 2020, 20000.00, 'Sedan', 1, NULL),
(5, 'Honda', 'Civic', 2021, 22000.00, 'Compact Sedan', 1, NULL),
(7, 'hyundai', 'santro', 2020, 4000000.00, 'good average', NULL, NULL),
(9, 'Toyota', 'Camry', 2022, 25000.00, 'Sedan, Hybrid, Automatic', NULL, NULL),
(10, 'Honda', 'Civic', 2023, 22000.00, 'Compact, Gasoline, Manual', NULL, NULL),
(11, 'Ford', 'F-150', 2021, 35000.00, 'Truck, Gasoline, Automatic', NULL, NULL),
(12, 'Tesla', 'Model S', 2022, 80000.00, 'Electric, AWD, Autonomous', NULL, NULL),
(13, 'BMW', 'X5', 2023, 60000.00, 'SUV, Diesel, Automatic', NULL, NULL),
(14, 'Mercedes', 'C-Class', 2022, 55000.00, 'Sedan, Gasoline, Automatic', NULL, NULL),
(15, 'Audi', 'Q7', 2024, 65000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(16, 'Chevrolet', 'Malibu', 2021, 24000.00, 'Sedan, Gasoline, Automatic', NULL, NULL),
(17, 'Nissan', 'Altima', 2022, 23000.00, 'Sedan, Gasoline, CVT', NULL, NULL),
(18, 'Hyundai', 'Elantra', 2023, 21000.00, 'Sedan, Hybrid, Automatic', NULL, NULL),
(19, 'Kia', 'Sorento', 2022, 28000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(20, 'Jeep', 'Wrangler', 2023, 45000.00, 'SUV, 4x4, Manual', NULL, NULL),
(21, 'Subaru', 'Outback', 2022, 32000.00, 'Crossover, AWD, Automatic', NULL, NULL),
(22, 'Mazda', 'CX-5', 2023, 29000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(23, 'Volkswagen', 'Passat', 2021, 27000.00, 'Sedan, Gasoline, Automatic', NULL, NULL),
(24, 'Volvo', 'XC90', 2023, 70000.00, 'SUV, Hybrid, Automatic', NULL, NULL),
(25, 'Porsche', '911', 2022, 100000.00, 'Coupe, Gasoline, Manual', NULL, NULL),
(26, 'Lexus', 'RX 350', 2023, 50000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(27, 'Jaguar', 'XF', 2022, 60000.00, 'Sedan, Gasoline, Automatic', NULL, NULL),
(28, 'Land Rover', 'Defender', 2023, 75000.00, 'SUV, 4x4, Automatic', NULL, NULL),
(29, 'Chevrolet', 'Tahoe', 2023, 55000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(30, 'GMC', 'Sierra', 2022, 52000.00, 'Truck, Gasoline, Automatic', NULL, NULL),
(31, 'Ram', '1500', 2021, 48000.00, 'Truck, Diesel, Automatic', NULL, NULL),
(32, 'Toyota', 'RAV4', 2023, 29000.00, 'SUV, Hybrid, AWD', NULL, NULL),
(33, 'Honda', 'CR-V', 2022, 30000.00, 'SUV, Gasoline, Automatic', NULL, NULL),
(36, 'abc', 'abs', 2020, 200000.00, 'great car', NULL, 'upload/images/resized_67485ed7a8fac.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ContactId`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`PageId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`VehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ContactId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `PageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `VehicleID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicles` (`VehicleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
