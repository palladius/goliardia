<?php 
include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$VALIDA_FORM=1;


function aggiungiJavaScript() {
?>
<script language="javascript" type="text/javascript">
		function validaRadio(nome) {
			var checked=0;
			//var arr=document.getElementById('labs['+nome+']');
			var arr=document.iscrivigoliardia[nome];
			for (var i=0;i<arr.length;i++) {
				if (arr[i].checked ==  true) {
					checked=1;
				}
			}
			return checked;	// un radio e' calido se e solo se hai barrato una scelta
		}
		function erore(s) { alert(s); }
		function debug(s) { if(0) alert("DEB| "+s); }
		function validaNonVuoto(s) {
			var val=document.iscrivigoliardia[""+s+""].value
			//var val=document.getElementById(s);
			//return (val != "" && val != null)
			return 1
		}
		function validaTextArea( Field) {
			var length = eval("document.iscrivigoliardia." + Field + ".value.length");
			if (length == 0) {
				return false;
			} else {
				return true;
			}
		}
		function validaCombo(s) { // non valida una combo che abbi un elemento di valore NISBA
			var regex= new RegExp("nisba","i");
			var val=document.iscrivigoliardia[s].value
			debug(s+"vale "+val);
			return (! regex.exec(val)); // se contiene 'nisba' vuol dire che non ha dato una scelta
		}
		function golValidaTutto() {
			var f=  document.iscrivigoliardia;
			var er="";
					// valida combobox
			//var arrCombo=new Array("titoloStudio","occupazione");
			//for (k=0; k<arrCombo.length;k++) {
			//	el=arrCombo[k];
			//	if (! validaCombo(el)) {
			//		er += "campo '"+el+"' vuoto\n";
			//	}
			//}
					// deve valere ACCETTO
			if (  iscrivigoliardia['disclaimer'][1].checked ) {
				 er += "ATTENZIONE, devi dare il consenso per il trattamento dei dati personali\n"; 
			}
					// valida radioButton
					// radio NON NULLI (a default li rendo nulli x maggior probabilità di dato buono)
					// valida textbox
			var arrNonVuoti=new Array("nick","nomecognome","email","note","interessi","gustisessuali");
			for (k=0; k<arrNonVuoti.length;k++) { 
				elems=arrNonVuoti[k];
				if (!  validaTextArea(elems)) {
					er += "campo '"+elems+"' nullo\n";
				}
			}
			
			return er;
		}
		function submitbutton() {
			var form = document.iscrivigoliardia;
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
				// inizio parte custom LABS
			var golOk=golValidaTutto();
			if ("" != golOk) {
				alert("ATTENZIONE: C'e' qualcosa che non va:\n--\n"+golOk);
				return; // se fallisce techne' non gli chiedo i parametri normali...
			} else {
				debug("OpenG: tutto ok (nel senso i campi custom)");
			}
				// fine parte custom

			// do field validation
			if (form.nick.value == "") {
				alert( "Inserisci il tuo nickname" );
			} else if (form.nomecognome.value == "") {
				alert( "Inserisci Nome (e volendo Cognome)" );
			} else if (r.exec(form.nomecognome.value) || form.nomecognome.value.length < 3) {
				alert( "Per favore, inserisci un campo NomeCognome valido. Senza spazi, con pi&#249; di 2 caratteri che comprendano 0-9,a-z,A-Z" );
			} else if (form.email.value == "") {
				alert( "Inserisci un indirizzo e-mail valido" );
			} else {
				debug("DEB2: dati ok, mi hai dato; invio dati al sito");
				form.submit();
			}
		}
		</script>
<?php 
}

$VER="2.1";

$utenteIp=$_SERVER["REMOTE_ADDR"];

$fatto= FALSE;
$errore=0;

$postatoQualcosa=String(Form("hidden_operazione"));	# dice se ho cliccato
#if ($postatoQualcosa) {
#echo "<h1>ispal: $ISPAL postato</h1>";
#}

$nick=String(Form("nick"));
#if (nick == "undefined") nick="";
$note=(String(Form("note")));
#if (note == "undefined") note="";
$note=encodeApostrofi($note); // raddoppia gli apostrofi...
if ($nick!="") // ragionevolmente FORM(nick) esiste se e solo se esiste FORM(data), così non dà warning...
	$datanascita = getAutoDataByFormmysql("datanascita"); 
