<?php include("/home/ekommune/www/fiksgate/admin/login.php"); ?>
<?
include 'inc/header.php';
?>
<?

	$hostname = "xxxx";
	$username = "xxxx";
	$password = "xxxx";
	$dbName = "xxxx";
	$tbname     = "fiksgrafitti";


	// Connect to database
	MYSQL_CONNECT($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname"); 
	@mysql_select_db("$dbName") or die("Kan ikke velge database"); 
	
	$today = date("Ymd");
    $query = "delete from $tbname where id = $id";
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
?>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<br><br><br>
<span class="tittel">Saken er slettet</span><br><br>
<A HREF="index.php">Tilbake til oversikten</A>
 </TD>
</TR>
</TABLE>
<br><br><br><br><br><br><br>
<?
include 'inc/footer.php';
?>