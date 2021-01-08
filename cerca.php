<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$parole=Form("goliardiDaCercare");
if ($parole == "")
	$parole="farina 00";  // :-)))
$parole = encodeApostrofi(strval($parole));



function prologo()
{
	openTable();
	scrivi("<table><center>\n");
}

function epilogo()
{scrivi("</center></table>"); // questa qua
 closeTable(); 
}


function creaAncora($nome)
{ // crea un'Ancora con il nome, eventualmente freccizzata.

 //freccizzaFrase(nome);
 return("<a name='$nome'>$nome</a>");

}

function linkamenu($nome)
{
 scrivi("- <a href=\"#".$nome."\">".$nome."</a><br>");
}




function scriviReport_Ordine($recSet)
{
echo("<h6>");
echo(getOrdineGraficoById($recSet["id_ord"],30));
echo("<a href='modifica_ordine.php?idord=".$recSet["id_ord"]."'>".$recSet["nome_veloce"]."</a> ("
	.$recSet["città"].")</h6>");
}





 $sql    = "SELECT  * from goliardi g, ordini o "
	  . " WHERE (g.nomegoliardico like '%" . $parole ."%' "
	  . " OR g.nomenobiliare like '%" . $parole."%' "
	  . " OR g.nome like '%" . $parole."%' "
	  . " OR g.cognome like '%" . $parole."%' )"
	  . " AND o.id_ord=g.id_ordine "
	  . " ORDER BY g.nomegoliardico";

// vengono usati dati (in RS) su goliardi e ordini...

// scrivib("aaa[$sql]<br>");
 $res = mysql_query($sql) 
	or die("erore sql: ".mysql_error());

 $foto="";
 $strFoto="";
// $NomeGolDoppio;

$MAXNUMERORECORDZ=8; // sarebbe 25, ma li devo contare


	scrivi("<center>");


if (FALSE)
{
	FANCYBEGIN("Il motorone di ricerca di $QGFDP");
?>	<big>In questa pagina troverete dei <i>match</i> tra la parola da voi digitata (<?php  echo $parole?>) 
	e varie informazioni del database (inserite soprattuto da VOI). Attenzione che ci sono
	novità. Scrollando la pagina, troverete informazioni su <b>goliardi</b>, <b>utenti</b>, 
	<b>messaggi</b>, <b>FAQ</b>, <b>ordini</b>.</big>
<?php  	  FANCYMIDDLE() ;	
	  linkamenu("goliardi");
	  linkamenu("utenti");
	  linkamenu("messaggi");
	  linkamenu("FAQ");
	  linkamenu("ordini");
	  FANCYEND();
}

scrivi("<table ><tr><td width='50%'  valign='top'>");


//openTable();


  

	scrivi(big(big("<h3>".creaAncora("goliardi")." con '<b>".$parole."</b>':</h3>")));

	prologo();
	$i=0;
	while ($recSet=mysql_fetch_array($res))
	   if($i++ < $MAXNUMERORECORDZ )
		{
		if (isdevelop()) echo rosso("in futuro usa il costrutto LIMIT A,B x proporre i campi seguenti!!!<br>");
		scriviReport_GoliardOrdine($recSet,$i % 2);
		}
	if ($i == 0) // nessun record scansionato, quindi roba vvuota
		scrivi("<h4>Nessun goliarda che matchi con i tuoi parametri di ricerca</h4>");

	/*
	if (mysql_num_rows($res)>$MAXNUMERORECORDZ) // ce n'erano ancora
		{
		 scrivi("<td><i>Attenzione! ce ne sono ancora (ne hai visti  $MAXNUMERORECORDZ/".mysql_num_rows($res)
			."), ma ho visualizzati solo i primi $MAXNUMERORECORDZ</i>!</td></td>");
		}
	*/
	epilogo();


echo("</td><td width='50%' valign='top'>");






#$tiporicerca=query("opzioni")

			// utenti

