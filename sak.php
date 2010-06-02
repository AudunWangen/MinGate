<?
include 'inc/header.php';
?>

<br /><br />
<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td width="400"><br /><span class="tittel">Kart med registert sak</span><br />
<br />
<?
include 'kart2.php';
?>
</td>
<td valign="top" width="100%">
<br />
<span class="tittel">Informasjon om innmeldt sak</span><br /><br />
<?
include 'config.php';

	// Build and execute SQL query
	$today = date("Ymd");
    $query = "select * from fiksgrafitti where id = $id"; 

	$result = MYSQL_QUERY($query);
    $number = MYSQL_NUMROWS($result);
	MYSQL_CLOSE();

 // Lag HTML 
 if ($number == 0)
 {
	  print " <table width=\"100%\" border=\"0\" bgcolor=\"#ffffff\">\n";
	print "<tr>\n";
	print "<td class=\"tittel\">Det er ikke registrert noen saker</td>\n";
	print "</tr>\n";
	 print " </table>\n";
 }
 else
 {
	 $i = 0;
	 WHILE ($i < $number):
	 $id = mysql_result($result,$i,"id");
	 $dato = mysql_result($result,$i,"dato");
	 $sted = mysql_result($result,$i,"sted");
	 $feil = mysql_result($result,$i,"feil");
	 $problem = mysql_result($result,$i,"problem");
	 $status = mysql_result($result,$i,"status");
	 $kommentar = mysql_result($result,$i,"kommentar");
	 $navn = mysql_result($result,$i,"navn");
	 $epost = mysql_result($result,$i,"epost");
	 $tlf = mysql_result($result,$i,"tlf");
	 $ip = mysql_result($result,$i,"ip");
	 $bilde = mysql_result($result,$i,"bilde");

	 print " <table width=\"100%\" border=\"0\" bgcolor=\"#F0F3F9\">\n";
	 print " <tr>\n";
	 print "<td width=\"100%\" valign=\"top\">";
	
	if ($status == "ubehandlet")
			print " <img src=\"img/bullet_red.png\" alt=\"Ubehandlet\" />";

	if ($status == "behandlet")
			print " <img src=\"img/bullet_green.png\" alt=\"Behandlet\" />";

	if ($status == "tilbehandling")
			print " <img src=\"img/bullet_orange.png\" alt=\"Til behandling\" />";
	
	 print "&nbsp;<span class=\"text\">$dato&nbsp;<b>$feil</b><br /></span><br /><b>Sted:</b>&nbsp;$sted<br /><br />$problem<br /><br />";
	 if ($kommentar == "")
			print "";
		else
			 print "Kommentar fra kommunen:<br /><span class=\"red\">$kommentar<br />\n";

	 print "	</td>\n";
	 print " </tr>\n";
	 print " <tr>\n";
	 print "<td width=\"100%\" valign=\"top\">";
	
	 	 if ($bilde == "")
			print "";
		else
			print "<br /><img src=\"http://www.e-kommune.com/fiksgate/upload/$bilde\" width=190 border=1 alt=\"$bilde\" /><br /><a href=\"http://www.e-kommune.com/fiksgate/upload/$bilde\" target=\"_new\">Se stort bilde</a>";

	 print "	</td>\n";
	 print " </tr>\n";
	 print " </table>\n";
	 print " <hr width=\"100%\" />\n";
	 $i++;
	 ENDWHILE;
 }
?>
<a href="visalle.php">Se alle saker</a>
<br /><br /><br />
</td>

</tr>
</table>
<?
include 'inc/footer.php';
?>
