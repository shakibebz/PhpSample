CREATE DATABASE test;
USE test;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS users (

    Id INT AUTO_INCREMENT PRIMARY KEY,
    email varchar(30) NOT NULL UNIQUE,
    pass varchar(60) NOT NULL,
    role_id INT NOT NULL,
    );

--
-- Table structure for table `roll`
--
CREATE TABLE IF NOT EXISTS roles (
      Id INT AUTO_INCREMENT PRIMARY KEY,
     role_name VARCHAR(50) NOT NULL UNIQUE
    );


-- Insert rolls
INSERT INTO roles (role_name) VALUES ('Admin'), ('Author'), ('Student');



select * from roles;
