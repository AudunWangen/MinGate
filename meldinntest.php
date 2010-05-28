<?
include 'inc/header.php';
?>
  <style type="text/css">
    
    #map{width:400px; height:450px; float:left;}
    #novel{width:400px; margin:20px;float:right;}
    a:hover {color: red; text-decoration: underline overline;}
    .pushpin{width:20px; height:34px; border:none;}
    .geocode {}
  </style>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="675"><BR><span class="tittel">Mitt n&aelig;romr&aring;de</span><br><br><span class="text">Her kan du melde inn mangler eller feil som feks. hull i veg, gatelykt som ikke virker, tagging m.m.<br>Sakene behandles fortløpende av kommunen.</span><BR>
	</TD>
</TR>
</TABLE>
<br>
<table width="675" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td width="400" valign="top">
<BR>&nbsp;<span class="tittel">Registrer sak her</span>

<script type="text/javascript">
function popup (el)
{
if(el.value.toLowerCase()=='gatelys')
	alert('\'Feil på gatelys må meldes til Skagerak Energi. www.skagerakenergi.no\'');
}
</script>

<?

include 'db/database.php';

	// Build SQL query
	$idag  = date ("d.m.y", mktime (0,0,0,date("m")  ,date("d") ,date("Y")));
	$dato = $idag;

$to = "thomas.naper@porsgrunn.kommune.no";
$subject = "Ny sak registrert i Fiks min gate";

$message = "
<html>
<head>
<title>Ny sak registrert i Fiks min gate</title>
</head>
<body>
<p>Feilmelding: $feil</p>
<p>Adresse: $sted</p><br>
<p>Type problem: $problem</p>
<p>Navn: $navn</p>
<p>E-post: $epost</p>
<p>Tlf: $tlf</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
$headers .= 'From: <$epost>' . "\r\n";

