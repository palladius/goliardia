<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "classes/manda_foto.php";
include "header.php";

#$DEBUG = 1;
$GIORNI_OBSOLESCENZA_GMS = 90; // solo per la query nel pannello, non e globale

$menu= array (
			#"OP1) concedi una CITTA a un UTENTE",	# obsoleta nel 2006
			"OP2) concedi un ORDINE a un UTENTE",
			"OP2.5) togli un ORDINE a un UTENTE",
			"OP3) REGALA un  goliarda a un altro utente",
			"OP4) dai in Ulteriore gestione un goliarda",
			"OP4.1) ATTIVA utente in punizione",
			"OP4.2) DISATTIVA utente (non può + far login)",
			"OP4.3) rendi EFFETTIVO utente (full user)",
			"OP4.4) rendi GUEST utente (guest)",
			"OP_CANCGOLIARDA) cancella goliarda",
			"OP5bis) Cambia Msg occasionale",
			"<b>BUGS X AMMINISTRATORI ALTRUISTI (ammodernato a Giu08!!!)</b>"
		);
$menuvip=array(
			"AV1) Modifica profilo utente",
			"OP_NUOVOORDINE) crea un nuovo ordine (da usare con le pinze)",	
			"AV2) Accetta/rifiuta foto mandafoto",
			#"AV3) Cambia dati utente (da usare con parsimonia o vi inculo)",
		   );
	# 205 in poi direi...
$menugod= array (
			"OP205) Cambia Msg del giorno",
			"OP7) sbircia GOLIARDA",
			"OP9) Repulisti",
			"BUGS",
			"OP11) Cambia Foto Primapagina",
			"OP12) Manda mail a utente",
			"OP213) Cambia Msg relativo alla prima pagina",
			);



if (! Session("ADMIN"))
	accertaAdministratorAltrimentiBona();
else 
	scrivib(rosso("Benvenuto, Administrator...<br>"));


$operazione=(Form("hidden_operazione")); // postata e da ELABORARE


$op= (QueryString("op")); 		// op scelta, devo PRESENTARLA
$opvip = (QueryString("opvip")); 	// idem x ADMIN VIP
$opgod=(QueryString("opgod")); 	// op scelta di God (pal e basta x ora), devo PRESENTARLA




