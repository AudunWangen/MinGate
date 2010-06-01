<table width="350" bgcolor="#E0E0E0" border="0" cellpadding="3" cellspacing="1">
<tr>
<td width="99%" bgcolor="#f0f3f9" valign="top"><img src="img/page_add.png" alt="Legg til side-ikon" /> <br /><span class="tittel">Send inn tilbakemelding</span><br /><br />
<span class="text">Her kan du sende inn ris og ros, forslag til forbedringer<br />eller annet som du m&aring;tte ha p&aring; hjerte.</span><br /><br />Vi er ogs&aring; tilgjengelige for direkte kontakt, se kontaktinformasjon.</td>
</tr>
</table>

<br />
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
	 // ** START **
  if (form.subject.value == "") {
    alert( "Vennligst fyll inn overskrift." );
    form.subject.focus();
    return false ;
  }
  // ** END **
  	 // ** START **
  if (form.message.value == "") {
    alert( "Vennligst fyll inn en melding." );
    form.message.focus();
    return false ;
  }
  // ** END **
 
  return true ;
}
//-->
</script>
<?php
if (isset($_REQUEST['email']))
  {
  //send email
  $email = $_REQUEST['email'] ;
  $subject = $_REQUEST['subject'] ;
  $message = $_REQUEST['message'] ;
  mail( "FIXME@FIXME.kommune.no", "Subject: $subject",
  $message, "From: $email" );
  echo "Takk for at du har sendt inn en melding.<br />Du vil havne på forsiden om 3 sekunder. <meta http-equiv='REFRESH' content='3; URL=index.php'>";
  }
else
  {
  echo "<form method='post' action='tilbakemelding.php' onsubmit=\"return checkform(this);\">
  
  <table width=\"400\">
  <tr>
	<td width=\"80\"><span class=\"text\"><b>Din e-post:</b></span></td>
	<td><input name=\"email\" type=\"text\" size=\"38\" /></td>
  </tr>
  <tr>
	<td><span class=\"text\"><b>Overskrift:</b></span></td>
	<td><input name=\"subject\" type=\"text\" size=\"38\" /><br /></td>
  </tr>
  </table>
  
<table width=\"400\">
  <tr>
	<td width=\"80\" valign=\"top\"><span class=\"text\"><b>Melding:</b></span></td>
	<td> <textarea name=\"message\" rows=\"6\" cols=\"30\"></textarea><br /></td>
  </tr>
  </table>  
 
<table width=\"400\">
  <tr>
	<td width=\"80\"></td>
	<td><input type=\"submit\" value=\"Send tilbakemelding\" /></td>
  </tr>
  </table>  
  </form>";
  }
?>

