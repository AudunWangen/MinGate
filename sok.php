<?
include 'inc/header.php';
?>
<br><br>
<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="400" valign="top">
<br><span class="tittel">Kart med alle registerte saker</span><BR><BR>
<?
include 'kart_sok.php';
?>
</TD>

<TD valign="top" width="485"><BR>
	<span class="tittel">Treff i søk</span><BR><BR>
<?

include 'db/database.php';
	
	$today = date("Ymd");
    $query = "select * from $tbname where dato LIKE '%$streng%' or sted LIKE '%$streng%' or feil LIKE '%$streng%' or problem LIKE '%$streng%' or navn LIKE '%$streng%'";
	$result = MYSQL_QUERY($query);
	$number = MYSQL_NUMROWS($result);
	MYSQL_CLOSE();
?>
<?
 // Lag HTML
 if ($number == 0)
 {
	
 	print "<table width=\"\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";
	print " <tr>\n";
	print "	<td class=\"normal\">\n";
	print "<span class=\"overskrift2\">Søket gav desverre ingen treff<br>Prøv med et annet søkeord.</span><br><br>\n";
	print "<form action=\"sok.php\" method=\"post\" name=\"søk\">\n";
	print "<input type=\"text\" name=\"streng\" size=\"20\"><br>\n";
	print "<input type=\"submit\" value=\"Søk\">\n";
	print "</form>\n";
	print "	</td>\n";
	print " </tr>\n";
	print "</table>\n";
  
 }
 else
 {
	$i = 0;
	WHILE ($i < $number):
	$id = mysql_result($result,$i,"id");
	$dato = mysql_result($result,$i,"dato");
	$sted = mysql_result($result,$i,"sted");
	 $status = mysql_result($result,$i,"status");
	$feil = mysql_result($result,$i,"feil");
	$problem = mysql_result($result,$i,"problem");
	$navn = mysql_result($result,$i,"navn");

	print "<table width=\"\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";
	print " <tr>\n";
	print "	<td class=\"normal\">\n";
	
	print " Registert: $dato\n";
	if ($status == "ubehandlet")
			print " <img src=\"img/bullet_red.png\" alt=\"Ubehandlet\">";

	if ($status == "behandlet")
			print " <img src=\"img/bullet_green.png\" alt=\"Behandlet\">";

	if ($status == "tilbehandling")
			print " <img src=\"img/bullet_orange.png\" alt=\"Til behandling\">";
	print "<br>\n";
	print "	<SPAN class=tittel>$sted</span><br>$feil<BR><a href=\"sak.php?id=$id\" alt=\"Vis sak\">Les mer</SPAN></a>";
	print "	</td>\n";
	print " </tr>\n";
	print "</table>\n";
	print "<hr width=\"100%\">\n";

	$i++;
	ENDWHILE;
 }
?>
<br>
</TD>
</TR>
</TABLE>
<?
include 'inc/footer.php';
?>