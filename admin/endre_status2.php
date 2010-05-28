<?
	$hostname = "xxxx";
	$username = "xxxx";
	$password = "xxxx";
	$dbName = "xxxx";
	$tbname = "fiksgrafitti";

	MYSQL_CONNECT($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname"); 
	@mysql_select_db("$dbName") or die("Kan ikke velge database"); 
	$today = date("Ymd");
?>
<?
if ($endre != 'endre') 
{
	$query = "select * from $tbname where id = $id"; 
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
	$i = 0;
	
	 $id = mysql_result($result,$i,"id");
	 $dato = mysql_result($result,$i,"dato");
	 $sted = mysql_result($result,$i,"sted");
	 $feil = mysql_result($result,$i,"feil");
	 $lon = mysql_result($result,$i,"lon");
	 $lat = mysql_result($result,$i,"lat");
	 $problem = mysql_result($result,$i,"problem");
	 $status = mysql_result($result,$i,"status");
	 $kommentar = mysql_result($result,$i,"kommentar");
	 $navn = mysql_result($result,$i,"navn");
	 $epost = mysql_result($result,$i,"epost");
	 $tlf = mysql_result($result,$i,"tlf");
	 $ip = mysql_result($result,$i,"ip");
	 $bilde = mysql_result($result,$i,"bilde");

	print "<form action=\"endre_status.php\" method=\"post\" name=\"fiksgrafitti\">\n";
	print "<input type=\"hidden\" name=\"endre\" value=\"endre\">\n";
	print "<input type=\"hidden\" name=\"id\" value=\"$id\">\n";
	
	print " <table width=\"450\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";
	print "<tr>\n";
	print "	<td width=\"\">\n";
	print "	<span class=\"text\">Feil:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"feil\" value=\"$feil\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td width=\"\">\n";
	print "	<span class=\"text\">Dato:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"dato\" value=\"$dato\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td width=\"\">\n";
	print "	<span class=\"text\">Sted:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"sted\" value=\"$sted\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td width=\"\">\n";
	print "	<span class=\"text\">Lon:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"lon\" value=\"$lon\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td width=\"\">\n";
	print "	<span class=\"text\">Lat:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"lat\" value=\"$lat\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	
	print "<tr>\n";
	print "	<td valign=\"top\">\n";
	print "	<span class=\"text\">Problem:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<TEXTAREA NAME=\"problem\" ROWS=\"5\" COLS=\"38\">$problem</TEXTAREA>\n";
	print "	</td>\n";
	print "	</tr>\n";
	
	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Navn\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"navn\" value=\"$navn\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Epost\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"epost\" value=\"$epost\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Tlfnr\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"tlf\" value=\"$tlf\" size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Endre status\n";
	print "	</td>\n";
	print "	<td>\n";
	print "<SELECT NAME=\"status\">\n";
	print "	<OPTION VALUE=\"$status\" SELECTED>$status\n";
	print "	<OPTION VALUE=\"ubehandlet\">ubehandlet\n";
	print "	<OPTION VALUE=\"behandlet\">behandlet\n";
	print "	<OPTION VALUE=\"tilbehandling\">Til behandling\n";
		print "	<OPTION VALUE=\"avvist\">Avvist\n";
	print "	</SELECT>\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Standardsvar\n";
	print "	</td>\n";
	print "	<td>\n";
	print "<select name=\"oSel\" size=\"1\" onchange=\"showText()\">\n";
	print "<option>Velg standardsvar</option>\n";
	print "<option>Registrering er sendt til saksbehandler</option>\n";
	print "<option>Innmeldt sak er utbedret</option>\n";
	print "</select>\n";
 	print "<input type=\"button\" value=\"Visk ut\" onclick=\"this.form.elements['kommentar'].value=''\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Kommentar fra kommunen\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<TEXTAREA NAME=\"kommentar\" ROWS=\"5\" COLS=\"38\">$kommentar</TEXTAREA>\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">IP\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"ip\" value=\"$ip\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	print "<tr>\n";
	print "	<td>\n";
	print "	<span class=\"text\">Bildefil:\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"bilde\" value=\"$bilde\"size=\"50\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";

	//Submit knapp
	print "<tr>\n";
	print "	<td colspan=\"2\" align=\"left\">\n";
	print "	<input type=\"submit\" value=\"Oppdater saken\" class=\"text\"><br><a href=\"slett_sak.php?id=$id\">Slett saken</a><br><A HREF=\"mailto:&subject=Ny henvendelse fra Min Gate&body=type+your&body=$feil - $sted - $problem - Koordinater: $lon-$lat - Fra: $navn - $epost - $tlf - $status\">Send sak til ansvarlig</A>\n";	
	print "	</td>\n";
	print "</tr>\n";
	print " </table>\n";
	print "</form>\n";
}
else
{
	// 
	$query = "update $tbname set feil = '$feil', dato = '$dato', sted = '$sted', lon = '$lon', lat = '$lat', status = '$status', kommentar = '$kommentar', problem = '$problem', navn = '$navn', epost = '$epost', tlf = '$tlf', ip = '$ip', bilde = '$bilde' where id = $id"; 
	
$to = "$epost";
$subject = "Oppdatering på din sak i Fiks min gate";
$message = "
<html>
<head>
<title>Oppdatering på din sak i Fiks min gate</title>
</head>
<body>
<p>Status: $status</p>
<p>Feilmelding: $feil</p>
<p>Adresse: $sted</p><br>
<p>Type problem: $problem</p>
<p>Kommentar: $kommentar</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <Min Gate Porsgrunn kommune>' . "\r\n";

mail($to,$subject,$message,$headers);

echo "<br><br>Saken er oppdatert og e-post er sendt til innmelder.";
	
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
}
?>