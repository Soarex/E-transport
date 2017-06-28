  <?php
    require_once("database.php");
    require_once("user.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", "");
    $database->selectDatabase("e_transport");

    $result = $database->query(
        "UPDATE carta_trasporto
        SET id_proprietario = NULL
        WHERE id_proprietario=".$_POST['id']
    );

    if($result == false) {
        $database->close();
        die("Errore");
    }

    $result = $database->query(
        "SELECT id_indirizzo
         FROM cliente
        WHERE id=".$_POST['id']
    );

    $data = $result->fetch_array();

    $result = $database->query(
        "DELETE FROM indirizzo
        WHERE id=".$data['id_indirizzo']
    );

    if($result == false) {
        $database->close();
        die("Errore");
    }

    $result = $database->query(
        "DELETE FROM cliente
        WHERE id=".$_POST['id']
    );

    if($result == false) {
        $database->close();
        die("Errore");
    }

    unset($_SESSION['logged_user']);

    $database->close();
    echo 'Cancellazione avvenuta con successo';
  ?>
