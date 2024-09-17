INSERT INTO users (pronouns, givenname, surname, username, email, role, password_hash, salt) VALUES
('he/him', 'John', 'Doe', 'johndoe', 'john@example.com', 'admin', 'hashedpassword1', 'salt1'),
('she/her', 'Jane', 'Smith', 'janesmith', 'jane@example.com', 'user', 'hashedpassword2', 'salt2'),
('they/them', 'Alex', 'Johnson', 'alexjohnson', 'alex@example.com', 'user', 'hashedpassword3', 'salt3'),
('he/him', 'Michael', 'Brown', 'michaelbrown', 'michael@example.com', 'user', 'hashedpassword4', 'salt4'),
('she/her', 'Emily', 'Davis', 'emilydavis', 'emily@example.com', 'user', 'hashedpassword5', 'salt5'),
('they/them', 'Taylor', 'Wilson', 'taylorwilson', 'taylor@example.com', 'user', 'hashedpassword6', 'salt6');

INSERT INTO rooms (room_number, type, status) VALUES
('101', 'Single', 'free'),
('102', 'Double', 'booked'),
('103', 'Suite', 'reserved'),
('104', 'Single', 'free'),
('105', 'Double', 'booked'),
('106', 'Suite', 'free');

INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date) VALUES
(1, 1, '2023-10-20', '2023-10-25'),
(2, 4, '2023-11-01', '2023-11-05'),
(3, 5, '2023-11-10', '2023-11-15'),
(2, 2, '2023-10-01', '2023-10-05'),
(3, 3, '2023-10-10', '2023-10-15');