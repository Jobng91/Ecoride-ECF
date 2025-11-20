CREATE TABLE IF NOT EXISTS vehicles (
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    license_plate VARCHAR(15) NOT NULL,
    marque VARCHAR(30) NOT NULL,
    color VARCHAR(20),
    model VARCHAR(20) NOT NULL,
    capacity INT NOT NULL,
    energy_type ENUM('Électrique', 'Hybride', 'Essence', 'Diesel') NOT NULL,
    driver_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES users(user_id)
    );