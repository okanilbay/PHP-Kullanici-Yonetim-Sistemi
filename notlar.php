<?php
    include("baglanti.php");

    $ogr_no_err=$ders_adi_err=$donem_err=$vize_err=$final_err="";
        
    //EKLE BUTONUNA TIKLANDIĞINDA
    if (isset($_POST["ekle"])) 
    {
        $ogr_no = $_POST["ogr_no"];
        $ders_adi = $_POST["ders_adi"];
        $donem = $_POST["donem"];
        $vize = $_POST["vize"];
        $final = $_POST["final"];

        // Sorgu sonucunda bir satır dönüyorsa, ders adı zaten mevcuttur
        $ders_sorgu = "SELECT ders_adi FROM notlar WHERE ders_adi='$ders_adi' LIMIT 1";
        $ders_sonuc = mysqli_query($baglanti, $ders_sorgu);
        if (mysqli_num_rows($ders_sonuc) > 0) {
            echo "<div class='alert alert-danger' role='alert'>Hata: Bu ders zaten var. Lütfen farklı bir ders adı girin." . $sql . "<br>" . mysqli_error($baglanti) . "</div>";
        } 
        else {
            $sql = "INSERT INTO notlar (ogr_no,ders_adi,donem,vize,final) VALUES ('$ogr_no','$ders_adi','$donem','$vize','$final')";
                
            if (mysqli_query($baglanti, $sql)) {
                echo '<div class="alert alert-success" role="alert">
                Kayıt başarılı bir şekilde eklendi.
                </div>';
            }
            else {
                echo '<div class="alert alert-danger" role="alert">
                Kayıt eklenirken bir problem oluştu.
                </div>';
            }
        }
    }

    // Öğrenci güncelleme işlemi
    if(isset($_POST['guncelle'])){
        
        $ogr_no = $_POST["ogr_no"];
        $ders_adi = $_POST["ders_adi"];
        $donem = $_POST["donem"];
        $vize = $_POST["vize"];
        $final = $_POST["final"];

        $sql = "UPDATE notlar SET donem='$donem',vize='$vize',final='$final' WHERE ogr_no='$ogr_no' AND ders_adi='$ders_adi'";

        if (mysqli_query($baglanti, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci bilgileri başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti) . "</div>";
        }
    }

    //NOT SİLME İŞLEMLERİ
    if(isset($_POST['sil'])){
        // Formdan gelen verileri alın
        $ogr_no = $_POST['ogr_no_sil'];
        $ders_adi = $_POST['ders_adi_sil'];

        // Silme sorgusunu oluşturun
        $sql = "DELETE FROM notlar WHERE ogr_no='$ogr_no' AND ders_adi='$ders_adi'";

        // Sorguyu çalıştırın
        if (mysqli_query($baglanti, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci başarıyla silindi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti) . "</div>";
        }
    }

    // Veritabanından öğrenci notlarını çekme
    $sql = "SELECT * FROM notlar";
    $result = mysqli_query($baglanti, $sql);

    // Veritabanı bağlantısını kapat
    mysqli_close($baglanti);
?>


<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Öğrenci Bilgi Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-3">
        <!-- HOŞGELDİNİZ BÖLÜMÜ -->
        <div class="card p-3">

            <?php
                session_start();
                if(isset($_SESSION["ad"]))
                {
                    echo "<h2>".$_SESSION["ad"]." ".$_SESSION["soyad"]." HOŞGELDİNİZ </h2>";
                    echo "<a href='profile.php'>ÖĞRENCİ BİLGİLERİ YÖNETİM SAYFASINA GİT</a> ";
                    echo "<a href='cikis.php'>ÇIKIŞ YAP</a> ";
                }
                else
                {
                    echo "<h3>Bu sayfayı görüntülemek için email ve parola ile giriş yapmalısınız.</h3>";
                }
            ?>
        </div>
    </div>
        

    <!-- ÖĞRENCİ BİLGİLERİ LİSTELEME -->
    <div class="container p-3">
        <div class="card p-3">
            <div class="card-body">
                <h5 class="card-title">Öğrenci Not Listesi</h5>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Öğrenci No</th>
                            <th scope="col">Ders Adı</th>
                            <th scope="col">Dönem</th>
                            <th scope="col">Vize</th> 
                            <th scope="col">Final</th> 
                            <th scope="col">Ortalama</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($result as $gorev) {
                            $vize_notu = $gorev["vize"];
                            $final_notu = $gorev["final"];

                            // Vize ve final notlarını kullanarak not ortalamasını hesapla
                            $not_ortalamasi = ($vize_notu * 0.4) + ($final_notu * 0.6);

                            echo "<tr><td>".$gorev["ogr_no"]."</td><td>".$gorev["ders_adi"]."</td><td>".$gorev["donem"]."</td><td>".$gorev["vize"]."</td><td>".$gorev["final"]."</td><td>".$not_ortalamasi."</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- EKLE - GÜNCELLE - SİL FORM BÖLÜMÜ -->
    <div class="container p-3">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">Kayıt Ekle ve Güncelleme İşlemleri</h5>
                        <form action="notlar.php" method="POST">
                            <div class="form-group">
                                <label for="ogr_no">Öğrenci No:</label>
                                <input type="number" class="form-control" name="ogr_no" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="ogr_ad">Ders Adı:</label>
                                <input type="text" class="form-control" name="ders_adi" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="donem">Dönem:</label>
                                <input type="text" class="form-control" name="donem" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="vize">Vize:</label>
                                <input type="number" class="form-control" name="vize" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="final">Final:</label>
                                <input type="number" class="form-control" name="final" min="0" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" name="ekle">Ekle</button>
                            <button type="submit" class="btn btn-warning" name="guncelle">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>    
            
            <div class="card p-3">
                <h5 class="card-title">Kayıt Silme İşlemleri</h5>
                <form action="notlar.php"method="POST">
                    <div class="form-group">
                        <label for="ogr_no">Öğrenci No:</label>
                        <input type="number" class="form-control" name="ogr_no_sil" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="ogr_ad">Ders Adı:</label>
                        <input type="text" class="form-control" name="ders_adi_sil" min="0" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-danger" name="sil">Sil</button>
                </form>
            </div> 
        </div>
    </div>

    

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>