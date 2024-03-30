<?php
//UYELİK BAĞLANTI
$host="localhost";
$kullanici="root";
$parola="";
$vt="ogrenciler";

$baglanti = mysqli_connect($host, $kullanici, $parola, $vt);
mysqli_set_charset($baglanti,"UTF8");

?>