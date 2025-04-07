-- Database schema for Surat Management System
CREATE DATABASE IF NOT EXISTS surat_masama;

USE surat_masama;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Incoming letters table
CREATE TABLE IF NOT EXISTS surat_masuk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) UNIQUE NOT NULL,
    tanggal DATE NOT NULL,
    perihal TEXT NOT NULL,
    pengirim VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tanggal (tanggal)
);

-- Outgoing letters table
CREATE TABLE IF NOT EXISTS surat_keluar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) UNIQUE NOT NULL,
    tanggal DATE NOT NULL,
    perihal TEXT NOT NULL,
    tujuan VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tanggal (tanggal)
);

-- Sample admin user (password: admin123)
INSERT INTO users (username, password, role) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');