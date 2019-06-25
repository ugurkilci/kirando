<div class="bg-white container"><div class="container">
    <div class="row">
        <div class="col-sm-12">
            <a href="index.php" title="Kirando Online"><img src="res/kirando.PNG" alt="Kirando Online" width="100px"></a>
            
            <?php
                if($_SESSION){
                    $verix = $db->prepare("SELECT * FROM uyeler WHERE uye_kadi=?");
                    $verix->execute([$_SESSION["uye_kadi"]]);
                    $islemx = $verix->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<span class="badge badge-warning">
                        <img src="res/strawberry.png" alt="Çilek">: '.$islemx["uye_cilek"].'
                    </span>
                    <strong>'.$_SESSION["uye_adsoyad"].'</strong>
                    <a href="cilekkazan.php" class="btn btn-danger">Çilek Kazan</a>
                    <a href="../uyelik?p=cikis&devam=kirando" class="btn btn-success">Çıkış Yap</a>';
                }else{
                    echo '<a href="../uyelik?p=giris&devam=kirando" class="btn btn-success">Giriş Yap</a>
                    veya 
                    <a href="../uyelik?p=kayit&devam=kirando" class="btn btn-danger">Kaydol</a>';
                }
            ?>
            <a href="../valide" class="btn btn-warning">KILCI:XYZ</a>
        </div>
    </div>
</div>