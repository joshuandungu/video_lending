CREATE DATABASE IF NOT EXISTS video_lending;
USE video_lending;

-- users tables -->

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users MODIFY password VARCHAR(255);

-- videos table -->
CREATE TABLE  IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    description TEXT,
    genre VARCHAR(50),
    thumbnail VARCHAR(255),
    file_path VARCHAR(255),
    price DECIMAL(5,2),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Rentals table -->
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    video_id INT,
    rented_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE,
    returned BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (video_id) REFERENCES videos(id)
);


-- Reviews table --
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT,
    user_id INT,
    rating TINYINT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (video_id) REFERENCES videos(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

ALTER TABLE rentals ADD late_fee DECIMAL(5,2) DEFAULT 0;

-- pyaments table -->
CREATE TABLE IF NOT EXISTS  payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rental_id INT,
    user_id INT,
    amount DECIMAL(10, 2),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_status ENUM('success', 'failed') DEFAULT 'success',
    FOREIGN KEY (rental_id) REFERENCES rentals(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
