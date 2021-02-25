<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <?php
        $error = "";

        if(isset($_POST['btnregister'])) {
            include "./connection.php";

            // Buat object connection
            $mysqli = new mysqli($server, $id, $pw, $db);

            // Cek ada error
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            }
            
            // Dapatkan data dari textbox
            $username = addslashes($_POST['txtuser']);
            $nama = addslashes($_POST['txtnama']);
            $pass = addslashes($_POST['txtpass']);
            $repass = addslashes($_POST['txtrepass']);

            // Tidak boleh ada nilai kosong
            if(empty($username) || empty($nama) || empty($pass) || empty($repass)) {
                $error .= "Tolong Isi Semua Data Yang Diminta.";
            }
            else {
                // Cek apakah password dan re-password memiliki nilai yang berbeda
                if($pass != $repass) {
                    $error .= "Nilai Password dan Re-Password berbeda.";
                }
                else {
                    // Cek apakah username sudah dipakai orang lain
                    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ?");
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    
                    // Jika username sudah terpakai
                    if($res->fetch_assoc()) {
                        $error .= "Username sudah digunakan oleh orang lain. Coba dengan Username yang berbeda.";
                    }
                    else {
                        // ciptakan salt
                        $salt = md5($username . strtotime("now"));

                        // ciptakan final password
                        $md5_pass = md5($pass);
                        $kombinasi = $md5_pass . $salt;
                        $final_pass = md5($kombinasi);
        
                        $stmt = $mysqli->prepare("INSERT INTO user VALUES (?,?,?,?)");
                        $stmt->bind_param('ssss', $username, $nama, $final_pass, $salt);
                        $stmt->execute();

                        // Jika perintah INSERT berhasil
                        if($stmt->affected_rows != 0) { 
                            echo "<p class='text-success text-center'>Selamat! Anda berhasil membuat akun baru.</p>
                                  <p class='text-center'>Silahkan <a href='login.php'>Login</a> untuk masuk ke sistem.</p>";
                            
                            // Kosongi nilai awal
                            $username = "";
                            $nama = "";
                            $pass = "";
                            $repass = "";
                        }
                    }
                }
                $stmt->close();
            }
            /* close connection */
            $mysqli->close();
        }
    ?>

    <div class="container">
        <div class="loginbox">
            <form action="" method="post">
                <p>
                    <label for="txtnama">Nama : </label><br>
                    <input type="text" name="txtnama" id="txtnama" placeholder="Nama" autocomplete="off">
                </p>
                <p>
                    <label for="txtuser">Username : </label><br>
                    <input type="text" name="txtuser" id="txtuser" placeholder="Username" autocomplete="off">
                </p>
                <p>
                    <label for="txtpass">Password : </label><br>
                    <input type="password" name="txtpass" id="txtpass" placeholder="Password" autocomplete="off">
                </p>
                <p>
                    <label for="txtrepass">Re-Password : </label><br>
                    <input type="password" name="txtrepass" id="txtrepass" placeholder="Re-Type Password" autocomplete="off">
                </p>
                <p>
                    <input type="submit" name="btnregister" value="Register">
                </p>
                <?php echo "<p class='text-error text-center'>$error</p>"; ?>
            </form>
            <p style="margin-top: 2.5em;">
                Sudah punya akun? <a href="login.php">Login</a> saja.
            </p>
        </div>
    </div>

    <div style="height: 50px;"></div>
</body>
</html>