<h2>Send inn tilbakemelding</h2>
<p>Her kan du sende inn ris og ros, forslag til forbedringer eller annet som du m&aring;tte ha p&aring; hjerte.</p><p>Vi er ogs&aring; tilgjengelige for direkte kontakt, se kontaktinformasjon.</p>

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
  
	<label for=\"email\">Din e-post</label>
	<input name=\"email\" id=\"email\" type=\"text\" size=\"38\" />

	<label for=\"subject\">Overskrift</label>
	<input name=\"subject\" id=\"subject\" type=\"text\" size=\"38\" />
  
	<label for=\"message\">Melding:</label>
	<textarea name=\"message\" id=\"message\" rows=\"6\" cols=\"30\"></textarea>
	<input type=\"submit\" value=\"Send tilbakemelding\" />
	</form>";
  }
?>