if ($ny != "ny")
{

$ip = getenv("REMOTE_ADDR") ; 



	print "<br><br>\n";
	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";

	print "<form action=\"meldinn.php\" method=\"post\" name=\"fiksgrafitti\" enctype=\"multipart/form-data\"  onsubmit=\"return checkform(this);\">\n";
	print "<input type=\"hidden\" name=\"ny\" value=\"ny\">\n";
	print "<input type=\"hidden\" name=\"status\" value=\"ubehandlet\">\n";
	print "<input type=\"hidden\" name=\"ip\" value=\"$ip\">\n";

		
	print "<tr>\n";
	print "	<td width=\"75\" class=\"normal\">\n";
	print "	<span class=\"text\"><B>Feil:</B>\n";
	print "	</td>\n";
	print "	<td>\n";
	print " <SELECT NAME=\"feil\" onchange=\"popup(this)\"> \n";
	print " <OPTION VALUE=\"Ingen valgt\" SELECTED>Velg\n";
	print " <OPTION VALUE=\"gatelys\">Gatelys virker ikke\n";
	print " 	<OPTION VALUE=\"Hull i veg\">Hull i veg\n";
	print " 	<OPTION VALUE=\"Grafitti-Tagging\">Grafitti-Tagging\n";
	print " 	<OPTION VALUE=\"Vann og avløp\">Vann og avl&oslash;p\n";
	print " 	<OPTION VALUE=\"Park\">Park\n";
	print " 	<OPTION VALUE=\"Renovasjon\">Renovasjon\n";
	print " 	<OPTION VALUE=\"Friluft\">Friluft\n";
	print " 	<OPTION VALUE=\"Annet\">Annet\n";
	print " 	</SELECT>\n";
	
	print "	</td>\n";
	print "</tr>\n";
	print "</table>\n"; 
	
	

	print "	  <table border=\"0\" width=\"90%\">\n";
	print "	  <tr>\n";
	print "	  <td><span class=\"text\"><B>Marker adress i kart</b></td><td>-</td>\n";
	print "	  </tr>\n";
	print "	  <tr>\n";
	print "   <td>	Klikk p&aring; mark&oslash;r og plasser den<br>p&aring; det aktuelle stedet i kartet.<br>Bekreft plassering etterp&aring;.</td><td align=\"center\">\n";

 
	print "    <a class=\"marker\" href=\"javascript:follow(0)\">\n";
	print "          <img src=\"http://maps.google.com/mapfiles/marker.png\" alt=\"\" title=\"click me\" class=\"pushpin\"/></a>\n";
	print "        </td></tr></table>\n";
	print "    </form>\n";	
	
	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // lagt inn for pil
	print "<tr>\n";
//	print "	<td class=\"normal\" valign=\"top\">\n";
//	print "	<span class=\"text\"><B>Adresse:</B>&nbsp;\n";
//	print "	</td>\n";
//	print "</tr>\n";
//	print "<tr>\n";
	print "	<td>\n";
	
	print "	<TEXTAREA style=\"border: 0; overflow: auto;\" NAME=\"sted\" ROWS=\"4\" COLS=\"30\" id=\"memo\"></TEXTAREA>\n";
	print "	</td>\n";
	print "	</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // lagt inn for pil
	print "<tr>\n";
	print "	<td class=\"normal\" valign=\"top\">\n";
	print "	<span class=\"text\"><B>Problem:</B>&nbsp;\n";
	print "	</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "	<td>\n";
	
	print "	<TEXTAREA NAME=\"problem\" ROWS=\"5\" COLS=\"30\"></TEXTAREA>\n";
	print "	</td>\n";
	print "	</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Navn:</B>\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"navn\" size=\"25\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Epost:</B> *\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"epost\" size=\"25\" class=\"normal\">\n";
	print "	</td>\n";
	print "</tr>\n";
	
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Tlf:</B> *\n";
	print "	</td>\n";
	print "	<td>\n";
	print "	<input type=\"text\" name=\"tlf\" size=\"25\" class=\"normal\">\n";
	print "	<br>Din ip-adresse: $ip</td>\n";
	print "</tr>\n";
	print "</table>\n"; 

	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // lagt inn for pil
	print "<tr>\n";
	print "	<td class=\"normal\" width=\"75\">\n";
	print "	<span class=\"text\"><B>Bilde:</B>\n";
	print "	</td>\n";
	print "<tr>\n";
	print "</tr>\n";
	print "	<td>\n";
	print "	<input name=\"bilde\" size=\"20\" type=\"file\" value=\"$bilde\">\n";
	print "	</td>\n";
	print "</tr>\n";
print "</table>\n"; 


	print "<table width=\"100%\" border=0 valign=\"top\" bgcolor=\"#FFFFFF\">\n";  // lagt inn for pil
	//Submit knapp
	print "<tr>\n";

	print "	<td>\n";
	print "	<input type=\"submit\" value=\"Registrer sak\" class=\"normalbold\">\n";
	print "	</td>\n";

	print "	<td class=\"normal\" width=\"200\">\n";
	print "	<span class=\"small\">* Vises ikke p&aring; websiden</span>\n";
	print "	</td>\n";
	
	print "</tr>\n";
print "</table>\n";
	print "</form>\n";
}
else
{
	
mail($to,$subject,$message,$headers);

 

// Configuration - Your Options
      $allowed_filetypes = array('.jpg','.gif','.bmp','.png',''); // These will be the types of file that will pass the validation.
      $max_filesize = 55524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = './upload/'; // The place the files will be uploaded to (currently a 'files' directory).
	
   $bilde = $_FILES['bilde']['name']; // Get the name of the file (including file extension).
   $ext = substr($bilde, strpos($bilde,'.'), strlen($bilde)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('Filtypen du prøver å laste opp er ikke tillatt.');
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['bilde']['tmp_name']) > $max_filesize)
      die('Bildefilen er for stor til å lastes opp.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['bilde']['tmp_name'],$upload_path . $bilde))
         echo '<br><br>Ditt bilde ble lastet opp, se ditt bilde her: <a href="' . $upload_path . $bilde . '" title="Your File" target="_top">her</a>'; // It worked.
      else
         echo ''; // It failed :(.

$query = "INSERT INTO fiksgrafitti (id, dato, sted, lat, lon, feil, status, problem, navn, epost, tlf, ip, bilde) VALUES ('$id','$dato','$sted','$lat','$lon','$feil','$status','$problem','$navn','$epost','$tlf','$ip','$bilde')";

echo "<br><br>Takk for din registrering!<br><br>Vi setter stor pris på ditt sosiale engasjement som hjelper oss med å yte bedre tjenester til våre innbyggere.";

	
	$result = MYSQL_QUERY($query);
	MYSQL_CLOSE();
}
?>


<td width="400" valign="top" align="left"><BR>



        <div id="map">
          <noscript>You should turn on JavaScript</noscript>
        </div>
      </div>
    </td></tr><tr>
    <td>
   

 
        <p><span id="api-version"></span></p>
      </div>
    </td>
  </tr>
  <tr>
    <td>

    </td>
  </tr>
