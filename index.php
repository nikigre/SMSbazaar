<!doctype html>

<html lang="sl">
<head>
  <meta charset="utf-8">

  <title>OŠ Petrovče bazar Artikli</title>
  <meta name="description" content="Bazar online">
  <meta name="author" content="Nik Grebovšek">
  <meta http-equiv="refresh" content="20"/>
  <style>
    img{
        padding-top: 5px;
        padding-left: 5px;
        padding-right: 5px;
        width: 120px;
        border-radius: 8px;
    }
    td{
        text-align: center;
        vertical-align: top; 
        vertical-align: middle;
    }
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 20px;
        transform: translate(-50%, -50%);
    }
    .container {
        position: relative;
        text-align: center;
        color: red;
    }
    .rezervirano
    {
        color: red;
    }
    table{
        border-collapse: collapse;
    }
  </style>
</head>

<?php
$telefon = NaredimTabeloVenemStolpcu();
?>

<body>
    <center>
        <table border="1">
            <tr>
                <?= $telefon == true ? "<th>Artikel</th><th>Artikel</th>" : "<th>Slika artikla</th><th>QR koda</th><th>Slika artikla</th><th>QR koda</th><th>Slika artikla</th><th>QR koda</th>" ?>
            </tr>
             <?php
                include "db.php";
                include "./qrcode/phpqrcode.php";
                
                $filter = "";
                if(isset($_GET["1r"]))
                {
                    $filter = "WHERE ID >= 201 AND ID <= 350";
                }
                if(isset($_GET["2r"]))
                {
                    $filter = "WHERE ID >= 351 AND ID <= 500";
                }
                if(isset($_GET["3r"]))
                {
                    $filter = "WHERE ID >= 501 AND ID <= 650";
                }
                if(isset($_GET["4r"]))
                {
                    $filter = "WHERE ID >= 651 AND ID <= 800";
                }if(isset($_GET["5r"]))
                {
                    $filter = "WHERE ID >= 801 AND ID <= 950";
                }
                if(isset($_GET["6r"]))
                {
                    $filter = "WHERE ID >= 951 AND ID <= 1100";
                }
                if(isset($_GET["7r"]))
                {
                    $filter = "WHERE ID >= 1101 AND ID <= 1250";
                }
                if(isset($_GET["8r"]))
                {
                    $filter = "WHERE ID >= 1251 AND ID <= 1400";
                }
                if(isset($_GET["9r"]))
                {
                    $filter = "WHERE ID >= 1401 AND ID <= 1550";
                }
                if(isset($_GET["vizitke"]))
                {
                    $filter = "WHERE ID >= 1600";
                }
                
                
                $sql = "SELECT ID, IF(rezerviran IS NULL, 'ne', 'da') 'rezerviran' FROM (SELECT `ID`, RezervacijaArtikel.ID_rezervacija 'rezerviran' FROM `ArtikelArtikel` LEFT JOIN RezervacijaArtikel ON ArtikelArtikel.ID=RezervacijaArtikel.IDArtikel) tbl " . $filter . " ORDER BY ID ASC";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $stevec = 1;
                    while($row = $result->fetch_assoc()) {
                        if($stevec == 1)
                            echo "<tr>\n";
                            
                        if(!$telefon){
                            NarediArtikelTabelaRacunalnik($row['ID'], $row["rezerviran"]);
                        }
                        else{
                            NarediArtikelTabelaTelefon($row['ID'], $row["rezerviran"]);
                        }
                                            
                        $stevec++;
                        
                        if(($telefon && $stevec > 2) or (!$telefon && $stevec > 3))
                        {                        
                            echo "\n</tr>\n";
                            $stevec = 1;
                        }
                    }
                } else {
                    echo "<tr><td colspan=6>Ni artiklov za prikaz.</td></tr>";
                }
                $conn->close();
            ?> 
        </table>
    </center>
</body>
</html>

<?php
function NaredimTabeloVenemStolpcu()
{
    $useragent=$_SERVER['HTTP_USER_AGENT'];

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    {
        return true;
    }
    return false;
}

function NarediArtikelTabelaRacunalnik($id, $rezerviran)
{
    $imageString="";
    if($rezerviran=='ne')
    {
        ob_start();
        QRCode::png("SMSTO:+38664178774:artikel " . $id, null);
        $imageString = "<img src=\"data:image/png;base64," . base64_encode(ob_get_contents()) . "\">";
        ob_end_clean();
    }
    
    $data = "<div class='container'><div class='centered'>Rezervirano</div>";
 
    echo "<td>
            <a target='_blank' href='./slikeArtikel/" . sprintf("%04s",$id)  . ".jpg'>
                <img loading='lazy' src='./slikeArtikel/" . sprintf("%04s",$id)  . ".jpg' />
            </a>
            <br>
            &nbsp;Številka artikla: " . $id . "
        </td>
        <td style='border-left:1px solid white; width: 120px'>
            " . ($rezerviran == "da" ? $data : "") . "
            " . $imageString . "
            " . ($rezerviran == "da" ? "</div>" : "") . "
        </td>
        ";
}

function NarediArtikelTabelaTelefon($id, $rezerviran)
{
        $data = "<div class='rezervirano'>Rezervirano</div>";
 
    echo "<td>
            <a target='_blank' href='./slikeArtikel/" . sprintf("%04s",$id)  . ".jpg'>
                <img loading='lazy' src='./slikeArtikel/" . sprintf("%04s",$id)  . ".jpg' />
            </a>
            <br>
            ";
    
    if($rezerviran == "da")
        echo $data;
    else
    echo    "
            <a target='_parent' href='sms:0038664178774?&body=artikel " . $id . "'>Rezerviraj!</a>
            <br>
            ali pošlji sms 'artikel " . $id . "' na 064178774
        ";
        
    echo"</td>
        ";
}
?>
