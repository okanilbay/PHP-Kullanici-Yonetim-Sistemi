<?php
    include("baglanti.php");


    //EKLE BUTONUNA TIKLANDIĞINDA
    if (isset($_POST["ekle"])) 
    {

        $ogr_ad = $_POST["ogr_ad"];
        $ogr_soyad = $_POST["ogr_soyad"];
        $ogr_no = $_POST["ogr_no"];
    
        $ekle = "INSERT INTO ogrenci (ogr_ad,ogr_soyad,ogr_no) VALUES ('$ogr_ad','$ogr_soyad','$ogr_no')";
        
        $calistir_ekle = mysqli_query($baglanti_ogr,$ekle);
        
        if ($calistir_ekle) {
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

    // Öğrenci güncelleme işlemi
    if(isset($_POST['submit_update'])){
        $ogrenci_id = $_POST['ogrenci_id_guncelle'];
        $ogrenci_ad = $_POST['ogrenci_ad_guncelle'];
        $ogrenci_soyad = $_POST['ogrenci_soyad_guncelle'];
        $ogrenci_numara = $_POST['ogrenci_numara_guncelle'];

        $sql = "UPDATE ogrenci SET ogr_ad='$ogrenci_ad', ogr_soyad='$ogrenci_soyad', ogr_no='$ogrenci_numara' WHERE ogr_id='$ogrenci_id'";

        if (mysqli_query($baglanti_ogr, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci bilgileri başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti_ogr) . "</div>";
        }
    }

    if(isset($_GET['delete_id'])){
        $ogrenci_id = $_GET['delete_id'];

        $sql = "DELETE FROM ogrenci WHERE ogr_id='$ogrenci_id'";

        if (mysqli_query($baglanti_ogr, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Öğrenci başarıyla silindi.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Hata: " . $sql . "<br>" . mysqli_error($baglanti_ogr) . "</div>";
        }
    }

    $db=new PDO('mysql:host=localhost;dbname=ogrenciler','root','');
    $gorevler=$db->query("select * from ogrenci");

    // Veritabanı bağlantısını kapat
    mysqli_close($baglanti_ogr);
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
                <h5 class="card-title">Öğrenci Listesi</h5>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Öğrenci ID</th>
                            <th scope="col">Öğrenci Adı</th>
                            <th scope="col">Öğrenci Soyadı</th>
                            <th scope="col">Öğrenci Numarası</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($gorevler as $gorev)
                        {
                        echo "<tr><td>".$gorev["ogr_id"]."</td><td>".$gorev["ogr_ad"]."</td><td>".$gorev["ogr_soyad"]."</td><td>".$gorev["ogr_no"]."</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            </div>
    </div>


        <!-- CRUD İŞLEMLERİ -->
    <div class="container p-3">
        <div class="row row-cols-1 row-cols-md-2 g-4">
                <!-- ÖĞRENCİ EKLE BÖLÜMÜ -->
            <div class="col">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">Yeni Öğrenci Ekle</h5>

                        <form action="profile.php" method="POST">
                            <div class="form-group">
                                <label for="ogrenci_ad">Adı:</label>
                                <input type="text" class="form-control" id="ogrenci_ad" name="ogr_ad">
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_soyad">Soyadı:</label>
                                <input type="text" class="form-control" id="ogrenci_soyad" name="ogr_soyad">
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_numara">Numarası:</label>
                                <input type="text" class="form-control" id="ogrenci_numara" name="ogr_no">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" name="ekle">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ÖĞRENCİ GÜNCELLE BÖLÜMÜ -->
            <div class="col">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">Öğrenci Güncelle</h5>

                        <form action="profile.php" method="POST">
                            <div class="form-group">
                                <label for="ogrenci_id_guncelle">Öğrenci ID:</label>
                                <input type="text" class="form-control" id="ogrenci_id_guncelle" name="ogrenci_id_guncelle">
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_ad_guncelle">Adı:</label>
                                <input type="text" class="form-control" id="ogrenci_ad_guncelle" name="ogrenci_ad_guncelle">
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_soyad_guncelle">Soyadı:</label>
                                <input type="text" class="form-control" id="ogrenci_soyad_guncelle" name="ogrenci_soyad_guncelle">
                            </div>
                            <div class="form-group">
                                <label for="ogrenci_numara_guncelle">Numarası:</label>
                                <input type="text" class="form-control" id="ogrenci_numara_guncelle" name="ogrenci_numara_guncelle">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-warning" name="submit_update">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ÖĞRENCİ SİL BÖLÜMÜ -->
            <div class="col">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">Öğrenci Sil</h5>
                        <form action="profile.php" method="GET">
                            <div class="form-group">
                                <label for="ogrenci_id_sil">Öğrenci ID:</label>
                                <input type="text" class="form-control" id="ogrenci_id_sil" name="delete_id">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </div>
                </div>
            </div>     
        </div>
    </div>

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>