<?php
    session_start();

    if(isset($_GET["username"]) && isset($_GET["nama"])) {
        // // // Clear cookie
        setcookie("user[username]", $_GET["username"], time()-1);
        setcookie("user[nama]", $_GET["nama"], time()-1);

        // Clear session
        unset($_SESSION['username']);
        unset($_SESSION['nama']);

        session_destroy();

        // Redirect to login.php
        header('Location: login.php');
    }
?>