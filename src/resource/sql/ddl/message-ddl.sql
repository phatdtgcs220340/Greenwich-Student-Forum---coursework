CREATE TABLE `message` (
    message_id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id INT(11),
    PRIMARY KEY (message_id),
    FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE
);
