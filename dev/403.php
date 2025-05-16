<?php

include_once(__DIR__.'/template/head-error.inc.php');
header("HTTP/1.1 403 Forbidden - Niet toegestaan");

?>

<div class="uk-flex uk-flex-column">
	<h1 style="color: red;"><span uk-icon="icon: warning; ratio: 2"></span>&nbsp;403 - GEEN TOEGANG!</h1>
	<p>
		U probeert toegang te krijgen tot een deel van de applicatie waar u geen recht toe hebt.<br />
		Keer terug naar de startpagina via het logo of de navigatie optie <a href="/"><strong>Home</strong></a>.
	</p>
</div>


<?php
include_once(__DIR__.'/template/foot-error.inc.php');