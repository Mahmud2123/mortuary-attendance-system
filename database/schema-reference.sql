-- =====================================================
-- Mortuary Attendance Management System - Schema Reference
-- This is a REFERENCE dump matching the Laravel migrations.
-- Prefer running `php artisan migrate --seed` instead — it
-- keeps Eloquent models, timestamps, and soft-deletes in sync.
-- Use this file only if you need to inspect/import the schema
-- manually outside of Artisan.
-- =====================================================

CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) NOT NULL,
  staff_id VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','attendant','management') NOT NULL DEFAULT 'attendant',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS chambers (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  location VARCHAR(255) NOT NULL,
  capacity INT NOT NULL DEFAULT 1,
  current_occupancy INT NOT NULL DEFAULT 0,
  status ENUM('available','full','maintenance') NOT NULL DEFAULT 'available',
  notes TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS bodies (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ref_number VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(255) NOT NULL,
  age INT NULL,
  sex ENUM('male','female','unknown') NOT NULL DEFAULT 'unknown',
  nationality VARCHAR(100) NOT NULL DEFAULT 'Nigerian',
  date_of_death DATE NULL,
  time_of_death TIME NULL,
  cause_of_death VARCHAR(255) NULL,
  place_of_death VARCHAR(255) NULL,
  admitted_by BIGINT UNSIGNED NOT NULL,
  chamber_id BIGINT UNSIGNED NULL,
  status ENUM('admitted','in_storage','released','transferred') NOT NULL DEFAULT 'admitted',
  notes TEXT NULL,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (admitted_by) REFERENCES users(id),
  FOREIGN KEY (chamber_id) REFERENCES chambers(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS next_of_kins (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  body_id BIGINT UNSIGNED NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  relationship VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(255) NULL,
  id_type VARCHAR(50) NULL,
  id_number VARCHAR(50) NULL,
  address VARCHAR(255) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (body_id) REFERENCES bodies(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS body_chamber_assignments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  body_id BIGINT UNSIGNED NOT NULL,
  chamber_id BIGINT UNSIGNED NOT NULL,
  assigned_at TIMESTAMP NOT NULL,
  vacated_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (body_id) REFERENCES bodies(id) ON DELETE CASCADE,
  FOREIGN KEY (chamber_id) REFERENCES chambers(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS attendance_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  staff_id BIGINT UNSIGNED NOT NULL,
  clock_in TIMESTAMP NOT NULL,
  clock_out TIMESTAMP NULL,
  duration_hours DECIMAL(5,2) NULL,
  notes TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS body_releases (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  body_id BIGINT UNSIGNED NOT NULL,
  released_by BIGINT UNSIGNED NOT NULL,
  kin_id BIGINT UNSIGNED NULL,
  release_date DATE NOT NULL,
  notes TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (body_id) REFERENCES bodies(id),
  FOREIGN KEY (released_by) REFERENCES users(id),
  FOREIGN KEY (kin_id) REFERENCES next_of_kins(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  action VARCHAR(50) NOT NULL,
  table_name VARCHAR(100) NOT NULL,
  record_id BIGINT UNSIGNED NULL,
  old_data JSON NULL,
  new_data JSON NULL,
  ip_address VARCHAR(45) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
