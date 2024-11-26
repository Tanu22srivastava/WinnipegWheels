INSERT INTO Vehicles (Manufacturer, Model, Year, Price, Specifications) 
VALUES
('Toyota', 'Camry', 2022, 25000, 'Sedan, Hybrid, Automatic'),
('Honda', 'Civic', 2023, 22000, 'Compact, Gasoline, Manual'),
('Ford', 'F-150', 2021, 35000, 'Truck, Gasoline, Automatic'),
('Tesla', 'Model S', 2022, 80000, 'Electric, AWD, Autonomous'),
('BMW', 'X5', 2023, 60000, 'SUV, Diesel, Automatic'),
('Mercedes', 'C-Class', 2022, 55000, 'Sedan, Gasoline, Automatic'),
('Audi', 'Q7', 2023, 65000, 'SUV, Gasoline, Automatic'),
('Chevrolet', 'Malibu', 2021, 24000, 'Sedan, Gasoline, Automatic'),
('Nissan', 'Altima', 2022, 23000, 'Sedan, Gasoline, CVT'),
('Hyundai', 'Elantra', 2023, 21000, 'Sedan, Hybrid, Automatic'),
('Kia', 'Sorento', 2022, 28000, 'SUV, Gasoline, Automatic'),
('Jeep', 'Wrangler', 2023, 45000, 'SUV, 4x4, Manual'),
('Subaru', 'Outback', 2022, 32000, 'Crossover, AWD, Automatic'),
('Mazda', 'CX-5', 2023, 29000, 'SUV, Gasoline, Automatic'),
('Volkswagen', 'Passat', 2021, 27000, 'Sedan, Gasoline, Automatic'),
('Volvo', 'XC90', 2023, 70000, 'SUV, Hybrid, Automatic'),
('Porsche', '911', 2022, 100000, 'Coupe, Gasoline, Manual'),
('Lexus', 'RX 350', 2023, 50000, 'SUV, Gasoline, Automatic'),
('Jaguar', 'XF', 2022, 60000, 'Sedan, Gasoline, Automatic'),
('Land Rover', 'Defender', 2023, 75000, 'SUV, 4x4, Automatic'),
('Chevrolet', 'Tahoe', 2023, 55000, 'SUV, Gasoline, Automatic'),
('GMC', 'Sierra', 2022, 52000, 'Truck, Gasoline, Automatic'),
('Ram', '1500', 2021, 48000, 'Truck, Diesel, Automatic'),
('Toyota', 'RAV4', 2023, 29000, 'SUV, Hybrid, AWD'),
('Honda', 'CR-V', 2022, 30000, 'SUV, Gasoline, Automatic');


ALTER TABLE Pages ADD COLUMN Keywords TEXT;

INSERT INTO `pages` (`PageId`, `PageName`, `PageContent`, `PageURL`, `Keywords`) VALUES
(1, 'Vehicles', 'This page contains information about various vehicles.', 'read.php', 'Vehicles, Manufacturer, Specification, Automatic, Model, Gasoline, speed, Hybrid, Sedan, Compact, Truck, Manual'),
(2, 'About Us', 'Learn more about our company, mission, and vision.', 'about_us.php', 'Vehicles, About, Contact, mission, Company'),
(3, 'Contact Us', 'Get in touch with us through this page.', 'contact_us.php', 'Vehicles, Manufacturer, Specification, contact, query, customer, services, touch');
