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

--@block
CREATE TABLE short_projects (
    project_id INT PRIMARY KEY,
    max_duration INT NOT NULL,
    CONSTRAINT fk_short_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

--@block
CREATE TABLE long_projects (
    project_id INT PRIMARY KEY,
    budget DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_long_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

--@block
CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    status ENUM('in_progress', 'completed') NOT NULL,
    activity_date DATETIME NOT NULL,
    project_id INT NOT NULL,
    CONSTRAINT fk_activity_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;
--@block
ALTER TABLE activities
ADD COLUMN projet_id INT NOT NULL,
ADD CONSTRAINT fk_activities_projet
FOREIGN KEY (project_id) REFERENCES projects(id)
ON DELETE CASCADE;

--@block
ALTER TABLE activities
ADD COLUMN description TEXT NOT NULL;

--@block
ALTER TABLE activities
ADD COLUMN created_at DATETIME NOT NULL;

--@block
SELECT * FROM projects;


