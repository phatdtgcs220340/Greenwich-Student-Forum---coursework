CREATE TABLE `thread` (
    thread_id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id INT(11),
    module_id INT(11),
    PRIMARY KEY (thread_id),
    FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE
    FOREIGN KEY (module_id) REFERENCES `module`(user_id) ON DELETE CASCADE
);
