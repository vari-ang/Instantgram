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
    <title>Post Detail Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <div class="container">
        <p><a href="index.php?akses=<?php echo $akses; ?>">&lt;&lt; Kembali ke Home <?php echo $akses; ?></a></p>

        <?php
            if(isset($_GET['id_post'])){
                $idpost = $_GET['id_post'];

                include "./connection.php";

                // Buat object connection
                $mysqli = new mysqli($server, $id, $pw, $db);

                // Cek ada error
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                }

                $gambar = isset($_GET['gambar']) ? $_GET['gambar'] : 1;
                
                // Dapatkan jumlah post asli
                $stmt0 = $mysqli->prepare("SELECT idposting, idgambar, extention FROM gambar 
                            WHERE idposting = ?");
                $stmt0->bind_param('i', $_GET['id_post']);
                $stmt0->execute();

                $res0 = $stmt0->get_result();
                $jumlah_post = $res0->num_rows;

                // Dapatkan gambar ke sekian untuk id posting ini
                $stmt = $mysqli->prepare("SELECT idposting, idgambar, extention FROM gambar 
                            WHERE idposting = ? LIMIT ?,1");
                $offset = $gambar - 1;
                $stmt->bind_param('ii', $_GET['id_post'], $offset);
                $stmt->execute();

                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                // Tampilkan postingan dengan thumbnail gambar
                echo '<div class="photo-cover">
                        <div class="slide-box">';
                if($gambar - 1 != 0) {
                    echo    '<a href="ditel_post.php?akses='.$akses.'&id_post='.$idpost.'&gambar='.($gambar-1).'" class="btn-slide previous round">&#8249;</a>';
                } 
                echo    '</div>
                        <div class="cover-box">
                            <img src="posting/' . $row["idgambar"] . '.' . $row["extention"] . '" alt="Gambar Post">
                        </div>';
                        '<div class="slide-box">';
                if($gambar != $jumlah_post) {
                    echo    '<a href="ditel_post.php?akses='.$akses.'&id_post='.$idpost.'&gambar='.($gambar+1).'" class="btn-slide next round">&#8250;</a>';
                }
                echo    '</div>
                      </div>';

                $stmt->close();

                //============================SHOW LIKE===========================================
                $stmt2 = $mysqli->prepare("SELECT count(*) as total FROM jempol_like WHERE idposting = ?");
                $stmt2->bind_param('i', $_GET['id_post']);
                $stmt2->execute();

                $res2 = $stmt2->get_result();
                $row2 = $res2->fetch_assoc();
                
                echo '<div id="btn-like">
                        <img src="http://pngimg.com/uploads/like/like_PNG90.png"><span id="jumlah-like">' . $row2["total"] .
                    '</span></div>';
                $stmt2->close();
                
                // Pesan sukses/ error dari like_ajax.php
                echo '<div id="like-msg"></div>';

                //===========================SHOW CAPTION==========================================
                $stmt3 = $mysqli->prepare("SELECT username, tanggal, komen FROM posting WHERE idposting = ?");
                $stmt3->bind_param('i', $_GET['id_post']);
                $stmt3->execute();

                $res3 = $stmt3->get_result();
                $row3 = $res3->fetch_assoc();

                echo '<div class="caption">'.
                        '(' . $row3["tanggal"] . ') ' . $row3["username"] . ' : ' . $row3["komen"].
                    '</div>';
                $stmt3->close();


                //============================SHOW COMMENT==========================================
                $stmt4 = $mysqli->prepare("SELECT username, tanggal, isi_komen FROM balasan_komen WHERE idposting = ?");
                $stmt4->bind_param('i', $_GET['id_post']);
                $stmt4->execute();

                $res4 = $stmt4->get_result();

                echo '<div class="comment">';
                while($row4 = $res4->fetch_assoc()){  
                    echo '<p>(' . $row4["tanggal"] . ') ' . $row4["username"] . ' : ' . $row4["isi_komen"]. '</p>';
                }              
                echo '</div>';

                $stmt4->close();
            }           
        ?>
        <input type="hidden" id="hididpost" name="hididpost" value="<?php echo $_GET['id_post']; ?>">
        <input type="hidden" id="hidusername" name="hidusername" value="<?php echo $username; ?>">
        
        <div style="margin-top: 50px;">
            <input type="text" id="txtkomen">
            <input type="button" id="btnkomen" value="SUBMIT">
        </div>
    </div>
    <div style="height: 100px;"></div>

<script src="./jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function() {
        var idpost = $('#hididpost').val(),
            username = $('#hidusername').val();

        // User menekan button like
        $('div#btn-like').click(function(e) {
            e.preventDefault();
            $('#like-msg').html('');
            
            var jumlahlike = parseInt($('#jumlah-like').text());
            $.post('like_ajax.php', { 
                idpost: idpost,
                username: username,
                jumlahlike: jumlahlike
            })
            .done(function(res) {
                // Tampilkan hasil pencarian
                var obj = JSON.parse(res);

                $('#jumlah-like').text(obj.result);
                $('#like-msg').html(obj.msg);
            })
            .fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });

        $("#btnkomen").click(function(e) {
            e.preventDefault();
            $('#like-msg').html('');
            
            var komen = $("#txtkomen").val();
            if(komen == "") {
                alert("Tolong Isi Input Komen");
            }
            else{
                $.post('komen_ajax.php', { 
                    idpost: idpost,
                    username: username,
                    komen: komen
                })
                .done(function(res) {
                    // Tampilkan hasil komen
                    $('.comment').html(res);

                    // Hapus inputbox komen
                    $('#txtkomen').val('');
                })
                .fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });
            }
        });
    });
</script>
</body>
</html>