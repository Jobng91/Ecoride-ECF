CREATE TABLE IF NOT EXISTS disputes (
    dispute_id INT PRIMARY KEY AUTO_INCREMENT,
    complaint TEXT NOT NULL,
    is_resolve ENUM('En attente', 'Résolu', 'Fermé') NOT NULL,
    complaignant_id INT NOT NULL,
    reported_user_id INT NOT NULL,
    payment_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (complaignant_id) REFERENCES users(user_id),
    FOREIGN KEY (reported_user_id) REFERENCES users(user_id),
    FOREIGN KEY (payment_id) REFERENCES payments(payment_id)
);