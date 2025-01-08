INSERT INTO users (pronouns, givenname, surname, username, email, role, user_state, newsletter, password_hash, salt, telephone, country, city, postal_code, street, house_number)
VALUES
('Herr', 'John', 'Doe', 'johndoe', 'john.doe@example.com', 'user', 'active', TRUE, 'dummyhash1', 'dummysalt1', '+123456789', 'Germany', 'Berlin', '10115', 'Main Street', '12A'),
('Frau', 'Jane', 'Smith', 'janesmith', 'jane.smith@example.com', 'user', 'active', FALSE, 'dummyhash2', 'dummysalt2', '+987654321', 'Germany', 'Munich', '80331', 'Oak Avenue', '5B'),
('Herr', 'Albert', 'Brown', 'albertbrown', 'albert.brown@example.com', 'employee', 'active', FALSE, 'dummyhash3', 'dummysalt3', '+1122334455', 'Germany', 'Hamburg', '20457', 'River Road', '9'),
('Frau', 'Clara', 'Johnson', 'clarajohnson', 'clara.johnson@example.com', 'admin', 'active', TRUE, 'dummyhash4', 'dummysalt4', '+5566778899', 'Germany', 'Frankfurt', '60313', 'Maple Street', '3C');

INSERT INTO rooms (number, name, type, description, image_path, price_per_night)
VALUES
(101, 'Single Room 101', 'single', 'A cozy single room with a city view.', NULL, 80.00),
(102, 'Double Room 102', 'double', 'Spacious double room perfect for couples.', NULL, 120.00),
(201, 'Suite 201', 'suite', 'Luxurious suite with a panoramic view and extra amenities.', NULL, 250.00),
(202, 'Single Room 202', 'single', 'Quiet single room with modern decor.', NULL, 85.00);

INSERT INTO bookings (user_id, room_number, check_in_date, check_out_date, price_per_night, status, breakfast, parking, pet, additional_info)
VALUES
(1, 101, '2025-01-15', '2025-01-17', 80.00, 'approved', TRUE, FALSE, FALSE, 'Preferred a room on a higher floor.'),
(2, 102, '2025-01-18', '2025-01-20', 120.00, 'new', TRUE, TRUE, TRUE, 'Bringing a small dog.'),
(1, 201, '2025-02-01', '2025-02-05', 250.00, 'canceled', FALSE, TRUE, FALSE, 'Changed travel plans.'),
(3, 202, '2025-01-10', '2025-01-12', 85.00, 'approved', TRUE, FALSE, FALSE, 'Early check-in requested.');

INSERT INTO news (title, content, image_path, created_by)
VALUES
('Welcome to Underground Hotel', 'We are delighted to have you here. Enjoy your stay!', '/images/welcome.jpg', 4),
('Winter Specials', 'Book now and enjoy our exclusive winter discounts.', NULL, 4),
('New Amenities Added', 'Our hotel now offers a fitness center and spa.', NULL, 3),
('COVID-19 Updates', 'Your health and safety are our top priority.', NULL, 4);