if(!empty($operazione)) {
		//////////////////////////////////////////////////
		/// mi sono autochiamato: prcoedo con l'elaborazione

	log2("[PANNELLO] operazione $operazione (vedere eventuale riga seguente)","pannello.log.php");
	switch ($operazione) {
	   #case "1":
     	   #	autoInserisciTabella("gestione_citta");
	#	break;
	   case "2":
		autoInserisciTabella("gestione_ordini");
		break;
	   case "2.5":
		autoCancellaTabella("gestione_ordini","id_login");
		break;
	   case "3":
		autoAggiornaTabella("goliardi","id_gol");
		break;
	   case "4":
		autoInserisciTabella("ulteriori_gestioni_goliardiche");
		break;
	   case "4.1":
	   case "4.2":
	   case "4.3":
		log2("[PANNELLO] OP$operazione attiva/disattiva/userizza ".Form("my_hidden_id")." (nome: '".getNomeByTipoAndId("utenti",Form("my_hidden_id"))."')","pannello.log.php");
		autoAggiornaTabella("loginz","id_login");
		break;
	   case "4.4":
		log2("[PANNELLO] OP$operazione guestizzazione di ".Form("my_hidden_id")." (nome: '".getNomeByTipoAndId("utenti",Form("my_hidden_id"))."')","pannello.log.php");
		#$DEBUG=1;
		autoAggiornaTabella("loginz","id_login");
		break;
	   case "5":
  		autoAggiornaTabella("xxx_memoz","chiave");	// CAMBIO il msg del giorno....
		break;
	   case "5bis":		// CAMBIO l'HEADER
		$frase = Form("valore"); 			// chi ha la erre moscia se ne accorge.. ;-)
		if (Session("erremoscia"))
			$frase = rimpiazzaErreMoscia($frase);
		$utente=$GETUTENTE;
		if ($ISPAL)
			$utente="<b>$QGFDP</b>";
		$frase .= ("<br><div align=right><i>($utente)</i></div>");			
		$rs=mysql_query("UPDATE XXX_MEMOZ SET valore = '".encodeApostrofi($frase)."' where chiave='header'"); 
				// non serve il Server.HTMLEncode, ma serve quello degli apostrofi...	
		break;
	   case "6":
		echo "TBDS MAYBE...";
		break;
	   case "7":		// x ogni goliarda che si chiama COSI metto la riga descrittiva e i suoi padfroni e ulteriori...
			 	// aggiungo in ulteriori gestioni
		$idgol=Form("id_gol");
		$rsNome=query1("select nomegoliardico from goliardi where id_gol =".$idgol);
		$sql="select * from goliardi where nomegoliardico like '%".$rsNome[0]."%'";
		$resAll=mysql_query($sql);
		scrivid(big($sql));
		//scriviRecordSetConDelete(rsAll,sql)
		while($rsAll=mysql_fetch_array($resAll))
			{scrivi("<h1><center>".$rsNome[0]." (".$rsAll["nome"]." ".$rsAll["cognome"].")</h1>");
			 $rs=query1("select m_snome from loginz where id_login=".rsAll("id_login"));
			 scriviln("Creato da: ".big($rs[0])); 
			 invio();
			 scriviln("Ma anche in gestione di: ");
			 $sql = "select u.id,l.m_snome from ulteriori_gestioni_goliardiche u,loginz l where l.id_login"
				 ."=u.id_login AND u.id_gol=".$idgol;
			 $res=mysql_query($sql);
			 scrivid(big($sql));
			 scriviRecordSetConDelete($res,$sql);
			}
		 break;
	   case "8bis":		// aggiungo 100 GPz all'utente (in futuro 100 sarà personalizzabile... INUTILE!
  		  $id=Form("id_login");
		  gestisciGoliardPointz($id,Form("PX"),"incrementa");
		  break;
	   case "8tris":		// aggiungo 100 GPz all'utente (in futuro 100 sarà personalizzabile...
  		  $id=Form("id_login");
		  $PX=Form("PX");
		  gestisciGoliardPointz($id,PX,"setta");
	   case "11": // cambia foto!
		  echo "vediamo... hai scelto <b>".Form("fotoprimapagina")."</b><br>";		  
		  $ok=mq("UPDATE xxx_memoz SET valore = '".Form("fotoprimapagina")."' where chiave='fotoprimapagina'"); 
		  img("immagini/primapagina/".Form("fotoprimapagina"));		 
		  break;
	   case "12": // mandamail
		  $idtarget=Form("id_login");
		  echo "vediamo... vuoi mandare una mail a  <b>$idtarget</b>...<br>";		  
		  $res=mq("select m_snome,m_hemail from loginz where id_login=$idtarget");
		  $rs=mysql_fetch_array($res) 
			or die("utente $idtarget non trovato, muoio.");
		  $titolo="[$SITENAME] ".Form("titolo");
		  $body=Form("body");
		  $to=$rs["m_hemail"];
		  $nome=$rs["m_snome"];
		  $body .= "<br>---------------------<br>Mail mandata dal sito <b>$SITENAME</b> dall'utente <b>$GETUTENTE</b>"
				.". Dal sito $DOVESONO (in quanto questa ($to) è la mail che corrisponde all'utente $nome).<br> "
				."Se ti è stata recapitata per sbaglio manda una mail a $WEBMASTERMAIL."
				.$MAILFOOTER."<br>---------------------";
		  opentable();
		   scrivicoppia("titolo",$titolo);
		   scrivicoppia("to",$to);
		   scrivicoppia("nome",$nome);
		   scrivicoppia("body",$body);
		  closetable();
		  mandaMail($to,$WEBMASTERMAIL,$titolo,"<html>$body</html>");

		  break;
	   case "213":
  		#autoAggiornaTabella("xxx_memoz","chiave");	// CAMBIO il msg del giorno....
		$frase = Form("valore");
		$sql = "UPDATE xxx_memoz SET valore = '".encodeApostrofi($frase)."' where chiave='didascaliahome'" ;
		if (! mq($sql)) {
			echo rosso("errore con sql: $sql");
		}
		
		#$ok=mq("UPDATE xxx_memoz SET valore = '".Form("fotoprimapagina")."' where chiave='didascaliahome'");

		break;
	   case "NUOVOORDINE":
		  autoInserisciTabella("ordini");
		  bona();
	   case "CANCGOLIARDA":		//DEBUG=true;
		  autoCancellaTabella("goliardi","id_gol") ;
		  bona();
		  break;
	   case "MODUTENTE1":
		 if (! isadminvip())
			bona();
		 #$DEBUG=1;
		 $USERID=Form("my_hidden_id");

		 $sql="select id_login,m_hemail,m_bisgoliard,m_bismaschio,m_snome from loginz where id_login=$USERID limit 1";
		 $res=mysql_query($sql);
		 $rss=mysql_fetch_array($res);
		 $nome=$rss["m_snome"];
		 $email=$rss["m_hemail"];
		 echo "<h2>Dobbiamo modificare l'utente '$nome' (num $USERID)....</h2>";
		 #$m_bIsMaschio=  ($rss["m_bIsMaschio"]);
		 #scriviRecordSet($sql);
		 
		 formBegin();
			formSceltaTrueFalse("m_bisgoliard","Sei goliarda?",intval($rss["m_bIsGoliard"]));
        		invio(); 
			formSceltaTrueFalse("m_bismaschio","Sei maschio?",intval($rss["m_bismaschio"]));
        		invio(); 
			formtext("m_snome",$nome);
        		invio(); 
			formtext("m_hemail",$email);
			invio();
			echo "<h2>da usare con attenzione se mettete un email che non va mi incazzo con TE</h2>";
		  	echo "scusatemi devo ancora finirlo, am daovete dirmi cosa dovete cambiare. possibilmente non email e nomeutente";	
		 formhidden("id_login",$USERID);
		 formhidden("my_hidden_id",$USERID);
		 formhidden("hidden_operazione","MODUTENTE2");
		 invio();
		 formBottoneInvia("fa pure");
		 formEnd();
		break;
	case "MODUTENTE2":
		 echo "<h2>Aggiornamento utente, fase 2</h2>";
		if (! isadminvip())
                        bona();
		$DEBUG=1;
		$id=Form("id_login");
		$nome=Form("m_snome"); 
		autoAggiornaTabella("loginz","id_login");
		logga2("cambiati dati di utente numero $id (ora chiamato '$nome')");
		echo "<h2>Aggiornato!!!</h2>";
		break;
	case "EDITA_MANDAFOTO_2021": 		
		#autoAggiornaTabella("loginz","id_login");
		echo h2("TODO Riucc quando seby dorme");
		echo "Qui fai un autoaggiornatabella.. ma prima abilita DEBUG e vedi i post :)";
		//provato, va quasi, esegue questo:
		// PdAtE mandafoto_images SET `admin_user_id`='3' , `status`='01-ACCEPTED' , `admin_description`='figatissima' WHERE `id`=''
		print_r(Querystring());
		autoAggiornaTabella("mandafoto_images", "id");
		break;
	}
	invio();
	hline(80);
	scrivib("Spero di averti soddisfatto.");
	bona();
	}

	{
		//////////////////////////////////////////////////
		/// nessuna elab in corso, presento la pag e basta

//		scrivi("utenti Totali dalla nascita dell'Application: ".big(Application("utentiDallInizioDellApplicazione")));
//		scrivi("<br>Data di nascita dell'applicazzone: ".big((Application("Ap_datadinascita"))));
openTable();
?>
<h3><big><b>DISKLEIMER</b></big><br>
<?php 
$diskleimerstr = "Io, amministratore, giuro solennemente di impegnarmi affinché lo zio Pal non abbia a pentirsi del potere che mi ha dato. Giuro inoltre di cercare di mantenere l'Integrità Referenziale del database, e altresì di rafforzare il più possibile la tassonomia a duplice sussunzione alla base del meccanismo di naming delle foto. Cercherò <u>in ogni modo</u> (a costo di fare una cazzata in meno) di far sì che per ogni persona che si collega al sito vi sia uno e un solo utente registrato. Mi impegno a guardare che non ci siano utenti o goliardi doppioni. Mi impegno a mandare una mail ogni tanto allo zio Pal dicendogli: '<i>soccia ma che bello che sta venendo il tuo sito... complimenti!</i>'. Mi impegno a usare questi poteri solo a fin di bene e non abbraccerò mai il lato oscuro della Scamorza. Prometto inoltre (soccia che palle però Pal!) che non user� i miei poteri x giochini goliardici (tipo abbassare di grado il capoordine a me rivale (a meno che non sia dell'Oca, ovviamente) o scriverci 2 cazzate nel suo nome) poiché questi poteri trascendono il mio gioco; cercherò di scrivere invece pi� maialate possibili nei messaggi e in chat. Capisco inoltre che il messaggio occasionale è l'UNICA parte del sito visibile a chi non abbia un account, e m'impegno a non scrivere troppe volgarità in esso, per paura che questo bel sito chiuda. Capisco altresì che se violer� questi sacri e-vincoli il UebMonster mi potr� de-amministrare a volontà."
    . "<br/><u>Accetto che la mia mail venga resa pub[bl]ica</u> e prometto di usare con criterio il potere di USERIZZARE utenti (avendo visto le FAQ). Se di sesso femminile, mi impegno a tirare su di morale Pal come ama lui (se sei bionda, ti do una dritta: leggi le faq su come guadagnare GP), e a sostenere la <u>propaganda affinché superi Spanami, Ciapaso e il Levriero</u> nel  GdC.";

//themesidebox("Diskleimer",diskleimerstr);
?>
<?php  echo $diskleimerstr?>
</h3>
<?php 
closeTable();

	openTable2();

	if ($op=="OP1) concedi una CITTA a un UTENTE") {
		scrivib("OP1) concedi una CITTA a un UTENTE");
		formBegin();
			popolaComboCitta("città");
			popolaComboUtentiRegistrati("id_login");
			formhidden("hidden_operazione","1");
		scrivi("<input type='submit' value='concedi città'>\n</form>\n");

	} else if ($op=="OP2) concedi un ORDINE a un UTENTE") {
		scrivib("OP2) concedi un ORDINE a un UTENTE");
		formBegin();
			popolaComboOrdini("id_ordine");
			popolaComboUtentiRegistrati("id_login");
			formhidden("hidden_operazione","2");
		scrivi("<input type='submit' value='concedi ordine'>\n</form>\n");	
	} else if ($op=="OP2.5) togli un ORDINE a un UTENTE") {
		scrivib("OP2.5) togli un ORDINE a un UTENTE");
		formBegin();
			#popolaComboUtentiRegistrati("my_hidden_id");
			popolaComboUtenti("my_hidden_id");
			formhidden("hidden_operazione","2.5");
		scrivi("<input type='submit' value='togli ordine'>\n</form>\n");	
	}
		else if ($op=="OP3) REGALA un  goliarda a un altro utente")
	{
		scrivib("OP3) REGALA un  goliarda a un altro utente");
		formBegin();
			popolaComboGoliardiConUtente("my_hidden_id");
			popolaComboUtentiRegistrati("id_login");
			formhidden("hidden_operazione","3");
		scrivi("<input type='submit' value='REGALA goliarda'>\n</form>\n");
	}	
		else if ($op=="OP4) dai in Ulteriore gestione un goliarda")
	{
		scrivib("OP4) dai in Ulteriore gestione un goliarda");
		formBegin();
			popolaComboGoliardiConUtente("id_gol");
			invio();
			popolaComboUtentiRegistrati("id_login");
			invio();
			formtext("note","");
			invio();
			formhidden("hidden_operazione","4");
		scrivi("<input type='submit' value='gestisca anche lui'>\n</form>\n");
	}	
		else if ($op=="OP4.1) ATTIVA utente in punizione")
	{
		scrivib("OP4.1) ATTIVA utente in punizione");
		formBegin();
			popolaComboBySqlDoppia_Key_Valore("my_hidden_id","select id_login,m_snome from loginz where m_bAttivo=0 order by m_snome",1);
			formhidden("M_BATTIVO",1);
			formhidden("hidden_operazione","4.1");
		scrivi("<input type='submit' value='attiva'>\n</form>\n");
	}	
		else if ($op=="OP4.2) DISATTIVA utente (non può + far login)")
	{
		scrivib("OP4.2) DISATTIVA utente (non può + far login)");
		formBegin();
			popolaComboBySqlDoppia_Key_Valore("my_hidden_id","select id_login,m_snome from loginz where m_bAttivo=1 order by m_snome",1);
			formhidden("M_BATTIVO","0");
			formhidden("hidden_operazione","4.2");
		scrivi("<input type='submit' value='punisci!'>\n</form>\n");	
	}	
		else if ($op=="OP4.3) rendi EFFETTIVO utente (full user)")
	{	if (isdevelop()) 
			echo rosso("prossimamente metti nella lista SOLO coloro che hanno il file uguale al nome... magari con system(GREP) se + veloce... ma no è + lenta della fopen, ovviamente!");
		scrivib("OP4.3) rendi EFFETTIVO utente (full user)");
		if (isadminvip()) {
			echo rosso("solo xché sei adminvip...");
			formBegin();
				popolaComboBySqlDoppia_Key_Valore("my_hidden_id","select id_login,m_snome from loginz where m_bGuest=1 order by m_snome",1);
				formhidden("M_BGUEST","0");
				formhidden("hidden_operazione","4.3");
				formbottoneinvia("rendi FULL USER (da usare con cautela)");
			formend();
//			scrivi("<input type='submit' value='rendi full user'>\n</form>\n");
			}
		else // tutti gli altri
{?>
<?php 
}
	}
	
		else if ($op=="OP4.4) rendi GUEST utente (guest)")
	{

		scrivib("OP4.4) rendi GUEST utente (guest)");
		formBegin();
			popolaComboBySqlDoppia_Key_Valore("my_hidden_id","select id_login,m_snome from loginz ".
				" where m_bguest=0 order by m_snome",1);
			formhidden("M_BGUEST","1");
			formhidden("hidden_operazione","4.4");
		scrivi("<input type='submit' value='rendi guest'>\n</form>\n");
	}
		else if ($op=="OP_CANCGOLIARDA) cancella goliarda")
	{
		scrivib("OP_CANCGOLIARDA) cancella goliarda");
		scrivib(" (da usare con le pinze, solo in caso di doppioni); non funzionerà se qualche"
			." IDIOTA ha concesso il goliarda ad altri utenti, per motivi di integrità referenziale.");
		formBegin();
			popolaComboGoliardiConUtente("my_hidden_id");
			formhidden("hidden_operazione","CANCGOLIARDA");
		scrivi("<input type='submit' value='cancella'>\n</form>\n");
	} else if ($op=="OP5bis) Cambia Msg occasionale") {
		scrivib("OP5bis) Cambia Msg occasionale");
		formBegin();
			formtextarea("valore","",10,30);
			formhidden("my_hidden_id_testuale","header");
			formhidden("hidden_operazione","5bis");
		scrivi("<input type='submit' value='cambia msg'>\n</form>\n<br>");
	} else	if  ($op=="<b>BUGS X AMMINISTRATORI ALTRUISTI</b>") {
		scrivi(bigg("BUGS:"));
		//scrivi("1) <i>ulteriori gestioni goliardiche</i> doppioni...");
		$sql="select u.id_gol as idgoliardico,u.id_login as idlogin,g.nomegoliardico,l.m_snome as diChi,count(*) as quanteGetsioniXLui from ulteriori_gestioni_goliardiche u,goliardi g,loginz l WHERE g.id_gol=u.id_gol AND u.id_login=l.id_login GROUP BY u.id_gol,u.id_login,g.nomegoliardico,l.m_snome having COUNT(*)>1";
		//scriviRecordSet($sql); //?!? cazzo è?		
		$res=mysql_query($sql) or sqlerror($sql);
		scriviRecordSetConTimeout($res,30,"1. Ulteriori gestioni goliardiche DOPPIONE","Bisogna ovviamente toglierne fino a farle arrivare a UNA!");
		invio();

		//scrivi("2) goliardi con nome doppione (bisogna cancellarne UNO tranne x i rari doppioni"." veri come buddha, tigre, ...) Bisogna anche sgridare chi ha registrato il II...");
		$sql="select nomegoliardico,count(*) as quanti from goliardi GROUP BY nomegoliardico HAVING count(*)>1";
		
		$res=mysql_query($sql)
			or sqlerror($sql);
		scriviRecordSetConTimeout($res,30,"2. goliardi con nome doppione","Bisogna cancellarne UNO tranne x i rari doppioni, veri come buddha, tigre, ...) Bisogna anche sgridare chi ha registrato il II...");
		invio();

		scrivi("3) Ordini appartenenti a una città INESISTENTE!!!");
		$sql="SELECT m_fileImmagineTn AS _fotoordine,nome_veloce as nome,città FROM ordini WHERE città not in (select nomecitta from regioni)";
		$res=mysql_query($sql) or sqlerror($sql);
		scriviRecordSetConTimeout($res,30,"Ordini appartenenti a una città INESISTENTE","Bisogna segnalare iuna città mancante ed eventualmente aggiungerla");	
			
		//scrivi("3.1) Sbur-user con città INESISTENTE!!! da guestizzare subito!");
		$sql="select m_snome,provincia from loginz WHERE m_bguest=0 AND provincia not in (select nomecitta from regioni)";
		$res=mysql_query($sql) or sqlerror($sql);
		scriviRecordSetConTimeout($res,50,"3.1) Sbur-user con città INESISTENTE!!! da guestizzare subito!");
	//	scriviRecordSet($sql);
		invio();

		$sql="SELECT m_snome,provincia  FROM loginz WHERE m_bguest=0 AND provincia is null";
		$res=mysql_query($sql) or sqlerror($sql);
		scriviRecordSetConTimeout($res,50,"3.2) Sbur-user con città NULLA!!! da guestizzare subito!");
		invio();

		scrivi("4.1) Guest con città INESISTENTE!!! piccolo problema... ma se è vostro amico diteglielo");
		$res=mysql_query($sql) or sqlerror($sql);
		$sql="select m_snome,provincia from loginz WHERE m_bguest=1 AND provincia not in (select nomecitta from regioni)";
		//scriviRecordSet($sql);
		scriviRecordSetConTimeout($res,50,"4.1) Guest con città INESISTENTE!!! piccolo problema... ma se è vostro amico diteglielo");
		invio();

		scrivi("4.2) Guest con città NULLA!!! piccolo problema... ma se è vostro amico diteglielo");
		$sql="SELECT m_snome,provincia  FROM loginz WHERE m_bguest=1  AND provincia is null";
		$res=mysql_query($sql) or sqlerror($sql);
		scriviRecordSetConTimeout($res,50,"4.2) Guest con città NULLA!!! piccolo problema... ma se è vostro amico diteglielo");
		invio();
	}
		else // presento il MENU;
	{


// se nessuna OP è stata visualizzata, presento il MENU:




echo "<h2>Menu dell'Amministratore</h2>";

for ($i=0;$i<sizeof($menu);$i++)
	echo "<b><font color=red>(*)</b></font> <a href='$AUTOPAGINA?op=".
		escape($menu[$i])."'>".$menu[$i]."</a>;<br>";

}

closeTable2();

if (isAdminVip()) {
	openTable2();
	if ($opvip == "AV1) Modifica profilo utente") {
		scrivib($opvip);
                formBegin();
                        popolaComboUtenti("my_hidden_id");
                        formhidden("hidden_operazione","MODUTENTE1");
                scrivi("<input type='submit' value='cambiautente'>\n</form>\n"); 
		#			formEnd(); 
	} elseif ($opvip=="OP_NUOVOORDINE) crea un nuovo ordine (da usare con le pinze)") {
		scrivib("OP_NUOVOORDINE) crea un nuovo ordine (da usare con le pinze)");
			formBegin();
			formtext("nome_veloce","");
			invio();
			formtext("nome_completo","");
			invio();
			formtext("sigla","");
			invio();
			scrivi("vassallo di: ");
			popolaComboConEccezionePrescelta("id_ord_vassallo_di","select id_ord,nome_veloce,città from ordini where sovrano=1","-1","-1","- nessuno -");
			invio();
			scrivi("sovrano: ");
			formScelta2("sovrano","true","false","true","false",2);
			invio();
			#scrivi("città: ");
			#popolaComboCitta("città");
			scrivi("Città: ");
			popolaComboCitta("Città");
			invio();
			formtext("motto","");
			invio();
			formtext("m_fileimmagine","notfound.gif");
			invio();
			formtext("m_fileImmagineTn","notfound.gif");
			invio();
			formtextarea("note","",6,50);
			invio();
			formtextarea("storia","",6,50);
			formhidden("id_utente_creatore",Session("SESS_id_utente"));
			formhidden("data_creazione",dammidatamysql());
			invio();
			formSceltaTrueFalse("m_bserio","Ordine serio",1);
			invio();
			formhidden("hidden_operazione","NUOVOORDINE");
			formbottoneinvia("crea!");
			formEnd();
	} elseif ($opvip== "AV2) Accetta/rifiuta foto mandafoto" ) {
			echo h2("Vediamo le foto che sono nel limbo...");
			if (QueryString('image_id')) {
				$foto_id = QueryString('image_id');
				echo h3("foto selezionata: $foto_id");
				echo "Caro amministratore, puoi scartarla, accettarla o non fare nulla (zen!)";
				echo "Vediamo insieme la foto. Ti rammento che deve essere portrait, la faccia si deve vedere (non un francobollino!) e non pesi piu di 1-2MB per favore! Hai diritto di cambiare la AdminVip Description da qui :)";

				showInfoToAdminvipReMandafotoById($foto_id);
				formBegin();
				formhidden("hidden_operazione","EDITA_MANDAFOTO_2021");
				formhidden("admin_user_id",Session("SESS_id_utente"));
				formhidden("my_hidden_id",$foto_id);
				popolaComboMandafotoStati("status");
				formtextarea("admin_description","",6,50,"dimmi perche");
				formbottoneinvia("edita (non va ancora)!");
				formEnd();

			} else {
				echo h2("Nessuna foto selezionate le mostro tutte");
				echo "Nota che a te interessano quelli in fase 1 (00-NEW). Il tuo potere e di cambiare STATO (fondamentalmente accettare, negare o rimanere in 00-NEW) e aggiornatre l'adminVipStatus :)";
				visualizza_foto_uploadate(true);

			}
	} else {

	echo "<h2>Menu-Admin-Vip</h2>";
	for ($i=0;$i<sizeof($menuvip);$i++)
		echo  "<b><font color=red>(*)</b></font> <a href=$AUTOPAGINA?opvip="
			.escape($menuvip[$i]).">".$menuvip[$i]."</a>;<br>";


	}

}
closeTable2();
}

