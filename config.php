<?php

$servername = "localhost";
$dbusername = "fiksgate";
$dbpassword = "fiksgate";
$dbname = "fiksgate";
$tbname = "fiksgrafitti";
$googleapikey = "ABQIAAAAziwQ4P9Qto7VoNQ5zMyz9xS1NvSkQuZCcMfLok91DzR4dG0fUxT-liTrUWv3nUJJ4ZSasDiikRW3Gw";

connecttodb($servername,$dbname,$dbusername,$dbpassword);
function connecttodb($servername,$dbname,$dbuser,$dbpassword)
{
global $link;
$link=mysql_connect ("$servername","$dbuser","$dbpassword");
if(!$link){die("Could not connect to MySQL");}
mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}


?>
