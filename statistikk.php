
<?php
//include 'config.php';

		mysql_connect($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname");
		@mysql_select_db("$dbName") or die("Kan ikke velge database");
			$query = "SELECT COUNT(*) FROM fiksgrafitti ";
                $result = mysql_query($query) or die(mysql_error());

				$row = mysql_fetch_array($result);
				
				echo "<h2>Totalt ". $row[0] ." saker er meldt inn</h2>";

                $query = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'ubehandlet'";
                $result = mysql_query($query) or die(mysql_error());

				$row = mysql_fetch_array($result);
				echo "<ul>";
				echo "<li class=\"red\">". $row[0] ." saker er ikke behandlet</li>";

				$query3 = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'tilbehandling'";
                $result = mysql_query($query3) or die(mysql_error());
                // Res
                $row = mysql_fetch_array($result);
				echo "<li class=\"yellow\">". $row[0] ." saker er til behandling</li>";

				$query2 = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'behandlet'";
                $result = mysql_query($query2) or die(mysql_error());
                // Res
                $row = mysql_fetch_array($result);
                echo "<li class=\"green\">". $row[0] ." saker er ferdig behandlet</li></ul>";

?>