$mbisgoliard = String(Form("m_bIsGoliard"));
$email = strtolower(Form("email"));
$sex=String(Form("m_bIsMaschio"));
$nick=strtolower($nick); // memorizzo tutto in lower!

$msgErrore = ""; //"de che aoh";

$msn = String(Form("msn"));
	if ($msn == "") $msn="-";
	$msn = encodeApostrofi($msn);
$nomecognome = String(Form("nomecognome")); 
			// andrà nella variabile m_thumbnail lo so che è sporco ma...
	if ($nomecognome == "") $nomecognome="-";
	$nomecognome = encodeApostrofi($nomecognome);
$icq = String(Form("icq"));
	if ($icq == "") $icq ="-";
	$icq = encodeApostrofi($icq);
$interessi= String(Form("interessi"));
//	if ($interessi== "") $interessi="-";
	$interessi = encodeApostrofi($interessi);
$gustisessuali= String(Form("gustisessuali"));
//	if ($gustisessuali== "") $gustisessuali="-";
	$gustisessuali = encodeApostrofi($gustisessuali);
$provincia= String(Form("provincia"));

$issingle = intval(Form("m_bSingle"));
	# cambiato il 20050915
//$isserio = intval(Form("m_bSingle"));
$isserio = intval(Form("m_bSerio"));
$m_berremoscia= intval(Form("m_berremoscia"));


#$DEBUG=1;
if ($DEBUG || $ISPAL) {
	visualizzaFormz();
}

