<html>
<?php
    require_once("database.php");
    require_once("user.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", ""); 
    $database->selectDatabase("e_transport");
    $result = $database->query(
       "SELECT * 
        FROM carta_trasporto 
        WHERE numero_carta='".$_POST['numero_carta']."'"
    );

    if($result->num_rows == 0) {
        $database->close();
        echo "<script>alert('Carta non esistente'); window.location.href='../index.html';</script>";
        die();
    }

    $data = $result->fetch_array();
    if($data['id_proprietario'] != null) {
        $database->close();
        echo "<script>alert('Carta già registrata'); window.location.href='../index.html';</script>";
        die();
    }


    $result = $database->query(
       "UPDATE carta_trasporto
        SET id_proprietario = ".$_SESSION['logged_user']->id."
        WHERE numero_carta='".$_POST['numero_carta']."'"
    );

    $database->close();
    echo "<script>alert('Carta registrata con successo'); window.location.href='../index.html';</script>";
?>
</html>