-- CREATE TABLE users (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   email VARCHAR(150) NOT NULL UNIQUE,
--   password VARCHAR(191) NOT NULL,
--   balance DECIMAL(15, 2) NOT NULL,
--   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- CREATE TABLE stocks (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     symbol VARCHAR(191) NOT NULL UNIQUE,
--     name VARCHAR(191) NOT NULL,
--     price FLOAT NOT NULL,
--     created_at TIMESTAMP NULL DEFAULT NULL,
--     updated_at TIMESTAMP NULL DEFAULT NULL
-- );


-- CREATE TABLE trades (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT UNSIGNED NOT NULL,
--     stock_id INT UNSIGNED NOT NULL,
--     type ENUM('buy', 'sell') NOT NULL,
--     quantity INT NOT NULL,
--     price FLOAT NOT NULL,
--     created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT fk_trades_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
--     CONSTRAINT fk_trades_stock FOREIGN KEY (stock_id) REFERENCES stocks(id) ON DELETE CASCADE
-- );

-- CREATE TABLE transactions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT UNSIGNED NOT NULL,
--     type ENUM('deposit', 'withdraw') NOT NULL,
--     amount FLOAT NOT NULL,
--     created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );

-- INSERT INTO users(
--   email,
--   password,
--   balance
-- ) VALUES (
--   'user@gmail.com',
--   '$argon2i$v=19$m=65536,t=4,p=1$Llp6bzllRXZ5b0hNcU1VTw$+9a7QY0V0iY6EB9n+5llTQJ13ZAKxNd0ra6p50loMjk',
--   200.00
-- )