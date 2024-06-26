CREATE TABLE `user` (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role ENUM('Student', 'Admin') NOT NULL,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    image VARCHAR(255) DEFAULT 'resource/static/images/user/default_avatar.jpg',
    is_enabled INT(2) NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id)
);
