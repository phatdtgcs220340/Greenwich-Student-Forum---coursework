CREATE TABLE Thread (
    thread_id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id INT(11),
    category ENUM('No Category', 'Algorithm', 'Data Science', 'Front-end', 'Back-end', 'Database', 'Network', 'Blockchain') NOT NULL,
    PRIMARY KEY (thread_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);
