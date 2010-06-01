
<?
require "inc/config.php";           // 

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


$query2=" SELECT * FROM fiksgrafitti  ";
$result2=mysql_query($query2);
echo mysql_error();
$nume=mysql_num_rows($result2);

echo "<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";

$query=" SELECT * FROM fiksgrafitti order by id desc limit $eu, $limit ";
$result=mysql_query($query);
echo mysql_error();


while($noticia = mysql_fetch_array($result))
{
if($bgcolor=='#F0F3F9'){$bgcolor='#ffffff';}
else{$bgcolor='#F0F3F9';}

echo "<tr>";
echo "<td align=\"left\" bgcolor=\"$bgcolor\" class=\"title\">";

if ($noticia[status] == "ubehandlet")
			print " <img src=\"img/bullet_red.png\" alt=\"Ubehandlet\" />";

	if ($noticia[status] == "behandlet")
			print " <img src=\"img/bullet_green.png\" alt=\"Behandlet\" />";

	if ($noticia[status] == "tilbehandling")
			print " <img src=\"img/bullet_orange.png\" alt=\"Til behandling\" />";

echo "<font face=\"Verdana\" size=\"2\">$noticia[dato]&nbsp;&nbsp; $noticia[feil]<br />Adresse: $noticia[sted]</font><br /><a href=\"sak.php?id=$noticia[id]\">Les mer</a><br /><br /></td>"; 
echo "</tr>";
}
echo "</table>";

if($nume > $limit ){ 

echo "<table align =\"center\" width=\"100%\"><tr><td  align=\"left\" width=\"30%\">";

if($back >=0) { 
print "<a href=\"$page_name?start=$back\"><font face=\"Verdana\" size=\"2\">Forrige side</font></a>"; 
} 

echo "</td><td align=\"center\" width=\"30%\">";
$i=0;
$l=1;
for($i=0;$i < $nume;$i=$i+$limit){
if($i <> $eu){
echo " <a href=\"$page_name?start=$i\"><font face=\"Verdana\" size=\"2\">$l</font></a> ";
}
else { echo "<font face=\"Verdana\" size=\"2\" color=\"#1b6289\"><b>$l</b></font>";}        /// 
$l=$l+1;
}


echo "</td><td  align=\"right\" width=\"30%\">";

if($this1 < $nume) { 
print "<a href='$page_name?start=$next'><font face=\"Verdana\" size=\"2\">Neste side</font></a>";} 
echo "</td></tr></table>";

}
?>
<center><span class="small8">Arkiv kodet av <a href="http://www.plus2net.com" target="_new"><span class="small8">plus2net.com</span></a></span></center>
