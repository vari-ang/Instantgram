<?php 
    $resp = '';

    // Dapatkan data
    $username = $_POST["username"];
    $idposting = $_POST["idpost"];
    $komen = $_POST["komen"];

    // Jika komen tidak kosong
    if(!empty($komen)) {
        include "./connection.php";

        // Buat object connection
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Lanjut jika tidak ada error
        if (!$mysqli->connect_errno) {
            $stmt = $mysqli->prepare("INSERT INTO balasan_komen(idposting, username, isi_komen) 
                                      VALUES (?,?,?)");
            $stmt->bind_param('iss', $idposting, $username, $komen);

            // Jika query berhasil
            if($stmt->execute()) {
                $stmt2 = $mysqli->prepare("SELECT * FROM balasan_komen WHERE idposting = ?");
                $stmt2->bind_param('i', $idposting);
                $stmt2->execute();

                $res = $stmt2->get_result();
                while($row = $res->fetch_assoc()) {
                    $resp .= '<p>(' . $row["tanggal"] . ') ' . $row["username"] . ' : ' . $row["isi_komen"] . '</p>';
                }
            }
        }

        echo $resp;

        $stmt->close();

        /* close connection */
        $mysqli->close();
    }
?>