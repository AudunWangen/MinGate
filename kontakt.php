<?
include 'inc/header.php';
?>
<br /><br />
<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td width="400">
<?
include 'tilbakemelding.php';
?>
</td>

<td valign="top">
<span class="tittel">Kontakt <?php echo COMPANY_NAME; ?></span><br /><br />
<span class="text"><?php echo COMPANY_NAME; ?><br /><br />

Sentralbord: <?php echo COMPANY_PHONE; ?><br /><br />
SMS: <?php echo COMPANY_SMS_CODE; ?> til <?php echo COMPANY_SMS_PHONE; ?> <img src="img/phone.png" alt="telefon-ikon" />| <a href="<?php echo COMPANY_CHAT_URI; ?>" target="_top">Nettprat</a> <img src="img/user_comment.png" alt="chat-ikon" /> <br /><br /> 

<a href="mailto:<?php echo COMPANY_EMAIL; ?>"><?php echo COMPANY_EMAIL; ?></a><br /><br />
Postadresse: <?php echo COMPANY_MAIL_ADDRESS; ?><br />
Bes&oslash;ksadresse: <?php echo COMPANY_VISIT_ADDRESS; ?><br /><br /><br /></span>

</td>
</tr>
</table>

<?
include 'inc/footer.php';
?>












