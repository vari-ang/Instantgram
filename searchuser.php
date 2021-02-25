<?php include('./ceklogin.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search User Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <div class="container">
        <p><a href="index.php">&lt;&lt; Kembali ke Home</a></p>

            <label>Search User:</label>
            <input id="searchBox" type="text" name="q" placeholder="Ketikkan username atau nama user lain ..." autocomplete="off">
            <p>Tekan "ENTER" untuk memulai pencarian</p>

            <input type="hidden" id="hidusername" value="<?php echo $username; ?>">

        <div id="result">
        </div>
    </div>
<script src="./jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchBox').keydown(function(e) {
        var code = e.which; // e.which compatible dengan browser2 yg ada
        
        // Jika user menekan tombol ENTER
        if(code == 13) {
            e.preventDefault();

            var q = $('#searchBox').val(),
                username = $('#hidusername').val();
            
            $.post('searchuser_ajax.php', { 
                username: username,
                q: q 
            })
            .done(function(res) {
                // Tampilkan hasil pencarian
                $('div#result').html(res);
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