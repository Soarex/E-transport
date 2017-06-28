<?php
    require_once('database.php');
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", "");
    $database->selectDatabase("e_transport");

    $result = $database->query(
        "UPDATE carta_trasporto 
        SET saldo = saldo - ".$_POST['quantita']."
        WHERE numero_carta='".$_POST['carta_origine']."'"
    );

    if($result == false) {
        $database->close();
        die("Errore");
    }

    $result = $database->query(
        "UPDATE carta_trasporto 
        SET saldo = saldo + ".$_POST['quantita']."
        WHERE numero_carta='".str_replace(" ", "", $_POST['carta_destinazione'])."'"
    );

    if($result == false) {
        $database->close();
        die("Errore");
    }
          
    $database->close();
    echo 'Trasferimento avvenuto con successo';
?>