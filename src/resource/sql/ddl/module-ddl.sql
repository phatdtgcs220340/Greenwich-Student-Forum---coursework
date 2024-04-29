CREATE TABLE `module` (
    module_id INT(11) NOT NULL AUTO_INCREMENT,
    module_name VARCHAR(255) UNIQUE,
    description TEXT,
    PRIMARY KEY (module_id)
)