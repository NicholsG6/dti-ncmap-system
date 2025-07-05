-- DTI-NCMAP System Database Schema
-- This database supports the DTI Negosyo Centers mapping system for Region 7

CREATE DATABASE IF NOT EXISTS dti_ncmap_system;
USE dti_ncmap_system;

-- Users table for authentication
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'guest') DEFAULT 'guest',
    email VARCHAR(100),
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Office locations table
CREATE TABLE office_locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    office_name VARCHAR(150) NOT NULL,
    office_code VARCHAR(20) UNIQUE,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    complete_address TEXT NOT NULL,
    region VARCHAR(50) DEFAULT 'Region 7',
    province VARCHAR(100) NOT NULL,
    municipality VARCHAR(100) NOT NULL,
    district VARCHAR(50),
    contact_number VARCHAR(20),
    email_address VARCHAR(100),
    office_head VARCHAR(100),
    office_description TEXT,
    service_hours VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Staff information table
CREATE TABLE staff_information (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    date_created DATE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    region VARCHAR(50) DEFAULT 'Region 7',
    province VARCHAR(100) NOT NULL,
    municipality VARCHAR(100) NOT NULL,
    district VARCHAR(50),
    complete_address TEXT NOT NULL,
    location_id INT,
    remarks TEXT,
    type_advanced VARCHAR(50),
    type_code ENUM('A', 'B', 'C') NOT NULL,
    service_area VARCHAR(100),
    contact_person VARCHAR(100),
    position VARCHAR(100) NOT NULL,
    cellphone_number VARCHAR(20),
    email_address VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES office_locations(location_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Reminders table
CREATE TABLE reminders (
    reminder_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    reminder_date DATE NOT NULL,
    reminder_time TIME,
    priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
    status ENUM('Active', 'Completed', 'Cancelled') DEFAULT 'Active',
    location_id INT,
    staff_id INT,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES office_locations(location_id),
    FOREIGN KEY (staff_id) REFERENCES staff_information(staff_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- User sessions table for security
CREATE TABLE user_sessions (
    session_id VARCHAR(255) PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Activity logs for audit trail
CREATE TABLE activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_affected VARCHAR(50),
    record_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Indexes for better performance
CREATE INDEX idx_office_location_coordinates ON office_locations(latitude, longitude);
CREATE INDEX idx_staff_location ON staff_information(location_id);
CREATE INDEX idx_reminders_date ON reminders(reminder_date);
CREATE INDEX idx_activity_logs_user ON activity_logs(user_id, created_at);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, user_type, email, full_name) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'admin@dti.gov.ph', 'System Administrator');

-- Insert sample data for testing
INSERT INTO office_locations (office_name, office_code, latitude, longitude, complete_address, province, municipality, district, contact_number, email_address, office_head, created_by) VALUES
('DTI Cebu Provincial Office', 'DTI-CEBU-001', 10.3157, 123.8854, 'DTI Building, Osmeña Boulevard, Cebu City', 'Cebu', 'Cebu City', 'District 1', '032-253-6294', 'cebu@dti.gov.ph', 'Maria Santos', 1),
('DTI Bohol Provincial Office', 'DTI-BOHOL-001', 9.6496, 123.8547, 'Provincial Capitol Compound, Tagbilaran City', 'Bohol', 'Tagbilaran City', 'District 1', '038-501-9335', 'bohol@dti.gov.ph', 'Juan Dela Cruz', 1),
('DTI Negros Oriental Office', 'DTI-NEGROS-001', 9.3016, 123.3063, 'Provincial Government Center, Dumaguete City', 'Negros Oriental', 'Dumaguete City', 'District 1', '035-225-9238', 'negros@dti.gov.ph', 'Ana Rodriguez', 1);

-- Insert sample staff data
INSERT INTO staff_information (date_created, first_name, middle_name, last_name, gender, province, municipality, district, complete_address, location_id, type_code, position, cellphone_number, email_address, created_by) VALUES
('2024-01-15', 'Maria', 'Santos', 'Garcia', 'Female', 'Cebu', 'Cebu City', 'District 1', '123 Main Street, Cebu City', 1, 'A', 'Provincial Director', '09171234567', 'maria.garcia@dti.gov.ph', 1),
('2024-01-20', 'Juan', 'Miguel', 'Dela Cruz', 'Male', 'Bohol', 'Tagbilaran City', 'District 1', '456 Capitol Road, Tagbilaran', 2, 'B', 'Assistant Director', '09187654321', 'juan.delacruz@dti.gov.ph', 1),
('2024-02-01', 'Ana', 'Luz', 'Rodriguez', 'Female', 'Negros Oriental', 'Dumaguete City', 'District 1', '789 University Belt, Dumaguete', 3, 'A', 'Provincial Director', '09199876543', 'ana.rodriguez@dti.gov.ph', 1);
