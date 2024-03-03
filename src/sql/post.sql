CREATE TABLE Post (
    post_id INT(11) NOT NULL AUTO_INCREMENT,
    content TEXT NOT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    user_id INT(11),
    thread_id INT(11),
    PRIMARY KEY (post_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES Thread(thread_id) ON DELETE CASCADE
);
