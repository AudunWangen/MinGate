<?
include 'inc/header.php';
?>

<!-- Introtekst til siden -->
<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="675" valign="top"><BR><span class="tittel">Mitt nærområde</span></span><br><br><span class="text">Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.<br>Sakene behandles fortløpende av kommunen.</span><BR>
	</TD>

</TR>
</TABLE>
<br>
<!-- Hvordan melde inn en sak -->
<TABLE>
<TR>
	<TD><span class="tittel">Hvordan melde inn en ny sak?</span></TD>
</TR>
</TABLE><br>
<TABLE width="100%" bgcolor="#E0E0E0" border="0" cellpadding="3" cellspacing="1">
<TR>
<TD width="99%" bgcolor="#f0f3f9" valign="top"><img src="img/page_add.png"> <B>Fyll ut skjema:</B><br>
<span class="text">For å melde inn en sak til kommunen, <A HREF="meldinn.php">klikk her</A>.</span><br><br>
</TD>
</TR>
</TABLE>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<TR>
	<TD width="400" valign="top"><br><span class="tittel">Kart med registerte saker</span><BR><BR>
<!-- Start: Viser kartløsningen fra Google -->
<?
include 'kart.php';
?>
<!-- Slutt kartløsningen fra Google -->
</TD>

<TD valign="top" width="485">
<br>
<!-- Start siste 5 saker som er meldt inn -->
<span class="tittel">Siste 5 innmeldte saker</span><br><br>
<?
include '5siste.php';
?>
<!-- Slutt siste 5 saker som er meldt inn -->

<!-- Link til side som viser alle saker som er registert -->
&nbsp;<A HREF="visalle.php">Se alle registrerte saker</A><br>

<!-- Start informasjon om fargekoder -->
<BR><B>Fargekoder viser status på saker.</B><br><img src="img/bullet_red.png">Rød - Ikke behandlet<br><img src="img/bullet_orange.png">Gul - Under behandling<br><img src="img/bullet_green.png">Grønn - Ferdig behandlet
<!-- Slutt informasjon om fargekoder -->

<!-- Start statistikk for alle saker som er meldt inn -->
	<br><br><?
	include 'statistikk.php';
	?>
<!-- Slutt statistikk for alle saker som er meldt inn -->

</TD>
</TR>
</TABLE>

<?
include 'inc/footer.php';
?>
