-- Runs once, when the MariaDB volume is first created: a separate database for PHPUnit (RefreshDatabase wipes it).
CREATE DATABASE IF NOT EXISTS talkila_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON talkila_test.* TO 'talkila'@'%';
