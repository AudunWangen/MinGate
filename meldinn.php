<?
include 'inc/header.php';
?>

<h2>Mitt n&aelig;romr&aring;de</h2>
<p>Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.</p><p>Sakene behandles fortløpende av kommunen.</p>

<h2>Registrer sak her</h2>

<script type="text/javascript">
function popup (el)
{
if(el.value.toLowerCase()=='gatelys')
	alert('\'Feil på gatelys må meldes til Skagerak Energi. www.skagerakenergi.no\'');
}
</script>

<?

//include 'config.php';

	// Build SQL query
	$idag  = date ("d.m.y", mktime (0,0,0,date("m")  ,date("d") ,date("Y")));
	$dato = $idag;

$to = "Fellesbruker.Servicesenteret.2@porsgrunn.kommune.no";
$subject = "Ny sak registrert i Fiks min gate";

$message = "
<html>
<head>
<title>Ny sak registrert i Fiks min gate</title>
</head>
<body>
<p>Feilmelding: $feil</p>
<p>Adresse: $sted</p><br />
<p>Type problem: $problem</p>
<p>Navn: $navn</p>
<p>E-post: $epost</p>
<p>Tlf: $tlf</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers

$headers .= 'From: <Min Gate Porsgrunn kommune>' . "\r\n";

if ($ny != "ny")
{

$ip = getenv("REMOTE_ADDR") ; 

	print "<div class=\"registrationform\">\n";

	print "<form action=\"meldinn.php\" method=\"post\" name=\"fiksgrafitti\" enctype=\"multipart/form-data\"  onsubmit=\"return checkform(this);\">\n";
	print "<input type=\"hidden\" name=\"ny\" value=\"ny\" />\n";
	print "<input type=\"hidden\" name=\"status\" value=\"ubehandlet\" />\n";
	print "<input type=\"hidden\" name=\"ip\" value=\"$ip\" />\n";

	print "	<label for=\"feil\">Feil</label>\n";
	print " <select name=\"feil\" id=\"feil\" onchange=\"popup(this)\"> \n";
	print " <option value=\"Ingen valgt\" selected=\"selected\">Velg</option>\n";
	print " <option value=\"gatelys\">Gatelys virker ikke</option>\n";
	print " 	<option value=\"Hull i veg\">Hull i veg</option>\n";
	print " 	<option value=\"Grafitti-Tagging\">Grafitti-Tagging</option>\n";
	print " 	<option value=\"Skilt-Trafikk\">Skilt/Trafikk</option>\n";
	print " 	<option value=\"Vann og avløp\">Vann og avl&oslash;p</option>\n";
	print " 	<option value=\"Park\">Park</option>\n";
	print " 	<option value=\"Renovasjon\">Renovasjon</option>\n";
	print " 	<option value=\"Friluft\">Friluft</option>\n";
	print " 	<option value=\"Annet\">Annet</option>\n";
	print " 	</select>\n";
	
	print "	<label for=\"sted\">Adresse</label>\n";
	print " <input type=\"text\" name=\"sted\" id=\"sted\" size=\"25\" class=\"normal\" />\n";
	print "	<p>Klikk på kartet for å registrere lengde- og breddegrad på den innmeldte saken.</p><p>Du kan klikke flere ganger for å rette koordinatene.</p>\n";
	print "	<label for=\"latbox\">Breddegrad</label>\n";
	print "<div id=\"stylized\" class=\"myform\">\n";
	print "<input size=\"6\" type=\"text\" id=\"latbox\" name=\"lat\" />\n";
	print "</div>\n";
	print "	<label for=\"lonbox\">Lengdegrad</label>\n";
	print "<div id=\"stylized\" class=\"myform\">\n";
	print "<input size=\"6\" type=\"text\" id=\"lonbox\" name=\"lon\" />\n";
	print "</div>\n";

	print "	<label for=\"problem\">Problem</label>\n";
	print "	<textarea name=\"problem\" id=\"problem\" rows=\"5\" cols=\"30\"></textarea>\n";
	print "	<label for=\"navn\">Navn</label>\n";
	print "	<input type=\"text\" name=\"navn\" id=\"navn\" size=\"25\" class=\"normal\" />\n";
	print "	<label for=\"epost\">Epost</label> *\n";
	print "	<input type=\"text\" name=\"epost\" id=\"epost\" size=\"25\" class=\"normal\"/>\n";
	print "	<label for=\"tlf\">Tlf</label> *\n";
	print "	<input type=\"text\" name=\"tlf\" id=\"tlf\" size=\"25\" class=\"normal\" />\n";
	print "	<p>Din ip-adresse: $ip</p>\n";

	print "	<label for=\"bilde\">Bilde:</label>\n";
	print "	<input name=\"bilde\" id=\"bilde\" size=\"20\" type=\"file\" value=\"$bilde\" />\n";

	//Submit knapp
	print "	<input type=\"submit\" value=\"Registrer sak\" class=\"normalbold\" />\n";
	print "	<span class=\"small\">* Vises ikke p&aring; websiden</span>\n";
	print "</form>\n";
	print "</div>";
}
else
{
	
mail($to,$subject,$message,$headers);

// Configuration - Your Options
      $allowed_filetypes = array('.jpg','.gif','.bmp','.png',''); // These will be the types of file that will pass the validation.
      $max_filesize = 55524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = './upload/'; // The place the files will be uploaded to (currently a 'files' directory).
	
   $bilde = $_FILES['bilde']['name']; // Get the name of the file (including file extension).
   $ext = substr($bilde, strpos($bilde,'.'), strlen($bilde)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('Filtypen du prøver å laste opp er ikke tillatt.');
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['bilde']['tmp_name']) > $max_filesize)
      die('Bildefilen er for stor til å lastes opp.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['bilde']['tmp_name'],$upload_path . $bilde))
         echo '<br /><br />Ditt bilde ble lastet opp, se ditt bilde her: <a href="' . $upload_path . $bilde . '" title="Your File" target="_top">her</a>'; // It worked.
      else
         echo ''; // It failed :(.

$query = "INSERT INTO fiksgrafitti (id, dato, sted, lat, lon, feil, status, problem, navn, epost, tlf, ip, bilde) VALUES ('$id','$dato','$sted','$lat','$lon','$feil','$status','$problem','$navn','$epost','$tlf','$ip','$bilde')";

echo "<br /><br />Takk for din registrering!<br /><br />Vi setter stor pris på ditt sosiale engasjement som hjelper oss med å yte bedre tjenester til våre innbyggere.";

	
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
}
?>


<h2>Usikker på adressen? Bruk kartet.</h2>

<div id="map" style="width: 380px; height: 380px"></div>
<div style="width: 380px;">
</div>

    <script type="text/javascript">
    //<![CDATA[
 
    var map = new GMap(document.getElementById("map"));
    map.centerAndZoom(new GPoint(<?php echo GOOGLE_CENTERPOINT_LON . ", " . GOOGLE_CENTERPOINT_LAT; ?>), 6);
 
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
 
// Recenter Map and add Coords by clicking the map
GEvent.addListener(map, 'click', function(overlay, point) {
            document.getElementById("latbox").value=point.y;
            document.getElementById("lonbox").value=point.x;
});
    //]]>
    </script>
<p>Naviger i kartet ved å holde venstreknappen inne og bevege musen</p>

<?
include 'inc/footer.php';
?>
