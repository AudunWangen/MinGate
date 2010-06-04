<?

//include 'db/database.php';


	MYSQL_CONNECT($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname"); 
	@mysql_select_db("$dbName") or die("Kan ikke velge database"); 

	// Build and execute SQL query
	$today = date("Ymd");
    $query = "select * from fiksgrafitti where id LIKE '%$streng%' ORDER BY id  DESC LIMIT 0,5";
	$result = MYSQL_QUERY($query);
    $number = MYSQL_NUMROWS($result);
	MYSQL_CLOSE();

 // HTML ut
 if ($number == 0)
 {
	  print " <table width=\"100%\" border=0 bgcolor=\"#ffffff\>\n";
	print "<tr>\n";
	print "<td class=\"tittel\" bgcolor=\"#ffffff\>Det er ikke registrert noen saker</td>\n";
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
	 print "<td valign=\"top\" width=\"20\" align=\"left\">";
	
	if ($status == "ubehandlet")
			print " <img src=\"img/bullet_red.png\" alt=\"Ubehandlet\" />";

	if ($status == "behandlet")
			print " <img src=\"img/bullet_green.png\" alt=\"Behandlet\" />";

	if ($status == "tilbehandling")
			print " <img src=\"img/bullet_orange.png\" alt=\"Til behandling\" />";

	 print "	</td>\n";
	 print "<td valign=\"top\" align=\"left\">";
	 print "<span class=\"text\">$dato&nbsp;<a href=\"sak.php?id=$id\">$feil</a><br />Sted:&nbsp;$sted</span>";
	 print "	</td>\n";
	 print " </tr>\n";
	 print " </table>\n";
	 print " <hr width=\"100%\" />\n";
	 $i++;
	 ENDWHILE;
 }
?>
