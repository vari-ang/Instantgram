<?php
    // Dapatkan isi txtkomen
    $komen = addslashes($_POST['txtkomen']);
    $tanggal = date("y-m-d h:i:s");
    $username = $_POST['username'];

    // Cek apakah ada bagian yang dikosongi
    if(empty($_FILES['photo']['name'][0]) || empty($komen)) {

        // Tampilkan pesan error
        echo "Tolong Isi Semua Data Yang Diminta.";
    }
    else {
        include "./connection.php";

        // Buat object connection
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Cek ada error
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        }

        $is_error = false; // Flag variable untuk memonitor apakah ada error/ tidak

        // Tambahkan data ke tabel posting terlebih dahulu
        $stmt = $mysqli->prepare("INSERT INTO posting
            (username, tanggal, komen) VALUES (?,?,?)");
        $stmt->bind_param('sss', $username, $tanggal , $komen);
        $stmt->execute();
        
        // Dapatkan id terakhir dari proses INSERT di atas
        $idposting = $stmt->insert_id;

        // Dapatkan foto yang diupload user
        $files = $_FILES["photo"];

        // Loop gambar yang diinputkan
        foreach($files['name'] as $key => $name) {
            // Jika tidak ada error
            if($files['error'][$key] == 0) {
                $file_info = getimagesize($files['tmp_name'][$key]);
                if(!empty($file_info)) {
                    $ext = substr($name, strrpos($name, '.') + 1);

                    // Lanjutkan dengan perintah INSERT ke tabel gambar
                    $stmt2 = $mysqli->prepare("INSERT INTO gambar (idposting, extention)
                                                VALUES (?,?)");
                    $stmt2->bind_param('is', $idposting , $ext);
                    $stmt2->execute();

                    // Dapatkan id terakhir dari proses INSERT di atas
                    $idgambar = $stmt2->insert_id;

                    $filename = $idgambar . '.' . $ext;
                    $destination = "posting/" . $filename;

                    // Pindahkan gambar ke folder "posting/"
                    if(!move_uploaded_file($files['tmp_name'][$key], $destination)) {
                        echo "Aduh! Foto yang Anda, $name, gagal diupload :(";
                        $is_error = true;
                    }
                }
                else {
                    echo "Foto yang Anda upload nampaknya bukan sebuah gambar.";
                    $is_error = true;
                }
            }
            else {
                echo "Oops! Terdapat error pada saat upload. Silahkan coba lagi.";
                    $is_error = true;
            }
        }

        if(!$is_error) {
            echo "Tambah posting berhasil dilakukan.";
        }
        
        $stmt->close();
        $stmt2->close();

        /* close connection */
        $mysqli->close();
    }
?>