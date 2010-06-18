<?php
header ('Content-type:text/html;charset=utf-8');

// Database
define ('DB_HOST', 'localhost');
define ('DB_USER', 'fiksgate');
define ('DB_PW', 'fiksgate');
define ('DB_NAME', 'fiksgate');

// Application
define ('MUNICIPAL_ID', 0402); // See database table postal_municipal
define ('GOOGLE_API_KEY', 'ABQIAAAAziwQ4P9Qto7VoNQ5zMyz9xS1NvSkQuZCcMfLok91DzR4dG0fUxT-liTrUWv3nUJJ4ZSasDiikRW3Gw');


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
