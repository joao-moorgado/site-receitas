CREATE DATABASE IF NOT EXISTS db_estouro_de_pilha;

USE db_estouro_de_pilha;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS db_usr (
  usr_id INT NOT NULL AUTO_INCREMENT,
  usr_name VARCHAR(20) NOT NULL,
  usr_password VARCHAR(255) NOT NULL,
  PRIMARY KEY (usr_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS db_post (
	post_id INT NOT NULL AUTO_INCREMENT,
    post_body TEXT NOT NULL,
    -- post_tags,
    usr_id INT,
    PRIMARY KEY (post_id),
    FOREIGN KEY (usr_id) REFERENCES db_usr(usr_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;