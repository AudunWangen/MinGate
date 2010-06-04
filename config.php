<?php

$servername = "localhost";
$dbusername = "fiksgate";
$dbpassword = "fiksgate";
$dbname = "fiksgate";
$tbname = "fiksgrafitti";
$googleapikey = "ABQIAAAAziwQ4P9Qto7VoNQ5zMyz9xS1NvSkQuZCcMfLok91DzR4dG0fUxT-liTrUWv3nUJJ4ZSasDiikRW3Gw";

define("DB_HOST","localhost");
define("DB_USER","fiksgate");
define("DB_PASS","fiksgate");
define("DB_NAME","fiksgate");
define("DB_TABLE","fiksgrafitti");
define("GOOGLEAPIKEY","ABQIAAAAziwQ4P9Qto7VoNQ5zMyz9xS1NvSkQuZCcMfLok91DzR4dG0fUxT-liTrUWv3nUJJ4ZSasDiikRW3Gw");
define("GOOGLE_CENTERPOINT_LON","11.995869");
define("GOOGLE_CENTERPOINT_LAT","60.192583");
define("GOOGLE_ZOOM_LEVEL","11");

define("COMPANY_NAME","Kommunens navn");
define("COMPANY_URI","http://www.min.kommune.no/");
define("COMPANY_SLA_URI","http://www.min.kommune.no/tjenestenivaa/");
define("COMPANY_PHONE","55555555");
define("COMPANY_SMS_CODE","kommune");
define("COMPANY_SMS_PHONE","1804");
define("COMPANY_CHAT_URI","http://www.min.kommune.no/chat");
define("COMPANY_EMAIL","postmottak@min.kommune.no");
define("COMPANY_PROBLEM_EMAIL","drift@min.kommune.no");
define("COMPANY_MAIL_ADDRESS","Postmottak, 1234 Minkommune");
define("COMPANY_VISIT_ADDRESS","Mingate 1, 1234 Minkommune");
define("COMPANY_RESPONSIBLE_PERSON","Ola Nordmann");

connecttodb($servername,$dbname,$dbusername,$dbpassword);
function connecttodb($servername,$dbname,$dbuser,$dbpassword)
{
global $link;
$link=mysql_connect ("$servername","$dbuser","$dbpassword");
if(!$link){die("Could not connect to MySQL");}
mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}


?>
