USE hotel;

INSERT INTO users (pronouns, givenname, surname, username, email, role, user_state, newsletter, password_hash, salt, telephone, country, city, postal_code, street, house_number)
VALUES
('Herr', 'John', 'Doe', 'johndoe', 'john.doe@example.com', 'user', 'active', 1, 'dummyhash1', 'dummysalt1', '+123456789', 'Germany', 'Berlin', '10115', 'Main Street', '12A'),
('Frau', 'Jane', 'Smith', 'janesmith', 'jane.smith@example.com', 'user', 'active', 1 , 'dummyhash2', 'dummysalt2', '+987654321', 'Germany', 'Munich', '80331', 'Oak Avenue', '5B'),
('Herr', 'Albert', 'Brown', 'albertbrown', 'albert.brown@example.com', 'employee', 'active', 0, 'dummyhash3', 'dummysalt3', '+1122334455', 'Germany', 'Hamburg', '20457', 'River Road', '9'),
('Frau', 'Clara', 'Johnson', 'clarajohnson', 'clara.johnson@example.com', 'admin', 'active', 1, 'dummyhash4', 'dummysalt4', '+5566778899', 'Germany', 'Frankfurt', '60313', 'Maple Street', '3C');

INSERT INTO rooms (number, name, type, description, image_path, price_per_night)
VALUES
(101, 'Single Room 101', 'single', 'A cozy single room with a city view.', 0, 80.00),
(102, 'Double Room 102', 'double', 'Spacious double room perfect for couples.', 0, 120.00),
(201, 'Suite 201', 'suite', 'Luxurious suite with a panoramic view and extra amenities.', 0, 250.00),
(202, 'Single Room 202', 'single', 'Quiet single room with modern decor.', 0, 85.00);

INSERT INTO bookings (user_id, room_number, check_in_date, check_out_date, price_per_night, total_price, status, breakfast, parking, pet, additional_info)
VALUES
(1, 101, '2025-01-15', '2025-01-17', 80.00, 180.00, 'approved', 1, 0, 0, 'Preferred a room on a higher floor.'),
(2, 102, '2025-01-18', '2025-01-20', 120.00, 274.00, 'new', 1, 1, 1, 'Bringing a small dog.'),
(1, 201, '2025-02-01', '2025-02-05', 250.00, 1028.00, 'canceled', 0, 1, 0, 'Changed travel plans.'),
(3, 202, '2025-01-10', '2025-01-12', 85.00, 190.00, 'approved', 1, 0, 0, 'Early check-in requested.');

INSERT INTO news (title, content, image_path, created_by)
VALUES
('Welcome to Underground Hotel', 'We are delighted to have you here. Enjoy your stay!', 0, 4),
('Winter Specials', 'Book now and enjoy our exclusive winter discounts.', 0, 4),
('New Amenities Added', 'Our hotel now offers a fitness center and spa.', 0, 3),
('COVID-19 Updates', 'Your health and safety are our top priority.', 0, 4);
