<html>
<?php
    include_once("database.php");
    session_start();
    class User  {
        public $email;
        public $password;
        public $nome;
        public $cognome;
        public $recapito;
        public $numero_documento;
        public $id;
    }

    $database = new Database();
    $database->connect("localhost", "root", ""); 
    $database->selectDatabase("e_transport");
    $result = $database->query("SELECT * FROM cliente WHERE email='".$_POST['email']."'");

    if($result->num_rows == 0) {
        echo "<script>alert('Utente non esistente'); window.location.href='log_in.html';</script>";
        die();
    }

    $data = $result->fetch_assoc();
    if($data['password'] != $_POST['password']) {
        echo "<script>alert('Username o password errati'); window.location.href='log_in.html';</script>";
        die();
    }

    $user = new User();
    $user->email = $data['email'];
    $user->password = $data['password'];
    $user->nome = $data['nome'];
    $user->cognome = $data['cognome'];
    $user->recapito = $data['recapito'];
    $user->numero_documento = $data['numero_documento'];
    $user->id = $data['id'];

    $_SESSION['logged_user'] = $user;
    header("Location: http://localhost/E-transport/website/index.html");
?>
</html>
