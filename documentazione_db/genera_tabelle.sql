CREATE DATABASE e_transport;
USE e_transport;

CREATE TABLE Tratta (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	costo DECIMAL(6, 2) UNSIGNED NOT NULL,
	PRIMARY KEY (id)
) ENGINE = INNODB;

CREATE TABLE Tratta_urbano (
	citta VARCHAR(50) NOT NULL UNIQUE,
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Tratta_extraurbano (
	da_km SMALLINT UNSIGNED NOT NULL,
	a_km SMALLINT UNSIGNED NOT NULL,	
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	UNIQUE (da_km, a_km),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Tratta_metro (
	da_zona TINYINT UNSIGNED NOT NULL,
	a_zona TINYINT UNSIGNED NOT NULL,	
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	UNIQUE (da_zona, a_zona),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Tratta_treno (
	da VARCHAR(50) NOT NULL,
	a VARCHAR(50) NOT NULL,	
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	UNIQUE (da, a),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Tratta_tram (
	citta VARCHAR(50) NOT NULL UNIQUE,
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Tratta_traghetto (
	da VARCHAR(50) NOT NULL,
	a VARCHAR(50) NOT NULL,	
	id_tratta INT UNSIGNED NOT NULL,
	PRIMARY KEY (id_tratta),
	UNIQUE (da, a),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Indirizzo(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	via VARCHAR(25) NOT NULL,
	provincia VARCHAR(25) NOT NULL,
	citta VARCHAR(25) NOT NULL,
	cap VARCHAR(5) NOT NULL,
	PRIMARY KEY(id)
) ENGINE = INNODB;

CREATE TABLE Autista (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	nome VARCHAR(25) NOT NULL,	
	cognome VARCHAR(25) NOT NULL,	
	data_nascita DATE NOT NULL,
	iban VARCHAR(34) NOT NULL,
	email VARCHAR(254) NOT NULL,
	numero_documento VARCHAR(9) NOT NULL UNIQUE,
	id_indirizzo INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_indirizzo)
		REFERENCES Indirizzo(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Cliente (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	nome VARCHAR(25) NOT NULL,	
	cognome VARCHAR(25) NOT NULL,	
	email VARCHAR(254) NOT NULL UNIQUE,
	password VARCHAR(32) NOT NULL,
	numero_documento VARCHAR(9) NOT NULL UNIQUE,
	id_indirizzo INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_indirizzo)
		REFERENCES Indirizzo(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Carta_trasporto (
	numero_carta VARCHAR(16) NOT NULL,
	saldo DECIMAL NOT NULL,	
	data_rilascio DATE NOT NULL,
	id_proprietario INT UNSIGNED,
	PRIMARY KEY (numero_carta),
	FOREIGN KEY (id_proprietario)
		REFERENCES Cliente(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE LettoreNFC (
	numero_serie VARCHAR(25) NOT NULL,
	data_installazione DATE NOT NULL,	
	PRIMARY KEY (numero_serie)
) ENGINE = INNODB;


CREATE TABLE Transazione (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	timestamp TIMESTAMP NOT NULL,
	tipo ENUM("in", "out") NOT NULL,
	id_tratta INT UNSIGNED NOT NULL,
	numero_lettore VARCHAR(25) NOT NULL,
	numero_carta VARCHAR(16) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (numero_lettore)
		REFERENCES LettoreNFC(numero_serie)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (numero_carta)
		REFERENCES Carta_trasporto(numero_carta)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Presenza (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	timestamp TIMESTAMP NOT NULL,
	tipo ENUM("in", "out") NOT NULL,
	id_autista INT UNSIGNED NOT NULL,
	numero_lettore VARCHAR(25) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_autista)
		REFERENCES Autista(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (numero_lettore)
		REFERENCES LettoreNFC(numero_serie)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Metodo_pagamento (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	tipo_carta ENUM("visa", "mastercard", "postepay", "maestro", "american_express") NOT NULL,
	numero_carta VARCHAR(16) NOT NULL UNIQUE,
	nome_titolare VARCHAR(25) NOT NULL,
	data_scadenza DATE NOT NULL,
	id_indirizzo INT UNSIGNED NOT NULL,
	id_cliente INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_indirizzo)
		REFERENCES Indirizzo(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (id_cliente)
		REFERENCES Cliente(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;

CREATE TABLE Abbonamento (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	data_scadenza DATE NOT NULL,
	id_tratta INT UNSIGNED NOT NULL,
	id_proprietario INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_tratta)
		REFERENCES Tratta(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (id_proprietario)
		REFERENCES Cliente(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = INNODB;