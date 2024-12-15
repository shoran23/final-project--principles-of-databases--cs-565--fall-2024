\W -- Enable all warnings

DROP DATABASE IF EXISTS passwords;

CREATE DATABASE IF NOT EXISTS `passwords` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE USER IF NOT EXISTS 'passwords_user'@'localhost' IDENTIFIED BY 'k(D2Whiue9d8yD';
GRANT ALL PRIVILEGES ON passwords.* TO 'passwords_user'@'localhost';

USE passwords;

SET block_encryption_mode = 'aes-256-cbc';
SET @key_str = UNHEX(SHA2('my secret passphrase', 512));
SET @init_vector = RANDOM_BYTES(32);
SET @test = 'test';

SOURCE create-user-table.sql;
SOURCE create-account-table.sql;