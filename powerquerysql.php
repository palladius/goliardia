<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


function formModificaRecord($tabella,$id) // tabella e id_valore
{
 global $ISPAL,$AUTOPAGINA;

 $res1=mq("select * from $tabella");
 $NOME_ID=mysql_field_name($res1,0);
 if ($ISPAL)
		{scrivib(rossone("ric, l'id si chiama: ".$NOME_ID));
		 if (substr(strtolower($NOME_ID),0,2) != "id")
			{scrivib("attenzione, NON èun id, ci metto gli apici!");
			 $id = "'$id'";
			}
		 scrivib(rossone("query: select * from $tabella WHERE `$NOME_ID`=$id"));
		}
	$res=mq("select * from $tabella WHERE `$NOME_ID`=$id");
	$rs=mysql_fetch_array($res);
	scrivi("<form name='edita_".$rs[0]."' action='$AUTOPAGINA' method='POST'>");
	 scriviRigaForm($res,$rs);
	 formhidden("hidden_1",46);
	 formhidden("hidden_tabella",$tabella);
	 formhidden("hidden_id_name",$NOME_ID);
	 formhidden("my_hidden_id",$rs[0]);
	 formbottoneinvia("manda");
	formend();
}



function scriviRigaForm($res,$rs)
{
 $nfieldz=mysql_num_fields($res);
 scrivi("<table  border=3><center>\n");
 scrivi("<tr><td>");
 $i="buh";
 $dato_i="bah";
 
 for ($i=1;$i<$nfieldz;$i++)
	{$dato_i= ($rs[$i]);
	 if (contiene($dato_i,"UTC")) //data
		 $dato_i=toHumanDate(($dato_i));
	 if (strlen($dato_i) > 30)
		{
		 $NRIGHE=intval(strlen($dato_i)/ 20);
		 formtextarea(mysql_field_name($res,$i),$dato_i,$NRIGHE,40);
		}
	   else
		formtext(mysql_field_name($res,$i),$dato_i);
	scrivi("</td></tr>\n<tr><td>");
	}
scrivi("</td>\n</tr>\n");
scrivi("</center></table>");
}



function accertaAdminQualunqueAltrimentiBona()
{
 global $GETUTENTE,$ISPAL;
 if (Session("admin")==1)
		{scrivi("<i>Lo sforzo è possente in te, ".$GETUTENTE."...<br></i>\n");
		 return;
		}
if($ISPAL)
		{
		 echo "<i>Lo sforzo è maledettamente possente in te, <b>Maestro</b>...<br></i>\n";
		 return;
		}
bona();
}


function scriviReportQuery($rs)
{
trtd();
 formquery("X","DELETE from query_notevoli where ID=".$rs["ID"]);


tdtd();
 formquery("M","SELECT * from query_notevoli where ID=".$rs["ID"]);
tdtd();
scrivib($rs["titolo"].": ");
tdtd();
scrivi($rs["data_creazione"]);
tdtd();
$x = strval($rs["encoded_query"]);
$y = unescape($x);
scrivi($y);
 formquery("EXE",$y);
tdtd();
scrivi($rs["note"]);
trtdEnd();
}


function scriviQueryNotevoli()
{
scrivi(h1("query Notevoli"));
openTable();
$res= mq("select * from query_notevoli order by data_creazione desc");
scrivi("<table width='500'>");
while ($rs=mysql_fetch_array($res))
	scriviReportQuery($rs);
closeTable();
}



# ?!?!?!?!?  tableEnd();

$Elaborazione=  (Form("hidden_1")=="42");

if ($Elaborazione)
	{
	//////////////////////////////////////////////
	// la pagina deve elaborare la query che ho in FORM e presentarla

	scrivi(decodifica(codifica("<h1>elab mode</h1>")));
	scrivi("<h3>(Son sempre io ma me ne sono accorto che mi son spedito dati da solo, sembro scemo m"
		."a fidatevi non lo sono, ora zitti che elaboro!)</h3>");
	accertaAdministratorAltrimentiBona();
	visualizzaFormz();
		// connetto al dibbì e faccio query che mi sono inviato tramite post
	$sql=stripslashes(Form("querysql")); // retrievo la query da qua...
	$res=mq($sql);
	scriviRecordSetConDelete($res,$sql);
	scrivi(rossone("sta query è una figata, salviamola!!!"));
	scrivi("un altro giorno metterai un'opzione che automaticamente trasforma, x esempio, tutt"
			."a la II colonna in text box da editare");
	scrivi("con un tasto submit x inserire in fretta e in modo automatico, x es, tutte le fot"
			."o o le email di tutti i torinesi di nome giulio...<br>");
	scrivi("un giorno metterai anche l'opzione di salvare/caricare il co"
			."dice sql nella tabella 'query notevoli'.");

	#scrivi("<form method='post' action='powerquerysql.php'>\n")
	formbegin();
	 scrivi("<br>\n<center>");
	 formtext("titolo","titolo");
	 scrivi("<br>\n<center>");
	 formtextarea("query",$sql,10,50);
	 invio();
	 formtextarea("note","note",10,50);
#	 scrivi("<br><input type=hidden name='hidden_1' value='43'>\n"); // 43 è la registrazione della query...
	 invio(); 
	 formhidden("hidden_1",43);
#	 scrivi("<input type='submit' value='invia query'>\n</form>\n");
	 formbottoneinvia("invia query");
	formend();
	}
