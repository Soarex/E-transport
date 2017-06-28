<html>
<?php
    require_once("database.php");
    require_once("user.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", ""); 
    $database->selectDatabase("e_transport");

    $user = $_SESSION['logged_user'];

    $result = $database->query(
       "SELECT * 
        FROM metodo_pagamento 
        WHERE numero_carta='".$_POST['numero_carta']."'"
    );

    if($result->num_rows != 0) {
        $database->close();
        echo "<script>alert('Carta già registrata'); window.location.href='../index.html';</script>";
        die();
    }

    $data_scadenza ='20'.$_POST['anno_scadenza'].'-'.$_POST['mese_scadenza'].'-00';

    $result = $database->query(
       "CALL ADD_METODO('".$_POST['tipo']."', '".$_POST['numero_carta']."', '".$_POST['nome_titolare']."', '".$data_scadenza."', 
       ".$user->id.", '".$_POST['via']."', '".$_POST['citta']."', '".$_POST['provincia']."', ".$_POST['CAP'].")"
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore nella registrazione'); window.location.href='../index.html';</script>";
    }

    $database->close();
    echo "<script>alert('Registrazione avvenuta con successo'); window.location.href='../index.html';</script>";
?>
</html>