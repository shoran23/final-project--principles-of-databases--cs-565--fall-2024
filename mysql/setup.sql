DROP DATABASE IF EXISTS password;

CREATE DATABASE IF NOT EXISTS `passwords` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE USER IF NOT EXISTS 'passwords_user'@'localhost' IDENTIFIED BY 'k(D2Whiue9d8yD';
GRANT ALL PRIVILEGES ON passwords.* TO 'passwords_user'@'localhost';

USE passwords;

SOURCE create-user-table.sql;
SOURCE create-account-table.sql;