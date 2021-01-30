<?php
$MAXizdelkov = 20;
$sporociloObNeuspeliRezervaciji = "Pozdravljeni!\nArtikel %s je že rezerviran. Izberite drugega.\nHvala, OŠ Petrovče";
$sporociloObUspeliRezervaciji   = "Pozdravljeni!\nArtikel %s je rezerviran za vas!\nHvala, OŠ Petrovče";
$sporociloObNapaki              = "Pozdravljeni!\nZgodila se je napaka. Poskusite ponovno kasneje.\nHvala, OŠ Petrovče";
$sporociloObPrevecIzdelkih      = "Pozdravljeni!\nRezervirate lahko največ $MAXizdelkov izdelkov.\nLep pozdrav, OŠ Petrovče";
$sporociloNeObstaja             = "Pozdravljeni!\nArtikel ne obstaja.\nLep pozdrav, OŠ Petrovče";
//Pošlje POST na API in vrne na novo prejeto sporočilo
$url  = 'https://dev.nikigre.si/sms/api.php';
$data = array(
    'func' => '0001',
    'user' => 'username'
);


$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$result  = file_get_contents($url, false, $context);


if ($result != "NO RECEIVED SMS") {
    //Iz rezultata dobi telefonsko številko in iskanje in ju shrani
    $polje = explode("'", $result);
    
    $stevilka = $polje[3];
    $iskanje  = $polje[5];
    $iskanje = preg_replace("/[^0-9]/", "", $iskanje);
    

    if(VrniAliJeNeZaseden($iskanje))
    {   
        if(KolikoIzdelkovZeIma($stevilka) <= $MAXizdelkov)
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
    $url  = 'https://dev.nikigre.si/sms/api.php';
    $data = array(
        'func' => '1000',
        'user' => 'username',
        'message' => $sms,
        'phone' => $tel
    );
    
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        echo $result;
    } else {
        echo "OK";
    }
}

function VrniAliJeNeZaseden($ID)
{
    include "db.php";
    $sql="SELECT `ID_rezervacija` FROM `RezervacijaArtikel` WHERE IDArtikel=" . $ID;
    
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
    
    $sql = "INSERT INTO `RezervacijaArtikel`(`IDArtikel`, `TelefonskaStevilka`) VALUES (" . $ID . ", '" . $stevilka . "')";
    
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

    $sql="SELECT COUNT(`ID_rezervacija`) 'ST' FROM `RezervacijaArtikel` WHERE TelefonskaStevilka ='" . $stevilka . "';";
    
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