</table>
 
<script type="text/javascript"> 
 
/**
 * DOM operations
 * 'Map coming...' visible only with JavaScript on.
 */
document.getElementById("map").innerHTML = "Map coming...";
document.getElementById("api-version").innerHTML = "api v=2."+G_API_VERSION;
if (!GBrowserIsCompatible()) {
  alert('Sorry. Your browser is not Google Maps compatible.');
}
 
/**
 * map
 */
_mPreferMetric = true;
var map = new GMap2(document.getElementById("map"));
var start = new GLatLng(60.213,24.88);
map.setCenter(start, 14);
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl(1));
map.addControl(new GScaleControl());
map.openInfoWindowHtml(map.getCenter(), "Nice to see you.");
map.closeInfoWindow(); //preload iw
 
 
/**
 * reverse/forward gecoder
 * sets marker LatLng
 */
var markers = [];
var geo = new GClientGeocoder();
function geocode(query, pin_){
  geo.getLocations(query, function(addresses){
    if(addresses.Status.code != 200){
      alert("D'oh!\n " + query);
    }else{
      marker = pin_||createMarker();
      var result = addresses.Placemark[0];
      marker.howMany = addresses.Placemark.length;
      marker.response = result.address;
      var details = result.AddressDetails||{};
      marker.accuracy = details.Accuracy||0;
      var lat = result.Point.coordinates[1];
      var lng = result.Point.coordinates[0];
      var responsePoint = new GLatLng(lat, lng);
      marker.setLatLng(responsePoint);
      if(marker.poly) map.removeOverlay(marker.poly);
      marker.poly = new GPolyline([query, responsePoint],"#ff0000",2,1);
      map.addOverlay(marker.poly);
      marker.index = markers.length;
      markers.push(marker);
      if(!pin_){
        map.setCenter(responsePoint);
        map.setZoom(marker.accuracy*2 + 3);
      }
      if(result.address) doInfo(marker);
    }
  });
}
 
 
/**
 * creates and opens an info window
 * @param GMarker
 */
function doInfo(marker_){
  var pin = marker_;
  var iwContents = pin.response.replace(/,/g, ",<br/>");
  iwContents += "<div class='small'>" + pin.getLatLng().toUrlValue();
  iwContents += "<br/>Accuracy: " + pin.accuracy;
  if (pin.howMany>1)iwContents += "<br/>" + pin.howMany;
  iwContents += "</div>";
  iwContents += "<a href='javascript:memo(markers["+pin.index+"])'>Bekreft at dette er riktig adresse</a>";
  pin.bindInfoWindowHtml(iwContents);
  map.openInfoWindowHtml(pin.getLatLng(), iwContents);
}
 
var memoarea = document.getElementById("memo");
memoarea.value = "";
function memo(marker_){
  var pin = marker_;
  var lat = pin.getLatLng().lat().toFixed(6);
  var lng = pin.getLatLng().lng().toFixed(6);
  var html = pin.response;
  memoarea.value += lng + ", " + lat + ", " + html + "\n";
}
 
 
/**
 * marker with follow() function
 * @author: Esa 2008
 */
var marker;
 
function createMarker(){
  marker = new GMarker(map.getCenter(),{draggable:true, autoPan:false});
  map.addOverlay(marker);
  
  GEvent.addListener(marker, 'dragend', function(markerPoint){
    if(!map.getBounds().containsLatLng(markerPoint)){
      map.removeOverlay(this);
      map.removeOverlay(this.poly);
    }else{
    geocode(this.getLatLng(),this);
    }
  });
  return marker
}
 
function follow(imageInd){
  var dog = true;
  var noMore = false;
 
  var mouseMove = GEvent.addListener(map, 'mousemove', function(cursorPoint){
    if(!noMore){
      marker = createMarker();
      noMore = true;
    }
    if(dog){
      marker.setLatLng(cursorPoint);
    }
  });
  var mapClick = GEvent.addListener(map, 'click', function(){
    dog = false;
    geocode(marker.getLatLng(),marker);
    // 'mousemove' event listener is deleted for saving resources
    GEvent.removeListener(mouseMove);
    GEvent.removeListener(mapClick);
  });
}
 
 
</script>


</td>

</TD>
<td></td>
</TR>
</TABLE>

