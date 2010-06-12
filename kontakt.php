<?
include 'inc/header.php';
?>
<?
include 'tilbakemelding.php';
?>

<h2>Kontakt <?php echo COMPANY_NAME; ?></h2>
<ul>
<li><?php echo COMPANY_NAME; ?></li>
<li>Sentralbord: <?php echo COMPANY_PHONE; ?></li>
<li>SMS: <?php echo COMPANY_SMS_CODE; ?> til <?php echo COMPANY_SMS_PHONE; ?> <img src="img/phone.png" alt="telefon-ikon" />| <a href="<?php echo COMPANY_CHAT_URI; ?>" target="_top">Nettprat</a> <img src="img/user_comment.png" alt="chat-ikon" /></li>
<li><a href="mailto:<?php echo COMPANY_EMAIL; ?>"><?php echo COMPANY_EMAIL; ?></a></li>
<li>Postadresse: <?php echo COMPANY_MAIL_ADDRESS; ?></li>
<li>Bes&oslash;ksadresse: <?php echo COMPANY_VISIT_ADDRESS; ?></li>
</ul>


<?
include 'inc/footer.php';
?>












