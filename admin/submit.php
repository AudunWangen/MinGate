<?php
require '../config.php';

if (isset ($_POST['submit'])) {
	$Empty = $Invalid = $Errors = array ();
	
	if (empty ($_POST['address'])) {
		$Empty[] = 'address';
	}
	
	if (empty ($_POST['lon'])) {
		$Empty[] = 'lon';
	}
	
	if (empty ($_POST['lat'])) {
		$Empty[] = 'lat';
	} 
	
	if (isset ($_POST['categories']) AND $_POST['categories'] == 0) {
		$Empty[] = 'categories';
	}
	
	if (empty ($_POST['name'])) {
		$Empty[] = 'name';
	} 
	
	if (empty ($_POST['email'])) {
		$Empty[] = 'email';
	} 
	
	if (empty ($_POST['description'])) {
		$Empty[] = 'description';
	}

	if (empty ($_POST['reply'])) {
		$Empty[] = 'reply';
	}
	
	if (long2ip (ip2long ($_SERVER['REMOTE_ADDR'])) != $_SERVER['REMOTE_ADDR']) {
		echo 'Your IP address is not valid. ';
		die;
	}
	
	if (!empty ($_FILES['picture']['tmp_name'])) {
		require 'inc/Avatar.php';
		
		$Picture = new Avatar  ();
		
		$picture_name = md5 (time() . rand (0, 999));
		
		if (!$Picture->move ($_FILES['picture']['tmp_name'], $picture_name) ) { 
			$Invalid['picture'] = 'Something went wrong. Allowed images are JPG, GIF, PNG and max file size is 6 MB. Also note that there is a max width and height on 5000 pixels.';
			$picture_name = NULL;
		}
	} else {
		$picture_name = NULL;
	}
	
	if (sizeof ($Empty) == 0) {
		
		if (!is_numeric ($_POST['lon'])) {
			$Invalid['lon'] = 'Failed to match a correct longitude pattern';
		}
		
		if (!is_numeric ($_POST['lat'])) {
			$Invalid['lat'] = 'Failed to match a correct latitude pattern';
		}
		
		if (!filter_var ($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$Invalid['email'] = 'Invalid E-mail address';
		}
		
		if (strlen ($_POST['name']) < 5) {
			$Invalid['name'] = 'Please supply a real name';
		}
	}
	
	$Errors = array_merge ($Empty, $Invalid);
	
	if (sizeof ($Errors) == 0) {
		$SQL = 'UPDATE problems set category_id=%d, status_id=%d, lat=%f, lon=%f, `timestamp`=%d, address=%s, description=%s, reply=%s, name=%s, email=%s, ip=%d, picture=%s where case_id=%d';
		
		$SQL = sprintf ($SQL, $_POST['categories'], $_POST['status'], $_POST['lat'], $_POST['lon'], time(), quote_smart ($_POST['address']), quote_smart ($_POST['description']), quote_smart ($_POST['reply']), quote_smart ($_POST['name']), quote_smart ($_POST['email']), ip2long ($_SERVER['REMOTE_ADDR']), quote_smart ($picture_name), quote_smart ($_GET['case_id']));
		mysql_query ($SQL);

                $SQL = mysql_query ('SELECT * FROM categories WHERE category_id=' . $_POST['categories']);
                $category = mysql_fetch_assoc ($SQL);

		$SQL = mysql_query ('SELECT * FROM statuses WHERE status_id=' . $_POST['status']);
		$status = mysql_fetch_assoc ($SQL);

                $to = $_POST['email'];
                $subject = 'Saken din i Fiks nabolaget mitt har blitt endret';
                $body = '<h1>' . $_POST['address'] . '</h1>' .
                        '<p>Saken din har blitt besvart. Du kan svare p&aring; denne e-posten dersom du har kommentarer.</p>' .
                        '<ul><li>Kategori: ' . $category['name'] . '</li>' .
                        '<li>Skildring: ' . $_POST['description'] . '</li>' .
			'<li>Status: ' . $status['name'] . '</li>' .
			'<li>Svar: ' . $_POST['reply'] . '</li></ul>' .
			'<p>Mvh.<br />Kommunen</p>';
                $headers = "MIME-Version: 1.0\r\n" .
                        "Content-type:text/html;charset=UTF-8\r\n" .
                        "From: Min Gate <mingate@example.com>\r\n";
                mail($to, $subject, $body, $headers);

		header ('Location: submit.php?ok');
		die;
	}
}

function addBorder ($input)
{
	global $Errors;
	
	if (!is_array ($Errors)) {
		return FALSE;
	}
	
	if (in_array ($input, $Errors) OR array_key_exists ($input, $Errors)) {
		return ' style="border:1px solid red" ';
	}
	
	return FALSE;
}

function showError ($input)
{
	global $Empty, $Invalid, $Errors;
	
	if (!is_array ($Errors)) {
		return FALSE;
	}
	
	$Template = '<span class="error">%s</span>';
	
	if (in_array ($input, $Empty)) {
		return sprintf ($Template, 'Required field');
	}
	
	if (array_key_exists ($input, $Invalid)) {
		return sprintf ($Template, $Invalid[$input]);
	}
	
	return FALSE;
}

function value ($full, $input) {
	if (isset ($_POST[$input])) {
		return htmlspecialchars (stripslashes ($_POST[$input]));
	}
	printf ($full[$input]);
	return FALSE;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>MinGate - Endre en sak</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" media="print, projection, screen" href="../style.css" />
	
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=GOOGLE_API_KEY?>" type="text/javascript"></script>
	
	<script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="../js/jquery.tipTip.min.js"></script>

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
		map.setCenter(new GLatLng(60.191335, 12.009258), 11, G_NORMAL_MAP);

		//map.centerAndZoom(new GPoint(9.67002, 59.10055), 6);
		 
		// Recenter Map and add Coords by clicking the map
		GEvent.addListener(map, 'click', function(overlay, point) {
			var url = '../index.php?lat=' + point.y + '&lon=' + point.x;
			//alert (url);
			
			map.clearOverlays();
			
			$.getJSON (url, function (data) {
				if (data.kommune_id != <?= MUNICIPAL_ID ?>) {
					alert ('Du kan bare legge til områder innen Kongsvinger');
				} else {
					$('#closest_address').show();
					$('#closest_address span').html (data.zip + ', ' + data.name);
					$('#lat').val (point.y);
					$('#lon').val (point.x);
					
					var marker = new GMarker(new GLatLng(point.y, point.x));
					map.addOverlay(marker);
				}
			});
			
		});
		
		
	});
	</script>
