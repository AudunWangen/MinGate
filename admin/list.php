<?php
//require '../config.php';  

$page_name="index.php"; 
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

echo "<TABLE width=450 align=center cellpadding=0 cellspacing=0> <tr>";

$query=" SELECT * FROM fiksgrafitti order by id desc limit $eu, $limit ";
$result=mysql_query($query);
echo mysql_error();

$bgcolor="#ffffff";
while($noticia = mysql_fetch_array($result))
{
if($bgcolor=='#F0F3F9'){$bgcolor='#ffffff';}
else{$bgcolor='#F0F3F9';}

echo "<tr >";
echo "<td align=left bgcolor=$bgcolor id='title'>";

if ($noticia[status] == "ubehandlet")
			print " <img src=\"../img/bullet_red.png\" alt=\"Ubehandlet\">";

	if ($noticia[status] == "behandlet")
			print " <img src=\"../img/bullet_green.png\" alt=\"Behandlet\">";

	if ($noticia[status] == "tilbehandling")
			print " <img src=\"../img/bullet_orange.png\" alt=\"Til behandling\">";

echo "<B><font face='Verdana' size='2'>Dato: $noticia[dato]&nbsp;&nbsp;&nbsp;&nbsp;Saken gjelder: $noticia[feil]</B><br>Adresse: $noticia[sted] Status: $noticia[status]</font><br><font face='Verdana' size='1'>Problem: $noticia[problem]<br><br><font face='Verdana' color=red size='1'>Kommentar: $noticia[kommentar]<br><a href=endre_status.php?id=$noticia[id]>Endre denne saken</a><br></td>"; 
echo "</tr>";
}
echo "</table>";

if($nume > $limit ){ 

echo "<table align = 'center' width='450'><tr><td  align='left' width='30%'>";

if($back >=0) { 
print "<a href='$page_name?start=$back'><font face='Verdana' size='2'>Forrige side</font></a>"; 
} 

echo "</td><td align=center width='30%'>";
$i=0;
$l=1;
for($i=0;$i < $nume;$i=$i+$limit){
if($i <> $eu){
echo " <a href='$page_name?start=$i'><font face='Verdana' size='2'>$l</font></a> ";
}
else { echo "<font face='Verdana' size='2' color=red><B>$l</B></font>";}        
$l=$l+1;
}

echo "</td><td  align='right' width='30%'>";

if($this1 < $nume) { 
print "<a href='$page_name?start=$next'><font face='Verdana' size='2'>Neste side</font></a>";} 
echo "</td></tr></table>";

}
?>

</body>

</html>
