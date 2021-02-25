<?php 
    $resp = array(
        'result' => 0,
        'msg' => ''
    );

    // Dapatkan data
    $username = $_POST["username"];
    $idposting = $_POST["idpost"];
    $jumlahlike = $_POST["jumlahlike"];
    $jumlahlikebaru = $jumlahlike;
                
    // Jika username tidak kosong
    if(!empty($username)) {
        include "./connection.php";

        // Buat object connection
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Cek ada error
        if ($mysqli->connect_errno) {
            $resp['msg'] .= "<p class='text-center text-error' style='margin-top: 3em;'>Gagal konek ke MySQL: " . $mysqli->connect_error . "</p>";
        }

        // Cek apakah username ini sudah pernah menekan tombol like
        $stmt = $mysqli->prepare("SELECT * FROM jempol_like 
                                    WHERE idposting = ? AND username = ?");
        $stmt->bind_param('is', $idposting , $username);
        $stmt->execute();

        $res = $stmt->get_result();

        // Jika ditemukan hasil pencarian (username ini sudah pernah menekan like)
        if($res->num_rows !== 0) {
            // kurangi jumlah button like --> hapus username dari table jempol_like
            $stmt2 = $mysqli->prepare("DELETE FROM jempol_like 
                                       WHERE idposting = ? AND username = ?");
            $stmt2->bind_param('is', $idposting , $username);
           
            // Jika query berhasil
            if($stmt2->execute()) {
                // kurangi jumlah like baru
                $jumlahlikebaru -= 1;
            }
            else { $resp['msg'] .= "<p class='text-center text-error'>$stmt2->error</p>"; }
        }
        // Jika tidak belum (username ini belum pernah menekan like)
        else {
            // tambah jumlah button like --> tambah username di table jempol_like
            $stmt2 = $mysqli->prepare("INSERT INTO jempol_like (idposting, username)
                                       VALUES (?,?)");
            $stmt2->bind_param('is', $idposting , $username);

            // Jika query berhasil
            if($stmt2->execute()) {
                // tambah jumlah like baru
                $jumlahlikebaru += 1;
            }
            else { $resp['msg'] .= "<p class='text-center text-error'>$stmt2->error</p>"; }
        }

        $resp['result'] = $jumlahlikebaru;
        echo json_encode($resp);

        $stmt->close();

        /* close connection */
        $mysqli->close();
    }
?>