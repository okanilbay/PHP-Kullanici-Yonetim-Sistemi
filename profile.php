<?php
    include("baglanti.php");


    //EKLE BUTONUNA TIKLANDIĞINDA
    if (isset($_POST["ekle"])) 
    {

        $ogr_no = $_POST["ogr_no"];
        $ogr_ad = $_POST["ogr_ad"];
        $ogr_soyad = $_POST["ogr_soyad"];
    
        $sql = "INSERT INTO ogrenci (ogr_no,ogr_ad,ogr_soyad) VALUES ('$ogr_no','$ogr_ad','$ogr_soyad')";
        
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

    //GÜNCELLEME İŞLEMLERİ
    if(isset($_POST['guncelle'])){
        $ogrenci_numara = $_POST['ogr_no'];
        $ogrenci_ad = $_POST['ogr_ad'];
        $ogrenci_soyad = $_POST['ogr_soyad'];

        $sql = "UPDATE ogrenci SET ogr_ad='$ogrenci_ad', ogr_soyad='$ogrenci_soyad' WHERE ogr_no='$ogrenci_numara'";

        if (mysqli_query($baglanti, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci bilgileri başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti) . "</div>";
        }
    }

    //NOT SİLME İŞLEMLERİ
    if(isset($_POST['sil'])){
        $ogr_no = $_POST['ogr_no_sil'];
        $sql = "DELETE FROM ogrenci WHERE ogr_no='$ogr_no'";

        if (mysqli_query($baglanti, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci başarıyla silindi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti) . "</div>";
        }
    }

    // Veritabanından öğrenci bilgilerini çekme
    $sql = "SELECT * FROM ogrenci";
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
                    echo "<a href='notlar.php'>NOT YÖNETİM SAYFASINA GİT</a> ";
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
            <div class="card-body" style="overflow-x:auto;">
                <h5 class="card-title">Öğrenci Listesi</h5>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Öğrenci Numarası</th> 
                            <th scope="col">Öğrenci Adı</th>
                            <th scope="col">Öğrenci Soyadı</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($result as $gorev)
                        {
                        echo "<tr><td>".$gorev["ogr_no"]."</td><td>".$gorev["ogr_ad"]."</td><td>".$gorev["ogr_soyad"]."</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container p-3">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">Ekle-Güncelle İşlemleri</h5>

                        <form action="profile.php" method="POST">
                             <div class="form-group">
                                <label for="ogrenci_numara">Öğrenci No:</label>
                                <input type="text" class="form-control" name="ogr_no" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_ad">Öğrenci Adı:</label>
                                <input type="text" class="form-control" name="ogr_ad" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_soyad">Öğrenci Soyadı:</label>
                                <input type="text" class="form-control" name="ogr_soyad" min="0" required>
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
                <form action="profile.php"method="POST">
                    <div class="form-group">
                        <label for="ogr_no">Öğrenci No:</label>
                        <input type="number" class="form-control" name="ogr_no_sil" min="0" required>
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