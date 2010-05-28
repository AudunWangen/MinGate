
<?php
include 'db/database.php';

			$query = "SELECT COUNT(*) FROM fiksgrafitti ";
                $result = mysql_query($query) or die(mysql_error());

				$row = mysql_fetch_array($result);
				
				echo "<b>Totalt ". $row[0] ." saker er meldt inn</b><br>";

                $query = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'ubehandlet'";
                $result = mysql_query($query) or die(mysql_error());

				$row = mysql_fetch_array($result);
				echo "<img src=\"img/bullet_red.png\" alt=\"Ikke behandlet\">". $row[0] ." saker er ikke behandlet<br>";

				$query3 = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'tilbehandling'";
                $result = mysql_query($query3) or die(mysql_error());
                // Res
                $row = mysql_fetch_array($result);
				echo "<img src=\"img/bullet_orange.png\" alt=\"Til behandling\">". $row[0] ." saker er til behandling<br>";

				$query2 = "SELECT COUNT(*) FROM fiksgrafitti WHERE status = 'behandlet'";
                $result = mysql_query($query2) or die(mysql_error());
                // Res
                $row = mysql_fetch_array($result);
                echo "<img src=\"img/bullet_green.png\" alt=\"Behandlet\">". $row[0] ." saker er ferdig behandlet";

?>