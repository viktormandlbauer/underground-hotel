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
    image_path VARCHAR(100),
    price_per_night DECIMAL(10, 2) NOT NULL
);

-- Create bookings table
CREATE TABLE bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    room_id INT,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    breakfast BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- Create news
CREATE TABLE news (
    news_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    text VARCHAR(5000) NOT NULL
);

-- Create initial admin user with password 'underground-hotel'
INSERT INTO users (pronouns, givenname, surname, username, email, role, password_hash, salt) 
VALUES ('Mr', 'hotel', 'admin', 'admin', 'admin@underground-hotel.de', 'admin', 'e93730fa0232088ea4d810ebf625686291ff6977e1fdb4f6569252fd40b1f796', '0088359d9501078e5a16c7fcbaffdfd6');