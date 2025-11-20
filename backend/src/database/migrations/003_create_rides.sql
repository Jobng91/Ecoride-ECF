CREATE TABLE IF NOT EXISTS rides (
    ride_id INT PRIMARY KEY AUTO_INCREMENT,
    price DECIMAL(6, 2) NOT NULL,
    course_state ENUM('En attente du départ','Trajet en cours', 'Arrivé', 'Annulé') NOT NULL,
    date_departure DATETIME NOT NULL,
    date_arrival DATETIME,
    city_departure VARCHAR(100) NOT NULL,
    city_arrival VARCHAR(100) NOT NULL,
    duration INT,
    driver_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES users(user_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id)
);