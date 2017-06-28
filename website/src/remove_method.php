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
        WHERE id=".$data['id_indirizzo']
    );

    if($result == false) {
        $database->close();
        echo "Errore";
    }

    $result = $database->query(
        "DELETE FROM metodo_pagamento
        WHERE id=".$_POST['id']
    );

    if($result == false) {
        $database->close();
        echo "Errore";
    }

    $database->close();
    echo 'Cancellazione avvenuta con successo';
  ?>
