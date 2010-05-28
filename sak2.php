<?
include 'inc/header.php';
?>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="675"><BR><B>Mitt n&aelig;romr&aring;de</B></span><br><br><span class="text">Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.</span>Sakene behandles av kommunen fortl&oslash;pende.<BR>
	</TD>
</TR>
</TABLE>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="400"><BR><span class="tittel">Kart med registerte saker</span><BR>
<BR>
<?
include 'kart2.php';
?>
</TD>
<TD valign="top" width="100%">
<br>
<span class="tittel">Informasjon om innmeldt sak</span><br><br>
<?
include 'db/database.php';

	// 
	$today = date("Ymd");
   $query = "select * from fiksgrafitti where id = $id"; 

	$result = MYSQL_QUERY($query);
    $number = MYSQL_NUMROWS($result);
	MYSQL_CLOSE();

 // lag HTML
 if ($number == 0)
 {
	  print " <table width=\"100%\" border=0 bgcolor=\"#ffffff\>\n";
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

	 print " <table width=\"100%\" border=\"0\" bgcolor=\"#F0F3F9\">\n";
	 print " <tr>\n";
	 print "<td width=\"100%\" valign=top>";
	
	if ($status == "ubehandlet")
			print " <img src=\"img/bullet_red.png\" alt=\"Ubehandlet\">";

	if ($status == "behandlet")
			print " <img src=\"img/bullet_green.png\" alt=\"Behandlet\">";

	if ($status == "tilbehandling")
			print " <img src=\"img/bullet_orange.png\" alt=\"Til behandling\">";

	 
	 print "&nbsp;<span class=\"text\"><B>$feil</b><br>$dato</span><br><br>";
	 print "<span class=\"text\">$problem<br><br>Meldt inn av $navn<br><br>\n";
	 print "Kommentar fra kommunen:<br><span class=\"red\">$kommentar<br>\n";
	 print "	</td>\n";
	 print " </tr>\n";
	 print " </table>\n";
	 print " <hr width=\"100%\">\n";
	 $i++;
	 ENDWHILE;
 }
?>
<A HREF="visalle.php" alt="Se alle saker">Se alle saker</A>
<BR><BR><BR>
</TD>
</TR>
</TABLE>
<?
include 'inc/footer.php';
?>








