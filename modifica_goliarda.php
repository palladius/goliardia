<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$MIVOGLIOREGISTRARE =  (Form("hidden_mivoglioregistrare"))=="davvero"; // se vero

/////////////////////////////////////////////////////////////////////////////////////////////////////////
// qua gestisco la gente che ha premuto registra. chiamo una f di debug che stampa TUTTE le form che mi sono arrivate!

$eventualeMsgConferma=QueryString("MSG");
$s=strtolower($eventualeMsgConferma);

$idgoliardico= QueryString("idgol");

if ($MIVOGLIOREGISTRARE)
	{scrivid(rosso("ah, vorresti registrare i dati? vediamo...<br>"));
	 autoAggiornaTabella("goliardi","id_gol"); 
	 bona();
	}

if (empty($idgoliardico))
	{
	scrivi(rossone("come puoi pensare di editare un goliarda senza darmi il suo id tramite QueryString? Sei matto?!?"));
	bona();
	}

$dirittiScrittura=utenteHaDirittoScritturaSuGoliardaById($idgoliardico);

if (! $dirittiScrittura)
	{scrivi(rossone("Non hai diritti su questo goliarda... caro mio ti dovrei bandire x questo e-affronto!"));
	 bona();
	}


if ($s=="ok")
	{scrivi(rossone("Modifica effettuata!!!<br>"));
	 scrivi("Dovresti anche aggiornare la data di LAST MODIFIED... ricorda caro Ric!<br>");	
	}

 $nickname=$GETUTENTE;
 $nickVero = $GETUTENTE;


 if (empty($nickVero))
	{
	$str=("Mi spiace, sei un anonimo e x entrare in"
		." sta pagina devi essere loggato (leggi le <a href='fuck.php'>FUCK</a>)... Cambia utente!");
	scrivi($str);
	bona();
	}



 $sql    = "select * from goliardi WHERE id_gol=".$idgoliardico;


 $resSet = mysql_query($sql)
	or sqlerror($sql);


 if (mysql_num_rows($resSet)==0)
	{$errore="Utente non trovato! Dillo al webmaster x favore!";
	 scrivi($errore);
	 bona();
	}
 else
	{ 
	$recSet=mysql_fetch_array($resSet);
	$NOMONE=rs_goliardi_getNomeGoliardicoCompleto($recSet);
	scrivi("<center><h3>Pagina di modifica di <u>".$NOMONE."</u>  ");
	scrivi("</h3></center>\n");
 	scrivi("<big><a href=\"pag_goliarda.php?idgol=".$recSet["ID_GOL"]."\">Torna alla pagina di <i>".$recSet["Nomegoliardico"]."</i></a></big><br><br>");
 	scrivi("<table  border=3><center>\n<tr>\n  <td>");
	}
formBegin();
scrivi("\n<center>\n");
scrivib("<h2>Estremi anagrafici</h2>");
formhidden("hidden_tornaindietroapagina",$AUTOPAGINA."?idgol=".$recSet["ID_GOL"]);
formhidden("my_hidden_id",$recSet["ID_GOL"]);
formhidden("hidden_mivoglioregistrare","davvero");
formhidden("dataiscrizione",dammiDataMysql());
scrivi("<table border=1><tr><td><div align=right>");
	formtext("Nome",$recSet["Nome"]);
	invio();
	formtext("Cognome",$recSet["Cognome"]);
	invio();
	formtext("foto",$recSet["foto"]);
scrivi("</div></td><td>");
	$fotoSua=rs_goliardi_getFotoPersona($recSet);
	scrivi(getTagFotoPersonaGestisceNullFast($fotoSua,100));
scrivi("</td></tr></table>");
hline(70);
scrivi("<table border=3>");
formtextConCheckbox("Indirizzo",$recSet["Indirizzo"],"privacy_address",$recSet["privacy_address"],"privato");
formtextConCheckbox("NumCellulare",$recSet["numcellulare"],"privacy_cell",$recSet["privacy_cell"],"privato");
formtextConCheckbox("Email",$recSet["email"],"privacy_mail",$recSet["privacy_mail"],"privato");
scrivi("</table>");
scrivi("<i>(se selezioni <u>sì</u> non saranno resi pubblici questi dati)</i><br>");
hline(70);
scrivib("<h2>Estremi goliardici</h2>");
formtext("titolo",$recSet["titolo"]);
invio();
formtext("Nomegoliardico",$recSet["Nomegoliardico"]);
invio();
//spazio(100);
formtext("Nomenobiliare",$recSet["Nomenobiliare"]);
invio();
hline(70);
$dataProcesso=$recSet["DataProcesso"];
//$d=Date($dataProcesso);
//formtext("Dataprocesso",toHumanDate($d));
//formtext("Dataprocesso",datasbura($dataProcesso));
formtext("Dataprocesso",($dataProcesso));

// ora devo retrievare tutti gli ordini disponbibili!!!!!!!!!!!



 $sql2 = "select ID_Ordine,id_facolta from goliardi where goliardi.id_gol=".QueryString("idgol");
		///// CERCO IL MIO ORDINE (da mettere in select di default)
 $resSet2 = mysql_query($sql2)
	or sqlerror($sql2);
 if (mysql_num_rows($resSet2)==0)
	{scrivi(htmlMessaggione("errore, non trovo il goliarda di id='".$idgoliardico."'!!!"));
	 bona();
	}
 $recSet2=mysql_fetch_array($resSet2);
 $mioIdOrdine = $recSet2["ID_Ordine"];
 $mioIdOrdine2 = $recSet2[0];
 $mioIdFacolta = $recSet2["id_facolta"];
 scrivi ("Ordine: ");
 popolaComboBySqlDoppia_Key_Valore("ID_Ordine",
	"select id_ord,nome_veloce,città from ordini order by nome_veloce",($mioIdOrdine));
scrivi (rosso("<br>Fuck")."oltà: ");
popolaComboBySqlDoppia_Key_Valore("ID_FACOLTA","select * from facolta order by facolta",$mioIdFacolta);
invio();
scrivi("<i>P.S. Se non c'è il tuo ordine nella scelta devi crearlo ex novo; non puoi creare un goliarda senza un ordine di nascita...");
scrivi("Quindi o fai prima l'ordine o - se hai fatto fatica finora - registri il tutto con un ordine pacco (leggasi fittizio), crei l'ordine e infine ");
scrivi("cambi solo questo!.. ok?</i>");
hline(70);
?>
<center>
<input type="submit" value="registra i cambiamenti">
</center>
<?php  formEnd(); ?>


<?php  if ($DEBUG_ON) 
	{hline(100);
	 scrivib("sql2: ".$sql2."<br>ORDINE MIO: '".$mioIdOrdine."' oppure '".$mioIdOrdine2."'<br>"); 
	}
?>
</center>
<?php 
scrivi("</table>");

include "footer.php";
?>


