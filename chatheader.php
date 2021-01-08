<?php 

	require_once("funzioni.php");

 session_start();

$PUBBL_MSG_ENTRA_ESCI = FALSE; // dice se mettere XXX � entrato, e cosi' via...
$NOMESKIN = "default";
$CONSTLARGEZZA600 = 650;
$MAXMESSAGGI  = 40;
$coloresfondo = "\"#FFFFBB\"";
$ANONIMO = "anonimo";
$QGFDP = "el Palladius maricon";

$GODNAME = "palladius"; // se cambi questo nome, viene un atro superuser...
$GETUTENTE = getUtente();
$ISANONIMO = anonimo();
$ISSERIO = Session('serio');
$ISSINGLE = Session('single');
$ISPAL = ($GETUTENTE == $GODNAME) && Session("powermode");


?>
	<link href="skin/<?php  echo $NOMESKIN?>/style/style.css" rel="stylesheet" type="text/css">
	<body bgcolor="#FFFFEE" onLoad="" >
<?php 

	// funzioni comuni

function bragheInit() {
	$braghe=(getApplication("braghe"));
	//if (braghe=="undefined" ) {Application("braghe")="";}
}

function bragheAdd($nome)
	{appendApplication("braghe", $nome."\$". Session("PX") .  "@");}

function bragheRemoveSEMPLICIOTTA($nome) {
	$brarr=splitta("\@",getApplication("braghe"));
	$brnew="";

	for ($i=0;$brarr[$i];$i++) 	{
		if (($brarr[$i]) != ($nome) && $brarr[$i] != "") 
			$brnew .= $brarr[$i] . "@";
		else {// e' lui
			$brarrarr=splitta("\$",$brarr[$i]);
			$CHI=$brarrarr[0];
			$PX=$brarrarr[1];
			$vincoio= (intval(Session("PX")) >= intval($PX));
			if (! $vincoio) 
				return; // rimozione NON consentita
			}
	}
	setApplication("braghe",$brnew);
}


function bragheRemove($nome) {
	$brarr=splitta("@",getApplication("braghe"));
	$ispal= (Session("nickname")=="palladius");
		
	$brnew="";
	for ($i=0;$i<$brarr[$i];$i++) 	{
		$brarrarr=splitta("\$",$brarr[i]);
		$CHI=$brarrarr[0];
		$PX=$brarrarr[1];

		if ($CHI != $nome && $CHI != "") 
				$brnew .= $brarr[$i] . "@";
		else if ($CHI == $nome) {// e' lui
			$vincoio= (intval(Session("PX")) >= intval($PX));
			if (! $vincoio) 
				{$brnew .= $brarr[$i] . "@";}
		}
	}
	setApplication("braghe",$brnew);
}

?>
