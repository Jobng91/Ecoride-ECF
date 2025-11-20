CREATE TABLE IF NOT EXISTS payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(6, 2) NOT NULL,
    commission DECIMAL(6, 2) NOT NULL,
    payment_state ENUM('En attente', 'Effectué', 'Annulé','Remboursé') NOT NULL,
    date_course DATETIME NOT NULL,
    date_transfer DATETIME,
    reservation_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id)
);
