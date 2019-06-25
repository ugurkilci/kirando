<?php
    session_start();
    include "ayar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kirando Online</title>
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
                $randomex = md5(rand(000000,999999));
                setcookie("random", $randomex);
                setcookie("str", $islemx["uye_cilek"]);
                
                if($_SESSION){
                    $rand = rand(1,5);
                    if ($islemx["uye_cilek"] <= 2) {
                        echo '<h1>Çileğin bitti.. :S</h1>';
                    }else{
                        
                    if($_POST){
                        $sayi = @$_POST["sayi"];
                        $randomm = @$_POST["randomm"];
                        $para = @$_POST["para"];

                        $spara = $para;

                        if ($_COOKIE["random"] == $randomm) {
                            if ($rand == $sayi) {
                                # kazandınız
                                if($spara > $islemx["uye_cilek"]) {
                                    $para = ($islemx["uye_cilek"] - 5000000);
                                    $guncelle = $db->prepare("UPDATE uyeler SET uye_cilek=? WHERE uye_kadi=?");
                                    $guncelleme = $guncelle->execute([$para, $_SESSION["uye_kadi"]]);
                                    if ($guncelleme) {
                                        echo '<br /><h1 class="alert alert-warning">Hack atan hak yer! Admin de çileğini alır!!</h1>';
                                    }else{
                                        echo '<br /><h1 class="alert alert-warning">Hay aksi bir hata ile karşılaştık. Lütfen tekrar deneyiniz..</h1>';
                                    }
                                } else {
                                    $para = ($para * 2) + $islemx["uye_cilek"];
                                    $guncelle = $db->prepare("UPDATE uyeler SET uye_cilek=? WHERE uye_kadi=?");
                                    $guncelleme = $guncelle->execute([$para, $_SESSION["uye_kadi"]]);
                                    if ($guncelleme) {
                                        echo '<br />
                                        <img src="res/'.$rand.'.png" class="img-responsive" width="100px"><br /><br />
                                        <h1 class="alert alert-success">'.$rand.' = '.$sayi.', +'.$spara.' çilek kazandınız! :)</h1><a href="index.php" class="btn btn-block btn-success">Tekrar Oyna!</a>';
                                    }else{
                                        echo '<br /><h1 class="alert alert-warning">Hay aksi bir hata ile karşılaştık. Lütfen tekrar deneyiniz..</h1>';
                                    }
                                }
                                
                            }else{
                                # kaybettiniz
                                echo 31;
                                $para = $islemx["uye_cilek"] - $para;
                                $guncelle = $db->prepare("UPDATE uyeler SET uye_cilek=? WHERE uye_kadi=?");
                                $guncelleme = $guncelle->execute([$para, $_SESSION["uye_kadi"]]);
                                if ($guncelleme) {
                                    echo '<br />
                                    <img src="res/'.$rand.'.png" class="img-responsive" width="100px"><br /><br />
                                    <h1 class="alert alert-danger">'.$rand.' != '.$sayi.', -'.$spara.' çilek kaybettiniz! :(</h1><a href="index.php" class="btn btn-block btn-danger">Tekrar Oyna!</a>';
                                }else{
                                    echo '<br /><h1 class="alert alert-warning">Hay aksi bir hata ile karşılaştık. Lütfen tekrar deneyiniz..</h1>';
                                }
                                
                            }
                        }else{
                            echo '01110011 01100001 01101100 01100001 01101011';
                        }
                    }else{
                        echo '<br /><img src="res/0.png" class="img-responsive" width="100px"><br /><br />
                        <form action="" method="POST">
                            <strong>Sayı Tahmin Et (1-5):</strong><input type="number" name="sayi" class="form-control" value="1" min="1" max="5">
                            <strong>Yatırılacak Miktar:</strong><input type="number" name="para" class="form-control" value="2" min="2" max="'.$islemx["uye_cilek"].'">
                            <br />
                            <input type="hidden" name="randomm" value="'.$randomex.'">
                            <input type="submit" value="Oyna!" class="btn btn-success">
                        </form>';
                    }}
                }else{
                    echo '<br /><h1>Kanka oyunu oynamak için giriş yapmalı veya kayıt olmalısın.. :)</h1>';
                }
            
                ?>
                <hr>

                <strong>Kirando Nedir?</strong>
                Kirando, sayı tahmin etmeli online şans oyunudur.
                <hr>
                <strong>Kurallar</strong>
                <li>Her yeni üyenin 315 tane çileği olur.</li>
                <li>Minimum 2 çilek yatırılabilir.</li>
                <hr>
                <strong>Nasıl Oynanır?</strong><br />
                En az 1 en fazla 5 olmak üzere bir sayı tahmin edilir. "Yatırılacak Miktar"a bakiyenizdeki çilek kadar çilek eklenir. Ve "Oyna" tuşuna basılarak oynanır.<br />
                Eğer tahmin edilen sayı "doğru" çıkarsa, yatırılan miktarın 2 katı kadar kazanılır. Eğer tahmin edilen sayı "yanlış" çıkarsa, yatırılan miktar kaybedilmiş olunur.
                <hr>
                <strong>YouTube</strong><br />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12"><hr>
                <strong>10 Çilek Zengini</strong>
                <ol>
                <?php
                    $veri = $db->prepare("SELECT * FROM uyeler ORDER BY uye_cilek DESC LIMIT 10");
                    $veri->execute();
                    $islem = $veri->fetchALL(PDO::FETCH_ASSOC);
                    
                    foreach($islem as $row){
                        echo '<li>'.$row["uye_adsoyad"].' -> '.$row["uye_cilek"].' Çilek</li>';
                    }
                
                ?>
                </ol>
            </div>
        </div>
    </div>

    <footer class="container">
        <div class="row">
            <small class="col-sm-12"><hr>
                <a href="https://www.youtube.com/watch?v=5iOm4yxV3QE&t=209s&utm_source=www.kilci.xyz/kirando" target="_blank" title="Bu oyun nasıl yapıldı?" class="btn btn-sm btn-primary">Bu oyun nasıl yapıldı?</a>
                <br />Kirando &copy; <?php echo date("Y"); ?> - Bir Uğur KILCI ürünüdür.
                <br /><br />
            </small>
        </div>
    </footer>
    </div>

</body>
</html>