<?php
$MAXizdelkov = 7;
$sporociloObNeuspeliRezervaciji = "Pozdravljeni!\nArtikel %s je že rezerviran. Izberite drugega.\nHvala, OŠ Petrovče";
$sporociloObUspeliRezervaciji   = "Pozdravljeni!\nArtikel %s je rezerviran za vas!\nHvala, OŠ Petrovče";
$sporociloObNapaki              = "Pozdravljeni!\nZgodila se je napaka. Poskusite ponovno kasneje.\nHvala, OŠ Petrovče";
$sporociloObPrevecIzdelkih      = "Pozdravljeni!\nRezervirate lahko največ $MAXizdelkov izdelkov.\nLep pozdrav, OŠ Petrovče";
$sporociloNeObstaja             = "Pozdravljeni!\nArtikel ne obstaja.\nLep pozdrav, OŠ Petrovče";


//Pošlje POST na API in vrne na novo prejeto sporočilo
$url = 'https://sms.nikigre.si/getOneSMS?key=fkvfg677lvwjekftdgvm';
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET'
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$data = json_decode($result, true);

if($data["SMS"] != null)
{
    $stevilka = $data["SMS"]["Sender"];
    $iskanje  = $data["SMS"]["Content"];
    $iskanje = preg_replace("/[^0-9]/", "", $iskanje);
    

    if(VrniAliJeNeZaseden($iskanje))
    {   
        if(KolikoIzdelkovZeIma($stevilka) < $MAXizdelkov)
        {
            $tmp = RezervirajIzdelek($iskanje, $stevilka);
            if($tmp == "true")
            {
                PosljiSMS($stevilka, sprintf($sporociloObUspeliRezervaciji, $iskanje));
            }
            else if($tmp == "niNajdeno"){
                PosljiSMS($stevilka, $sporociloNeObstaja);
            }
            else
            {
                PosljiSMS($stevilka, $sporociloObNapaki);
            }
        }
        else{
            PosljiSMS($stevilka, sprintf($sporociloObPrevecIzdelkih, $iskanje));
        }
    }
    else{
        PosljiSMS($stevilka, sprintf($sporociloObNeuspeliRezervaciji, $iskanje));
    }
} else {
    echo "No Info received";
}

//Pošlje SMS na določeno številko in vrne OK če je poslano
function PosljiSMS($tel, $sms)
{
    $url = 'https://sms.nikigre.si/sendSMS';
    $data = array('key' => 'fkvfg677lvwjekftdgvm', 'message' => $sms, 'phone' => $tel);


    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    echo $result;
}

function VrniAliJeNeZaseden($ID)
{
    include "db.php";
    $sql="SELECT `ID_rezervacija` FROM `RezervacijaArtikel` WHERE IDArtikel=" . mysqli_real_escape_string($conn, $ID);
    
    //echo $sql;
    
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
      // output data of each row
        return true;
    } else {
      return false;
    }
    $conn->close();
}

function RezervirajIzdelek($ID, $stevilka)
{
    include "db.php";
    
    $sql = "INSERT INTO `RezervacijaArtikel`(`IDArtikel`, `TelefonskaStevilka`) VALUES (" . mysqli_real_escape_string($conn, $ID) . ", '" . mysqli_real_escape_string($conn, $stevilka) . "')";
    
    //echo $sql;
    
    if ($conn->query($sql) === TRUE) {
      return "true";
    } else {
        echo $conn->error;
        if (strpos($conn->error, 'foreign key constraint fails') !== false) {
            return "niNajdeno";
        }
        else{
            return "false";
            
        }
    }
    
    $conn->close();
    
}

function KolikoIzdelkovZeIma($stevilka)
{
    include "db.php";

    $sql="SELECT COUNT(`ID_rezervacija`) 'ST' FROM `RezervacijaArtikel` WHERE TelefonskaStevilka ='" . mysqli_real_escape_string($conn, $stevilka) . "';";
    
    echo $sql;
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["ST"];
          }
    } else {
        return 0;
    }
    $conn->close();
}

?> 