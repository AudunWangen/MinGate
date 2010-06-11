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
	print "<p>Det er ikke registrert noen saker</p>\n";
 }
 else
 {
	  print "<ol class=\"caselist\">\n";
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

	 print "<li";
	
	if ($status == "ubehandlet") {
			print " class=\"red\">\n";
	} elseif ($status == "behandlet") {
			print " class=\"orange\">\n";
	} elseif ($status == "tilbehandling") {
			print " class=\"green\">\n";
	} else {
			print ">\n";
	}
	 print "$dato <a href=\"sak.php?id=$id\">$feil</a><br />Sted: $sted";
	 print "</li>\n";
	 $i++;
	 ENDWHILE;
	 print "</ol>\n";
 }
?>
