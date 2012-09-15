<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

function scriviFormattazioneCarina($rs1)
{
$storia=$rs1;
if (empty($storia ))
	scrivi("<i><big>non disponibile</big></i>");
else
	scrivi("<i><big>".$storia."</big></i>");
}

function titolozzoAncorato($ancora)
{global $fileimmaginetn;
scrivi("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));
scrivi(" ".ancora($ancora).":</h2>");

}


function scriviLinkOrdine($rs)
{
global $fileimmaginetn;

echo("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));
scrivi(" ".("Linkz correlati").":</h2>");
openTable2();
scrivi("<center><a href='".$rs["URLlink"]."'>".$rs["URLlink"]."</a><br> ".$rs["Descrizione"]."</center><br>");
closeTable2();
}


$cancord=QueryString("cancord");
if ($cancord != "")
	{
	scrivi("si sta cercando di cancellare l'ordine numero ".$cancord);
	if (!isAdminVip()) 
		bona();
	echo rossone("Potresti ma... non me la sento. metto poi un check x vedere che si possa davvero (non esistano cariche, nomine, goliardi con quell'ordine, ....");
	bona();
	mq("delete from ORDINI where id_ord=".$cancord);
	scrivi("ordine cancellato, suppongo");
	bona();
	}


$hoDiritti=FALSE;
$idord=QueryString("idord"); 
$tmp=Form("idord"); 
if ($tmp != "")
	$idord=$tmp;
if ($idord=="")
	{
	scrivi(rossone("mi aspetto l'id di un ordine: dammene uno!!!"));
	bona();
	}
$hoDiritti=utenteHaDirittoScritturaSuOrdineById($idord);
scrivi("<center>[ "
#		."<a href='#storia'>storia</a> | "
		.linkancora("cariche")." | "
		.linkancora("Attivi (new!)")." | "
#		.linkancora("Altro sull'ordine")." | "
		.linkancora("varie")." | ".linkancora("Albo d'Oro")
		." | ".linkancora("H.C.")." | ".linkancora("Iscritti")." | ".linkancora("Ulteriori afferenti")." ]");

$sql="select * from ordini where id_ord=".($idord);
$res=mq($sql); // nome ordine
$rs=mysql_fetch_array($res);
if ($hoDiritti)
	{invio();
	 openTable();
	 scrivi("<h2>ADMIN ONLY</h2><br/>- <a href='cambia_ordine.php?idord=".$idord."'>MODIFICA L'ORDINE</a> (storia,note,nome,...)");
	 invio();
	if (isAdminVip())
		{
		// 	scrivi("- <a href='fotografia_ordine.php?idord=".$idord."'>FOTOGRAFA L'ORDINE</a> (fa vedere chi c'è"
		//	." nell'ordine attualmente, e in futuro anche parametrico in DATA...figata!)<br/>");
	 	scrivi("- <a href='".$AUTOPAGINA."?cancord=".$idord."'>CANCELLA L'ORDINE</a> (funziona solo "
		."se non vi sono cariche/nomine associate O ALMENO SPERO CON MYSQL!)<br/>");
		}
	 closeTable();
	}




$nome=($rs["Nome_completo"]);
if (empty($nome))
	$nome=$rs["nome_veloce"];


	////////////////////////////////////////
	// dati sull'ordine


scrivi("<table ><tr><td width='20%'>");
scrivi(getTagFotoOrdineGestisceNull($rs["m_fileImmagine"]));
tdtd();
echo h1("$nome</center>");
trtdEnd();
tableEnd();



$fileimmaginetn=$rs["m_fileImmagineTn"];


	// attivi (novita 23007)
scrivi("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));
scrivi(" ".ancora("Attivi (new!)").":</h2>");
scrivi("  <blockquote>\n");
 $sql    = "select * from goliardi g, ordini o,nomine n,cariche c"
          . " WHERE c.id_ordine=".$idord." "
          . " AND o.id_ord=g.id_ordine "
          . " AND n.id_goliarda=g.id_gol "
          . " AND n.id_carica=c.id_carica "
          . " AND c.hc=0  "
          . " AND n.m_bAttiva=1  "
          #. " ORDER BY g.nomegoliardico";
          . " ORDER BY c.m_nImportanza DESC";

$resrecSet=mq($sql);

scrivi("<center><table border=2>");
while($recSet=mysql_fetch_array($resrecSet))
        {$ii=1-$ii;
         scriviReport_GoliardOrdine($recSet,$ii);
        }
scrivi("</table></center>");

scrivi("  </blockquote>\n");
scrivi("<br>\n");




	// varie info

scrivi("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));
scrivi(" ".ancora("varie").":</h2>");
scrivi("  <blockquote>\n");

$sqlGestori=mq("select g.id_gest_ordini,l.m_snome from loginz l, gestione_ordini g where l.id_login"
		."=g.id_login AND g.id_ordine=".$idord);
openTable();
echo "<center><table border=0 width='100%'><tr><td width='50%'>";
# scriviCoppia("Utenti che lo gestiscono","ecco");
 echo "Utenti che lo gestiscono: <b>";
 scriviRecordSetConVirgoleGestori($sqlGestori);
 echo "</b><br>";
 scriviCoppia("sigla",$rs["Sigla"]);
 scriviCoppia("Nome sbrigativo",$rs["Nome_veloce"]);
 scriviCoppia("Nome Lungo",$rs["Nome_completo"]);
 scriviCoppia("Tipo Ordine",($rs["m_bSerio"] ? "serio" : "pacco"));
 scriviCoppia("Storia dell'Ordine",stripslashes($rs["storia"]));
echo("</td><td width='50%'>");
 scriviCoppia("Motto",stripslashes($rs["Motto"]));
 scriviCoppia("Città",$rs["Città"]);
 scriviCoppia("ultime modifiche",dammidatamysql(time($rs["data_creazione"])));
 scriviCoppia("data di nascita",dammidatamysql(($rs["datadinascita"])));
 scriviCoppia("Altro sull'Ordine",stripslashes($rs["note"]));
 scriviCoppia("Indirizzo ufficiale (per inviti cartacei)",stripslashes($rs["indirizzo"]));
 scriviCoppia("Email ufficiale (per inviti elettronici)",stripslashes($rs["emailordine"]));
echo "</td></tr></table>";
closeTable();

scrivi("  </blockquote>\n");
scrivi("<br>\n");

$resLink=mq("select * from linkz where tipo='ordini' and id_oggettopuntato=".$idord);
$rsLink=mysql_fetch_array($resLink);
if ($rsLink)
	scriviLinkOrdine($rsLink);




			// storia

/*
openTable();
echo "<table border='0' width='100%'><tr><td width='50%' valign='top'>";
scrivi("<h2>");
scrivi(getTagFotoOrdineTnGestisceNull($fileimmaginetn));
scrivi("<a name='storia'> Storia dell'Ordine</a>:</h2>\n<blockquote>\n"); 
scriviFormattazioneCarina(snulla(stripslashes($rs["storia"])));
tdtd();

			// ALTRO SULL'ORDINE
		titolozzoAncorato("Altro sull'ordine");

$storia=$rs["note"];
if (empty($storia))
	$noteStr=("<i><big>non disponibile</big></i>");
else
	$noteStr=("<i><big>\"".snulla(stripslashes($storia))."\"</big></i>");
scrivi("  <blockquote>\n");
  scriviFormattazioneCarina(stripslashes($noteStr));
scrivi("  </blockquote>\n");
scrivi("<br>\n");
echo "</td></tr></table>";
closeTable();
*/









hline(80);




scrivi("  </blockquote>\n");





	titolozzoAncorato("cariche");



scrivi("  <blockquote>\n");

$inizio="<tr border='1'><td border='1'>";
$mezzo="</td><td border='1'>";
$fine="</td></tr>";

tabled();

	// prima riga di modifica
scrivi($inizio);

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
	case 0:	$clausola_i="AND attiva=1 AND HC=0";
					scrivi("<h3>Attive</h3>");
					break;
	case 1:	$clausola_i="AND attiva=0 AND HC=0";
					scrivi("<h3>Onori<b>fiche</b></h3>");
					break;
	case 2:	$clausola_i="AND HC=1";
					scrivi("<h3>H.C.</h3>");
					break;
	default:	$clausola_i="cosa te ne frega";
}

scrivi($mezzo);

$sql="SELECT * from cariche WHERE id_ordine=".$idord." AND id_car_STASOTTOA=-1 " ; 
		// tutto ciò cher mi serve tranne la sottpopostanza
if ($i<3)
	$res=mq($sql.$clausola_i); // nome ordine
else 
	{// cero gli spuri quelli figli di B con B inesistente, cariche orfane
	 if (isdevelop()) echo rosso("aggiungi la query che ora è innestata!");
	#	 $sql = "SELECT * FROM cariche WHERE id_ordine=".$idord." AND id_car_stasottoa<>-1 ";
		#. "AND  id_car_stasottoa not in (select id_carica from cariche)";
	#	 $res=mq($sql); // nome ordine
	}
//$rs=mysql_fetch_array($res);

if (mysql_num_rows($res) == 0)
	{if ($i<3) 
		scrivi(rosso("<center><h4>Nessuna carica disponibile</h4></center>"));
	}
#else 
#	if ($i==3) // caso ORFANE
#		{scrivi("<h3>".corsivoBluHtml("Orfane")."</h3>");
#		scrivib(corsivoBluHtml("Attenzione, questo si verifica quando in una gerarchia A>B>C>D>E"
#			." x esempio uccidi la B e la C (solo lei) rimane orfana del papà."
#			." Ciò è possibile xchè io non controllo l'integrità referenziale del puntatore (x "
#			."ottimi motivi) quindi a differenza di altre cose "
#	 		. "qua è possibile quest'incoerenza. Sta a te che hai fatto la cazzata di spezzare la"
#			. " gerarchia fere le giuste modifiche x togliere questo"
#	 		. " messaggio. Se ti becco io, at fag un cul acsì, che vuol dire che ti aumento di uno l'escazzo. :-)"));
#		}
							/////////////////////////////////
							// discesa ricorsiva dell'albero
reportRicorsivoCariche($idord,$res,$hoDiritti);
scrivi($fine);
}
tableend();
scrivi("  </blockquote>\n");
hline(80);

if (isAdminVip())
{
scrivi("<h1>solo x AdminVip:</h1>Guardate se ci sono cariche in quest'elenco che non corrispondono UNO a"
		." UNO con le cariche tutte belle impaginate: nel caso è un grosso problema: riferitemelo.");
$sql=mq("SELECT * from cariche WHERE id_ordine=".$idord);
scriviRecordSetcontimeout($sql,10);
$seql=mq("SELECT id_carica,c.*,o.nome_completo from cariche c,ordini o WHERE o.id_ord=c.id_ordine "
	 ."AND ID_CARICA=ID_CAR_staSottoA");
$sql=mysql_fetch_array($seql);
if ($sql)
	{
	hline(80);
	scrivi("<h2>Peggio ancora - e so che non è vuoto ;)</h2>Ordini con cariche che stan sotto a se stesse "
		."(chi sa un po' di informatuica, sa che la ricerca ricorsica in tale albero lo 'visualizza' come"
		." infinito, quindi vanno EVITATE!");
	scriviRecordSetConDelete($sql);
	}
}


titolozzoAncorato("Albo d'Oro");

$sql    = "select * from goliardi g, ordini o,nomine n,cariche c"
	  . " WHERE c.id_ordine=".$idord." "
	  . " AND o.id_ord=g.id_ordine "
	  . " AND n.id_goliarda=g.id_gol "
	  . " AND n.id_carica=c.id_carica "
	  . " AND c.hc=0"
	  . " AND c.attiva=1 "
	  . " AND (c.dignità='capoordine' OR c.dignità='capocittà')"
	  . " ORDER BY n.eventuale_numero_progressivo,n.data_nomina";

$resrecSet=mq($sql);
scrivi("<center><table border=2>");
$ii=0;
while($recSet=mysql_fetch_array($resrecSet))
	{

	 $ii=1-$ii;
	 scriviReport_GoliardAlboDoro($recSet,$ii);
	}
scrivi("</table></center>");


		titolozzoAncorato("H.C.");


 $sql    = "select * from goliardi g, ordini o,nomine n,cariche c"
	  . " WHERE c.id_ordine=".$idord." "
	  . " AND o.id_ord=g.id_ordine "
	  . " AND n.id_goliarda=g.id_gol "
	  . " AND n.id_carica=c.id_carica "
	  . " AND c.hc=1  "
	  . " ORDER BY g.nomegoliardico";

$resrecSet=mq($sql);

scrivi("<center><table border=2>");
while($recSet=mysql_fetch_array($resrecSet))
	{$ii=1-$ii;
	 scriviReport_GoliardOrdine($recSet,$ii);
	}
scrivi("</table></center>");


		titolozzoAncorato("Iscritti");



 $sql    = "select distinct g.*, o.m_fileImmagine,o.m_fileImmagineTn, o.nome_v"
	  . "eloce,o.ID_ORD from goliardi g, ordini o "
	  . " WHERE o.id_ord=".$idord." "
	  . " AND o.id_ord=g.id_ordine "
	  . " ORDER BY g.nomegoliardico";
$resrecSet=mq($sql);
scrivi("<center><table border=2>");
while($recSet=mysql_fetch_array($resrecSet))
	{$ii=1-$ii;
	 scriviReport_GoliardOrdine($recSet,$ii);
	}
scrivi("</table></center>");



		titolozzoAncorato("Ulteriori afferenti");

#scrivi(" ".$ancora("Ulteriori afferenti").":</h2><i>(qui vi sono tutti quei goliardi"
#		." con nomine attive nell'ordine ma non nati qui, per esempio chi lo ha cambiato"
#		." lungo il suo cammino.)</i><br><br>");

 $sql    = "select distinct g.*,o_nascita.m_fileImmagineTn,o_nascita.nome_veloce,o_nascita.ID_ORD "
	  . "from goliardi g, ordini o_nascita, nomine n, cariche c "
	  . " WHERE c.id_ordine=".$idord." " // ordine di nomina/carica
	  . " AND n.id_carica=c.id_carica "
	  . " AND n.id_goliarda=g.id_gol "
	  . " AND c.id_ordine<>g.id_ordine "
	  . " AND c.attiva=1"
	  . " AND c.hc=0"
	  . " AND o_nascita.id_ord=g.id_ordine "
	  . " ORDER BY g.nomegoliardico";

$ResRecSet=mq($sql);

scrivi("<center><table border=2>");
while($recSet=mysql_fetch_array($ResRecSet))
	{	
	$ii=1-$ii;
	scriviReport_GoliardOrdine($recSet,$ii);
	}
scrivi("</table></center>");

/*
devi mettere una cosa che si accorge se hai potere di modifica o meno.<br>
l'insegna dell'ordine e i suoi dati.
3 link x 3 sottopagine che ti palleggi via POST o QUERYSTRING con ATTIVI VECCHI e HC...
*/

?>










<?php 
include "footer.php";
?>
