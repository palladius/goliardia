<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

// controllo l'id datomi...
$id_msgDaVedere= QueryString("id");


if (! Session("ADMIN"))
{
 scrivie("Non sei amministratore, che ci fai qua?!?!? Pussa via!");
 bona();
}

if ($id_msgDaVedere != "")
	tornaindietro("se vuoi puoi sempre guardare il sondaggio come vien fuori di là..."
			,"votazioni.php?guardaid=$id_msgDaVedere");

			// controllo l'eventuale POST...
$operazione= Form("hidden_operazione");
if ($operazione=="aggiungi domanda")
	{
	 scrivi("aggiungo la domanda al dibbì...<br>");
	 if ($ISPAL) visualizzaformz();
	 autoInserisciTabella("polls_domande","Domanda inserita correttamente");
	 tornaindietro(
				"Aggiunta domanda. Torna al sondaggio num.".form("id_poll"),
				"$AUTOPAGINA?id=".form("id_poll")
			  );
	 bona();
	}
else if ($operazione=="AZZERA VOTI")
	{
	 if ($ISPAL) visualizzaformz();
	 scrivi("Azzero i voti relativi alla domanda (".Form("hidden_id_domanda").") ");
	 mq("delete  from polls_voti where id_domanda=".Form("hidden_id_domanda"));
	 tornaindietro	(
				 "Azzerati i voti di quella domanda. Torna al tuo sondaggio...",
				 "$AUTOPAGINA?id=".form("hidden_id_sondaggio_xTurnerIndria")
				);
	 bona();
	}
else if ($operazione=="AZZERA TUTTI VOTI")
	{
	 $id=Form("hidden_id_sondaggio");
	 if ($ISPAL) visualizzaformz();
	 scrivi("Azzero TUTTI i voti relativi del sondaggio ($id): è un prototipo di "
		."query quindi probabilmente NON andrà ;-) <br>");
	 mq("DELETE polls_voti.* FROM polls_domande domande INNER JOIN polls_voti "
		. " ON domande.id_domanda = polls_voti.id_domanda "
		. "WHERE (domande.id_poll = $id)"); 
#	 mq("delete pv from polls_voti pv, polls_domande pd where pv.id_domanda=pd.id_domanda and id_poll=$id");
	 tornaindietro	(
				 "Azzerati i voti totali e globali (?!?). Torna al tuo sondaggio...",
				 "$AUTOPAGINA?id=".form("hidden_id_sondaggio")
				);
	 bona();
	}
else if ($operazione=="AZZERA DOMANDE")
	{
	 scrivi("azzero le domande...");
	 if ($ISPAL) visualizzaformz();
	 if ($ISPAL) echo("guardo se esistono voti relativi a queste domande o a questo sondaggio...");
	 $quantiVoti = getVotiTotaliFromSondaggio(Form("hidden_id_poll"));
	 if ($quantiVoti==0)
		{
		 mq("delete  from polls_domande where id_poll=".Form("hidden_id_poll"));
		}
	   else 
		echo rossone("mi spiace, ci sono già $quantiVoti già esistenti"
			." nel sondaggio: devi rimuovere prima quelli");
	 tornaindietro("torna al tuo sondaggio","$AUTOPAGINA?id=".form("hidden_id_poll"));
	 bona();
	}
else if ($operazione=="RIMUOVI SONDAGGIO")
	{
	 scrivi("azzero il sondaggio...");
	 if ($ISPAL) visualizzaformz();
	 $ndomande=getDomandeTotaliFromSondaggio(Form("hidden_id_poll"));
	 if ($ndomande==0)
		 mq("delete  from polls_titoli where id_poll=".Form("hidden_id_poll"));
	   else	
	 	scrivie("Mi spiace, ma ci sono $ndomande ancora nel sondaggio: cancella prima quelle...");
	 scrivi("torna mo' ai <a href='votazioni.php'>sondaggi</a>...");
  	 bona();
	}

// altrimenti non dovrebbe esserci un'operazione... undefined cade qua infatti...


$autorizzato = TRUE;

if (empty($id_msgDaVedere))
	{
	 scrivie("attenzione, devi entrare in questa pagina con il concetto di Sondaggio (passatomi via queryst"
			."ring). non dovresti mai veder questo msg.. :-(");
	 bona();
	}
if ($ISPAL)
	scrivi("msg numero ".$id_msgDaVedere."<br>");

$res=mq("select count(*) from polls_titoli where id_utente_creatore=".getIdLogin()
			." and id_poll=".$id_msgDaVedere);

if (mysql_num_rows($res)==0)
	$autorizzato=FALSE;
   else
	{
	 $rs=mysql_fetch_array($res);
	 if ($rs[0]==1 || isAdminVip())
		$autorizzato=TRUE;




	}
