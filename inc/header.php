<?php
include 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="no">
<head lang="no">
<title>Fiks min gate!</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="global.css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $googleapikey ?>" type="text/javascript"></script>

<script type="text/javascript">
	function getlatlng()
	{
		if (window.opener==null) return ;
        window.opener.document.getElementById("set_lat_filter").value = document.getElementById("latbox").value;
		window.opener.document.getElementById("set_long_filter").value = document.getElementById("lonbox").value;
        window.close();
	}
</script>

<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
	 // ** START **
  if (form.feil.value == "Velg") {
    alert( "Vennligst fyll inn type feil." );
    form.feil.focus();
    return false ;
  }
  // ** END **
 // ** START **
  if (form.sted.value == "") {
    alert( "Vennligst fyll inn adresse." );
    form.sted.focus();
    return false ;
  }
  // ** END **
 // ** START **
  if (form.latbox.value == "") {
    alert( "Klikk i kartet for å markere sted." );
    form.latbox.focus();
    return false ;
  }
  // ** END **
   // ** START **
  if (form.problem.value == "") {
    alert( "Vennligst fyll inn problem." );
    form.problem.focus();
    return false ;
  }
  // ** END **
   // ** START **
  if (form.navn.value == "") {
    alert( "Vennligst fyll inn navn." );
    form.navn.focus();
    return false ;
  }
  // ** END **
     // ** START **
  if (form.subject.value == "") {
    alert( "Vennligst fyll inn subject." );
    form.subject.focus();
    return false ;
  }
  // ** END **
       // ** START **
  if (form.message.value == "") {
    alert( "Vennligst fyll inn en beskjed." );
    form.message.focus();
    return false ;
  }
  // ** END **
 
  return true ;
}
//-->
</script>



</head>

<body>
<div id="wrap">
<div id="topmenu">
<ol>
	<li><a href="index.php">Min gate</a></li>
	<li><a href="meldinn.php">Registrer sak</a></li>
	<li><a href="visalle.php">Alle saker</a></li>
	<li><a href="kontakt.php">Kontakt oss</a></li>
	<li><a href="forventninger.php">Tjenesteerklæring</a></li>
</ol>

<form action="sok.php" method="post" name="søk">
<input type="text" name="streng" size="20" />&nbsp;
<input type="submit" value="Søk" class="normalbold" />
</form>
</div>
