<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$hoDiritti=FALSE;
$idord=QueryString("idord");

$tmp=Form("idord");
if (!empty($tmp)) $idord=$tmp;

	// AGGIORNAMENTO VIA FORM

$operazione=Form("hidden_op");
if ($operazione=="AGGIORNA_ORDINE") {
	// faccio la query d'inserimento
	autoAggiornaTabella("ordini","id_ord") ;
	#$DEBUG=1;
	log2("[cambia_ordine.php] cambio ordine id=".Form("my_hidden_id")." (nomeveloce='".Form("nome_veloce")."')","pannello.log.php"); 
	bona();
	}

	// CONTROLLO DI AVERE UN ORDINE..
if (empty($idord)) {
	 scrivi(rossone("mi aspetto l'id di un ordine: dammene uno!!!"));
	 bona();
	}



$hoDiritti=utenteHaDirittoScritturaSuOrdineById($idord);
//echo "diritti=$hoDiritti,idord=$idord";

$sql="select id_ord,nome_completo,nome_veloce,sigla,città,motto,datadinascita,m_fileImmagine,m_fileImmagineTn,note,storia,m_bSerio,m_bInSonno,indirizzo,emailordine  ,m_nPrecedenzaCittadina FROM ordini where id_ord=".$idord;
$res=mq($sql); // nome ordine
$rs=mysql_fetch_array($res);

$nome=($rs["nomecompleto"]);
if (empty($nome))
	$nome=$rs["nome_veloce"];

formBegin();
scrivi("<center><table width='90%'>");
trtd();
formtext("nome_veloce",$rs["nome_veloce"]);
invio();
formtext("nome_completo",$rs["nome_completo"]);
invio();
formtext("sigla",$rs["sigla"]);
invio();
popolaComboCitta("città",$rs["città"]);
invio();
formtext("motto",stripslashes($rs["motto"]));
invio();
formtext("m_nPrecedenzaCittadina",stripslashes($rs["m_nPrecedenzaCittadina"]));
echo rosso("Questo campo strano serve a soddisfare Babbo Moscatelli. E' un numero invisibile grazie al quale gli ordini vengono ordinati (in senso crescente) nella tabella delle <a href='citta.php'>citta'</a>. Se li lasciate tutti a ZERO l'ordine e' alfabetico, se volete forzarne uno in su o in giu cambiategli il valore (valori bassi hanno maggiore priorita'). Il valor medio e' zero.");
invio();
formtext("datadinascita",dammidatamysql(($rs["datadinascita"])));
tdtd();
formtext("emailordine",$rs["emailordine"]);
tdtd();
formtext("m_fileImmagine",$rs["m_fileImmagine"]);
invio();
formtext("m_fileImmagineTn",$rs["m_fileImmagineTn"]);
invio();
formtextarea("indirizzo",$rs["indirizzo"],10,30);
tttt();
formtextarea("note",stripslashes($rs["note"]),10,30);
tdtd();
formtextarea("storia",stripslashes($rs["storia"]),10,30);
tttt();
formSceltaTrueFalse("m_bInSonno","In Sonno",($rs["m_bInSonno"]));
tdtd();
formSceltaTrueFalse("m_bserio","Serio",($rs["m_bSerio"]));
tdtd();
scrivii("<i>Se sì, l'ordine è serio. Se NO, l'ordine è pacco. NON barate su questo o vi punirò pesantemente</i>");
	# if ($ISPAL) scrivi(rosso("(serio vale: ".($rs["m_bSerio"]).")"));
trtdEnd();

tableEnd();
invio();
formhidden("id_utente_creatore",getIdLogin());
formhidden("hidden_tornaindietroapagina","modifica_ordine.php?idord=".$rs["id_ord"]);
formhidden("data_creazione",dammiDatamysql());
formhidden("hidden_op","AGGIORNA_ORDINE");
formhidden("my_hidden_id",$rs["id_ord"]);  	// eran cazzate le 2 precedenti ;)

formbottoneinvia("ok");
formEnd();





bona();

