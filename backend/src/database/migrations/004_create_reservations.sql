CREATE TABLE IF NOT EXISTS reservations(
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    reservation_state ENUM('En attente du départ','Trajet en cours', 'En attente de validation', 'Validé', 'Annulé') NOT NULL,
    date_reservation DATETIME NOT NULL,
    ride_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ride_id) REFERENCES rides(ride_id)
);