<html>
<?php
    require_once("database.php");
    require_once("user.php");
    session_start();

    $database = new Database();
    $database->connect("localhost", "root", ""); 
    $database->selectDatabase("e_transport");
    $result = $database->query(
       "SELECT cliente.email AS email,
               cliente.password AS password,
               cliente.nome AS nome,
               cliente.cognome AS cognome,
               cliente.numero_documento AS numero_documento,
               cliente.id AS id,
               indirizzo.via AS via,
               indirizzo.provincia AS provincia,
               indirizzo.citta AS citta,
               indirizzo.cap AS cap
        FROM cliente JOIN indirizzo 
            ON cliente.id_indirizzo = indirizzo.id 
        WHERE email='".$_POST['email']."'"
    );

    if($result->num_rows == 0) {
        $database->close();
        echo "<script>alert('Utente non esistente'); window.location.href='log_in.html';</script>";
        die();
    }

    $data = $result->fetch_assoc();
    if($data['password'] != $_POST['password']) {
        $database->close();
        echo "<script>alert('Username o password errati'); window.location.href='log_in.html';</script>";
        die();
    }

    $user = new User();
    $user->email = $data['email'];
    $user->password = $data['password'];
    $user->nome = $data['nome'];
    $user->cognome = $data['cognome'];
    $user->numero_documento = $data['numero_documento'];
    $user->id = $data['id'];
    $user->via = $data['via'];
    $user->provincia = $data['provincia'];
    $user->citta = $data['citta'];
    $user->cap = $data['cap'];

    $_SESSION['logged_user'] = $user;
    $database->close();
    echo "<script>window.location.href='../index.html';</script>";
?>
</html>
