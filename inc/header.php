<?php
include 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="no">
<head lang="no">
<title>Fiks min gate!</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<style type="text/css">
body {

	height: auto !important;
	height: 100%;
	min-height: 100%;
	font-size: 66.0%;
	font-family:Verdana;
}

A:link
{
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#1b6289; 
	text-decoration:underline;
}

A:visited
{
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#1b6289; 
	text-decoration:underline;
}

A:active
{
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#1b6289; 
	text-decoration:underline;
}

A:hover
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#000000; 
	text-decoration: underline;
}
.tittel
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#000000;
	FONT-WEIGHT: bold;
}
.text
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 11px;
	color:#000000; 
}
.text_i
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 9px;
	color:#000000; 
}
.red
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 11px;
	color:#FF001A; 
}
.small
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 10px;
	color:#000000; 
}
.small8
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 8px;
	color:#808080; 
}
.dato
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 10px;
	color:#000000; 
}
.heading
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#000000; 
	FONT-WEIGHT: bold;
}
.heading-stor
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 16px;
	color:#000000; 
	FONT-WEIGHT: bold;
}
.heading14
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 14px;
	color:#FFFFFF; 
	text-decoration: underline;
}
.heading14-b
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 14px;
	color:#000000; 
	text-decoration: underline;
}
.heading12
{ 
	font-family: verdana, arial, helvetica, sans-serif;
	FONT-SIZE: 12px;
	color:#FFFFFF; 
	text-decoration: underline;
}
#stylized input{
float:left;
font-size:12px;
padding:0px 0px;
border:solid 1px #FFFFFF;
width:100px;
margin:0px 0 0px 0px;
}
</style>

<style type="text/css">
    v\:* {
      behavior:url(#default#VML);
    }
</style>

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

<!-- Tabell som favner hele siden -->
<table align="left" width="675">
<tr>
	<td>
<!-- Tabell for topplinker -->
<table width="100%" bgcolor="#E0E0E0" border="0" cellpadding="3" cellspacing="1">
<tr height="20">
<td bgcolor="#f0f3f9"> <a href="index.php">Min gate</a> | <a href="meldinn.php">Registrer sak</a> | <a href="visalle.php">Alle saker</a> | <a href="kontakt.php">Kontakt oss</a> | <a href="forventninger.php">Tjenesteerklæring</a></td><td bgcolor="#f0f3f9" align="right"> <form action="sok.php" method="post" name="søk">
<input type="text" name="streng" size="20" />&nbsp;
<input type="submit" value="Søk" class="normalbold" />
</form> </td>
</tr>
</table>
