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
    (5, "Sant'Antonio 4916", "Carbonia-Iglesias", "Iglesias", '09016');

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
    --Tratte pullman urbano
    (1, 1.30),
    (2, 2.00),
    (3, 1.40),
    (4, 1.30),
    (5, 1.50);

    --Tratte extraurbano


INSERT INTO Tratta_urbano(citta, id_tratta) VALUES 
    ("Cagliari", 1),
    ("Iglesias", 2),
    ("Milano", 3),
    ("Pisa", 4),
    ("Roma", 5);
