<?
include 'inc/header.php';
?>

<!-- Introtekst til siden -->
<div id="intro">
<h2>Mitt nærområde</h2>
<p>Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.<br />Sakene behandles fortløpende av kommunen.
</p>

<!-- Hvordan melde inn en sak -->
<h2>Hvordan melde inn en ny sak?</h2>

<p><img src="img/page_add.png" alt="Legg til sak-ikon" /> <strong>Fyll ut skjema:</strong>
For å melde inn en sak til kommunen, <a href="meldinn.php">klikk her</a>.
</p>

<h2>Kart med registerte saker</h2>
<!-- Start: Viser kartløsningen fra Google -->
<?
include 'kart.php';
?>
<!-- Slutt kartløsningen fra Google -->

<!-- Start siste 5 saker som er meldt inn -->
<h2>Siste 5 innmeldte saker</h2>
<?
include '5siste.php';
?>
<!-- Slutt siste 5 saker som er meldt inn -->

<!-- Link til side som viser alle saker som er registert -->
<a href="visalle.php">Se alle registrerte saker</a>

<!-- Start informasjon om fargekoder -->
<br /><b>Fargekoder viser status på saker.</b><br /><img src="img/bullet_red.png" alt="Rød prikk" />Rød - Ikke behandlet<br /><img src="img/bullet_orange.png" alt="Gul prikk" />Gul - Under behandling<br /><img src="img/bullet_green.png" alt="Grønn prikk" />Grønn - Ferdig behandlet
<!-- Slutt informasjon om fargekoder -->

<!-- Start statistikk for alle saker som er meldt inn -->
	<br /><br /><?
	include 'statistikk.php';
	?>
<!-- Slutt statistikk for alle saker som er meldt inn -->

<?
include 'inc/footer.php';
?>
