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
        FROM cliente 
        WHERE email='".$_POST['email']."'"
    );

    if($result->num_rows != 0) {
        $database->close();
        echo "<script>alert('Email già esistente'); window.location.href='sign_up.html';</script>";
        die();
    }

    $result = $database->query(
       "SELECT * 
        FROM cliente 
        WHERE numero_documento='".$_POST['numero_documento']."'"
    );

    if($result->num_rows != 0) {
        $database->close();
        echo "<script>alert('Numero documento già esistente'); window.location.href='sign_up.html';</script>";
        die();
    }

    $result = $database->query(
       "CALL ADD_CLIENTE('".$_POST['nome']."', '".$_POST['cognome']."', '".$_POST['email']."', '".$_POST['password']."', 
       '".$_POST['numero_documento']."', '".$_POST['via']."', '".$_POST['citta']."', '".$_POST['provincia']."', '".$_POST['cap']."')"
    );

    $user = new User();
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->nome = $_POST['nome'];
    $user->cognome = $_POST['cognome'];
    $user->numero_documento = $_POST['numero_documento'];
    $user->id = $_POST['id'];
    $user->via = $_POST['via'];
    $user->provincia = $_POST['provincia'];
    $user->citta = $_POST['citta'];
    $user->cap = $_POST['cap'];

    $_SESSION['logged_user'] = $user;
    $database->close();
    echo "<script>alert('Registrazione avvenuta con successo'); window.location.href='../index.html';</script>";
?>
</html>