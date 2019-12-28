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

DROP TABLE IF EXISTS buero;
CREATE TABLE buero (
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
	BueroId int,
	InLager tinyint(1) NOT NULL,
	PRIMARY KEY (Id, Inventarnummer),
	FOREIGN KEY (HerstellerId) REFERENCES hersteller(Id),
	FOREIGN KEY (KategorieId) REFERENCES kategorie(Id),
	FOREIGN KEY (BueroId) REFERENCES buero(Id)
);

DROP TABLE IF EXISTS inventur;
CREATE TABLE inventur(
	Id int NOT NULL AUTO_INCREMENT,
	Datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Mitarbeiter varchar(255) NOT NULL,
	Finished tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (Id)
);

DROP TABLE IF EXISTS geraeteInventur;
CREATE TABLE geraeteInventur(
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