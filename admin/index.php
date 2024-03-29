<!doctype html>

<html lang="sl">
<head>
  <meta charset="utf-8">

  <title>OŠ Petrovče bazar online</title>
  <meta name="description" content="Bazar online">
  <meta name="author" content="Nik Grebovšek">
  <style>
      img{
            width: 150px;
            border-radius: 8px;
      }
      td{
            text-align: center;
            vertical-align: top; 
            vertical-align: middle;
      }
  </style>
</head>
<?php

if(isset($_GET['Do']))
header("Refresh:0; url=" . removeqsvar(removeqsvar($_SERVER['REQUEST_URI'], "Do"), "Od"));


function removeqsvar($url, $varname) {
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}

?>
<body>
    <h1>Seznam vseh Artiklov</h1>
    <center>
        <table border="1">
            <tr>
                <th>Šifra Izdelka</th><th>Datum rezervacije</th><Th>Slika</Th>
            </tr>
             <?php
                include "../db.php";
                
                
                if(isset($_GET['SifraIzdelkaNarascujoce']))
                    $order = "";
                
                
                $sql = "SELECT `ID`, DatumRezervacije FROM `ArtikelArtikel` LEFT JOIN RezervacijaArtikel on RezervacijaArtikel.IDArtikel=ArtikelArtikel.ID WHERE 1 ";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "\t<td>" . $row["ID"] . "</td><td>" . $row["DatumRezervacije"] . "</td><td>" . "<a href=\"../slikeArtikel/" . sprintf("%04s",$row["ID"]) . ".jpg\"><img src=\"../slikeArtikel/" . sprintf("%04s",$row["ID"])  . ".jpg\"></a>" . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "0 results";
                }
                $conn->close();
            ?> 
        </table>
        <br>
        <form method="GET">
            <label for="Od">OD:</label><input type="number" name="Od">
            <label for="Do">Do:</label><input type="number" name="Do">
            <input type="submit" value="Dodaj">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_GET['Od']))
{
    include "../db.php";
    
    for ($i=$_GET['Od']; $i <= $_GET['Do']; $i++)
    {
        $sql = "INSERT INTO `ArtikelArtikel`(`ID`) VALUES (". $i . ")";
        
        $conn->query($sql);
    }
    
    $conn->close();
    
    header("Location: https://bazar.os-petrovce.si/admin/index.php");
}
?>