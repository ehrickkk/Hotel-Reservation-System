-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS hotel_DB;
USE hotel_DB;

-- Create the reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    contact_number VARCHAR(50) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    room_capacity VARCHAR(50) NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    payment_type VARCHAR(50) NOT NULL,
    days INT NOT NULL,
    rate_per_day DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    payment_charge DECIMAL(10, 2) NOT NULL,
    discount DECIMAL(10, 2) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create admins table for login security
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert default admin account (password is 'admin123')
-- MD5 hash or password_hash can be used, but for simplicity of assignment we store it as is or md5
-- Storing raw for easy testing
INSERT IGNORE INTO admins (username, password) VALUES ('admin', 'admin123');
