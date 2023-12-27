CREATE DATABASE users;

CREATE TABLE users(
user varchar(15) BINARY PRIMARY KEY,
password varchar(100) BINARY NOT NULL,
surname varchar(100) NOT NULL,
name varchar(100) NOT NULL,
birthdate date NOT NULL);

CREATE TABLE accesses(
id_access int unsigned PRIMARY KEY AUTO_INCREMENT,
login_datetime datetime NOT NULL,
logout_datetime datetime,
fk_user varchar(15) binary, 
FOREIGN KEY(fk_user) REFERENCES users(user));