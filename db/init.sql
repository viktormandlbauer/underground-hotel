-- Use the newly created database
USE hotel;

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

-- Create rooms table
CREATE TABLE rooms (
    room_id INT PRIMARY KEY AUTO_INCREMENT,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    type VARCHAR(50) NOT NULL,
    status ENUM('booked', 'free', 'reserved') NOT NULL
);

-- Create bookings table
CREATE TABLE bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    room_id INT,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- Create payments news
CREATE TABLE news (
    news_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    text VARCHAR(5000) NOT NULL,
);

-- Create a view to join users, bookings, and rooms and group by users
CREATE VIEW user_bookings AS
SELECT 
    u.user_id,
    u.name,
    u.email,
    COUNT(b.booking_id) AS total_bookings,
    GROUP_CONCAT(r.room_number ORDER BY b.check_in_date) AS booked_rooms
FROM 
    users u
INNER JOIN 
    bookings b ON u.user_id = b.user_id
INNER JOIN 
    rooms r ON b.room_id = r.room_id
GROUP BY 
    u.user_id, u.name, u.email;

-- Create a trigger to update the status of a room to 'booked' when a new booking is made
CREATE TRIGGER update_room_status
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    UPDATE rooms
    SET status = 'booked'
    WHERE room_id = NEW.room_id;
END

