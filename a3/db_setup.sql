CREATE DATABASE IF NOT EXISTS petconnect DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

USE petconnect;

CREATE TABLE IF NOT EXISTS users (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)   NOT NULL UNIQUE,
    email       VARCHAR(100)  NOT NULL UNIQUE,
    password    CHAR(60)      NOT NULL,
    phone       VARCHAR(20),
    location    VARCHAR(100),
    joined_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pets (
    pet_id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT           NOT NULL,
    name            VARCHAR(100)  NOT NULL,
    species         ENUM('Dog','Cat','Bird','Rabbit','Other') NOT NULL DEFAULT 'Dog',
    breed           VARCHAR(100),
    age_years       INT,
    age_months      INT,
    gender          ENUM('Male','Female','Unknown') NOT NULL DEFAULT 'Unknown',
    size            ENUM('Small','Medium','Large','Extra Large') NOT NULL DEFAULT 'Medium',
    description     TEXT          NOT NULL,
    health_info     TEXT,
    image_path      VARCHAR(255),
    adoption_fee    DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
    status          ENUM('Available','Pending','Adopted') NOT NULL DEFAULT 'Available',
    created_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (username, email, password, phone, location) VALUES
    ('sarah_animal_lover', 'sarah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0101', 'Melbourne, VIC'),
    ('john_foster', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0102', 'Sydney, NSW'),
    ('emma_petcare', 'emma@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0103', 'Brisbane, QLD'),
    ('mike_rescuer', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0104', 'Perth, WA'),
    ('lisa_shelter', 'lisa@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0105', 'Adelaide, SA');

INSERT INTO pets (user_id, name, species, breed, age_years, age_months, gender, size, description, health_info, image_path, adoption_fee, status) VALUES
    (1, 'Buddy', 'Dog', 'Golden Retriever', 3, 6, 'Male', 'Large', 'Friendly and energetic golden retriever looking for an active family. Loves playing fetch and swimming.', 'Fully vaccinated, microchipped, neutered. No known health issues.', '1.jpg', 250.00, 'Available'),
    (1, 'Whiskers', 'Cat', 'Tabby', 2, 0, 'Female', 'Small', 'Sweet and affectionate tabby cat. Great with children and other cats. Indoor cat preferred.', 'Vaccinated, spayed, microchipped. Healthy.', '2.jpg', 150.00, 'Available'),
    (2, 'Max', 'Dog', 'Labrador Mix', 5, 0, 'Male', 'Large', 'Gentle giant who loves cuddles. Well-trained and house-broken. Perfect family dog.', 'Vaccinated, neutered, microchipped. Mild arthritis managed with supplements.', '3.jpg', 200.00, 'Available'),
    (3, 'Charlie', 'Bird', 'Cockatiel', 2, 0, 'Male', 'Small', 'Hand-raised cockatiel who loves to whistle and interact. Comes with cage and toys.', 'Healthy, vet checked. Can mimic simple tunes.', '5.jpg', 120.00, 'Available'),
    (2, 'Luna', 'Cat', 'Siamese', 1, 8, 'Female', 'Medium', 'Playful and curious Siamese kitten. Very vocal and loves attention. Needs an interactive owner.', 'Fully vaccinated, spayed, microchipped.', '4.jpg', 180.00, 'Pending'),
    (3, 'Bella', 'Dog', 'Beagle', 4, 3, 'Female', 'Medium', 'Sweet beagle with excellent temperament. Good with kids and other dogs. Loves walks.', 'Vaccinated, spayed, microchipped. Healthy.', '6.jpg', 220.00, 'Available'),
    (4, 'Oliver', 'Cat', 'Persian', 3, 0, 'Male', 'Medium', 'Laid-back Persian cat who enjoys quiet environments. Requires regular grooming.', 'Vaccinated, neutered, microchipped. Healthy coat.', '7.jpg', 200.00, 'Available'),
    (5, 'Rocky', 'Dog', 'German Shepherd', 6, 0, 'Male', 'Extra Large', 'Loyal and protective German Shepherd. Experienced owner preferred. Excellent guard dog.', 'Vaccinated, neutered, microchipped. Hip dysplasia managed.', '8.jpg', 180.00, 'Available');
