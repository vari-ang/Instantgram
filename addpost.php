<?php include('./ceklogin.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Post Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <div class="container">
        <p><a href="index.php">&lt;&lt; Kembali ke Home</a></p>

        <h1 class="text-center">Tambah Posting</h1>

        <form id="frmData" method="post" style="margin-top: 4em;">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <p>
                <label>Pilih Gambar:</label><br>
                <input type="file" name="photo[]" accept="image/*" multiple size="60">
            </p>
            <p>
                <label>Komentars:</label><br>
                <textarea type="text" class="textarea-komen" name="txtkomen"></textarea>
            </p>
            
            <button id="btnAdd" class="styled">Tambah</button>
        </form>
        <div id="result"></div>
    </div>

<script src="./jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function() {
    $("#btnAdd").click(function(){
        var formData = new FormData($("#frmData")[0]);

        // kirim data
        $.ajax({
            url: 'addpost_ajax.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (res) {
                alert(res);
            }
        });
    });
});
</script>
</body>
</html>