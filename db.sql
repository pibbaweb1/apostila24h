-- db.sql
CREATE DATABASE IF NOT EXISTS ml_integration CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ml_integration;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200),
  email VARCHAR(200)
);

CREATE TABLE ml_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  access_token TEXT NOT NULL,
  refresh_token TEXT NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE ml_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  local_sku VARCHAR(100) DEFAULT NULL,
  ml_item_id VARCHAR(100) DEFAULT NULL,
  title VARCHAR(255),
  price DECIMAL(10,2),
  quantity INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(255),
  customer_email VARCHAR(255),
  items_json TEXT,
  total DECIMAL(10,2),
  status VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* optional: seed a default admin user with id=1 */
INSERT INTO users (name,email) VALUES ('Admin','admin@seusite.com');
