<?php
    session_start();
    unset($_SESSION['logged_user']);
    echo "<script>window.location.href='../index.html';</script>"
?>