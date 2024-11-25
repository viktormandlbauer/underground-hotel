INSERT INTO users (pronouns, givenname, surname, username, email, role, password_hash, salt) VALUES
('he/him', 'John', 'Doe', 'johndoe', 'john@example.com', 'admin', 'hashedpassword1', 'salt1'),
('she/her', 'Jane', 'Smith', 'janesmith', 'jane@example.com', 'user', 'hashedpassword2', 'salt2'),
('they/them', 'Alex', 'Johnson', 'alexjohnson', 'alex@example.com', 'user', 'hashedpassword3', 'salt3'),
('he/him', 'Michael', 'Brown', 'michaelbrown', 'michael@example.com', 'user', 'hashedpassword4', 'salt4'),
('she/her', 'Emily', 'Davis', 'emilydavis', 'emily@example.com', 'user', 'hashedpassword5', 'salt5'),
('they/them', 'Taylor', 'Wilson', 'taylorwilson', 'taylor@example.com', 'user', 'hashedpassword6', 'salt6');

INSERT INTO rooms (room_number, type, description, price_per_night) VALUES
(201, 'Single', 'A single room with a single bed', 50.00),
(202, 'Double', 'A double room with a double bed', 75.00),
(203, 'Suite', 'A suite with a living area and bedroom', 150.00),
(204, 'Single', 'A single room with a single bed', 50.00),
(205, 'Double', 'A double room with a double bed', 75.00),
(206, 'Suite', 'A suite with a living area and bedroom', 150.00);

INSERT INTO bookings (username, room_number, check_in_date, check_out_date) VALUES
('johndoe', 201, '2023-10-20', '2023-10-25'),
('janesmith', 204, '2023-11-01', '2023-11-05'),
('alexjohnson', 205, '2023-11-10', '2023-11-15'),
('michaelbrown', 202, '2023-10-01', '2023-10-05'),
('alexjohnson', 203, '2023-10-10', '2023-10-15');