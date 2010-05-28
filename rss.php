<? header('Content-type: text/xml'); ?>

<rss version="2.0">
<channel>
<title>Fiks min gate - Porsgrunn kommune</title>
<description>Info</description>
<link>http://www.porsgrunn.kommune.no/</link>
<copyright>PK</copyright>

<?

$hostname = "xxxx";
$username = "xxxx";
$password = "xxxx";
$dbName = "xxxx";
$tbname  = "fiksgrafitti";

// Connect to database
MYSQL_CONNECT($hostname, $username, $password) OR DIE("Får ikke kontakt med $dbname"); 
@mysql_select_db("$dbName") or die("Kan ikke velge database"); 

$q="SELECT id,dato,sted,feil,problem FROM fiksgrafitti ORDER BY id DESC LIMIT 0,15";

$doGet=mysql_query($q);

while($result = mysql_fetch_array($doGet)){
?>
     <item>
        <title> <?=htmlentities(strip_tags($result['sted'])); ?></title>
		<description> <?=htmlentities(strip_tags($result['sted'])); ?></description>
         <link>http://www.e-kommune.com/fiksgate/sak.php?id=p?=$result['id'];?></link>
		 <pubDate> <?=htmlentities(strip_tags($result['dato'])); ?></pubDate>
        
     </item>  
<? } ?>  

</channel>
</rss>
