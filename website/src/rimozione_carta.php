<?php
    require_once('database.php');
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", "");
    $database->selectDatabase("e_transport");

    $result = $database->query(
        "UPDATE carta_trasporto 
        SET id_proprietario = null
        WHERE numero_carta=".$_POST['numero_carta']
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore'); window.location.href='../index.html';</script>";
    }
          
    $database->close();
    echo 'Eliminazione avvenuta con successo';
?>