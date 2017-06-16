<?php
    session_start();
    if(isset($_SESSION['logged_user'])) {
        echo '
            <li><a id="user_icon"><img src="res/user_icon.png" alt="user_icon" /></a></li>
            <li><a id="user_name">'.$_SESSION['logged_user']->nome.' '.$_SESSION['logged_user']->cognome.'</a></li>
        ';
    } else {
        echo ' 
            <li style="float:right"><a href="src/sign_up.html">Registrati</a></li>
            <li style="float:right"><a href="src/log_in.html">Log in</a></li>
        ';
    }
?>