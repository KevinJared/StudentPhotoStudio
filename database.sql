-- Student Photo Studio database schema
CREATE DATABASE IF NOT EXISTS student_photo_studio
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_photo_studio;

CREATE TABLE IF NOT EXISTS students (
  admno VARCHAR(100) NOT NULL,
  student_name VARCHAR(255) NOT NULL DEFAULT '',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (admno)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS student_photos (
  admno VARCHAR(100) NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  storage_name VARCHAR(80) NOT NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (admno)
  -- Photos are intentionally independent of the current register so clearing
  -- or replacing a register does not delete existing photographs.
) ENGINE=InnoDB;
