CREATE DATABASE IF NOT EXISTS database_sikatbukutamu CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE database_sikatbukutamu;

CREATE TABLE IF NOT EXISTS tamu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  keperluan ENUM('Keluarga','Teman','Rekan') NOT NULL,
  area VARCHAR(50) NOT NULL,
  luar_provinsi ENUM('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  waktu DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
