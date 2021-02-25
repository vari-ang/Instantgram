<?php 
    include('./ceklogin.php'); 

    // Dapatkan username yang diakses
    $akses = (isset($_GET['akses'])) ? $_GET['akses'] : $username;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <div class="container">
        <!-- Jika yang diakses BUKAN diri sendiri -->
        <?php if($username != $akses) { ?>
            <p><a href="searchuser.php">&lt;&lt; Kembali ke Halaman Search</a></p>
        <?php } ?>

        <h2><?php echo $akses; ?></h2>

        <!-- Jika yang diakses adalah diri sendiri -->
        <?php if($username == $akses) { echo "<p>(Halaman Home Anda)</p>"; } ?>

        <!-- Jika yang diakses adalah diri sendiri -->
        <?php if($username == $akses) { ?>
            <a href='<?php echo "logout.php?username=$username&nama=$nama" ?>' class="log-out">Log Out</a>

            <div style="margin: 2.5em 0 2.5em 0; text-align: center;">
                <a href="searchuser.php">
                    <button class="styled">Cari User</button>
                </a>
            </div>

            <hr>
                <p class="text-center"><a href="addpost.php">TAMBAH POST</a></p>
            <hr>
        <?php } ?>

        <!-- Jika yang diakses BUKAN diri sendiri -->
        <?php if($username != $akses) { echo "<div style='height: 50px;'></div>"; } ?>

    <?php
        include "./connection.php";

        // Buat object connection
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Cek ada error
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        }

        // Dapatkan id posting terlebih dahulu (dari yang terbaru ditambahkan) untuk user ii
        $stmt = $mysqli->prepare("SELECT idposting FROM posting 
                                    WHERE username = ?
                                    ORDER BY idposting DESC");
        $stmt->bind_param('s', $akses);
        $stmt->execute();

        $res = $stmt->get_result();

        // Jika user belum menambahkan posting
        if($res->num_rows == 0) {
            echo "<h4 class='text-center' style='margin-top: 8em;'>Tidak ada Posting untuk ditampilkan.</h4>";
            die();
        }

        while($row = $res->fetch_assoc()) {
            // Dapatkan gambar pertama untuk id posting ini
            $stmt2 = $mysqli->prepare("SELECT idposting, idgambar, extention FROM gambar 
                WHERE idposting = ? LIMIT 1");
            $stmt2->bind_param('i', $row['idposting']);
            $stmt2->execute();

            $res2 = $stmt2->get_result();
            $row2 = $res2->fetch_assoc();

            // Tampilkan postingan dengan thumbnail gambar
            echo '<div class="photo-grid">
                    <a href="ditel_post.php?akses=' . $akses . '&id_post=' . $row2["idposting"] . '">
                        <img src="posting/' . $row2["idgambar"] . '.' . $row2["extention"] . '" alt="Gambar Post">
                    </a>
                </div>';
        }

        $stmt->close();
        $stmt2->close();

        /* close connection */
        $mysqli->close();
    ?>
    </div>
</body>
</html>