CREATE TABLE user_profile (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255),
    email VARCHAR(255),
    phone_number VARCHAR(20),
    address VARCHAR(255),
    profile_picture1 VARCHAR(255), -- Updated column name
    profile_picture2 VARCHAR(255), -- Updated column name
    password VARCHAR(255),
    education VARCHAR(255),
    location VARCHAR(255),
    skills VARCHAR(255),
    notes TEXT,
    experience VARCHAR(255)
);
