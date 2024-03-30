<?php
include("baglanti.php");

$mail_err=$parola_err="";

//GİRİŞ BUTONUNA TIKLANDIĞINDA
if (isset($_POST["giris"])) 
{

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
  else 
  {
    $parola = $_POST["parola"];
  }

  //Girilen değerlerin veritabanında kontrolü
    if (isset($mail) && isset($parola))
    {
        $secim = "SELECT * FROM kullanicilar WHERE mail = '$mail'";
        $calistir = mysqli_query($baglanti,$secim);
        $kayitsayisi = mysqli_num_rows($calistir);

        if ($kayitsayisi > 0)
        {
            $ilgilikayit = mysqli_fetch_assoc($calistir);
            $hashlisifre = $ilgilikayit["parola"];

            if (password_verify($parola, $hashlisifre))
            {
                session_start();
                $_SESSION["ad"] = $ilgilikayit["ad"];
                $_SESSION["soyad"] = $ilgilikayit["soyad"];  
                header("location:profile.php");
            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">
                Email veya parola bilgisi hatalı.
                </div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger" role="alert">
            Email veya parola bilgisi hatalı.
            </div>';
        }
        mysqli_close($baglanti);
    }
}

//KAYIT OL BUTONUNA TIKLANDIĞINDA
if(isset ($_POST["kayit_ol"])){
    header("location:kayit.php");
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
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <h2>Not Otomasyonu Giriş</h2>
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

                <button type="submit" class="btn btn-primary" name="giris">GİRİŞ YAP</button>
                <button type="submit" class="btn btn-primary" name="kayit_ol">KAYIT OL</button>
            </form>
        </div>
      </div>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>