if ($ISPAL)
	$res=mysql_query("select * from loginz WHERE "
		." m_battivo = 1 AND "
		."(m_snome like '".$parole."%' "
		." OR m_hemail like '".$parole."%') "
		." ORDER BY m_snome");
#	$res=mysql_query("select * from loginz WHERE m_snome like '%".$parole."%' OR provincia like '%".$parole
#				."%' OR m_hemail like '%".$parole."%' order by m_snome");
   else	
	$res=mysql_query(
		"select * from loginz WHERE "
		." m_battivo = 1 AND "
		."(m_snome like '%".$parole."%' OR provincia like '%".$parole."%') "
		." ORDER BY m_snome");

scrivi(big(("<h3>".creaAncora("utenti")." contenenti '<b>".$parole."</b>':</h3>")));
$linkami=!$ISANONIMO;  //(getUtente()!=ANONIMO) || (String(recSet("pubblico")).toLowerCase()=="true")
prologo();
$i=0;
	while ($recSet=mysql_fetch_array($res))
	   if($i++ < $MAXNUMERORECORDZ ) 
		 scriviReport_Utente($recSet,1,1+($recSet["m_bIsMaschio"]==0));  
	if ($i == 0)
		scrivi("<h4>Nessun utente che matchi con i tuoi parametri di ricerca</h4>");

	if (mysql_num_rows($res)>$MAXNUMERORECORDZ) // ce n'erano ancora
		scrivi("<tr><td><i>Attenzione! ce ne sono ancora, ma ho visualizzati solo i primi ".$MAXNUMERORECORDZ."</i>!</td></td>");
	epilogo();



?>
</tr></td><tr valign=top><td>
<?php 




		// messaggi


$recSet=mysql_query("select * from messaggi m, loginz l WHERE m.id_login = l.id_login AND (m.titolo like '%".$parole."%' OR m.messaggio like '%".$parole."%') ORDER BY data_creazione DESC");

	 scrivi(big(big("<h3>".creaAncora("messaggi")." contenenti '<b>".$parole."</b>':</h3>")));
$EOF=EOF($recSet); #per ora! EOF($recSet);

if ($EOF) {
	scrivi("<h4>Nessun messaggio che matchi con i tuoi parametri di ricerca</h4>");
} else {
	$linkami=1; //	$linkami=(getUtente()!=ANONIMO) || (String(recSet("pubblico")).toLowerCase()=="true"); 
	prologo(); 
	#for ($i=0;$i<$MAXNUMERORECORDZ && (!$EOF  ); $i++)
	$i=0;
	while ($riga=mysql_fetch_array($recSet)) {
		trtd();
		$i++;
		if ($i >= $MAXNUMERORECORDZ) {
			debugga( "TROPPI MSGZ!!!!!!!");
			break;
		}
		debugga (": i=$i");
		scriviReport_Messaggio($riga,$linkami,0,$i%2); // condizione di stampaggio lungo
		trtdEnd();
	} 
	if (! EOF($recSet)) // ce n'erano ancora
		scrivi("<tr><td><i>Attenzione! ce ne sono ancora, ma ho visualizzati solo i primi ".$MAXNUMERORECORDZ."</i>!</td></td>");
	epilogo(); // questa qua
} 

tdtd();

  creaAncora("FAQ");

// scriviReport_FAQ

$recSet=mysql_query("select * from faq f WHERE (domanda like '%".$parole."%' OR risposta like '%".$parole."%') ORDER BY data DESC");

