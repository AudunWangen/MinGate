<?php
session_start();
if(!session_is_registered('myusername')){
header("location:main_login.php");
}

require '../config.php';

$category = FALSE;
if (isset ($_GET['category'])) {
	$category = urldecode ($_GET['category']);
	
	if (mysql_result (mysql_query ('SELECT COUNT(1) FROM categories WHERE name = ' . quote_smart ($category)), 0) == 0) {
		$category = FALSE;
	}
}

?><!DOCTYPE html>
<html>
	<head>
		<title>Fiks nabolaget mitt - Rydd opp i nærmiljøet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" media="print, projection, screen" href="../style.css" />
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_API_KEY?>&amp;sensor=false"></script>
		<script type="text/javascript" charset="utf-8" src="../js/jquery.tipTip.min.js"></script>
		
		<script type="text/javascript">
			<?php
				if (isset ($_GET['case_id'])) {
					$SQL = 'SELECT c.name as categoryName, p.lat, p.lon, p.case_id, p.address, p.description, p.reply, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id AND p.case_id = ' . $_GET['case_id'];
				} else if ($_GET['category'] == 'alle') {
					$SQL = 'SELECT c.name as categoryName, p.lat, p.lon, p.case_id, p.address, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id ORDER BY timestamp DESC';					
				} else if (isset ($_GET['category'])) {
					$SQL = 'SELECT c.category_id, c.name as categoryName, p.lat, p.lon, p.case_id, p.address, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id AND p.category_id = ' . $_GET['category'];
				} else {
					$SQL = 'SELECT c.name as categoryName, p.lat, p.lon, p.case_id, p.address, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id ORDER BY timestamp DESC LIMIT 20';
				}
				$SQL = mysql_query ($SQL);
			?>
			var center = new google.maps.LatLng(<?=CENTER_LON?>, <?=CENTER_LAT?>);
			var problems = [
							<?php while ($Data = mysql_fetch_assoc ($SQL)): ?>
								[ <?=$Data['lat'] ?>,<?=$Data['lon']?>,'<?=$Data['case_id'] ?>','../img/<?=$Data['type'] ?>.png','<?=$Data['address'] ?>' ],
							<?php endwhile ?>
						];
			
			var iterator = 0;
			
			function initialize() {
				var mapOptions = {
						zoom: <?=MAP_ZOOM?>,
						center: center,
						mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				
				var map = new google.maps.Map(document.getElementById('map'),
						mapOptions);

				var infowindow = new google.maps.InfoWindow();

				var marker, i;
				
				for (i = 0; i < problems.length; i++) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(problems[i][0], problems[i][1]),
						map: map, 
						draggable: false,
						icon: problems[i][3]
					});

					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow.setContent('<a href=?case_id=' + problems[i][2] + '>' + problems[i][4] + '</a>');
							infowindow.open(map, marker);
						}
					})(marker, i));
				}
			}

			function addMarkers() {
				var marker = new google.maps.Marker({
					position: problems[iterator][0],
					map: map,
					draggable: false,
					icon: green
				});
				var infowindow = new google.maps.InfoWindow({
					content : "holding..."
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.setContent(this.html);
					infowindow.open(map, this);
				});
				markers.push(marker);
				iterator++;
			}

			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</head>
	<body>
    <div class="wrapper">
      <h1><a href="../">Fiks nabolaget mitt</a></h1>
	    <h2>Administrer saker</h2>
	
			<div class="content">
				<ul class="menu">
					<li><a href="index.php">Fiks nabolaget mitt</a></li>
					<li><a href="../submit.php">Registrer sak</a></li>
					<li><a href="index.php?category=alle">Alle saker</a></li>
					<li><a href="http://www.kongsvinger.kommune.no/no/Artikler/Kontakt-oss/">Kontakt oss</a></li>
					<li class="search">
						<form>
						<select name="categories" id="type">
							<option value="0">Velg</option>
							<?php
								$SQL = mysql_query ('SELECT * FROM categories ORDER BY name ASC');
								while ($Data = mysql_fetch_assoc ($SQL)): ?>
									<option value="?category=<?=$Data['category_id']?>"><?=$Data['name']?></option>
							<?php endwhile ?>
						</select>
            <button type="submit" id="switchCategory" onClick="top.location.href = this.form.categories.options[this.form.categories.selectedIndex].value; return false;">Vis fra kategori</button>
						</form>
					</li>
				</ul>
		<h3>Se alle saker</h3>
		<div id="map"></div>
		<div class="right latest small">
					<?php
					if (isset ($_GET['case_id'])) {
						$SQL = 'SELECT c.category_id, c.name as categoryName, p.lat, p.lon, p.case_id, p.address, p.description, p.reply, p.timestamp, p.picture, s.type, s.name as statusName FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id AND p.case_id = ' . $_GET['case_id'];
                                                $SQL = mysql_query ($SQL);
                                                while ($Data = mysql_fetch_assoc ($SQL)): ?>
							<h3><?=escape_html ($Data['address'])?></h3>
                                                        <ul>
								<li><strong>Status:</strong> <?=escape_html ($Data['statusName']) ?></li>
								<li><strong>Registrert:</strong> <?=date ('d.m.Y', $Data['timestamp']) ?></li>
								<li><strong>Kategori:</strong> <a href="?category=<?=$Data['category_id'] ?>"><?=escape_html ($Data['categoryName']) ?></a></li>
								<li><strong>Beskrivelse:</strong> <?=escape_html ($Data['description']) ?><br /><img src="../uploads/thumbs/<?=$Data['picture']?>.jpg" alt="<?=$Data['address']?>" /></li>
								<li><strong>Svar:</strong> <?=escape_html ($Data['reply']) ?>
                <br /><a href="submit.php?case_id=<?=$Data['case_id']?>">Endre</a></li>
							</ul>
                                                <?php endwhile ?>

					<?
					} else if ($_GET['category'] == 'alle') {
						?><h3>Alle saker</h3><?
																	$SQL = 'SELECT c.category_id, c.name as categoryName, p.case_id, p.address, p.description, p.timestamp, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id';
																	$SQL = mysql_query ($SQL);
											            ?><ul><?
																	while ($Data = mysql_fetch_assoc ($SQL)): ?>
																		<li class="<?=$Data['type']?>"><span><?=date ('d.m.Y', $Data['timestamp']) ?> <a href="?case_id=<?=escape_html ($Data['case_id']) ?>"><?=escape_html ($Data['address']) ?></a><br /><strong>Beskrivelse:</strong> <?=escape_html ($Data['description']) ?><br /><a href="submit.php?case_id=<?=$Data['case_id']?>">Endre</a></span></li>
																	<?php endwhile ?>
														</ul><?
					} else if (isset ($_GET['category'])) {
						?><h3>Saker i kategorien  <?
            $SQL = "SELECT c.name as categoryName from categories c where c.category_id = " . $_GET['category'];
            $SQL = mysql_query ($SQL);
            $Data = mysql_fetch_row ($SQL);
            echo $Data[0];
            ?></h3><?
						$SQL = 'SELECT c.category_id, c.name as categoryName, p.case_id, p.address, p.description, p.timestamp, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id AND p.category_id = ' . $_GET['category'];
						$SQL = mysql_query ($SQL);
            ?><ul><?
						while ($Data = mysql_fetch_assoc ($SQL)): ?>
							<li class="<?=$Data['type']?>"><span><?=date ('d.m.Y', $Data['timestamp']) ?> <a href="?case_id=<?=escape_html ($Data['case_id']) ?>"><?=escape_html ($Data['address']) ?></a><br /><strong>Beskrivelse:</strong> <?=escape_html ($Data['description']) ?><br /><a href="submit.php?case_id=<?=$Data['case_id']?>">Endre</a></span></li>
						<?php endwhile ?>
						</ul><?
					} else {
					?>

				
					<h3>Siste 20 registrerte saker</h3>
					<ul>
						<?php $SQL = mysql_query ('SELECT c.category_id, p.timestamp, p.case_id, p.address, c.name as categoryName, s.type FROM problems p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN statuses s ON p.status_id = s.status_id ORDER BY timestamp DESC LIMIT 20');
						while ($Data = mysql_fetch_assoc ($SQL)): ?>
							<li class="<?=$Data['type']?>"><span><?=date ('d.m.Y', $Data['timestamp']) ?> <a href="?category=<?=$Data['category_id'] ?>"><?=escape_html ($Data['categoryName']) ?></a><br />Sted: <a href="?case_id=<?=$Data['case_id'] ?>"><?=escape_html ($Data['address']) ?></a><br /><a href="submit.php?case_id=<?=$Data['case_id']?>">Endre</a></span></li>
						<?php endwhile ?>
					</ul>
					<?
					}
					?>
					<h4><a href=".">Se alle</a></h4>
				</div>
			</div>
		</div>
	</body>
</html>

