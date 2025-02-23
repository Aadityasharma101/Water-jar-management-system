ALTER TABLE users
ADD COLUMN phone VARCHAR(20) AFTER email;

ALTER TABLE water_records 
ADD COLUMN customer_name VARCHAR(100) AFTER id,
ADD COLUMN water_quantity INT AFTER customer_name,
ADD COLUMN phone VARCHAR(20) AFTER water_quantity,
ADD COLUMN email VARCHAR(100) AFTER phone,
ADD COLUMN delivery_date DATE AFTER email;

CREATE TABLE IF NOT EXISTS water_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    water_quantity INT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    delivery_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending'
); 