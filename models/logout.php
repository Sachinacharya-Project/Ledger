<?php
    session_start();
    if(isset($_POST['confirmation']) && isset($_SESSION['login'])){
        session_unset();
        session_destroy();
        echo "yes";
    }
?>