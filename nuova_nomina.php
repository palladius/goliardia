<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


#visualizzaformz();
?>
<center><h1>Aggiunta Nomine</h1>


<?php 
//ACCERTA I DIRITTI  SULL'ORDINE!!!

$idgol=Form("idgol");
$idordine=Form("idord");
$op=Form("hidden_operazione");

if ($op=="aggiunta")
	{
	 if (Form("ID_CARICA")=="-1")
		{
		 scrivib(rosso("Se la carica che devi inserire non è presente nell'ordine, "
			."prima devi aggiungerla come carica dell'Ordine! "));
		 scrivib(rosso("Questo vale anche se è una nomina che vale solo x questa persona."
			." Insomma, non sta certo a me giustificare le mie scelte "));
		 scrivib(rosso("progettuali con te, ok?!?!? :-)"));
		 bona();
		}
	 else
		{
		 autoInserisciTabella("nomine");
		 scrivi("<a href='pag_goliarda.php?idgol=".Form("id_goliarda")
			."'><h3>Torna alla pagina del goliarda modificato</h3></a>");
		 bona();
		}
	}

if (empty($idgol) || empty($idordine))
	{
	 scrivi("<h2>Attenzione, non ho dati x costruire la nomina. Torna indietro...</h2>");
	 bona();
	}

if (! utenteHaDirittoScritturaSuOrdineById($idordine))
	{
	 scrivib(rosso("Non hai diritti sull'Ordine di cui vorresti notificare una nomina... um spies di mondi."));
	 bona();
	}

$sql3="SELECT id_carica,nomecarica FROM cariche WHERE id_ordine=".$idordine;
$res=mq($sql3);
$rs=mysql_fetch_array($res);

?>
	<h3>dà un'occhiata all'<a href=modifica_ordine.php?idord=<?php  echo $idordine?>>ordine</a> in questione</h3>
<?php 
if (isdevelop()) echo rosso("guarda ric che qua viene fatta una querona (beh dai, diciamo 10 record) quando"
	." poi non viene usata se non x fre un controllo di esistenza: cerca di tradurla in una query di count"
	." o qualcosa del genere..");
if (! $rs)
{
?>
	<h1>Maccheccazzo, vuoi inserire una nomina in un ordine che non ne ha... ma roba da matti!</h1>
	
<?php 
}
else
{

formBegin();
	scrivi("cariche disponibili nell'Ordine:");
	popolaComboConEccezionePrescelta("ID_CARICA",$sql3,"-1","-1","[ALTRO]")	;
	formhidden("id_goliarda",$idgol);
	invio();
	formtext("eventuale_numero_progressivo","0");
	scrivi("<br><i>(Il numero progressivo ha senso se è un capoordine o capocittà, tipo: "
		. "il <b>45mo</b> Gran Maestro di StiCazzi... Se non ha senso lascia stare "
		. "a 0, il computer capirà...)</i>");
	invio();
	formtext("data_nomina",dammiDatamysql());
	$res42=mq("select id_login from loginz where m_snome='$GETUTENTE'");
	$rs42=mysql_fetch_array($res42);
	formhidden("id_utente_postante",$rs42[0]);
	formhidden("data_inserimento_nomina",dammiDatamysql());
	formhidden("hidden_operazione","aggiunta");
	invio();
	formtext("data_fine_nomina",dammiDatamysql());
	invio();
	scrivi("Goliarda nominante (se presente):<br>");
	$sql =  "select g.id_gol,g.nomegoliardico,o.nome_veloce from goliardi g,ordini o "
		. " WHERE o.id_ord=g.id_ordine "
	    	. " ORDER BY g.nomegoliardico";
	popolaComboConEccezionePrescelta("ID_goliarda_nominante",$sql,"0","0","[NON PRESENTE]")	;
	invio();
	formtextarea("note","assolutamente rubata",8,19);
	invio();
	formbottoneinvia("AGGIUNGI");
formEnd();

}




include "footer.php";
?>
