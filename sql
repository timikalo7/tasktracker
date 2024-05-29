-- Create the tasktracker database
CREATE DATABASE IF NOT EXISTS tasktracker;

-- Use the tasktracker database
USE tasktracker;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);

-- Create the tasks table
CREATE TABLE IF NOT EXISTS tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    task_name VARCHAR(255) NOT NULL,
    task_description TEXT,
    completed BOOLEAN DEFAULT false,
    due_date DATE,
    FOREIGN KEY (username) REFERENCES users(username)
);

mysql -u root -p

CREATE USER IF NOT EXISTS 'kalejoo'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON tasktracker.* TO 'kalejoo'@'localhost';
