<?php
    session_start();
    include "ayar.php";

    if($_SESSION){
        $cek = $db->prepare("SELECT * FROM uyeler WHERE uye_kadi=?");
        $cek->execute([$_SESSION["uye_kadi"]]);
        $cekx = $cek->fetch(PDO::FETCH_ASSOC);

        $cilekx = $cekx["uye_cilek"] + 10;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Çilek Kazan - Kirando Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-grid.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-reboot.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/genel.css" />
</head>
<body>

    <?php include 'header.php'; ?>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php
                    $rand = rand(1,6);

                    if ($_COOKIE["deger"]) {
                        echo '<h1>Daha beş dakika dolmadı..</h1>';
                    } else {
                        if ($_POST) {
                            $code = $_POST["code"];
                            setcookie("deger", 1, time()+300);

                            $guncelle = $db->prepare("UPDATE uyeler SET uye_cilek=? WHERE uye_kadi=?");
                            $guncelle->execute([$cilekx, $_SESSION["uye_kadi"]]);

                            if ($guncelle) {
                                echo '<meta http-equiv="refresh" content="0;URL=http://kilci.xyz/kirando/cilekkazan.php">';
                            } else {
                               echo 'bir şey oldu, hata mı ne oldu, kb canısı';
                            }
                        } else {
                            echo '<center><h1>5 dakika = 10 çilek</h1><form action="" method="POST"><input type="hidden" name="code" value="'.$rand.'"><button type="submit">Çilek Kazan</button></form></center>';
                        }
                    }
                    
                    

                ?>
                <hr>
            </div>
        </div>
    </div>

    <footer class="container">
        <div class="row">
            <small class="col-sm-12"><hr>
                <a href="https://www.youtube.com/watch?v=5iOm4yxV3QE&t=209s&utm_source=www.kilci.xyz" target="_blank" title="Bu oyun nasıl yapıldı?" class="btn btn-sm btn-primary">Bu oyun nasıl yapıldı?</a>
                <br />Kirando &copy; <?php echo date("Y"); ?> - Bir Uğur KILCI ürünüdür.
                <br /><br />
            </small>
        </div>
    </footer>
    </div>

</body>
</html>
<?php

    }else {
        echo '<h1>404 hata, giriş yapmadan giremezsin hacı..</h1>';
    }

?>