else
if ( (Form("hidden_1")=="43"))
{
	//////////////////////////////////////////////
	// la pagina mi è arrivato via post il dato da salvare come query notevole

	scrivi("<h1>registra query notevole (43)</h1>");
	accertaAdministratorAltrimentiBona();
	if (! $DEBUG) 
		visualizzaFormz();

	$b=dammiDataMysql(); // va messa nella query

	//template	sql="insert into query_notevoly (titolo,data_creazione,note,query) values ('a','b','c','d')"

	$a=Form("titolo");
	$c=Form("note");
	$d=escape(Form("query")); // la ancodo con i %20 così non rompono i coglioni gli apostrofi eccetera...
	$sql = "insert into query_notevoli (`titolo`,`data_creazione`,`note`,`encoded_query`) "
		."values ('".$a."','".$b."','".$c."','".$d."')";

	scrivib(rosso("sql di inserimento query notevoli vale, x ora: ".$sql));
	if ($a == "")
		scrivib(rosso("Attenzione! stavo x inserire una query notevole IDIOTA :("));
	else
		mq($sql); // faccio la query e del recordset me ne sbatto (è una insert!!!)
}
else
if ( (Form("hidden_1")=="44"))	// CANCELLA 
{
	//////////////////////////////////////////////
	// la pagina mi è arrivato via post il dato da CANCELLARE

	scrivi("<h1>cancella un id da una tabella  (44)</h1>");
	autoCancellaTabella(Form("tabella"),Form("my_hidden_val")) ;
	accertaAdministratorAltrimentiBona();
	if (!$DEBUG) 
		visualizzaFormz();
	$b=dammiDataMysql(); // va messa nella query
	$a=Form("titolo");
	$c=Form("note");
	$d=escape(Form("query")); // la ancodo con i %20 così non rompono i coglioni gli apostrofi eccetera...
	$sql = "insert into query_notevoli (titolo,data_creazione,note,encoded_query) valu"
			."es ('".$a."','".$b."','".$c."','".$d."')";
	if ($ISPAL)
		scrivib(rosso("sql x ora: [$sql]"));
	if ($a!="" && $d != "")
		mq($sql); // faccio la query e del recordset me ne sbatto (è una insert!!!)
	else
		scrivib(rosso("NON inserisco la query tra le query notevoli: titolo o query son vuote, scemo!!!"));
	hline(100);
}
else
if ( (Form("hidden_1")=="45")) // MODIFICA
{
	//////////////////////////////////////////////
	// la pagina mi è arrivato via post il dato da EDITARE
	scrivi("<h1>EDITA l'id da una tabella  (45)</h1>");
	accertaAdminQualunqueAltrimentiBona(); // anche gli altri admin...
	formModificaRecord(Form("tabella"),Form("my_hidden_val")); // tabella e id_valore
	hline(100);
	bona();
}
else
if ( (Form("hidden_1")=="46"))
{
	//////////////////////////////////////////////
	// la pagina mi è arrivato via post il dato già EDITATO, ora devo solo sqlarlo su server
	scrivi("<h1>AGGIORNO IL DIBBI' coi dati (46)</h1>");
	accertaAdminQualunqueAltrimentiBona();
	autoAggiornaTabella(Form("hidden_tabella"),Form("hidden_id_name")) ;
	hline(100);
	bona();
}

// sta parentesi graffa che cazzo ci sta a fare?!?
	{
	//////////////////////////////////////////////
	// la pagina deve fare il formino xchè qualcuno scriva la query e la spedisca a se stessa via POST

accertaAdministratorAltrimentiBona();
scrivi("<h1>request mode</h1>");

scrivi(rosso("<br>UPDATE: ").("UPDATE goliardi SET campo = 'valore', campo2 = 'valore2' where ID='42'"));
scrivi(rosso("<br>INSERT: ").("INSERT INTO query_notevoly (titolo,data_creazione,note,query) VALUES ('a','b','c','d')"));
scrivi(rosso("<br>DELETE: ").("DELETE FROM goliardi where ID_GOL=2"));
scrivi(rosso("<br>CREATE TABLE!!!: "));

?>
	CREATE TABLE Canzoni2
	(
	 [ID_canzone] integer,
	 [titolo] text,
	 [id_login] long ,
	 [Data_creazione] date,
	 [Autore] text,
	 [m_bSeria] yesno,
	 [Corpo] memo,
	 [Note] memo,
	 CONSTRAINT [Indice1] PRIMARY KEY ([ID_canzone])
	);


<i>(del cotraint non ne son sicurissimo x quel che concerne mysql...)</i>

<?php 

#scrivi("<form method='post' action='powerquerysql.php'>\n")
formbegin();
#scrivi("<textarea name='querysql' rows=10 cols=40 value='value'>SELECT * \n FR"
#	."OM loginz\n WHERE m_snome like '%%'</textarea>");
formtextarea("querysql"," SELECT * \n FROM loginz\n WHERE m_snome like '%%'",10,40);
#scrivi("<br><input type=hidden name='hidden_1' value='42'>\n");
invio();
formhidden("hidden_1",42);
#scrivi("<input type='submit' value='invia query'>\n</form>\n");
formbottoneinvia("invia query");
formend();

if ((QueryString("querynotevoli")) != "")
		scriviQueryNotevoli();
	else 
		scrivi(h1("<a href='".$AUTOPAGINA."?querynotevoli=masidai'>Query notevoli</a>"));
	}
?>


mettere casomai l'implementazione dei goliard_pointz e vedi il goliarda + fico:
69 pti capo citta




23 capo ordine
15 nobile
2 saio

HC di ordine sovrano 10 pti

HC di ordine vassallo 8 pti


con la classifica, e i cannonieri ...
e i + pataccari...

:-)



<?php 
include "footer.php";
?>