if (! $autorizzato)
	{
	 scrivie("attenzione, non puoi modificare questo sondaggio...");
	}
   else
	{ // GESTIONE DEL SONDAGGIO; ORA SEI AUTORIZATO
	 $sql="select * from polls_domande where id_poll=".$id_msgDaVedere;
	 $res=mq($sql);
	 opentable();
	 scrivi("<h3>Aggiungi opzione</h3>");
	 formBegin();
	  formhidden("hidden_operazione","aggiungi domanda");
	  formtext("testodomanda","è un mona");
	  invio();
	  formtext("foto","$GETUTENTE.jpg");
	  invio();
	  formtext("tipofoto","persone");
	  invio();
	  formhidden("id_poll",$id_msgDaVedere);
	  formbottoneinvia("aggiungi");
	 formEnd();
	 tdtd();
?>
<big>Attenzione!</big> <br>
Attualmente ci sono solo 3 modi di usare la combinazione FOTO e TIPOFOTO:<br>
1) Se l'opzione ha a che fare con un goliarda di nome XXX la cui foto è presente nel dibbì, metti come foto "<i>XXX</i>.jpg", e la parola chiave "persone" come <i>tipofoto</i>.
<br/>
2) Se l'opzione ha a che fare con un ordine la cui foto è presente nel dibbì, metti come foto "<i>XYZ</i>.jpg" o "<i>XYZ</i>.jpg", dove il nome lo devi trovare tu a mano (arranzat!), e la parola chiave "ordini" come <i>tipofoto</i>.
<br/>
3) Se l'opzione NON NECESSITA di FOTO (o non è applicabile o lo è ma la foto non c'è) mette ciò che volete alla voce 'foto', ma tassativamente la parola <i>niente</i> alla voce 'tipofoto'.
<br/>
<i>(tutti questi inutili discorsi solo x far comparire successfulmente la foticina a fianco dell'opzione, nel dubbio mettete NIENTE sotto ogni tipo foto e non vi sbagliate!!!)</i>
<?php 
	 closetable();

	 scrivi("<h3>Modifica/Cancella singole domande (titolo domanda, foto, ...)</h3>");
	 scriviRecordSetConDelete($res,$sql,TRUE); // inibisco la cancellazione

	$ntot=getVotiTotaliFromSondaggio($id_msgDaVedere);
	 
	if (isadminvip())
		{
		 echo rossone("attento, amministratore: se clicchi su modifica NON CAMBIARE ASSOLTAMENTE l'ID_PO"
			."LL! ma solo tutto ciò che vuoi del resto, ok? e non fare come adamo!");
		 opentable();
		  scrivi("<h3>Modifica/Cancella il Sondaggio in sè (padre delle domande titolo,descrizione,date...)</h3>");
		  echo "(esso è padre di tutte le domande, ha un titolo, una descrizione, una data di attivazione, ..."
				." e ad esso sono associati $ntot voti)";
		  $sql="select * from polls_titoli where id_poll=".$id_msgDaVedere;
		  $res=mq($sql);
		  $arrIntoccabili= array("id_poll","id_utente_creatore");
		  scriviRecordSetConDelete($res,$sql,TRUE,$arrIntoccabili);	
			// inibisco il tasto CANCELLA, tutt'al+ lo metto in fondo!!!
		 closetable();
		}

	 scrivi("<h3>Azzera voti/domande (x una singola domanda).</h3>");
	 $resDomande=mq("SELECT testodomanda,id_domanda from  polls_domande where id_poll=".$id_msgDaVedere);
	 $numDomande=0;
	 opentable();
	 while ($rsDomande=mysql_fetch_array($resDomande))
		{$numDomande++;
	 	 $idDomanda=$rsDomande["id_domanda"];
		 formBegin();
		  formhidden("hidden_operazione","AZZERA VOTI");
		  formhidden("hidden_id_domanda",$idDomanda);
		  formhidden("hidden_id_sondaggio_xTurnerIndria",$id_msgDaVedere);
		  $strInvia="<div align='right'>domanda: <b>"
			.$rsDomande["testodomanda"]."</b></div>";
		  echo $strInvia;
		  tdtd();
		  $n=getVotiTotaliFromDomanda($rsDomande["id_domanda"]);
		  if ($n>0)
			  formbottoneinvia("rimuovi i suoi [$n] voti");
		     else
			  scrivib("rimuovi la domanda $idDomanda stessa (tbds: mettici la form nell'altro ramo if e qua una nuova form con una n)");
		 formEnd();
		 tttt();
		}
	closetable();

	 scrivi("<h3>Azzera voti (x tutte le domande presenti: x ora non va regaz; attendo da Black Hole Sun).</h3>");
	 opentable();
	 if ($ntot==0)		
			echo rossone("inutile: voti non presenti");
	   else // $ntot > 0 x ipotesi
		{
		 formBegin();
		  formhidden("hidden_operazione","AZZERA TUTTI VOTI");
		  formhidden("hidden_id_sondaggio",$id_msgDaVedere);
		  echo "<div align='right'>rimuovi TUTTI gli $ntot voti relativi al sondaggio: <b>"
				."$id_msgDaVedere</b></div>";
		  formbottoneinvia("rimuovi [$ntot] voti");
		 formEnd();
		}
	closetable();

	scrivi("<h3>Cancella TUTTE le domande (rimane un moncherino di sondaggio con solo titolo).</h3>");
	scrivi("attenzione, x rimuovere le domande, x motivi di integrità referenziale, bisogna "
			."prima rimuovere ogni voto relativo a QUELLA domanda...");
#	echo rossone("i voti relativi al sondaggio $id_msgDaVedere sono: [$ntot]...<br>");
	if ($ntot > 0)
		echo rossone("Mi spiace, vi sono $ntot voti su questo sondaggio, quindi non ti lascio "
			."ripulire tutte le domande. L'um spies");
	  else
		{
		formBegin($AUTOPAGINA);
		 formhidden("hidden_operazione","AZZERA DOMANDE");
		 formhidden("hidden_id_poll",$id_msgDaVedere);
		 formbottoneinvia("rimuovi tutte le domande");
		formEnd();
		}

	$ndomande=getDomandeTotaliFromSondaggio($id_msgDaVedere);
	if ($ndomande==0)
		{opentable();
		 scrivi("<h3>Rimuovi il sondaggio.</h3>");
		 echo rossone("Te lo faccio fare (si vis) solo perché hai cancellato ormai tutto il resto!");
		 formBegin();
		  formhidden("hidden_operazione","RIMUOVI SONDAGGIO");
		  formhidden("hidden_id_poll",$id_msgDaVedere);
		  formbottoneinvia("rimuovi sondaggio");
		 formEnd();
		 closetable();
		}
	}


include "footer.php";
?>
