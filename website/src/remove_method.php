  <?php
    require_once("database.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", "");
    $database->selectDatabase("e_transport");

    $result = $database->query(
        "SELECT id_indirizzo
         FROM metodo_pagamento
        WHERE id=".$_POST['id']
    );

    $data = $result->fetch_array();

    $result = $database->query(
        "DELETE FROM indirizzo
        WHERE id=".$data['id_indrizzo']
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore'); window.location.href='../index.html';</script>";
    }

    $result = $database->query(
        "DELETE FROM metodo_pagamento
        WHERE id=".$_POST['id']
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore'); window.location.href='../index.html';</script>";
    }

    $database->close();
    echo 'Cancellazione avvenuta con successo';
  ?>