if ($postatoQualcosa) {
	# verifichiamo la bontà del POST
	if ($gustisessuali=="" ) { 
		$msgErrore = (htmlMessaggione("campo gustisessuali vuoto")); }
	else if ($icq=="" )
		$msgErrore = (htmlMessaggione("campo Skype  vuoto (vale '$icq')..."));
	else if ($interessi=="" )
		$msgErrore = (htmlMessaggione("campo interessi vuoto (vale '$interessi')..."));
	else if ($nick!="") { //echo "nick vale qualcosa ($nick)...";
		  if (! isValidNick($nick))
			$msgErrore = (htmlMessaggione("Nome mal formato (contiene caratteri non buoni)..."));
		  else if (!isValidMail($email)) {
			 $msgErrore = (htmlMessaggione("E-Mail scritta male... Guarda che se la metti sbagliata non saprai mai la tua pwd e non entrerai cmq!!!"));
	}
   else // tutto ok, nome e pwd van bene
	{
   	scrivi(htmlMessaggione("sembra ciuccio ok..."));
	$nick=strtolower($nick);
	$sql1="select m_spwd,m_bAdmin,id_login,m_thumbnail,m_bIsMaschio,m_bGuest,m_bAttivo,m_nPX from loginz where m_snome like '$nick' OR m_hemail like '%$email%'";
 	$recSet1= mysql_query($sql1);
 	$msgErrore="_ERROR_UNDEF'D";
 	$row=mysql_fetch_row($recSet1);
	if (!empty($row)) // riga vuota
		{
		$msgErrore=(htmlMessaggione("Il nome '$nick' oppure la email '$email' sono gia' presenti!!!"));
		}
	   else // riga query non vuota
		{
	 	echo "creo la pwd.. Se hai problemi con l'iscrizione contatta il <a href='mailto:".$WEBMASTERMAIL."'>webmaster</a><br/>";
		 $randompwd = creaPassword();
		 $sql    = "INSERT INTO loginz (m_sNome,m_spwd,m_hemail,M_dataiscrizione,m_bIsMaschio,m_snote,m_battivo,"
			."m_bguest,m_bIsGoliard,datanascita,m_berremoscia,msn,provincia,gustisessuali,interessi,icq,"
			."m_thumbnail,m_nPX,m_bmailpubblica) values ('"
			.$nick."','".$randompwd."','".$email."','".getmysqldata()."',".intval($sex).",'".$note."',1,1,"
			.intval($mbisgoliard).",'".$datanascita."',".$m_berremoscia.",'".$msn."','".$provincia."','"
			.$gustisessuali."','".$interessi."','"
			.$icq."','".$nomecognome."',0,0)";
		 if ($ISPAL)
			 scrivi(rosso($sql));
		 mysql_query($sql)
		 	or die("<br><b>ahi ahi ahi!!!</b> la query non è andata a buon fine: ".mysql_error());

		$bodi = "<center><h1>Benvenuto nel sito www.goliardia.it!</h1></center>\n<br>La password da te richiesta per il login '<b>$nick</b>' '<b>$randompwd</b>'. Prova a fare il login <a href='http://www.goliardia.it/'>qui</a>. Se non ti piace, puoi sempre cambiarla nella sezione <b>UTENTE</b> (in alto in ogni pagina).<br><br>Ti ricordo che mi hai detto che:<br>"
		."E-mail: <b>$email</b><br>Nome e cognome: <b>$nomecognome</b><br>Data di nascita: <b>$datanascita</b><br>"
		."Sei goliarda o meno: <b>".($mbisgoliard ? "goliarda" : "filisteo")."</b><br>Sesso: <b>".($sex ? "maschio" : "femmina")."</b><br>Note: <b>$note</b><br>Citta': <b>$provincia</b><br>"
		."IP: <b>".$utenteIp."</b><br/>"
		."<br>P.S. Se non vuoi essere guest, devi <i>banalmente</i> mandarmi una foto con la tua faccia. I motivi e soprattutto il formato (jpg, - di 10 KB, ...) li trovi nelle <a href='faq.php'>F.A.Q.</a>  del sito che rispondono alla maggior parte delle domande che ti  possono ora come ora venire in mente. Vacci a dare un occhio!!! <i>Mi raccomando quando ti degnerai di mandarmi la foto mandala (1) dallo stesso indirizzo con cui ti sei iscritto e (2) col nome della foto pari al tuo nome  goliardico, x esempio se tu sei icsus mi devi mandare la foto 'icsus.jpg', ok?!? In caso contrario verra'  cestinata</i>. Se me la spedisci e non compare entro 1 giorno e' probabile che l'abbia cestinata. Sai ne ricevo TANTE al giorno, il minimo e' che me le spediate secodo il formato che vi CHIEDO. quindi perdete 5 minuti a guardare le FAQ. Grazie.<br>\nTroverai in questo sito parole volgari talvolta poiche'  c'e'  assoluta libertà di espressione; se la cosa ti disturba, non entrarci. Entrando NON renderai disponibile la tua emailagli iscritti. Grazie.<br>\n<br>e ora sei pronto x il <a href='login.php'>login</a>!!!<br> PS. X domande triviali, anziche' scrivermi, chiedi in chat  a qualche amministratore " ."x favore: ricevo una trentina di mail al giorno sempre uguali :( ...";
				// operazione ok, spedisco i dati via mail...
		scrivi("Invio mail...<br>");
		log2("qualcuno iscritto col nome di '".$nick."' e pwd '$randompwd'");
		mandaMail($email,$WEBMASTERMAIL,"[www.goliardia.it] Iscrizione riuscita di '".$nick."'",$bodi);

		$res=mq("select id_login from loginz where m_snome like '$nick'");
		$rs=mysql_fetch_row($res) or die("non ti ho mica inserito nel sito, cacchio! sob! dillo a pal.");

		sendGms($rs[0],"Benentrato nel sito! prima di disturbare via mail, guarda le FAQ x favore o chiedi in chat! "
			."(Il webmaster ha tante cose da fare e odia chi manda mail piene di ovvietà: grazie! Se no le faq"
			." che le compila a fare?)");
		if (! $sex) {
			#sendGms(3,"GNOCCA Si e' iscrittA al sito <a href='utente.php?nomeutente=$nick'>$nick</a>,sex='".($sex ? "maschio" : "femmina")."' ,<a href='mailto:$email'>$email</a>'.");
		} else {
			#sendGms(3,"Si e' iscrittO al sito <a href='utente.php?nomeutente=$nick'>$nick</a>,pwd='$randompwd',sex='".($sex ? "maschio" : "femmina")."' ,<a href='mailto:$email'>$email</a>'.");
		}
		scrivi("<center>");
		scrivi(rossone("Il nome '".$nick."' è stato succesfulmente spedito a '".$email."'!!! <br>Vai a leggere la posta e poi"));
		scrivi(big("<a href='login.php'>Va al login</a>.<br> Se invece hai scritto male la email fai un piacere al Webmaster e <a href='mailto:".$WEBMASTERMAIL."'>digli di aver inserito un utente x sbaglio</a>, X FAVOREEEEEEEEEEE. Grazie. <br/> <h2 class=debug>Ricordati che se la mail scritta e' sbagliata oppure punta a uno di quegli indirizzi hotmail che non accettano mail la password NON TI ARRIVERA' MAI. Il 90% della gente che mi stressa sull'iscrizione mette delle mail del cavolo, quindi prima di stressarmi siate certi che il vostro account RICEVA mail; se siete convinti, ditemi qualcosa tipo 'ciao Palladius, sono XXX e mi sono scritto come YYY dando mail ZZZ ma non va: puoi aiutarmi? Questi 3 dati spesso non me li date credendo che io sia un indovino...' Comunque sia, vi chiedo cortesemente di <u>aspettare una decina di minuti</u> (il server di posta e' abbastanza carico quanto a mail, quindi facciamo anche dieci minuti), se la email non arriva provate a usare la form di password dimenticata (LOGIN-&gt;Ho dimenticato la password) e inserire il vostro nome... quello strumento vi spedisce la password all'indirizzo email associato all'utente che digitate. Se dopo un altro minuto non va, scrivetemi pure. Due minuti persi per voi, due ore guadagnate per me...</h2>"));
		exit;
		} // fine else (riga di query NON vuota
	}
}

} # fine valutazione form, ora inizia l'html normale...







