<?php
    $resp = "";

    // Dapatkan keyword pencarian
    $q = (isset($_POST["q"])) ? addslashes($_POST["q"]) : "";
    $username = $_POST["username"];
                
    // Jika kata pencarian kosong
    if(!empty($q)) {
        $resp .= "<h4 style='font-weight: bold;' style='margin-top:2em;'>
                Menampilkan pencarian untuk: \"$q\"
            </h4>";

        include "./connection.php";

        // Buat object connection
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Cek ada error
        if ($mysqli->connect_errno) {
            $resp .= "<p class='text-center text-error' style='margin-top: 3em;'>Gagal konek ke MySQL: " . $mysqli->connect_error . "</p>";
        }

        // Lakukan query ke db untuk mencari user dengan kriteria tertentu
        $stmt = $mysqli->prepare("SELECT * FROM user 
                                    WHERE (username LIKE ? OR nama LIKE ?)
                                        AND username <> ?");
        $search = "%$q%";
        $stmt->bind_param('sss', $search, $search, $username);
        $stmt->execute();

        $res = $stmt->get_result();

        $resp .= "<p style='margin-bottom: 2em;'>Berhasil menemukan: $res->num_rows User</p>";

        // Jika ditemukan hasil pencarian
        if($res->num_rows != 0) {
            // Menampilkan hasil pencarian baris per baris
            while($row = $res->fetch_assoc()) {
                // Hanya menampilkan user hasil pencarian yang bukan diri sendiri
                $resp .= "<div class='user'>
                        <a href='index.php?akses=" . $row["username"] . "'> 
                            <span class='username'>" . $row["username"] . "</span>
                            <span class='nama'>" . $row["nama"] . "</span>
                        </a>
                    </div>";
            }
        }
        else {
            $resp .= "<p class='text-center text-error' style='margin-top: 3em;'>Coba dengan kata kunci yang lain.</p>";
        }

        echo $resp;

        $stmt->close();

        /* close connection */
        $mysqli->close();
    }
?>