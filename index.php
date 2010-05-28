<?
include 'inc/header.php';
?>

<!-- Introtekst til siden -->
<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td width="675" valign="top"><br /><span class="tittel">Mitt nærområde</span><br /><br /><span class="text">Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.<br />Sakene behandles fortløpende av kommunen.</span><br />
	</td>

</tr>
</table>
<br />
<!-- Hvordan melde inn en sak -->
<table>
<tr>
	<td><span class="tittel">Hvordan melde inn en ny sak?</span></td>
</tr>
</table><br />
<table width="100%" bgcolor="#E0E0E0" border="0" cellpadding="3" cellspacing="1">
<tr>
<td width="99%" bgcolor="#f0f3f9" valign="top"><img src="img/page_add.png" alt="Legg til sak-ikon" /> <b>Fyll ut skjema:</b><br />
<span class="text">For å melde inn en sak til kommunen, <a href="meldinn.php">klikk her</a>.</span><br /><br />
</td>
</tr>
</table>

<table width="675" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td width="400" valign="top"><br /><span class="tittel">Kart med registerte saker</span><br /><br />
<!-- Start: Viser kartløsningen fra Google -->
<?
include 'kart.php';
?>
<!-- Slutt kartløsningen fra Google -->
</td>

<td valign="top" width="485">
<br />
<!-- Start siste 5 saker som er meldt inn -->
<span class="tittel">Siste 5 innmeldte saker</span><br /><br />
<?
include '5siste.php';
?>
<!-- Slutt siste 5 saker som er meldt inn -->

<!-- Link til side som viser alle saker som er registert -->
&nbsp;<a href="visalle.php">Se alle registrerte saker</a><br />

<!-- Start informasjon om fargekoder -->
<br /><b>Fargekoder viser status på saker.</b><br /><img src="img/bullet_red.png" alt="Rød prikk" />Rød - Ikke behandlet<br /><img src="img/bullet_orange.png" alt="Gul prikk" />Gul - Under behandling<br /><img src="img/bullet_green.png" alt="Grønn prikk" />Grønn - Ferdig behandlet
<!-- Slutt informasjon om fargekoder -->

<!-- Start statistikk for alle saker som er meldt inn -->
	<br /><br /><?
	include 'statistikk.php';
	?>
<!-- Slutt statistikk for alle saker som er meldt inn -->

</td>
</tr>
</table>

<?
include 'inc/footer.php';
?>
