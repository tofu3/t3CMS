<?php

$_S['pageName'] = 't3cmsTestAlpha';     # Name of the page.
$_S['pageRoot'] = 'http://tofu3.ath.cx/t3cms/'; # Base HREF

$_S['dbType'] = 'sqlite';                # Other database types is unsupported.
$_S['dbName'] = ''; # Not used.
$_S['dbPath'] = 'db/alpha.db';    # Path to sqlite database file.
$_S['dbUser'] = '';     # Not used.
$_S['dbPass'] = '';            # Not used.
$_S['dbPrfix'] = 'sora_';

//$_S['dbConnectionString'] = 'mysql:host=mysql13.loopia.se;dbname=formedlingsverket_se'; //$_S['dbType'].':dbname='.$_S['dbName'].';host='.$_S['dbPath'];

$_S['dbConnectionString'] = $_S['dbType'].':'.$_S['dbPath'];

?>
