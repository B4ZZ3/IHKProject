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
	InLager boolean NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (HerstellerId) REFERENCES hersteller(Id),
	FOREIGN KEY (KategorieId) REFERENCES kategorie(Id),
	FOREIGN KEY (BueroId) REFERENCES buero(Id)
);