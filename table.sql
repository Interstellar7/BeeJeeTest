CREATE TABLE tasks (
`id_task` int NOT NULL AUTO_INCREMENT,
`username` VARCHAR(50) NOT NULL,
`email` VARCHAR(50) NOT NULL,
`text` VARCHAR(500) NOT NULL,
`flag_status` TINYINT NOT NULL DEFAULT 0
PRIMARY KEY (`id_task`) );