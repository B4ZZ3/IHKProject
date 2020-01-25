DROP DATABASE IF EXISTS inventarEOA;
CREATE DATABASE inventarEOA;

DROP TABLE IF EXISTS kategorie;
CREATE TABLE kategorie(
	Id int NOT NULL AUTO_INCREMENT,
	Name varchar(255),
	PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS hersteller;
CREATE TABLE hersteller(
	Id int NOT NULL AUTO_INCREMENT,
	Name varchar(255),
	PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS positions;
CREATE TABLE positions (
	Id int NOT NULL AUTO_INCREMENT,
	Name varchar(255),
	PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS geraete;
CREATE TABLE geraete(
	Id int NOT NULL AUTO_INCREMENT,
	Inventarnummer int NOT NULL,
	Name varchar(255),
	HerstellerId int NOT NULL,
	KategorieId int NOT NULL,
	PositionId int,
	InLager tinyint(1) NOT NULL,
	Schaden tinyint(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (Id, Inventarnummer),
	FOREIGN KEY (HerstellerId) REFERENCES hersteller(Id),
	FOREIGN KEY (KategorieId) REFERENCES kategorie(Id),
	FOREIGN KEY (PositionId) REFERENCES positions(Id)
);

DROP TABLE IF EXISTS inventur;
CREATE TABLE inventur(
	Id int NOT NULL AUTO_INCREMENT,
	Datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Mitarbeiter varchar(255) NOT NULL,
	Finished tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS geraeteinventur;
CREATE TABLE geraeteinventur(
	InventurId int NOT NULL,
	GeraeteId int NOT NULL,
	PRIMARY KEY (InventurId, GeraeteId),
	FOREIGN KEY (InventurId) REFERENCES inventur(Id),
	FOREIGN KEY (GeraeteId) REFERENCES geraete(Id)
);

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	Id int NOT NULL AUTO_INCREMENT,
	Username varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	PRIMARY KEY(Id)
);

INSERT INTO users (Username, Password) 
VALUES ("admin", "$2y$07$ZvJgzaPcVfJJvFaXR1PRBOaLjruqAh/kWw4/o8T8XAZPIsH5xdHCW");