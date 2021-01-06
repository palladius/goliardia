<?php
	//$webmaster_email = 'palladius@goliardia.org';
	$webmaster_email = 'goliardiapuntoit+iscrizione@gmail.com';
	$WEBMASTERMAIL = "riccardo.carl.esso+goliardia@gmail.com"; 
	$MESSAGGINO_HEADER = "Scusate, addi' 2020-09-15 il Load Balancer si e' invornito e ho dovuto migrare l'intero sito.. ora funge. \
		Grazie a Manolus e NPP per l'aiuto. Per problemi, per favore filate un baco \
		<a href='https://distillery.fogbugz.com/default.asp?pg=pgPublicEdit'>qui</a>. Tuttora c'e' un baco sugli apostrofi. \
		Se avete problemi a inserire/modificare dati per favore provate a non usare il single quote (') ma magari qualunque altro carattere (grazie Criceto). \
		Anzi, potete usare il quote basta RADDOPPIARLO ('') e ne avrete uno solo. Grazie per la pazienza... -- IronPal <br/>\n
		<b>PS</b> Sto lavorando ad ammodernare il mandafoto perche e l unica dependency che mi impedisce di dockerizzare goliardia.
		<b>PPS</b> Addi' 6/1/2021 ho quasi finito! Ci sono quasi in STAGING.
		" ;

	#$DEBUG = 1 ;
	#$DEBUG_ON = 1 ;
	$PAZ_UPLOAD="uploads";

	// NON VA! FIXIT! Non va perche constant non ha ancora session start.
	// La session start e fatta nell header :P
	//$current_user = $_SESSION["_SESS_nickname"]; # NON FUNZIONA! Non capisco perche ma viene vuoto..
	//$current_user_id = $_SESSION["_SESS_id_login"];

	// questo va da dio!
	global $DISABLE_DELTAT_LOGGING;
	$DISABLE_DELTAT_LOGGING=true;
?>
