<?php
require 'config.php';
/* Redirect browser */
header( "Location: " . CONTACTPAGE );
/* Make sure that code below does not get executed when we redirect. */
exit;
?>