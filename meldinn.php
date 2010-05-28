<?
include 'inc/header.php';
?>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="675"><BR><span class="tittel">Mitt n&aelig;romr&aring;de</span><br><br><span class="text">Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.<br>Sakene behandles fortløpende av kommunen.</span><BR>
	</TD>
</TR>
</TABLE>
<br>
<table width="675" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td width="400" valign="top">
<BR>&nbsp;<span class="tittel">Registrer sak her</span>

<script type="text/javascript">
function popup (el)
{
if(el.value.toLowerCase()=='gatelys')
	alert('\'Feil på gatelys må meldes til Skagerak Energi. www.skagerakenergi.no\'');
}
</script>

<?

include 'db/database.php';

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
<p>Adresse: $sted</p><br>
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

	print "<br><br>\n";
	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";

	print "<form action=\"meldinn.php\" method=\"post\" name=\"fiksgrafitti\" enctype=\"multipart/form-data\"  onsubmit=\"return checkform(this);\">\n";
	print "<input type=\"hidden\" name=\"ny\" value=\"ny\">\n";
	print "<input type=\"hidden\" name=\"status\" value=\"ubehandlet\">\n";
	print "<input type=\"hidden\" name=\"ip\" value=\"$ip\">\n";

	print "<tr>\n";
	print "	<td width=\"75\" class=\"normal\">\n";
	print "	<span class=\"text\"><B>Feil:</B>\n";
	print "	</td>\n";
	print "	<td>\n";
	print " <SELECT NAME=\"feil\" onchange=\"popup(this)\"> \n";
	print " <OPTION VALUE=\"Ingen valgt\" SELECTED>Velg\n";
	print " <OPTION VALUE=\"gatelys\">Gatelys virker ikke\n";
	print " 	<OPTION VALUE=\"Hull i veg\">Hull i veg\n";
	print " 	<OPTION VALUE=\"Grafitti-Tagging\">Grafitti-Tagging\n";
	print " 	<OPTION VALUE=\"Skilt-Trafikk\">Skilt/Trafikk\n";
	print " 	<OPTION VALUE=\"Vann og avløp\">Vann og avl&oslash;p\n";
	print " 	<OPTION VALUE=\"Park\">Park\n";
	print " 	<OPTION VALUE=\"Renovasjon\">Renovasjon\n";
	print " 	<OPTION VALUE=\"Friluft\">Friluft\n";
	print " 	<OPTION VALUE=\"Annet\">Annet\n";
	print " 	</SELECT>\n";
	
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td width=\"75\" class=\"normal\">\n";
	print "	<span class=\"text\"><B>Adresse:</B>\n";
	print "	</td>\n";
	print "	<td>\n";
	print " <input type=\"text\" name=\"sted\" size=\"25\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // 
	print "<tr>\n";
	print "	<td width=\"\" class=\"normal\" valign=\"\">\n";
	print "	<span class=\"text\">Klikk på kartet for å registrere lengde- og breddegrad på den innmeldte saken.<br><br>Du kan klikke flere ganger for å rette koordinatene.\n";
	
	print "<br>\n";
	print "<table width=\"90%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // 
	print "<tr>\n";
	print "	<td width=\"50%\" class=\"normal\" valign=\"top\">\n";
	print "	<br><span class=\"text\"><B>Breddegrad:</B>\n";
	print "	</td>\n";
	print "	<td width=\"50%\" class=\"normal\" valign=\"top\">\n";
	print "	<br><span class=\"text\"><B>Lengdegrad:</B>\n";
	print "	</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "	<td  width=\"50%\" class=\"normal\" valign=\"top\">\n";
	print "<div id=\"stylized\" class=\"myform\">\n";
	print "<INPUT SIZE=\"6\" TYPE=\"TEXT\" ID=\"latbox\" NAME=\"lat\">\n";
	print "</div>\n";
	print "	</td>\n";
	print "	<td  width=\"50%\" class=\"normal\" valign=\"top\">\n";
	print "<div id=\"stylized\" class=\"myform\">\n";
	print "<INPUT SIZE=\"6\" TYPE=\"TEXT\" ID=\"lonbox\" NAME=\"lon\">\n";
	print "</div>\n";
	print "	</td>\n";
	print "</tr>\n";
	print "</div>\n";
	print "</table>\n"; 

	print "	</td>\n";
	print "</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // 
	print "<tr>\n";
	print "	<td class=\"normal\" valign=\"top\">\n";
	print "	<span class=\"text\"><B>Problem:</B>&nbsp;\n";
	print "	</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "	<td>\n";
	print "	<TEXTAREA NAME=\"problem\" ROWS=\"5\" COLS=\"30\"></TEXTAREA>\n";
	print "	</td>\n";
	print "	</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Navn:</B>\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"navn\" size=\"25\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Epost:</B> *\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"epost\" size=\"25\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Tlf:</B> *\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"tlf\" size=\"25\" class=\"normal\">\n";
	print "	<br>Din ip-adresse: $ip</td>\n";
	print "</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // 
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Bilde:</B>\n";
	print "	</td>\n";
	print "<tr>\n";
	print "</tr>\n";
	print "	<td>\n";
	print "	<input name=\"bilde\" size=\"20\" type=\"file\" value=\"$bilde\">\n";
	print "	</td>\n";
	print "</tr>\n";
	print "</table>\n"; 


	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // 
	//Submit knapp
	print "<tr>\n";

	print "	<td>\n";
	print "	<input type=\"submit\" value=\"Registrer sak\" class=\"normalbold\">\n";
	print "	</td>\n";

	print "	<td class=\"normal\" width=\"200\">\n";
	print "	<span class=\"small\">* Vises ikke p&aring; websiden</span>\n";
	print "	</td>\n";
	
	print "</tr>\n";
	print "</table>\n";
	print "</form>\n";
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
         echo '<br><br>Ditt bilde ble lastet opp, se ditt bilde her: <a href="' . $upload_path . $bilde . '" title="Your File" target="_top">her</a>'; // It worked.
      else
         echo ''; // It failed :(.

$query = "INSERT INTO fiksgrafitti (id, dato, sted, lat, lon, feil, status, problem, navn, epost, tlf, ip, bilde) VALUES ('$id','$dato','$sted','$lat','$lon','$feil','$status','$problem','$navn','$epost','$tlf','$ip','$bilde')";

echo "<br><br>Takk for din registrering!<br><br>Vi setter stor pris på ditt sosiale engasjement som hjelper oss med å yte bedre tjenester til våre innbyggere.";

	
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
}
?>


<td width="400" valign="top" align="center"><BR>
<span class="tittel">Usikker på adressen? Bruk kartet.</span><BR><BR>

<body>
<div id="map" style="width: 380px; height: 380px"></div>
<div style="width: 380px;">
</div>

    <script type="text/javascript">
    //<![CDATA[
 
    var map = new GMap(document.getElementById("map"));
    map.centerAndZoom(new GPoint(9.67002, 59.10055), 6);
 
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
 
// Recenter Map and add Coords by clicking the map
GEvent.addListener(map, 'click', function(overlay, point) {
            document.getElementById("latbox").value=point.y;
            document.getElementById("lonbox").value=point.x;
});
    //]]>
    </script>
Naviger i kartet ved å holde venstreknappen<br>inne og bevege musen
</td>

</TD>
<td></td>
</TR>
</TABLE>

<?
include 'inc/footer.php';
?>