//include "header.php";

?>  
<center>
<?php 

function iniziaCon($str,$iniz) { $pos= strstr($str,$iniz); return ($pos == $str); }

function visualizzaArr($arr) { # serve per technedonne, lo rifaccio da zero
	$t="";
	while(list($k,$v)=each($arr)) {
		$t .= "chiave[$k]: <b>$v</b><br/>\n";
	}
	return $t;
}
function visualizzaArrIniziaPer($arr,$inizio) { # serve per technedonne, posta i pezzi di fomr che iniziano con "data" ad esempio
	$t="";
	while(list($k,$v)=each($arr)) {
		if (iniziaCon($k,$inizio)) 
			$t .= "chiave[$k]: <b>$v</b><br/>\n";
	}
	return $t;
}
if (! empty($msgErrore)) {
	scriviErroreSpapla( $msgErrore."<br><b>PS</b> Se clicchi qui ti si resetta la form. Vai "
		."in basso e molto te l'ho riportato pari pari. Una futura feature, ti colorerò di rosso "
		."cio' che hai sbagliato. Nel frattempo cerca di dormire lo stesso..." ,$AUTOPAGINA);
	$body=	"<table border=1><tr><td>Errore nell'iscrizione: </td><td>$msgErrore</td></tr>"
		."<tr><td>IP:</td><td>$utenteIp</td></tr> "
		."<tr><td>POST TOTALE GLOBALE:</td><td>".visualizzaArr($_POST)."</td></tr> "
		."<tr><td>POST TOTALE GLOBALE: INIZIA PER 'da'</td><td>".visualizzaArrIniziaPer($_POST,'da')."</td></tr> "
		."<tr><td>SERV TOTALE GLOBALE:</td><td>".visualizzaArr($_SERVER)."</td></tr> "
		."</table> ";
	mandaMail("$WEBMASTERMAIL",$WEBMASTERMAIL,"[www.goliardia.it] Iscrizione fallita: $nick@$utenteIp",$body);
}

if ($fatto)
		echo(htmlMessaggione("NICK <i>registrato</i>!!! la password ti è appena stata spedita via mail. Controllala e poi vai al login"));
if ($errore==1)
	echo('<p><font color="red"><b>Hai utilizzato caratteri non validi</b></font></p>');
if ($errore==2)
	echo('<p><font color="red"><b>Il nick è già in uso</b></font></p>');
if ($errore==3)
	echo('<p><font color="red"><b>La mail è già in uso</b></font></p>');
if ($errore==4)
	echo('<p><font color="red"><b>Qualche campo (MSN,ICQ,...) vuoto</b></font></p>');
