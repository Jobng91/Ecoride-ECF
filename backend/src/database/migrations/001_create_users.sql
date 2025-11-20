CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL, 
    username VARCHAR(50) NOT NULL,
    user_role ENUM('Chauffeur', 'Passager','Employé','Admin') NOT NULL,
    picture VARCHAR(255),
    credit INT NOT NULL DEFAULT 0,
    passwordHash VARCHAR(255) NOT NULL,
    auth_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);