/*
	////////////////////////////////////////
	// dati sull'ordine


scrivi("<table ><tr><td width='20%'>");
scrivi(getTagFotoOrdineGestisceNull($rs["m_fileimmagine"]));
tdtd();
scrivi("<h1>");
scrivi(nome);
scrivi("</center></h1>");
trtdEnd();
tableEnd();


scrivi("<h2>");
$fileimmaginetn=String($rs["m_fileimmaginetn"]);
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));


	// storia
scrivi("<a name='storia'> Storia dell'Ordine</a>:</h2>\n<blockquote>\n"); // inizia un paragrafo indentato a dx
$storia=$rs["storia"];
if (empty($storia ))
	scrivi("<i><big>non disponibile</big></i>");
else
	scrivi("<i><big>".$storia."</big></i>");

hline(80);

scrivi("  </blockquote>\n");

$storia=$rs["note"];
if (empty($storia ))
	$noteStr=("<i><big>non disponibile</big></i>");
else
	$noteStr=("<i><big>\"".$storia."\"</big></i>");


scrivi("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($rs["m_fileimmaginetn"]));
scrivi(" ".$ancora("cariche").":</h2>");

scrivi("  <blockquote>\n");

$inizio="<tr><td>";
$mezzo="</td><td>";
$fine="</td></tr>";



scrivi("<table border=3>");

	// prima riga di modifica
scrivi(inizio);

if ($hoDiritti)
	{
	scrivi("</td><td><a href='modifica_carica.php?AGGIUNGI_NON_MODIF_MA_ORD_VALE=".$idord."'>");
	scrivi("<big>Aggiungi una nuova carica</big></a><br>");
	}
scrivi($mezzo);
scrivi($fine);


for ($i=0;$i<4;$i++)
{
scrivi($inizio);
switch ($i)
{
	case 0:	clausola_i="AND attiva=true AND HC=false";
					scrivi("<h3>Attive</h3>");
					break;
	case 1:	clausola_i="AND attiva=false AND HC=false";
					scrivi("<h3>Onori<b>fiche</b></h3>");
					break;
	case 2:	clausola_i="AND HC=true"
					scrivi("<h3>H.C.</h3>");

					break;
	default:	calausola_i="cosa te ne frega";
}

scrivi(mezzo);

sql="SELECT * from CARICHE WHERE id_ordine=".$idord." AND id_car_STASOTTOA=-1 " ; // tutto ciò cher mi serve tranne la sottpopostanza
if (i<3)
	rs=getRecordSetByQuery(sql+clausola_i) // nome ordine
else 
	{// cero gli spuri quelli figli di B con B inesistente
//	sql="SELECT c1.* FROM cariche c1,cariche c2 WHERE c1.id_car_stasottoa not in c2.id_carica"
	sql="SELECT * FROM cariche WHERE id_ordine=".$idord." AND id_car_stasottoa<>-1 AND "
	. " id_car_stasottoa not in (select id_carica from cariche)"
//SELECT c1.* FROM cariche AS c1
//WHERE c1.id_car_stasottoa not in (select id_carica from cariche);


	rs=getRecordSetByQuery(sql) // nome ordine

	}

if (rs.EOF)
	{if (i<3) scrivi(rosso("<center><h4>Nessuna carica disponibile</h4></center>"))}
else 
if (i==3) // caso ORFANE
{scrivi("<h3>".$corsivoBluHtml("Orfane")."</h3>")

scrivib(corsivoBluHtml("Attenzione, questo si verifica quando in una gerarchia A>B>C>D>E x esempio uccidi la B e la C (solo lei) rimane orfana del papà.".$
	  " Ciò è possibile xchè io non controllo l'integrità referenziale del puntatore (x ottimi motivi) quindi a differenza di altre cose ".$
	  "qua è possibile quest'incoerenza. Sta a te che hai fatto la cazzata di spezzare la gerarchia fere le giuste modifiche x togliere questo".$
	  " messaggio. Se ti becco io, at fag un cul acsì, che vuol dire che ti aumento di uno l'escazzo. :-)"))

}
$sql2,rs2


	/////////////////////////////////
	// discesa ricorsiva dell'albero

reportRicorsivoCariche(idord,rs,hoDiritti)


scrivi(fine);

}

scrivi("</table>")



scrivi("  </blockquote>\n")

hline(80)



scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("Altro sull'ordine").":</h2>");

scrivi("  <blockquote>\n")
scrivi(noteStr);
scrivi("  </blockquote>\n")
scrivi("<br>\n")
hline(80)

scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("utenti che lo gestiscono")." (e relative mail):</h2>");

scrivi("  <blockquote>\n")
$sqlGestori=getRecordSetByQuery("select l.m_snome,l.m_hemail from loginz l, gestione_ordini g where l.id_login=g.id_login AND g.id_ordine=".$idord);
scriviRecordSet(sqlGestori);
scrivi("  </blockquote>\n")
scrivi("<br>\n")


hline(80)

scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("Albo d'Oro").":</h2>");

 $sql    = "select * from goliardi g, ordini o,nomine n,cariche c"
	  . " WHERE c.id_ordine=".$idord." ";
	  . " AND o.id_ord=g.id_ordine ";
	  . " AND n.id_goliarda=g.id_gol ";
	  . " AND n.id_carica=c.id_carica ";
	  . " AND c.hc=false";
	  . " AND c.attiva=true ";
	  . " AND (c.dignità='capoordine' OR c.dignità='capocittà')";
	  . " ORDER BY n.eventuale_numero_progressivo,n.[data_nomina]";

recSet=getRecordSetByQuery(sql)

scrivi("<center><table border=2>")
while(! recSet.EOF)
		scriviReport_GoliardAlboDoro(recSet)
scrivi("</table></center>")


scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("H.C.").":</h2>");

 $sql    = "select * from goliardi g, ordini o,nomine n,cariche c"
	  . " WHERE c.id_ordine=".$idord." ";
	  . " AND o.id_ord=g.id_ordine ";
	  . " AND n.id_goliarda=g.id_gol ";
	  . " AND n.id_carica=c.id_carica ";
	  . " AND c.hc=true ";
	  . " ORDER BY g.[nome goliardico]";

recSet=getRecordSetByQuery(sql)

scrivi("<center><table border=2>")
while(! recSet.EOF)
		scriviReport_GoliardOrdine(recSet)
scrivi("</table></center>")



scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("Iscritti").":</h2>");

 sql    = "select distinct g.*, o.m_fileimmagine,o.m_fileimmaginetn, o.nome_veloce,o.id_ord from goliardi g, ordini o "
	  . " WHERE o.id_ord=".$idord." "
	  . " AND o.id_ord=g.id_ordine "
	  . " ORDER BY g.nomegoliardico";

recSet=getRecordSetByQuery(sql)

scrivi("<center><table border=2>")
while(! recSet.EOF)

		scriviReport_GoliardOrdine(recSet)
scrivi("</table></center>")



scrivi("<h2>")
scrivi(getTagFotoOrdineTnGestisceNull(fileimmaginetn));
scrivi(" ".$ancora("Ulteriori afferenti").":</h2><i>(qui vi sono tutti quei goliardi con nomine attive nell'ordine ma non nati qui, per esempio chi lo ha cambiato lungo il suo cammino.)</i><br><br>");

 $sql    = "select distinct g.*,o_nascita.m_fileimmaginetn,o_nascita.nome_veloce,o_nascita.id_ord from goliardi g, ordini o_nascita, nomine n, cariche c "
	  . " WHERE c.id_ordine=".$idord." " // ordine di nomina/carica
	  . " AND n.id_carica=c.id_carica "
	  . " AND n.id_goliarda=g.id_gol "
	  . " AND c.id_ordine<>g.id_ordine "
	  . " AND c.attiva=true"
	  . " AND c.hc=false"
	  . " AND o_nascita.id_ord=g.id_ordine "
	  . " ORDER BY g.[nome goliardico]";

recSet=getRecordSetByQuery(sql)

scrivi("<center><table border=2>")
while(! recSet.EOF)
		scriviReport_GoliardOrdine(recSet)

scrivi("</table></center>")


%>






Devi mettere una cosa che si accorge se hai potere di modifica o meno l'insegna dell'ordine e i suoi dati.  3 link x 3 sottopagine che ti palleggi via POST o QUERYSTRING con ATTIVI VECCHI e HC...

<?php 
*/
  include "header.php";
?>
