<?php
header ('Content-type:text/html;charset=utf-8');

// Database
define ('DB_HOST', 'localhost');
define ('DB_USER', '');
define ('DB_PW', '');
define ('DB_NAME', 'mingate');

// Application
define ('MUNICIPAL_ID', 402); // See database table postal_municipal (PS! No leading 0)
define ('GOOGLE_API_KEY', '');
define ('CENTER_LON', '60.18936');
define ('CENTER_LAT', '11.997306');
define ('MAP_ZOOM', '12');
define ('CONTACTPAGE', 'https://github.com/AudunWangen/MinGate');

mysql_connect (DB_HOST, DB_USER, DB_PW);
mysql_select_db (DB_NAME);

mysql_query ('SET NAMES `utf8`');


if (!function_exists ('quote_smart')) {
	function quote_smart($value){
		// Stripslashes
		if (get_magic_quotes_gpc() && !is_null($value) ) {
				$value = stripslashes($value);
		}

		//Change decimal values from , to . if applicable
		if( is_numeric($value) && strpos($value,',') !== false ){
				$value = str_replace(',','.',$value);
		}
		if( is_null($value) ){
				$value = 'NULL';
		}
		// Quote if not integer or null
		elseif (!is_numeric($value)) {
				$value = "'" . mysql_real_escape_string($value) . "'";
		}

		return $value;
	}
}

if (!function_exists ('escape_html')) {
	function escape_html ($string)
	{
		return htmlspecialchars (stripslashes ($string));
	}
}
?>
