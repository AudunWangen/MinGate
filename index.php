<?php

require 'config.php';

if (isset ($_GET['lat']) AND isset ($_GET['lon'])) {
	
	$lat = mysql_real_escape_string($_GET['lat']);
	$lon = mysql_real_escape_string($_GET['lon']);
	
	$SQL = 'SELECT m.id as kommune_id, z.zip, p.name, z.lat, z.lon, acos(SIN( RADIANS(' . $lat . ')) * SIN( RADIANS(z.lat))
+(cos(RADIANS(' . $lat . ')) * COS( RADIANS(z.lat)) * COS(RADIANS(z.lon) - RADIANS(' . $lon . '))
)) * 6378137 AS distance
FROM postal_zip_codes z
INNER JOIN postal_zip_places p
ON z.place_id = p.place_id
LEFT JOIN postal_municipal m 
ON p.municipal_id = m.id 
ORDER BY distance ASC
LIMIT 1';
	
	$Data = mysql_fetch_assoc (mysql_query ($SQL));

	echo json_encode ($Data);
	die;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>MinGate - Rydd opp i nærmiljøet</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" media="print, projection, screen" href="style.css" />
	
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=GOOGLE_API_KEY?>" type="text/javascript"></script>
	
	<script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="http://davidsteinsland.net/assets/js/jquery.tipTip.min.js"></script>

	<script type="text/javascript">
	$(function() {
		//$('ul.nav a[title]').tipTip();
		
		$('#switchCategory').click (function () {
			var category = $('#type :selected').val();
			
			if (category != 0) {
				location.href = 'view.php?category=' + category;
			} else {
				location.href = 'view.php';
			}
		});
		
		var map = new GMap2(document.getElementById("map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new GScaleControl());
		map.setCenter(new GLatLng(59.747517, 5.261328), 11, G_NORMAL_MAP);

		function createMarker(point, number) {
			var marker = new GMarker(point);
			var html = number;
			GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
			return marker;
		};

		<?php
		$SQL = 'SELECT c.name as categoryName, p.lat, p.lon, p.case_id, p.address FROM problems p INNER JOIN categories c ON p.category_id = c.category_id';
		$SQL = mysql_query ($SQL);
		
		while ($Data = mysql_fetch_assoc ($SQL)): ?>
		var point = new GLatLng(<?=$Data['lat'] ?>,<?=$Data['lon']?>);
		var marker = createMarker(point, '<p>Type: <?=escape_html ($Data['categoryName']) ?><br />Adresse: <?=escape_html ($Data['address'])?></p><p><a href="view.php?case_id=<?=$Data['case_id']?>">Se sak.</a></p>');
		map.addOverlay(marker);
		<?php endwhile ?>
	});
	</script>
</head>
<body>

<div class="wrapper">

	<h1><a href="./">MinGate</a></h1>
	<h2>Rydd opp i nærmiljøet!</h2>
	
	<div class="content">
		<ul class="menu">
			<li><a href="index.php">Min gate</a></li>
			<li><a href="submit.php">Registrer sak</a></li>
			<li><a href="view.php">Alle saker</a></li>
			<li><a href="info.php">Kontakt oss</a></li>
			<li class="search">
				<select name="categories" id="type">
					<option value="0">Velg</option>
					<?php
					$SQL = mysql_query ('SELECT * FROM categories ORDER BY name ASC');
					
					while ($Data = mysql_fetch_assoc ($SQL)): ?>
					<option value="<?=urlencode ($Data['name'])?>"><?=$Data['name']?></option>
					<?php endwhile ?>
				</select>
				<button type="submit" id="switchCategory">Vis fra kategori</button>
			</li>
		</ul>
		
		<h3>Mitt nærområde</h3>

		<p>
			Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m. <br />
			Sakene behandles fortløpende av kommunen.
		</p>
		
		<h3>Hvordan melde inn en ny sak?</h3>
		
		<p>
			Du kan melde inn et problem ved å benytte vårt <a href="submit.php">elektroniske skjema</a>.
		</p>
		
		<h3>Kart over registrerte saker</h3>
		
		<div class="left large">
			<div class="map" id="map"> </div>
		</div>
		
		<div class="right latest small">
			<h3>Siste 10 registrerte saker</h3>
				
			<ul>
				<?php $SQL = mysql_query ('SELECT p.timestamp, p.case_id, p.address, c.name as categoryName, s.type FROM problems p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN statuses s ON p.status_id = s.status_id ORDER BY timestamp DESC LIMIT 10');
				while ($Data = mysql_fetch_assoc ($SQL)): ?>
				<li class="<?=$Data['type']?>"><span><?=date ('d.m.Y', $Data['timestamp']) ?> <a href="view.php?category=<?=urlencode ($Data['categoryName']) ?>"><?=escape_html ($Data['categoryName']) ?></a><br />Sted: <?=escape_html ($Data['address']) ?></span></li>
				<?php endwhile ?>
			</ul>
			
			<h4><a href="view.php">Se alle</a></h4>
			
			<h4>Forklaring</h4>
			
			<ul>
				<li class="pending"><span>Venter på behandling</span></li>
				<li class="open"><span>Under behandling</span></li>
				<li class="closed"><span>Saken er løst/avsluttet</span></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>
