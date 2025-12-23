CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

--@block
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL,
    member_id INT NOT NULL,
    type ENUM('short', 'long') NOT NULL,
    CONSTRAINT fk_project_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;