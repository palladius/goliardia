<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

scrivi("<center>");

$CANCELLA_VOTI_PRECEDENTI = FALSE;
$GUARDAID = QueryString("guardaid");


function visualizzaReport_PollTitolino($rs)
{
 global $AUTOPAGINA;
?>
 <?php  echo getFotoUtenteDimensionataRight($rs["m_sNome"],40)?>
 </td>
 <td>
 <b><a href="<?php  echo $AUTOPAGINA?>?guardaid=<?php  echo $rs["id_poll"]?>"><?php  echo $rs["titolo"]?></a></b> <i>(<?php  echo $rs["m_sNome"]?>)</i>
<?php 
}

function visualizzaTuttiISondaggi()
{
tabled();
trtd();
 $res=mq("select id_poll,titolo,m_sNome from polls_titoli p,loginz l WHERE l.id_login=p.id_utente_creatore "
		."AND datafine>=now() order by datacreazione desc");
 scriviVotazioniSuDueColonne("Votazioni ancora attive",$res);
tdtd();
 $res=mq("select id_poll,titolo,m_sNome from polls_titoli p,loginz l WHERE l.id_login=p.id_utente_creatore "
		."AND datafine<now() order by datacreazione desc");
 scriviVotazioniSuDueColonne("Votazioni già terminate",$res);
trtdEnd();
tableEnd();
}

function scriviVotazioniSuDueColonne($titolo,$res)
{
scrivi(freccizzaFrase("<h3>".$titolo."</h3>"));
scrivi("<table border='1' bgcolor='#FFFFEE'><tbody border='1'><tr><td>");
$i=0;
while ($rs=mysql_fetch_array($res))
{
  visualizzaReport_PollTitolino($rs);

if ($i % 2) // dispari
	scrivi("</td></tr><tr><td valign='top'>");
else 
	scrivi("</td><td valign='top'>");
$i++;
}
scrivi("</td></tr></tbody></table>");
}


$autooperazione= Form("hidden_operazione");

	// INSERIMENTO VOTO

if ($autooperazione == "voto")
	{
	 scrivi(rosso("Sto cercando di aggiornare il dibbì col tuo cacchio di voto..."));
	 $OK_INSERISCI_PURE = TRUE;
	 invio();
	 scrivi("Guardiamo se il voto esiste già...<br/>"); 
	 $iddom=Form("id_domanda");
	 $idutente=Form("id_utente");
	 if ($idutente != getIdLogin()) // ctrl lo spoofing dell'utente...
		log2("(hacker) modificato utente votante da ".$getIdLogin()." a ".$idutente);
	 $res1=mq("select id_poll from polls_domande where id_domanda=".$iddom); // trovo l'idpoll 'PADRE'
	 $rs1=mysql_fetch_array($res1);
#	 $res=mq("SELECT count(*) as QUANTI from polls_voti WHERE id_voto in (select id_voto from polls_doma"
#			."nde pd, polls_voti pv where pd.id_poll=".$rs1["id_poll"]
#			." AND pd.id_domanda=pv.id_domanda AND id_utente=".$idutente.")"); 
#	 if (intval($rs["QUANTI"]) != 0)
	 $res=mq("select id_voto from polls_doma"
			."nde pd, polls_voti pv where pd.id_poll=".$rs1["id_poll"]
			." AND pd.id_domanda=pv.id_domanda AND id_utente=".$idutente.""); 
	 $QUANTI = mysql_num_rows($res);
	 if ($ISPAL) echo rossone("num voti: [$QUANTI]");
	 if (($QUANTI) != 0)
		{
		 scrivib(rosso("Mi, spiace, barone, hai votato già troppe volte questo poll! Il voto non vale, stvonzo.<br/>"));
		 $OK_INSERISCI_PURE = FALSE;
		}
	 #scriviRecordSetConTimeout($res,50);
	 #scriviRecordSetConTimeout($res,50,"Eventuale altro voto che hai fatto");
	 if ($CANCELLA_VOTI_PRECEDENTI)
		$rsCancellaPrecedenti = query( "DELETE * from polls_voti WHERE id_voto in (select id_voto fro"
			."m polls_domande pd, polls_voti pv where pd.id_poll=".$rs1("id_poll") 
			." AND pd.id_domanda=pv.id_domanda AND id_utente=".$idutente.")" ); 

	if ($OK_INSERISCI_PURE)
		{
		$ok=autoInserisciTabella("polls_voti","votto inseritto coretamente");
		if ($ok)
			scrivi(rosso("<br>Ok, inserito!"));
		   else 
			scrivi("<br>Qualcosa è andato storto, probabilmente hai cliccato senza prima selezi"
				."onare alcun elemento da votare, brutto pirla!!!");
		}
	   else
		scrivib(("Il voto NON è stato inserito.<br/>"));		
	}


if ($autooperazione == "inseriscinuovosondaggio")
	{
	 autoInserisciTabella("polls_titoli");
	 scrivi(bigg("<br><br>se è andato tutto bene, torna <a href='votazioni.php'><b>indietr"
		."o</b></a> e edita le domande del nuovo sondaggio..."));
	 bona();
	}

if ( Session("ADMIN"))
	{
	 openTable();
	 scrivi("<table width=600><tr valign=top><td width='30%'>");
	 scrivi("<h3>ADMIN ONLY: Modifica un tuo sondaggio</h3>");
	 $resMyPollz=mq("select * from polls_titoli where id_utente_creatore=".getIdLogin());
	 $myn=0;
	 while ($rsMyPollz=mysql_fetch_array($resMyPollz))
		{$myn++;
		 scrivi($myn.") <b><a href='sondaggi_modifica.php?id=".$rsMyPollz["id_poll"]."'>"
				.$rsMyPollz["Titolo"]."</a></b><br/>");
		}
	 scrivi("</td><td>");
	 scrivi("<h3>Crea un nuovo sondaggio</h3>");

	formBegin();
	 formhidden("hidden_operazione","inseriscinuovosondaggio");
	 formhidden("id_utente_creatore",Session("SESS_id_utente"));
	 $dataAttuale=dammiDataMysql();
	 formhidden("datacreazione",$dataAttuale);
	 formtext("Titolo","vota il ...");
	 invio();
	 formtext("datainizio",$dataAttuale);
	 invio();
	 formtext("datafine",$dataAttuale);
	 invio();
	 formtextarea("descrizione","",7,30);
	 invio();
	 formbottoneinvia("OK");
	formEnd();
	
	scrivi("</td></tr></table>");
	closeTable();
	}


if (! empty($GUARDAID))// voglio vedere UN SONDAGGIO IN PARTICOLARE...
	{
 	 scrivi("<h2>Osserviamo il sondaggio (numero ".$GUARDAID.") che t'interessa ...</h2>");
	 if (isadminvip())
		{
		 scrivib(rosso("Attenzione, compare solo QUA e non in ogni report sondaggio, se sei admin vip"
			."....<br/> <a href='sondaggi_modifica.php?id=".$GUARDAID."'>MODIFICA SONDAGGIO</a>!!!"));
		}
	 visualizzaReport_PollTitolo($GUARDAID ,FALSE);
 	 visualizzaReport_PollCorpo($GUARDAID ,FALSE);
	 scriviTabellaInscatolataBellaEnd();	
	}
   else
	{
	 formSondaggi(FALSE); // visualizza l'ultimo sondaggio in maniera NON veloce.
	 visualizzaTuttiISondaggi();
	}

// mi sa che questa deve essere a FINE pagina!!!!1
//scriviTabellaInscatolataBellaEnd();

include "footer.php";
?>