scrivi(big(big("<h3>".creaAncora("FAQ")." contenenti '<b>".$parole."</b>':</h3>")));
if (EOF($recSet)) {
	scrivi("<h4>Nessuna FAQ che matchi con i tuoi parametri di ricerca</h4>");
} else {
	prologo(); 
	#for ($i=0;$i<$MAXNUMERORECORDZ && (!recSet.EOF  );i++)
	while ($riga=mysql_fetch_array($recSet)) {	
		tri($i%2); scrivi("<td>");
		scriviReport_FAQ($riga,"breve");
		trtdEnd();
		#recSet.MoveNext();
	}
	#Use of undefined constant recSet - assumed 'recSet' in 
	#[Tue Jan 05 16:51:13.226120 2021] [:error] [pid 139] [client 172.17.0.1:43250] PHP Notice:  Use of undefined constant recSet - assumed 'recSet' in /var/www/www.goliardia.it/cerca.php on line 227, referer: http://localhost:8090/www.goliardia.it/mandafoto2021.php
	if (! EOF($recSet)) // ce n'erano ancora
		scrivi("<i>Attenzione! ce ne sono ancora, ma ho visualizzati solo i primi ".$MAXNUMERORECORDZ."</i>!<br>"); 
	epilogo();
}



tttt();

echo h1("le foto di utenti simili a $parole");

visualizzaThumbPaz($parole);

tdtd();


// ordini che matchano...
$qwertmp="select distinct * from ordini WHERE nome_veloce like '%".$parole."%' OR nome_completo like '%".$parole."%' OR sigla like '%".$parole."%' OR note like '%".$parole."%'";
$recSet=mysql_query($qwertmp);

//#$recSet=mysql_query("select distinct * from ordini WHERE nome_veloce like '%".$parole."%' OR nome_completo like '%".$parole."%' OR sigla like '%".$parole."%' OR note like '%".$parole."%'");

	#if ($ISPAL) {scrivi("query: $qwertmp");}	


	 scrivi(big(big("<h3>".creaAncora("ordini")." contenenti '<b>".$parole."</b>':</h3>")));

scrivi("TBDS");
scrivi("<i>Se conosci la città dell'ordine, ti consiglio di cliccare su 'città' e troverai tutti gli ordini esistenti... la funzionalità di ricerca verrà implementata quando qualcuno si degnerà di dare una mano ;)</i>");

/*
if (recSet.EOF)
	{scrivi("<h4>Nessun ordine che matchi con i tuoi parametri di ricerca</h4>");
	} else 
{
	prologo();

	for (i=0;i<$MAXNUMERORECORDZ && (!recSet.EOF  );i++)
	{
		 scriviReport_Ordine(recSet);
	// id_ord,nome_veloce,città from ordini

		recSet.MoveNext();
	}
	if (! recSet.EOF) // ce n'erano ancora
		scrivi("<i>Attenzione! ce ne sono ancora, ma ho visualizzati solo i primi ".$MAXNUMERORECORDZ."</i>!<br>");

	

	recSet.Close()
	epilogo()
}

*/




		/****	// Apparizioni goliardiche in FOTO

recSet=mysql_query("select distinct f.* from foto f,apparizioni_goliardi_in_foto a,goliardi g  WHERE a.id_gol=g.id_gol AND f.id_foto=a.id_foto AND (g.[nome goliardico] like '%".$parole."%' OR a.note like '%".$parole."%')");

	 scrivi(big(big("<h3>".creaAncora("Apparizioni_in_FOTO")." contenenti '<b>".$parole."</b>':</h3>")))

if (recSet.EOF)
	{scrivi("<h4>Nessuna FOTO che matchi con i tuoi parametri di ricerca</h4>");
	} else 
{
	prologo()

	for (i=0;i<$MAXNUMERORECORDZ && (!recSet.EOF  );i++)
	{
		scriviReport_FOTO($recSet);
		recSet.MoveNext();
	}
	if (! recSet.EOF) // ce n'erano ancora
		scrivi("<i>Attenzione! ce ne sono ancora, ma ho visualizzati solo i primi ".$MAXNUMERORECORDZ."</i>!<br>");

	

	recSet.Close()
	epilogo()
}

*/

trtdEnd();

//closeTable();
scrivi("</table>");

scrivi("</center>");




include "footer.php";
?>

