-- PetConnect Database Setup
-- Local: database name is 'petconnect'
-- On Jacob 5 (jupiter.csit.rmit.edu.au): database name is the student ID 's4092023'

CREATE DATABASE IF NOT EXISTS `petconnect`;
USE `petconnect`;

CREATE TABLE IF NOT EXISTS `pets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `species` VARCHAR(50) NOT NULL,
  `breed` VARCHAR(100) DEFAULT NULL,
  `gender` VARCHAR(20) NOT NULL,
  `size` VARCHAR(20) NOT NULL,
  `age_years` INT DEFAULT 0,
  `age_months` INT DEFAULT 0,
  `adoption_fee` DECIMAL(10,2) NOT NULL,
  `description` TEXT NOT NULL,
  `health_info` TEXT DEFAULT NULL,
  `status` ENUM('available','pending','adopted') NOT NULL DEFAULT 'available',
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `pets` (`name`, `species`, `breed`, `gender`, `size`, `age_years`, `age_months`, `adoption_fee`, `description`, `health_info`, `status`, `image`) VALUES
('Buddy', 'Dog', 'Golden Retriever', 'Male', 'Large', 3, 6, 250.00, 'Friendly and energetic golden retriever looking for an active family. Loves playing fetch and swimming.', 'Fully vaccinated, microchipped, neutered. No known health issues.', 'available', 'buddy.jpg'),
('Whiskers', 'Cat', 'Tabby', 'Female', 'Small', 3, 0, 150.00, 'Gentle and affectionate tabby cat who loves to cuddle. Great with children.', 'Vaccinated, spayed, regular vet checkups.', 'available', 'whiskers.jpg'),
('Max', 'Dog', 'Labrador Mix', 'Male', 'Large', 1, 6, 200.00, 'Playful young labrador mix full of energy. Would love a home with a yard.', 'Vaccinated, microchipped. Healthy and active.', 'available', 'max.jpg'),
('Charlie', 'Bird', 'Cockatiel', 'Male', 'Small', 0, 8, 120.00, 'Cheerful cockatiel who loves to whistle and interact. Very social bird.', 'Healthy, regular vet checkups.', 'available', 'charlie.jpg'),
('Bella', 'Dog', 'Beagle', 'Female', 'Medium', 4, 0, 220.00, 'Sweet and curious beagle who loves to sniff and explore. Good with families.', 'Vaccinated, spayed, no health issues.', 'available', 'bella.jpg'),
('Oliver', 'Cat', 'Persian', 'Male', 'Medium', 5, 2, 200.00, 'Calm and regal persian cat who enjoys a quiet home. Loves being groomed.', 'Vaccinated, neutered, dental checkup done.', 'available', 'oliver.jpg'),
('Rocky', 'Dog', 'German Shepherd', 'Male', 'Extra Large', 3, 1, 180.00, 'Loyal and intelligent german shepherd. Well trained, great with older children.', 'Vaccinated, microchipped, neutered. Hip checked.', 'available', 'rocky.jpg'),
('Luna', 'Cat', 'Siamese', 'Female', 'Small', 2, 0, 180.00, 'Elegant siamese cat with striking blue eyes. Loves to talk and follow her owner around.', 'Vaccinated, spayed. Currently pending adoption review.', 'pending', 'luna.jpg');
