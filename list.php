
<?
//require "config.php";           // 

$page_name="visalle.php"; //  
$start=$_GET['start'];
if(strlen($start) > 0 and !is_numeric($start)){
echo "Data Error";
exit;
}

$eu = ($start - 0); 
$limit = 5;
$this1 = $eu + $limit; 
$back = $eu - $limit; 
$next = $eu + $limit; 

mysql_connect($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname");
@mysql_select_db("$dbName") or die("Kan ikke velge database");
$query2=" SELECT * FROM fiksgrafitti  ";
$result2=mysql_query($query2);
echo mysql_error();
$nume=mysql_num_rows($result2);

echo "<ol class=\"caselist\">";

$query=" SELECT * FROM fiksgrafitti order by id desc limit $eu, $limit ";
$result=mysql_query($query);
echo mysql_error();

$bgcolor="even";
while($noticia = mysql_fetch_array($result))
{
if($bgcolor=='odd'){$bgcolor='even';}
else{$bgcolor='odd';}

echo "<li class=\"$bgcolor";

if ($noticia[status] == "ubehandlet") {
			print " red\">";
	} elseif ($noticia[status] == "behandlet") {
			print " green\">";
	} elseif ($noticia[status] == "tilbehandling") {
			print " yellow\">";
	} else {
			print "\">";
	}

echo "$noticia[dato] <a href=\"sak.php?id=$noticia[id]\"> $noticia[feil]</a><br />Adresse: $noticia[sted]"; 
echo "</li>";
}
echo "</ol>";

if($nume > $limit ){ 

if($back >=0) { 
print "<a href=\"$page_name?start=$back\">Forrige side</a>"; 
} 

$i=0;
$l=1;
for($i=0;$i < $nume;$i=$i+$limit){
if($i <> $eu){
echo " <a href=\"$page_name?start=$i\">$l</a> ";
}
else { echo "<b>$l</b>";}        /// 
$l=$l+1;
}


if($this1 < $nume) { 
print "<a href='$page_name?start=$next'>Neste side</a>";} 

}
?>
<p>Arkiv kodet av <a href="http://www.plus2net.com" target="_new">plus2net.com</a></p>
