INSERT INTO users (name, email, phone, role) VALUES
('Alice Brown', 'alice@example.com', '555-1234', 'client'),
('Bob Green', 'bob@example.com', '555-5678', 'client'),
('Chef Emma', 'emma@chefs.com', '555-6789', 'chef'),
('Chef Liam', 'liam@chefs.com', '555-7890', 'chef');

CREATE TABLE clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
    requests TEXT,
    FOREIGN KEY (user_id) References users(user_id) ON
    DELETE cascade 
);
INSERT INTO clients (user_id, requests) VALUES
(1, 'Gluten-free and vegan options requested'),
(2, 'Low-carb meals for weight loss');


CREATE TABLE chefs (
    chef_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    specialty VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO chefs (user_id, specialty) VALUES
(3, 'Italian Cuisine'),
(4, 'Japanese Cuisine');

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    chef_id INT NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (chef_id) REFERENCES chefs(chef_id)
);

INSERT INTO services (chef_id, service_name, price) VALUES
(1, 'Italian Dinner for Two', 120.00),
(1, 'Weekly Meal Prep', 300.00),
(2, 'Sushi Night', 150.00),
(2, 'Kaiseki Dinner', 200.00);

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    service_id INT NOT NULL,
    booking_date DATE NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(client_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);

INSERT INTO bookings (client_id, service_id, booking_date, status, total_price) VALUES
(1, 1, '2025-03-10', 'confirmed', 120.00),
(1, 2, '2025-03-15', 'pending', 300.00),
(2, 3, '2025-03-20', 'confirmed', 150.00),
(2, 4, '2025-03-25', 'completed', 200.00);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    payment_date DATETIME NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('credit_card', 'paypal', 'cash') DEFAULT 'credit_card',
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)
);

INSERT INTO payments (booking_id, payment_date, amount, payment_method) VALUES
(1, '2025-03-09 14:00:00', 120.00, 'credit_card'),
(3, '2025-03-19 10:00:00', 150.00, 'paypal'),
(4, '2025-03-24 18:00:00', 200.00, 'cash');

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)
);

INSERT INTO reviews (booking_id, rating, comment) VALUES
(1, 5, 'Amazing Italian dinner! Highly recommend.'),
(4, 4, 'Great experience, but a bit pricey.');


SELECT * FROM users;
SELECT * FROM clients;
SELECT * FROM chefs;
SELECT * FROM services;
SELECT * FROM bookings;
SELECT * FROM payments;
SELECT * FROM reviews;
