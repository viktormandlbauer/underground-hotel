-- Use the newly created database
USE hotel;

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    pronouns VARCHAR(10) NOT NULL,
    givenname VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL,
    password_hash VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL
);

-- Create rooms table
CREATE TABLE rooms (
    room_id INT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    description VARCHAR(500),
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

-- Create news
CREATE TABLE news (
    news_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    text VARCHAR(5000) NOT NULL
);

-- Create a view to join users, bookings, and rooms and group by users
CREATE VIEW user_bookings AS
SELECT 
    u.user_id,
    u.pronouns,
    u.surname,
    u.givenname,
    u.username,
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
    u.user_id;

-- Create initial admin user with password 'underground-hotel'
INSERT INTO users (pronouns, givenname, surname, username, email, role, password_hash, salt) 
VALUES ('Mr', 'hotel', 'admin', 'admin', 'admin@underground-hotel.de', 'admin', 'e93730fa0232088ea4d810ebf625686291ff6977e1fdb4f6569252fd40b1f796', '0088359d9501078e5a16c7fcbaffdfd6');