///////////////////////////////////////
// da qua in poi solo il GM può ovvvero io....


		accertaAdministratorAltrimentiBona();
		scrivi(rossone("Benvenuto, <i>Maestro</i>..."));


		openTable2();


	if ($opgod=="OP205) Cambia Msg del giorno") {
		scrivib("OP205) Cambia Msg del giorno");
		formBegin();
			formtextarea("valore",trim(getMemozByChiave("benvenuto")),10,30);
			formhidden("my_hidden_id_testuale","benvenuto");
			formhidden("hidden_operazione","5");
		scrivi("<input type='submit' value='cambia msg'>\n</form>\n<br>");
	} else if ($opgod== "OP213) Cambia Msg relativo alla prima pagina") {
		scrivib("OP213) Cambia Msg relativo alla prima pagina (<i>didascaliahome</i>)");
		formBegin();
			$val =  getMemozByChiave("didascaliahome") ;
			formtextarea("valore",$val,10,30);
			formhidden("my_hidden_id_testuale","didascaliahome");
			formhidden("hidden_operazione","213");
		scrivi("<input type='submit' value='cambia msg'>\n</form>\n<br>"); 
	} else	if ($opgod=="OP9) Repulisti") {
		scrivi("operazione di repulisti: gms vecchi, msg vecchi (magari prima me li spedisco via mail), ...");
		$rs=query1("delete from gms where (now()-data_invio)>".$GIORNI_OBSOLESCENZA_GMS);
		scrivib("Ho appena cancellato i GMS + vecchi di ".$GIORNI_OBSOLESCENZA_GMS." giorni...<br/>");
		$sql="select titolo,data_creazione from messaggi where (now-data_creazione)>60 order by data_creazione";
		scriviRecordSet2($sql);
	} else	if ($opvip=="OP7) sbircia GOLIARDA") {
		scrivib("OP7) sbircia GOLIARDA");
		formBegin();
			popolaComboGoliardiConUtente("id_gol");
			formhidden("hidden_operazione","7");
		scrivi("<input type='submit' value='guarda'>\n</form>\n");
	}
		else	if ($opgod=="BUGS")
	{
		scrivi(bigg("BUGS:"));
		scrivi("1) ulteriori gestioni goliardiche doppioni...");
		$sql="select u.id_gol,u.id_login,g.[nome goliardico],l.m_snome from ulteriori_gestioni_goliardiche u,goliardi g,loginz l WHERE g.id_gol=u.id_gol AND u.id_login=l.id_login GROUP BY u.id_gol,u.id_login,g.[nome goliardico],l.m_snome having COUNT(*)>1";
		$rs=mysql_query($sql);
		scriviRecordSetConDelete($rs,$sql);
		scrivi("2) goliardi con nome doppione...");
		$sql="select [nome goliardico] from goliardi GROUP BY [nome goliardico] HAVING count(*)>1";
		$rs=mysql_query($sql);
		scriviRecordSetConDelete($rs,$sql);
	}
		else if ($opgod=="OP11) Cambia Foto Primapagina")
	{
		echo bigg("Scegli Foto Primapagina");
		formBegin();
		 formhidden("hidden_operazione","11");
		 popolaComboFilePattern("fotoprimapagina","immagini/primapagina/","p*","pal_tapiro.jpg");
		 formbottoneinvia("vai");
		formend();

		if (isdevelop())
			echo rosso("figata! poi replichi tutto con un altro paz che un giorno sarà la directory di upload!!!");

	}
		else if ($opgod=="OP12) Manda mail a utente")
	{
		echo bigg("Manda foto a un utente");
		formBegin();
		 formhidden("hidden_operazione","12");
			popolaComboUtentiRegistrati("id_login");
			invio();
			formtext("titolo","from goliardia.org");
			invio();
			formtextarea("body","ciao da $GETUTENTE.");
		 formbottoneinvia("vai");
		formend();
	}
		else	// nessuna OPGOD definita - - > chiamo il menugod... 
	{			// se nessuna OP è stata visualizzata, presento il MENU:
	 echo "<h2>Menu-God</h2>";
	 for ($i=0;$i<sizeof($menugod);$i++)
		echo   "<b><font color=red>(*)</b></font> <a href=$AUTOPAGINA"
			."?opgod=".escape($menugod[$i])
			.">".$menugod[$i]."</a>;<br>";
	 closeTable2();	
	}


closeTable2();

include "footer.php";

?>
