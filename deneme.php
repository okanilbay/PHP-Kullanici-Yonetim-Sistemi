<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        $db=new PDO('mysql:host=localhost;dbname=ogrenciler','root','');
        $gorevler=$db->query("select * from ogrenci");
    ?>          
        <table>
            <tr>
                <td>ID</td>
                <td>AD</td>
                <td>SOYAD</td>
                <td>OGR NO</td>
            <tr>
            <?php
            foreach ($gorevler as $gorev)
            {
            echo "<tr><td>".$gorev["ogr_id"]."</td><td>".$gorev["ogr_ad"]."</td><td>".$gorev["ogr_soyad"]."</td><td>".$gorev["ogr_no"]."</td></tr>";
            }
            ?>
        </table>
</body>
</html>