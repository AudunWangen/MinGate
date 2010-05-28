<?

$hostname = "localhost";
$username = "fiksgate";
$password = "fiksgate";
$dbName = "fiksgate";
$tbname  = "fiksgrafitti";

// Connect to database
MYSQL_CONNECT($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname"); 
@mysql_select_db("$dbName") or die("Kan ikke velge database"); 
?>