?>

<h2>registrati nel sito!</h2>

<h2>CONSIGLI</h2><br>

<font class='errorone'>ATTENZIONE!!!</font> <br>
<b>Ti conviene mettere una <i>e-mail</i> giusta</b> piuttosto che farlocca, 
<b>poiché lì ti viene spedita la PASSWORD</b> (senza la quale nel sito non ci entri). 
Sappi che non ti verranno spedite schifezze pubblicitarie né altro se non per errore, 
magari ti scriverò io dicendo "ehi tu chi sei?!?" e poco altro. Se non vuoi registrarti
 devi accontentarti della pagina di facciata (la <a href='index.php'>home</a>), ma attento
 che i link sono disabilitati (o meglio, sono attivi ma ti spediranno sempre al LOGIN). 
Altra cosa: la maggior parte dei campi è obbligatoria, se no dà errore :-(


<br><br>
<br>

<b>NB</b> <u>Per i non goliardi</u> Sappiate che questo nasce come sito goliardico, quindi 
leggerete facilmente parole volgari sia nei forum che in chat. Inoltre i goliardi hanno un 
modo tutto loro di giocare che può essere mal interpretato da un non-goliarda come un'offesa
 gratuita. Di solito NON E' COSI', comunque siete avvisati: alcuni contenuti possono essere 
ritenuti offensivi.

<br>
<br>
<br>

<?php  if ($VALIDA_FORM) {aggiungiJavaScript();} ?>
<form method="post" action="nuovo_utente.php" name='iscrivigoliardia'>

<table>
<tr>
 <td width="50%">inserisci il <b>nick</b> (possibilmente il nome  goliardico, <i>se</i> sei goliarda)</td>
 <td width="50%"><input type="text" name="nick" size="15" value="<?php  echo Form("nick")?>"></td>
</tr>

<tr>
 <td width="50%">inserisci il <b>nome e cognome</b> (che compariranno pubblicamente, per privacy puoi anche mettere solo il nome, giusto qualcosa perchè ti si riconosca: ci sono tanti casi di omonimia goliardica, sapessi!!!)</td>
 <td width="50%"><input type="text" name="nomecognome" size="20" value="<?php  echo Form("nomecognome")?>"></td>
</tr>

<tr>
	<td>inserisci la tua <i>e-mail</i> (e che sia giusta!)</td>
	<td><input type="text" name="email" size="25" value="<?php  echo Form("email")?>"></td>
</tr>

<tr>
	<td>inserisci il tuo indirizzo di  <i>MSN</i> (se ce l'hai, se no tranqui!)</td>
	<td><input type="text" name="msn" size="25" value="<?php  echo Form("msn")?>"></td>
</tr>
<tr>
	<td>inserisci il tuo indirizzo  <i>Skype</i> (se ce l'hai, se no tranqui!)</td>
	<td><input type="text" name="icq" size="25" value="<?php  echo Form("icq")?>"></td>
</tr>
<tr>
	<td>inserisci la <b>provincia</b> in cui vivi (vi sono anche stati al'estero), nel dubbio la città che ospita il tuo ordine. Mi raccomando, se la TUA città non è applicabile, metti un valore a caso e segnalamelo via mail che la aggiungerò prontamente, ok? Potrai sempre cambiarla nella sezione utente man mano che ti sposti per il mondo o nel caso io aggiunga la tua amata provincia.</td>
	<td> 
		<!--- input type="text" name="provincia" size="25" --->
		<?php  popolaComboCitta("provincia",Form("provincia")); ?>

	</td>
</tr>
<tr>
	<td>inserisci i tuoi interessi in breve</td>
	<td><?php   formtextarea("interessi",Form("interessi"),5,30); ?></td>
</tr>
<tr>
	<td>inserisci i tuoi <b>gusti sessuali</b> in breve (posizioni, targets, .., qualunque cosa possa far ridere più di una barzelletta per ingegneri raccontata dallo zio Pal)</td>
	<td><?php   formtextarea("gustisessuali",Form("gustisessuali"),5,30); ?></td>
</tr>

<tr>
	<td >inserisci il Sesso</td>
	<td><?php  formScelta2("m_bIsMaschio",1,0,"Maschio","Femmina",1)?></td>
</tr>
</tr>
	<td >Sei un goliarda?!?</td>
	<td><?php  formScelta2("m_bIsGoliard",1,0,"sì","no",1)?></td>
</tr>


<tr>
	<td>inserisci la tua <i>data di nascita</i> (ti servirà se oblii la pwd)</td>
	<td><?php  popolaComboGGMMYY("datanascita")?></td>
</tr>
<tr>

	<td>Hai la erre moscia?</td>
	<td><?php  formScelta2("m_berremoscia",1,0,"sì","no",2)?></td>
</tr>
<tr>
	<td>inserisci note su di te... (max 150 caratteri). <b>Ti prego</b>, scrivi qualcosa che mi aiuti a identificarti. Account con note nulle verrano spesso cancellati a <I>insindacabile tiramento di culo</i> (ITC®) del Webmaster</td>
	<td><?php   formtextarea("note",Form("note"),5,30); ?></td>
</tr>
<tr>

	<td>Sei single?</td>
	<td><?php  formScelta2("m_bsingle",1,0,"sì","no",1)?></td>
</tr>
</tr>


<tr>

	<td>Sei serio? (se scegli SI, verranno nascoste a te certe cose tipicamente buffe x cui certi anziani potrebbero storcere il naso, come un ordine sovrano su Tokio o Gotham City)</td>
	<td><?php  formScelta2("m_bSerio",1,0,"sì","no",2)?></td>
	<?php  formhidden("hidden_operazione","iscrizione_sito06");


	?>
</tr>
<tr><td bgcolor="#FFFFCC" colspan='2'>
	<center><h2>DISCLAIMER (momento serio)</h2>
Sapete che ci sono leggi sulla privacy che proibiscono di pubblicare dati personali non 
autorizzati. Iscrivendoti a questo sito accetti implicitamente due cose: 1) di rendere
 visibile agli utenti del sito informazioni su di te che tu stesso ci dai (ovvero TUTTO
 tranne la tua e-mail, che conoscerò solo io); 2) ti impegni a NON pubblicare dati su 
altre persone sapendo che questa potrebbe non volere che essi vengano pubblicati. Perlopiù
 è di solito facile risalire a chi sia stato a fare una certa cosa... Questo è MOLTO importante
 da capire. Se una persona si collega al sito e vede il proprio nome, i propri dati personali
 e/o la propria foto pubblicata ha tutti i diritti di sporgere denuncia. Io tengo traccia di 
CHI mi manda le foto e di chi mi butta su i dati (ho creato un sistema di LOG niente male) e 
quindi è facile risalire al responsabile: NON PUBBLICATI DATI DI PERSONE CHE NON SIATE VOI A 
MENO CHE NON VI ABBIANO DATO IL CONSENSO!<br/>
<b>Vi ricordo che <i>iscrivervi a nome di un'altra persona</i> (è successo) pubblicandone dati
 o anche associando il nome a una sua foto costituisce reato di violazione della privacy. Poiché
 i vostri IP sono loggati, è molto facile per la polizia postale individuare da dove vien fatta
 la chiamata. Evitate di farlo, nel vostro interesse, poiché il diretto interessato potrebbe 
denunciarvi e io non mi assumo alcuna responsabilità per attività maliziose nel mio sito.</b>

<div align="right">Riccardo Carlesso</div>
</td></tr>
<tr> 
        <td>Hai letto e accetti il quanto scritto sopra?</td>
        <td><?php  formScelta2("disclaimer",1,0,"sì","no",2)?></td>
</tr>
</table>
<br>
<!-- <input type="submit" value="Ho letto il disclaimer, lo accetto e mi registro"> -->
 <input type="button" value="Ho letto il disclaimer, lo accetto e mi registro" onclick="submitbutton()" /> 
<!-- <input type="button" value="Invia Registrazione" class="button" onclick="submitbutton()" /> -->

</form>


<p><b>N.B.</b> non utilizzare caratteri strani (minori, maggiori, chiocciole, dollari...) nel nome né, se possibile caratteri accentati e simili. Se poi qualcosa non funzia, son cacchi tuoi! </p>
<p><b>[ <a href="login.php">pagina di login</a> ]</b></p>
</center>

<?php 
include "footer.php";
?>


	
