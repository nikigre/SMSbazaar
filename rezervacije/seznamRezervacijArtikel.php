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
<?php

$spremenljivke = "";

foreach ($_GET as $key => $value)
{
    if($key != "prevzemi" && $key != "odprevzemi")
        $spremenljivke .= "<input type=\"hidden\" name=\"$key\" value=\"$value\">";
}

if(isset($_GET['prevzemi']))
{
    include "../db.php";
    $sql = "UPDATE `RezervacijaArtikel` SET `JePrevzet`='1' WHERE IDArtikel=" . $_GET['prevzemi'];
    
    if (!($conn->query($sql) === TRUE)) {
        echo "<script>alert(\"Zgodila se je napaka pri zapisovanju prevzema. Šifro prevzetega izdelka si zapišite na list!\");</script>";
    }
    
    $conn->close();
    header("Refresh:0; url=" . removeqsvar($_SERVER['REQUEST_URI'], "prevzemi"));
}
if(isset($_GET['odprevzemi']))
{
    include "../db.php";
    $sql = "UPDATE `RezervacijaArtikel` SET `JePrevzet`='0' WHERE IDArtikel=" . $_GET['odprevzemi'];
    
    if (!($conn->query($sql) === TRUE)) {
        echo "<script>alert(\"Zgodila se je napaka pri zapisovanju prevzema. Šifro prevzetega izdelka si zapišite na list!\");</script>";
    }else{
        echo "<script>alert(\"Izdelek sedaj ni več prevzet.\");</script>";
    }
    
    $conn->close();
    header("Refresh:0; url=" . removeqsvar($_SERVER['REQUEST_URI'], "odprevzemi"));
}

function removeqsvar($url, $varname) {
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}

?>
    <h1>Rezervirani artikli glede na telefonsko številko</h1>
    <center>
        <p><a href="https://ospetrovce-my.sharepoint.com/:w:/g/personal/nik_grebovsek_ospetrovce_onmicrosoft_com/Ef5M_PiVT-xPnmxEtTEmro8BJHkhF7gUNhMQEm4y1vtpmg?e=isIHSt">Kratka navodila za uporabo</a></p>
        <p>
            <?php
                include "../db.php";
                

                $sql = "SELECT COUNT(`ID_rezervacija`) 'stevilo' FROM `RezervacijaArtikel` WHERE 1";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                      $stevilo = $row["stevilo"];
                    echo "Število rezervacij: " . $stevilo;
                  }
                } else {
                  echo "0 results";
                }
                $conn->close();
            ?>
        </p>
        <p>
            <?php
                include "../db.php";
                

                $sql = "(SELECT COUNT(`ID`) 'stevilo' FROM `ArtikelArtikel` WHERE 1)";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                      $stevilo -= $row["stevilo"];
                    echo "Število vseh artiklov: " . $row["stevilo"] ;
                  }
                } else {
                  echo "0 results";
                }
                $conn->close();
            ?>
        </p>
        <p>
            <?php
                echo "Število ostalih artiklov: " . abs($stevilo);
            ?>
        </p>
        <table>
            <tr>
                <td>
                    <form method="GET"><input type="hidden" name="SifraIzdelkaPadajoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po šifri izdelka padajoče"></form>
                </td>
                <td>
                    <form method="GET"><input type="hidden" name="SifraIzdelkaNarascujoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po šifri izdelka naraščajoče"></form>
                </td>
                <td>
                    <form method="GET"><input type="hidden" name="TelefonskaStevilkaPadajoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po telefonski številki padajoče"></form>
                </td>
                </tr>
                <tr>
                <td>
                    <form method="GET"><input type="hidden" name="TelefonskaStevilkaNarascujoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po telefonski številki naraščajoče"></form>
                </td>
                <td>
                    <form method="GET"><input type="hidden" name="DatumNarascujoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po datumu naraščajoče"></form>
                </td>
                <td>
                    <form method="GET"><input type="hidden" name="DatumPadajoce" value="True"><?= isset($_GET['SamoPrevzete']) ? "<input type=\"hidden\" name=\"SamoPrevzete\" value=\"True\">" : "" ?><?= isset($_GET['SamoNePrevzete']) ? "<input type=\"hidden\" name=\"SamoNePrevzete\" value=\"True\">" : "" ?><input type="submit" value="Razvrsti po datumu padajoče"></form>
                </td>
            </tr>
        </table>
        <form method="GET"><input type="hidden" name="SamoNePrevzete" value="True"><input type="submit" value="Samo neprevzete"></form>
        <form method="GET"><input type="hidden" name="SamoPrevzete" value="True"><input type="submit" value="Samo prevzete"></form>
                
        <br>
        
        <table border="1">
            <tr>
                <th>Telefonska številka</th><th>Šifra Izdelka</th><th>Datum rezervacije</th><th>Slika</th><th>Prevzemi</th>
            </tr>
             <?php
                include "../db.php";
                
                $order = "ORDER BY TelefonskaStevilka";

                if(isset($_GET['TelefonskaStevilkaNarascujoce']))
                    $order = "ORDER BY TelefonskaStevilka";
                
                if(isset($_GET['TelefonskaStevilkaPadajoce']))
                    $order = "ORDER BY TelefonskaStevilka DESC";
                
                if(isset($_GET['SifraIzdelkaNarascujoce']))
                    $order = "ORDER BY ID";
                
                if(isset($_GET['SifraIzdelkaPadajoce']))
                    $order = "ORDER BY ID DESC";
                    
                if(isset($_GET['DatumNarascujoce']))
                    $order = "ORDER BY DatumRezervacije";
                    
                if(isset($_GET['DatumPadajoce']))
                    $order = "ORDER BY DatumRezervacije DESC";
                
                 $prevzet = "";
                
                if(isset($_GET['SamoNePrevzete']))
                    $prevzet = "WHERE JePrevzet=0";
                
                if(isset($_GET['SamoPrevzete']))
                    $prevzet = "WHERE JePrevzet=1";
                
                   
                $sql = "SELECT `ID`, TelefonskaStevilka, DatumRezervacije, JePrevzet FROM `ArtikelArtikel` JOIN RezervacijaArtikel ON RezervacijaArtikel.IDArtikel=ArtikelArtikel.ID " . $prevzet . " " . $order;
                
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "\t<td>" . $row["TelefonskaStevilka"] . "</td><td>#" . $row["ID"] . "</td><td>" . $row["DatumRezervacije"] . "</td><td>" . "<a href=\"../slikeArtikel/" . sprintf("%04s",$row["ID"])  . ".jpg\"><img src=\"../slikeArtikel/" . sprintf("%04s",$row["ID"])  . ".jpg\"></a>" . "</td><td>" . ($row["JePrevzet"] == "1" ? "<form method=\"GET\"><input type=\"hidden\" name=\"odprevzemi\" value=\"" . $row["ID"] . "\">" . $spremenljivke . "<input type=\"submit\" value=\"Razveljavi\"></form>" : "<form method=\"GET\"><input type=\"hidden\" name=\"prevzemi\" value=\"" . $row["ID"] . "\">" . $spremenljivke . "<input type=\"submit\" value=\"Prevzemi\"></form>") .  "</td>\n";
                    echo "</tr>";
                  }
                } else {
                  echo "0 results";
                }
                $conn->close();
            ?> 
        </table>
    </center>
</body>
</html>