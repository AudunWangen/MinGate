<?
include 'inc/header.php';
?>

<div id="intro">
<!-- Introtekst til siden -->
<h1>Mitt nærområde</h1>
<p>Her kan du melde inn mangler eller feil som feks. hull i veg, søppel og tagging m.m.<br />Sakene behandles fortløpende av kommunen.
</p>

<h2>Hvordan melde inn en ny sak?</h2>

<p class="highlight"><img class="imgmargin" src="img/page_add.png" alt="Legg til sak-ikon" />Du kan selv melde inn feil til kommunen ved å <a href="meldinn.php">fylle ut et enkelt skjema</a>.
</p>
</div>

<div id="leftcontent">
<h2>Kart med registerte saker</h2>
<!-- Start: Viser kartløsningen fra Google -->
<?
include 'kart.php';
?>
<!-- Slutt kartløsningen fra Google -->
</div>

<div id="rightmenu">
<!-- Start siste 5 saker som er meldt inn -->
<h2>Siste 5 innmeldte saker</h2>
<?
include '5siste.php';
?>
<!-- Slutt siste 5 saker som er meldt inn -->

<!-- Link til side som viser alle saker som er registert -->
<a href="visalle.php">Se alle registrerte saker</a>

<!-- Start informasjon om fargekoder -->
<h2>Fargekoder viser status på saker</h2>
<ul>
<li class="red">Rød - Ikke behandlet</li>
<li class="yellow">Gul - Under behandling</li>
<li class="green">Grønn - Ferdig behandlet</li>
</ul>
<!-- Slutt informasjon om fargekoder -->

<!-- Start statistikk for alle saker som er meldt inn -->
	<?
	include 'statistikk.php';
	?>
<!-- Slutt statistikk for alle saker som er meldt inn -->
</div>
<?
include 'inc/footer.php';
?>