</head>
<body>

<div class="wrapper">

	<h1><a href="../">MinGate</a></h1>
	<h2>Endre en sak</h2>
	
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
		
		<?php if (isset ($_GET['ok'])): ?>
		<h3>Saken er endret!</h3>
		
		<p>
			Saken ble endret.
		</p>
		
		<?php else: ?>
		<!-- Her må det inn noe kode for å fylle ut verdier til alle input-feltene. -->
		<?php
		$SQL = 'SELECT * FROM problems where case_id=%d';
		$SQL = sprintf ($SQL, $_GET['case_id']);
		$SQL = mysql_query ($SQL);
		$Data = mysql_fetch_assoc ($SQL);
		?>
		<!-- Ferdig med stuff for å fylle ut verdier til input-feltene. -->
		<h3>Endre saken</h3>
		
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
			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Plassering av problemet</legend>
					
					<p>
						<label for="address">Adresse:</label>
						<input type="text" id="address" value="<?=value($Data,'address')?>" name="address" <?= addBorder ('address') ?> /> <?= showError ('address') ?>
					</p>
					
					<p>
						Klikk på kartet for å registrere lengde- og breddegrad på den innmeldte saken.
					</p>
					
					<p>
						Du kan klikke flere ganger for å rette koordinatene.
					</p>
					
					<p>
						<label for="lat">Lengdegrad: </label><input type="text" value="<?=value($Data,'lat')?>" name="lat" <?= addBorder ('lat') ?> id="lat" /> <?= showError ('lat') ?><br />
						<label for="lon">Breddegrad:</label><input type="text" value="<?=value($Data,'lon')?>" name="lon" <?= addBorder ('lon') ?> id="lon" /> <?= showError ('lon') ?>
					</p>
					
					<p class="informative" id="closest_address">
						Basert på dine koordinater har vi funnet ut at <span>N/A</span> er det nærmeste poststedet.
					</p>
				</fieldset>
				
				<fieldset>
					<legend>Problembeskrivelse</legend>
					
					<p>
						<label for="type">Type:</label>
						<select name="categories" id="categories" <?=addBorder('categories')?>>
							<option value="<?=value($Data,'category_id')?>">Velg</option>
							<?php
							$SQL = mysql_query ('SELECT * FROM categories ORDER BY name ASC');
							
							while ($Data_cat = mysql_fetch_assoc ($SQL)): ?>
							<option value="<?=$Data_cat['category_id']?>"<?php if($Data_cat['category_id'] == $Data['category_id']) echo ' selected="selected"'; ?>><?=$Data_cat['name']?></option>
							<?php endwhile ?>
						</select>
					</p>
					
					<p>
						<label for="description">Skildring:</label>
					</p>
					
					<p>
						<textarea id="description" name="description" rows="7" <?=addBorder('description')?> cols="50"><?=value($Data,'description')?></textarea> <?= showError ('description') ?>
					</p>
					
					<p>
						<label for="picture">Evt. bilde</label>
						<input type="file" id="picture" name="picture" <?=addBorder('picture')?> /> <?= showError ('picture') ?>
					</p>
				</fieldset>
				<fieldset>
					<!-- Her må det inn noe for å kunne endre status -->
					<legend>Svar til kunde</legend>
					<p>
						<label for="status">Status</label>
						<select name="status" id="status" <?=addBorder('status')?>>
							<option value="<?=value($Data,'status_id')?>">Velg</option>
							<?php
							$SQL= mysql_query ('SELECT * FROM statuses ORDER BY name ASC');

							while ($Data_status = mysql_fetch_assoc ($SQL)): ?>
							<option value="<?=$Data_status['status_id']?>"<?php if($Data_status['status_id'] == $Data['status_id']) echo ' selected="selected"'; ?>><?=$Data_status['name']?></option>
							<?php endwhile ?>
						</select>
					</p>

					<p>
						<label for="reply">Svar:</label>
					</p>

					<p>
						<textarea id="reply" name="reply" rows="7" <?=addBorder('reply')?> cols="50"><?=value($Data,'reply')?></textarea>
					</p>
				</fieldset>	
				<fieldset>
					<legend>Personalia</legend>
				
					<p>
						<label for="name">Navn:</label>
						<input type="text" name="name" value="<?=value($Data,'name')?>" id="name" <?=addBorder('name')?> /> <?= showError ('name') ?>
					</p>
					
					<p>
						<label for="email">E-post:</label>
						<input type="text" name="email" id="email" value="<?=value($Data,'email')?>" <?=addBorder('email')?> /> <?= showError ('email') ?>
					</p>
				</fieldset>
				
				<p>
					<button type="submit" name="submit">Endre sak</button>
				</p>
			</form>
		</div>
		
		<?php endif ?>
	</div>
</div>
</body>
</html>
