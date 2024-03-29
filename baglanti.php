<?php
//UYELİK BAĞLANTI
$host="localhost";
$kullanici="root";
$parola="";
$vt="uyelik";

$baglanti = mysqli_connect($host, $kullanici, $parola, $vt);
mysqli_set_charset($baglanti,"UTF8");

//OGRENCİLER BAĞLANTI
$host2="localhost";
$kullanici2="root";
$parola2="";
$vt2="ogrenciler";

$baglanti_ogr = mysqli_connect($host2, $kullanici2, $parola2, $vt2);
mysqli_set_charset($baglanti_ogr,"UTF8");

?>