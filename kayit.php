<?php
include("baglanti.php");

$ad_err=$soyad_err=$mail_err=$parola_err=$parolatkr_err="";

//KAYDET BUTONUNA TIKLANDIĞINDA
if (isset($_POST["kaydet"])) 
{

  //isim alanı doğrulama işlemleri.
  if (empty($_POST["ad"]))
  {
    $ad_err= "Bu alan boş geçilemez.";
  }
  else
  {
    $ad = $_POST["ad"];
  }

  //Soyadı alanı doğrulama işlemleri
  if (empty($_POST["soyad"]))
  {
    $soyad_err= "Bu alan boş geçilemez.";
  }
  else
  {
    $soyad = $_POST["soyad"];
  }

  //Email alanı doğrulama işlemleri
  if (empty($_POST["mail"]))
  {
    $mail_err= "Bu alan boş geçilemez.";
  }
  else
  {
    $mail = $_POST["mail"];
  }
      
  //Parola doğrulama 
  if (empty($_POST["parola"]))
  {
    $parola_err= "Parola alanı boş geçilemez.";
  }
  else {
    $parola = password_hash($_POST["parola"],PASSWORD_DEFAULT);
  }

  //Parola Tekrar Doğrulaması
  if (empty($_POST["parolatkr"]))
  {
    $parolatkr_err= "Parola tekrar alanı boş geçilemez.";
  }
  else if ($_POST["parola"] != $_POST["parolatkr"]) 
  {
    $parolatkr_err= "Parolalar eşleşmiyor.";
  }
  else 
  {
    $parolatkr=$_POST["parolatkr"];
  }
      
    //Kayıt sorgusu

  if (isset($ad) && isset($soyad) && isset($mail) && isset($parola) && isset($parolatkr))
  {
    $ekle = "INSERT INTO kullanicilar (ad,soyad,mail,parola) VALUES ('$ad','$soyad','$mail','$parola')";
    $calistir_ekle = mysqli_query($baglanti,$ekle);
    
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
    mysqli_close($baglanti);
    header("location:index.php");
  }
}

//GİRİŞ YAP BUTONUNA TIKLANDIĞINDA
if (isset($_POST["giris_yap"]))
{
  header("location:index.php");
}
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Yönetim Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-5">
      <div class="row row-cols-1 row-cols-md-2 g-4 d-flex justify-content-center align-items-center">
        <div class="card p-5">
            <form action="kayit.php" method="POST">
                <div class="mb-3">
                    <h2>Sistemine Kayıt Ol</h2>
                    <label for="exampleInputEmail1" class="form-label">Ad</label>
                    <input type="text" class="form-control 
                    <?php
                    if (!empty($ad_err))
                    {
                      echo "is-invalid";
                    }
                    ?>
                    " name="ad">
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                      <?php
                        echo $ad_err;
                      ?>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Soyad</label>
                    <input type="text" class="form-control 
                    <?php
                    if (!empty($soyad_err))
                    {
                      echo "is-invalid";
                    }
                    ?>
                    " name="soyad">
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    <?php
                        echo $soyad_err;
                      ?>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Email Adres</label>
                    <input type="email" class="form-control 
                    <?php
                    if (!empty($mail_err))
                    {
                      echo "is-invalid";
                    }
                    ?>
                    " name="mail">
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    <?php
                        echo $mail_err;
                      ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Parola</label>
                    <input type="password" class="form-control 
                    <?php
                    if (!empty($parola_err))
                    {
                      echo "is-invalid";
                    }
                    ?>
                    " name="parola">
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    <?php
                        echo $parola_err;
                      ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Parola Tekrar</label>
                    <input type="password" class="form-control 
                    <?php
                    if (!empty($parolatkr_err))
                    {
                      echo "is-invalid";
                    }
                    ?>
                    " name="parolatkr">
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    <?php
                        echo $parolatkr_err;
                      ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" name="kaydet">KAYDET</button>
                <button type="submit" class="btn btn-primary" name="giris_yap">GİRİŞ YAP</button>
            </form>
        </div>
      </div>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>