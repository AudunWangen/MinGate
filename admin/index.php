<?php

require '../config.php';

$category = FALSE;
if (isset ($_GET['category'])) {
	$category = urldecode ($_GET['category']);
	
	if (mysql_result (mysql_query ('SELECT COUNT(1) FROM categories WHERE name = ' . quote_smart ($category)), 0) == 0) {
		$category = FALSE;
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>MinGate - Opprett ny sak</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" media="print, projection, screen" href="../style.css" />
	
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=GOOGLE_API_KEY?>" type="text/javascript"></script>
	
	<script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="http://davidsteinsland.net/assets/js/jquery.tipTip.min.js"></script>

	<script type="text/javascript">
	$(function() {
	
		$('#switchCategory').click (function () {
			var category = $('#type :selected').val();
			
			if (category != 0) {
				location.href = 'index.php?category=' + category;
			} else {
				location.href = 'index.php';
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
		
		if ($category) {
			$SQL .= ' WHERE c.name = ' . quote_smart ($category);
		}
		
		$SQL = mysql_query ($SQL);
		
		while ($Data = mysql_fetch_assoc ($SQL)): ?>
		var point = new GLatLng(<?=$Data['lat'] ?>,<?=$Data['lon']?>);
		var marker = createMarker(point, '<p>Type: <?=escape_html ($Data['categoryName']) ?><br />Adresse: <?=escape_html ($Data['address'])?></p><p><a href="index.php?case_id=<?=$Data['case_id']?>">Se sak.</a></p>');
		map.addOverlay(marker);
		<?php endwhile ?>
	});
	</script>
</head>
<body>

<div class="wrapper">

	<h1><a href="../">MinGate</a></h1>
	<h2>Administrer saker</h2>
	
	<div class="content">
		<ul class="menu">
			<li><a href="index.php">Administrasjon</a></li>
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
		
		<h3>Se alle saker</h3>
		
		<div class="left">
			<fieldset>
				<legend>Kart</legend>
				
				<div class="map" id="map"> </div>
				
				<p class="informative">
					Navigér i kartet ved å holde venstreknappen inne og bevege musen.
				</p>
			</fieldset>
		</div>
		
		<div class="right">
			<ul class="latest">
				<?php $SQL = 'SELECT p.timestamp, p.description, p.case_id, p.address, c.name as categoryName, s.type FROM problems p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN statuses s ON p.status_id = s.status_id';
				
				if ($category) {
					$SQL .= ' WHERE c.name = ' . quote_smart ($category);
				}
				
				$SQL .= ' ORDER BY timestamp DESC';
				$SQL = mysql_query($SQL);
				
				while ($Data = mysql_fetch_assoc ($SQL)): ?>
				<li class="<?=$Data['type']?><?php if(isset ($_GET['case_id']) AND $_GET['case_id'] == $Data['case_id']) echo ' highlight'?>" id="case_<?=$Data['case_id']?>"><span><?=date ('d.m.Y', $Data['timestamp']) ?> <a href="index.php?category=<?=urlencode ($Data['categoryName']) ?>"><?=escape_html ($Data['categoryName']) ?></a><br />Sted: <?=escape_html ($Data['address']) ?><br />Beskrivelse: <?= escape_html ($Data['description']) ?><br /><a href="submit.php?<?php echo $Data['case_id'] ?>">Endre</a></span></li>
				<?php endwhile ?>
			</ul>
		</div>
	</div>
</div>
</body>
</html>
