<?php
    session_start();
    // Hanya user yang log in yang dapat mengakses halaman ini
    
    if(empty($_COOKIE['user']) && empty($_SESSION['username'])) {
        // arahkan ke login.php bila user belum pernah login
        header('Location: login.php');
    }

    // Dapatkan username, nama dari cookie n session
    $username = (!empty($_COOKIE['user']['username']) ? $_COOKIE['user']['username'] : $_SESSION['username']);;
    $nama = (!empty($_COOKIE['user']['nama']) ? $_COOKIE['user']['nama'] : $_SESSION['nama']);;
?>