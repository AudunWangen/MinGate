<?php
session_start();
if(!session_is_registered('myusername')){
header("location:main_login.php");
}

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
		require '../inc/Avatar.php';
		
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

?><!DOCTYPE html>
<html>
<head>
	<title>MinGate - Endre en sak</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" media="print, projection, screen" href="../style.css" />
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_API_KEY?>&amp;sensor=false"></script>
    <script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/jquery.tipTip.min.js"></script>

		<script type="text/javascript">
			var center = new google.maps.LatLng(<?=CENTER_LON?>, <?=CENTER_LAT?>);
      var location;
      var map;
      var marker;
      var i;

			<?php
				if (isset ($_GET['case_id'])) {
					$SQL = 'SELECT c.name as categoryName, p.lat, p.lon, p.case_id, p.address, p.description, p.reply, s.type FROM problems p INNER JOIN categories c INNER JOIN statuses s WHERE p.category_id = c.category_id AND p.status_id = s.status_id AND p.case_id = ' . $_GET['case_id'];
          $SQL = mysql_query ($SQL);
      ?>
			    var problems = [
							<?php while ($Data = mysql_fetch_assoc ($SQL)): ?>
								[ <?=$Data['lat'] ?>,<?=$Data['lon']?>,'<?=$Data['case_id'] ?>','../img/<?=$Data['type'] ?>.png','<?=$Data['address'] ?>' ],
							<?php endwhile ?>
						];
      <?php
        }
      ?>

			function initialize() {
				var mapOptions = {
						zoom: <?=MAP_ZOOM?>,
						center: center,
						mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				
				map = new google.maps.Map(document.getElementById('map'),
						mapOptions);

					marker = new google.maps.Marker({
						position: new google.maps.LatLng(problems[0][0], problems[0][1]),
						map: map, 
						draggable: true,
						icon: problems[0][3]
					});

        google.maps.event.addListener(marker, 'dragend', function(event){
          placeMarker(event.latLng);
        });

				google.maps.event.addListener(map, 'click', function(event){
          placeMarker(event.latLng);
        });
			}

      function placeMarker(position){
        // Create or move marker
        if (marker == undefined){
          marker = new google.maps.Marker({
            position: position,
            map: map,
            draggable: true,
            icon: "../img/pending.png"
          });
        }
        else {
          marker.setPosition(position);
        }
        map.panTo(position);
        
        // Get municipality through JSON
        var url = '../index.php?lat=' + position.lat() + '&lon=' + position.lng();
        $.getJSON(url, function (data) {
          // Is this the right municipality?
          if (data.kommune_id != <?= MUNICIPAL_ID ?>) {
            alert ("Du kan ikke legge til saker i " + data.name);
          } else {
            $('#lat').val (position.lat());
            $('#lon').val (position.lng());
          }
        });

      }

			google.maps.event.addDomListener(window, 'load', initialize);
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
			  <form>
			  	<select name="categories" id="type">
	  				<option value="0">Velg</option>
	  				<?php
	  				$SQL = mysql_query ('SELECT * FROM categories ORDER BY name ASC');
	  				
		  			while ($Data = mysql_fetch_assoc ($SQL)): ?>
  					<option value="index.php?category=<?=$Data['category_id']?>"><?=$Data['name']?></option>
	  				<?php endwhile ?>
	  			</select>
	  			<button type="submit" id="switchCategory" onClick="top.location.href = this.form.categories.options[this.form.categories.selectedIndex].value; return false;">Vis fra kategori</button>
			  </form>
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
		<div id="map"></div>
		
		<div class="right latest small">
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
						<textarea id="description" name="description" rows="7" <?=addBorder('description')?> cols="40"><?=value($Data,'description')?></textarea> <?= showError ('description') ?>
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
						<textarea id="reply" name="reply" rows="7" <?=addBorder('reply')?> cols="40"><?=value($Data,'reply')?></textarea>
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
