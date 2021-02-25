<?php 
    session_start();

    // Jika user sudah login, maka tidak perlu mengakses halaman ini
    if(!empty($_COOKIE['user']) || !empty($_SESSION['username'])) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <?php
        $show_form = true;
        $error = "";

        if(isset($_POST['btnlogin'])) {
            include "./connection.php";

            // Buat object connection
            $mysqli = new mysqli($server, $id, $pw, $db);

            // Cek ada error
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            }
            
            // Dapatkan data dari textbox
            $username = addslashes($_POST['txtuser']);
            $password = addslashes($_POST['txtpass']);

            // Tidak boleh ada nilai kosong
            if(empty($username) || empty($password)) {
                $error .= "Tolong Isi Semua Data Yang Diminta.";
            }
            else {
                $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ?");
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $res = $stmt->get_result();
                
                // Jika login benar
                $row = $res->fetch_assoc();

                if($row) {
                    // ciptakan ulang finalPass dari salt (dari no.1) dan password yg diketik user di textbox
                    $md5_pass = md5($password);
                    $kombinasi = $md5_pass . $row["salt"];
                    $final_pass = md5($kombinasi);

                    // Jika hasil enkripsi password berbeda dengan yg ada di database
                    if($final_pass != $row["password"]) {
                        $error .= "Password salah. Silahkan coba lagi.";
                    }
			        else {
                        $show_form = false;

                        // delay penampilan pesan selamat datang sebelum diarahkan ke index.php
                        header("refresh:4;url=index.php");

                        echo "<h1 class='text-success text-center'>Welcome to Instantgram</h1>";
                        echo "<p class='text-center'><b>Aplikasi berbagi foto berbaris website</b></p>";
                        echo "<br>";
                        echo "<p class='text-center'>Sebentar lagi Anda akan diarahkan ke halaman Home.</p>";

                        // Buat session user dan cookie
                        if(isset($_POST['chxremember'])) {
                            // Jika tercentang maka buatlah cokie yg isinya username
                            
                            // Cookie habis dalam 1 minggu
                            setcookie('user[username]', $row['username'], time()+7*24*3600);
                            setcookie('user[nama]', $row['nama'], time()+7*24*3600);                        
                        }
                        else {
                            // Jika tidak dicentang maka hapuslah cookie itu
                            setcookie('username', $username, time() - 1);
                        }

                        // Buat session (diperlukan bila user masuk tanpa ingin mengigat username)
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['nama'] = $row['nama'];
                    }
                }
                else {
                    $error .= "Username tidak ditemukan. Silahkan coba lagi.";
                }
                $stmt->close();
            }
            $mysqli->close();
        }
    ?>

    <?php if($show_form) { 
        if(isset($_COOKIE['user'])){ ?>
            <div class="container">
                <div class="loginbox">
                    <form action="" method="post">
                        <p>
                            <label for="txtuser">Username : </label>
                            <input type="text" name="txtuser" id="txtuser" value="<?php echo $username; ?>">
                        </p>
                        <p>
                            <label for="txtpass">Password : </label>
                            <input type="password" name="txtpass" id="txtpass" value="<?php echo $password; ?>">
                        </p>
                        <p>
                            <input type="checkbox" name="chxremember" value="1">
                            <span style="font-size: 0.75em;"><em>Remember Username</em></span>
                        </p>
                        <p>
                            <input type="submit" name="btnlogin" value="Login">
                        </p>
                        <?php echo "<p class='text-error text-center'>$error</p>"; ?>
                    </form>
                    <p style="margin-top: 2.5em;">
                        Belum punya akun? <a href="register.php">Register</a> akun Anda.
                    </p>
                </div>
            </div>
        <?php }
        else{ ?>
            <div class="container">
                <div class="loginbox">
                    <form action="" method="post">
                        <p>
                            <label for="txtuser">Username : </label>
                            <input type="text" name="txtuser" id="txtuser" placeholder="Username" autocomplete="off">
                        </p>
                        <p>
                            <label for="txtpass">Password : </label>
                            <input type="password" name="txtpass" id="txtpass" placeholder="Password" autocomplete="off">
                        </p>
                        <p>
                            <input type="checkbox" name="chxremember" value="1">
                            <span style="font-size: 0.75em;"><em>Remember Username</em></span>
                        </p>
                        <p>
                            <input type="submit" name="btnlogin" value="Login">
                        </p>
                        <?php echo "<p class='text-error text-center'>$error</p>"; ?>
                    </form>
                    <p style="margin-top: 2.5em;">
                        Belum punya akun? <a href="register.php">Register</a> akun Anda.
                    </p>
                </div>
            </div>
        <?php }
    } ?>

    <?php
        
    ?>
</body>
</html>