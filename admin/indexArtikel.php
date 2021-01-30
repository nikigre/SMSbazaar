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
            <label for="DodajSt">Koliko novih artiklov naj dodam:</label><input type="number" name="DodajSt"><input type="submit" value="Dodaj">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_GET['DodajSt']))
{
    $stevilo = $_GET['DodajSt'];
    
    include "../db.php";
    
    for ($i == 1; $i < $stevilo; $i++)
    {
        $sql = "INSERT INTO `ArtikelArtikel`(`ID`) VALUES (NULL)";
        
        $conn->query($sql);
    }
    
    $conn->close();
    
    header("Location: https://bazar.os-petrovce.si/admin/index.php");
}
?>