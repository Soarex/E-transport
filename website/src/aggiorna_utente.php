<html>
<?php
    require_once("database.php");
    require_once("user.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", ""); 
    $database->selectDatabase("e_transport");

    $result = $database->query(
       "UPDATE cliente 
        SET nome = '".$_POST['nome']."',
            cognome = '".$_POST['cognome']."',
            email = '".$_POST['email']."',
            password = '".$_POST['password']."',
            numero_documento = '".$_POST['numero_documento']."'
        WHERE id=".$_SESSION['logged_user']->id
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore'); window.location.href='../index.html';</script>";
    }

    $result = $database->query(
       "SELECT id_indirizzo 
        FROM cliente
        WHERE id=".$_SESSION['logged_user']->id
    );

    $data = $result->fetch_array();

    $result = $database->query(
       "UPDATE indirizzo 
        SET via = '".$_POST['via']."',
            provincia = '".$_POST['provincia']."',
            citta = '".$_POST['citta']."',
            cap = '".$_POST['cap']."'
        WHERE id=".$data['id_indirizzo']
    );

    if($result == false) {
        $database->close();
        echo "<script>alert('Errore'); window.location.href='../index.html';</script>";
    }

    $user = new User();
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->nome = $_POST['nome'];
    $user->cognome = $_POST['cognome'];
    $user->numero_documento = $_POST['numero_documento'];
    $user->id = $_SESSION['logged_user']->id;
    $user->via = $_POST['via'];
    $user->provincia = $_POST['provincia'];
    $user->citta = $_POST['citta'];
    $user->cap = $_POST['cap'];

    $_SESSION['logged_user'] = $user;
    $database->close();
    echo "<script>alert('Update avvenuto con successo'); window.location.href='../index.html';</script>";
?>
</html>