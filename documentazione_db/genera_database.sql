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

DELIMITER  $$
CREATE PROCEDURE ADD_CLIENTE(nomep VARCHAR(25), cognomep VARCHAR(25), emailp VARCHAR(254), passwordp VARCHAR(32), 
        numero_documentop VARCHAR(9), viap VARCHAR(25), provinciap VARCHAR(25), cittap VARCHAR(25), capp INT)
    BEGIN
        INSERT INTO Indirizzo(via, provincia, citta, cap) VALUES
            (viap, provinciap, cittap, capp);

        INSERT INTO Cliente(nome, cognome, email, password, numero_documento, id_indirizzo) VALUES
            (nomep, cognomep, emailp, passwordp, numero_documentop, LAST_INSERT_ID());
    END$$

CREATE PROCEDURE ADD_METODO(tipop ENUM('visa','mastercard','postepay','maestro','american_express'),numero_cartap VARCHAR(16), nome_titolarep VARCHAR(25), data_scadenzap DATE, id_clientep INT, 
        viap VARCHAR(25), provinciap VARCHAR(25), cittap VARCHAR(25), capp INT)
    BEGIN
        INSERT INTO Indirizzo(via, provincia, citta, cap) VALUES
            (viap, provinciap, cittap, capp);

        INSERT INTO Metodo_pagamento(tipo_carta, numero_carta, nome_titolare, data_scadenza, id_cliente, id_indirizzo) VALUES
            (tipop, numero_cartap, nome_titolarep, data_scadenzap, id_clientep, LAST_INSERT_ID());
    END$$

DELIMITER ;

INSERT INTO Indirizzo(id, via, provincia, citta, cap) VALUES
    (1, "Dante 16", "Carbonia-Iglesias", "Portoscuso", '09010'),
    (2, "Piemonte 2", "Carbonia-Iglesias", "Portoscuso", '09010'),
    (3, "Roma 23", "Carbonia-Iglesias", "Iglesias", '09016'),
    (4, "Cappuccini 18", "Carbonia-Iglesias", "Iglesias", '09016'),
    (5, "Sant'Antonio 4916", "Carbonia-Iglesias", "Iglesias", '09016'),
    (6, "Dante 16", "Carbonia-Iglesias", "Portoscuso", '09010'),
    (7, "Roma 23", "Carbonia-Iglesias", "Iglesias", '09016'),
    (8, "Cappuccini 18", "Carbonia-Iglesias", "Iglesias", '09016');

INSERT INTO Cliente(id, nome, cognome, email, password, numero_documento, id_indirizzo) VALUES
    (1, "Alessio", "Loddo", "alessio_98x@hotmail.it", "pw1234", "AX1234567", 1),
    (2, "Mario", "Rossi", "rossi.mario@gmail.it", "password2", "AJ5312567", 3),
    (3, "Salvatore", "Aranzulla", "aran@libero.it", "pass123", "AX0984567", 2),
    (4, "Giulio", "Cesare", "amagica@hotmail.it", "1223", "AX1874567", 4);

INSERT INTO Carta_trasporto(numero_carta, saldo, data_rilascio, id_proprietario) VALUES 
    ("5436987212396543", 0.0, "2017-05-05", 2),
    ("9502123009218574", 10.0, "2016-02-11", 1),
    ("8493212346732135", 50.0, "2013-04-05", 3),
    ("8765943201928391", 100.0, "2017-01-01", 1),
    ("5467291855048274", 32.0, "2015-01-05", NULL),
    ("3452975410293847", 0.0, "2014-10-15", NULL);

INSERT INTO LettoreNFC(numero_serie, data_installazione) VALUES 
    ("A9854376", "2010-05-11"),
    ("A5368453", "2012-01-11"),
    ("Y2578425", "2017-09-23");

INSERT INTO Tratta(id, costo) VALUES 
    (1, 1.30),
    (2, 2.00),
    (3, 1.40),
    (4, 1.30),
    (5, 1.50),

    (6, 1.20),
    (7, 1.80),
    (8, 2.50),
    (9, 3.00),
    (10, 3.80),

    (11, 4.30),
    (12, 4.60),
    (13, 3.00),

    (14, 1.30),
    (15, 2.00),
    (16, 1.40),

    (17, 1.30),
    (18, 2.00),
    (19, 2.50),
    (20, 1.50),
    (21, 2.50),

    (22, 3.50),
    (23, 3.50),
    (24, 3.50),
    (25, 3.50);

INSERT INTO Tratta_urbano(citta, id_tratta) VALUES 
    ("Cagliari", 1),
    ("Iglesias", 2),
    ("Milano", 3),
    ("Pisa", 4),
    ("Roma", 5);

INSERT INTO Tratta_extraurbano(da_km, a_km, id_tratta) VALUES 
    (0, 9, 6),
    (10, 19, 7),
    (20, 29, 8),
    (30, 39, 9),
    (40, 49, 10);

INSERT INTO Tratta_treno(da, a, id_tratta) VALUES 
    ('Iglesias', 'Cagliari', 11),
    ('Carbonia', 'Cagliari', 12),
    ('Villamassargia', 'Cagliari', 13);

INSERT INTO Tratta_tram(citta, id_tratta) VALUES 
    ("Cagliari", 14),
    ("Milano", 15),
    ("Roma", 16);

INSERT INTO Tratta_metro(da_zona, a_zona, id_tratta) VALUES 
    (1, 2, 17),
    (1, 3, 18),
    (1, 4, 19),
    (2, 3, 20),
    (2, 4, 21);

INSERT INTO Tratta_traghetto(da, a, id_tratta) VALUES 
    ("Portoscuso", "Carloforte", 22),
    ("Carloforte", "Portoscuso", 23),
    ("Carloforte", "Calasetta", 24),
    ("Calasetta", "Carloforte", 25);

INSERT INTO Transazione(id, timestamp, tipo, id_tratta, numero_lettore, numero_carta) VALUES
    (1, '2016-04-20 10:05:22', 'in', 7, "A5368453", "9502123009218574"),
    (2, '2016-04-20 10:50:22', 'out', 7, "A5368453", "9502123009218574"),
    (3, '2017-01-20 15:05:22', 'in', 1, "A9854376", "9502123009218574"),
    (4, '2017-03-10 9:01:12', 'in', 12, "Y2578425", "8493212346732135"),
    (5, '2017-03-10 10:05:22', 'out', 12, "Y2578425", "8493212346732135"),
    (6, '2017-09-01 20:00:13', 'in', 14, "Y2578425", "5436987212396543");

INSERT INTO Metodo_pagamento(id, tipo_carta, numero_carta, nome_titolare, data_scadenza, id_indirizzo, id_cliente) VALUES
    (1, 'mastercard', 1234543216780987, 'Alessio Loddo', '2020-05-00', 6, 1),
    (2, 'visa', 5463786987089786, 'Alberto Loddo', '2021-04-00', 7, 1),
    (3, 'postepay', 6475934029485784, 'Giulio Cesare', '2020-10-00', 8, 4);