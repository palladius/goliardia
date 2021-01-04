<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php"; // er al quarto posto


function finiscePerSpazio($str)
	{return $str[strlen($str)-1]==' ';}



$errore="";
$nickname = strtolower(stripslashes(Post("nickname")));
$password = strtolower(stripslashes(Post("password")));

if (!empty($nickname))
  if ($nickname != Post("nickname")
		||
	finisceperspazio($nickname))
	{echo rosso("x bug inenarrabili son costretto a impedire login che finiscono x SPAZIO o che "
		."contengano maiuscole. I'm terribly zorry... fa il bravo, mo', e riprova senza maiuscole e spazi esterni");
	 bona();
	}

#echo "nickname vale '$nickname' ed � lungo ".strlen($nickname);
#echo "<br>finisce x spazio?!? ".intval(finisceperspazio($nickname));
#bona();

$datalastcollegato="BOH";

$pwdDB="?!?!??!?!?";

function incrementaUtentiAttivi()
{
$attuale = intval(getApplication("utentiattivi"));
$attuale ++;
setApplication("utentiattivi",$attuale);
}





if (! empty($_POST["nickname"])) // era if != "" && isset()
{
	// cerco nel db un match tra nick e pwd
 	// USA M_BATTIVO x vedere se pu� entrare...
	// e fai check su email case unsensitive x il NUOVO UTENTE...


 $autorizzato=0;
 $nick=strtolower($nickname);

 $sql= "select m_spwd,m_bAdmin,id_login,m_thumbnail,m_bIsMaschio,m_bGuest,m_bAttivo,m_bsingle,"
	."m_bserio,m_nPX,m_berremoscia,m_datalastcollegato,provincia,m_bIsGoliard from loginz where m_snome='$nick'";

 $result=mysql_query($sql);
 $riga = mysql_fetch_array($result);

// debRiga($result,$riga); // non consuma la riga


 $rigaTrovata = intval(!empty($riga[0])); // pwd vuota(impossibile) o riga vuota (ci� che voglio)

// scrivib("rigaTrovata: $rigaTrovata.");

	// if (! $rigaTrovata)	scrivi("errore teribbile con fetch row (dovrei dare errore nick non trovato mi sa...sorry): ".mysql_error());

 if (! $rigaTrovata)
	{$errore="Nome '$nick' non trovato nel myDB!!!";	
	}
 else
	{
	
	$pwdDB = strtolower($riga["m_spwd"]); 
	$isAdmin=$riga["m_bAdmin"];
	$user_id=String($riga["id_login"]);
	$thumby=($riga["m_thumbnail"]); 	// nome e cognome, direi.
	$Sex=($riga["m_bIsMaschio"] ? "M" : "F");
	$isGuest=$riga["m_bGuest"];
	$PX=intval($riga["m_nPX"]);
	$PROVINCIA=strtolower($riga["provincia"]);
	$Rmoscia=$riga["m_berremoscia"];
	$isSingle=$riga["m_bsingle"];
	$isSerio=$riga["m_bserio"];
	$datalastcollegato = date($riga["m_datalastcollegato"]);
	$isGoliard = $riga["m_bIsGoliard"];

   if (strtolower($pwdDB)==strtolower($password))
	  {$autorizzato=1;
	   $errore="";
	  } else {
		$errore="passuorde invalida";
	 	log2("password invalida [$nick//$password]");
	}

   if ($riga["m_bAttivo"] != 1) {
	 scrivi("<b>Attenzione, il tuo account non � attivo (vale ".$riga["m_bAttivo"]."), prossimamente questo implicher� che tu non potrai entrare...<br>");
	 scrivi("Questo vuol dire che NON PUOI ENTRARE. Manda una mail a zio Pal per spiegazioni.</b>");
	 $autorizzato=0;
	 $errore="Account disabilitato...";
	}
}

  	 $STAIBARANDO = 0;

  if ($autorizzato) {// metto la sessione giusta...
	echo "yes autorizzato!";
	log2("loggato [$nick]");
  	 if (Session("nickname") == strtolower($nickname))
  	 	$STAIBARANDO = 1; // si sta riloggando

	 $tipo = "sbur-user";
	 if ($isGuest)
	 	$tipo="ospite";

	 $_SESSION["_SESS_nickname"] = ($nickname);

		echo 	"<h1>Il login ha funzionato! altero il nick di sessione, che ora vale: <u>"
			.Session("nickname") 
			."</u>. Pi� in sotto trovi un link che ti manda in manuale alla HOME</h1>";
	 $dd=time();
	 $_SESSION["_SESS_collegato_alle"]	= $dd;
	 $_SESSION["_SESS_ADMIN"]		= $isAdmin;
	 $_SESSION["_SESS_single"] 		= $isSingle;
	 $_SESSION["_SESS_serio"]  		= $isSerio;
	 $_SESSION["_SESS_SEX"] 		= $Sex;
	 //Session.Timeout=60; chiedi a venerdi' come si imposta la durata di una sessione (in mninuti)
	 $_SESSION["_SESS_erremoscia"]	= $Rmoscia;
	 $_SESSION["_SESS_PX"]			= $PX;
	 $_SESSION["_SESS_provincia"] 	= $PROVINCIA;
	 $_SESSION["_SESS_SESS_id_utente"]	= $user_id;
	 $_SESSION["_SESS_id_login"]	= $user_id; # quello di sopra sembra un typo: boh! Ma quanto capra ero 10 anni fa?!?
	 $_SESSION["_SESS_antiprof"]	= 0; 
	 $_SESSION["_SESS_foto"]		= strval($thumby); // inutile
	 $_SESSION["_SESS_nomecognome"]	= $thumby;
	 $_SESSION["_SESS_isgoliard"]		= $isGoliard;
 	 $_SESSION["_SESS_livello"]=$tipo;
 	 $_SESSION["_SESS_powermode"] = 1;

	 setSession("conf_fancy", 1); 
	 setSession("conf_immagini", 1); 
	 setSession("conf_debug",0);
	 setSession("conf_balbuziente",0);
	 setSession("skin",$DFLTSKIN);

#	 sendGms($user_id,"login a userid($user_id) (prova gms automatico by ric!)");
#	 sendGms(3,"login a 3 Benentrato TRE (prova gms automatico by ric!)");

	incrementaUtentiAttivi();

	// aggiorno le variabili...
	$GETUTENTE = getUtente();
	$ISANONIMO = anonimo();

	// aggiorno la tabella degli indirizzi... IP, HOST, USER eccetera...
	aggiornaIndirizzi();

	#echo " qua non ci arrivo... boh!";
	$rs=mysql_query("update loginz set m_datalastcollegato='".dammiDataByJavaDate(time())
			."' WHERE id_login=$user_id")
				or die("cudd'not apd�it i�r m_datalastcollegato, shitt!");

	// devo decidere se la data � cambiata o no, se SI aumento di uno, se NO non faccio nulla

		// 		ad esser + fini... ma freghiamocene del bug...
		//	monthlast=new String(datalastcollegato.getMonth());
		//	monthnow=new String(NOW.getMonth());
		//	nuovogiorno = (daynow != daylast || monthnow != monthlast); // 
	$daynow  = date("d");
	$daylast = date("d",strtotime($datalastcollegato));
	$nuovogiorno = ($daynow != $daylast ); // giorno diverso, ha il bug che se non ti colleghi da 1 mese esatto perdi quel GP... amen :-)

	if ($nuovogiorno ) // x debug
		{//echo "� l'alba di un nuovo giorno...";
		 gestisciGoliardPointz($user_id,1,"incrementa"); // aumento di 1 i GP...
		}
	setApplication("UTENTI_ORA", getApplication("UTENTI_ORA")."\$".strtolower($nickname)."@".time() );

    echo "CIUCCIO OK!!!!!!!!!!!";
    ridirigi("index.php");
  } else echo "non autorizzato";
}


?>


<p><h3> Benvenuto nella pagina di login!!!</h3></p>

<?php 
if (($errore!=""))
{
	echo(htmlMessaggione($errore));

}
//else echo(htmlMessaggione("Nessun errore!!! fico! forte! :)"));

$visualizzaMsgLogin=1; // va ovviamente a 1 a dflt, l'ho messo x non vedermi sta merda in mezo a mare di debug...

if ($visualizzaMsgLogin)
{
?>
<p><b>[ <a href="nuovo_utente.php"><?php  echo rosso("nuovo utente")?></a> | <a href="login_dimenticatapwd.php"><?php  echo rosso("ho dimenticato la password")?></a> ]</b></p>
<br>
<?php opentable();?>

Se � la prima volta che vieni qui, devi sapere che x entrare devi prima 
<a href="nuovo_utente.php"><i>registrarti</i></a>. Questo � stato scelto 
da me e dalla maggioranza degli utenti per proteggere informazioni pi� o 
meno riservate e poich� crediamo che il nostro mondo sia qualcosa di 'iniziatico' 
e ci spiacerebbe vedere ogni pagina indicizzata in ogni motore di ricerca. L'iter � semplice:
ti registri e ti viene inviata una password alla email indicata da te. Da quel momento potrai
tornare qui, inserire il <i>nick</i> che avevi scelto e la <i>password</i> che ti era stata assegnata. <br>
<i>Non dare la password in giro!!!</i>: a fini legali ogni cosa fatta col tuo utente � TUA responsabilit�. <br/>
Se hai dimenticato la password, clicca invece <a href="login_dimenticatapwd.php">qui</a> e se indovini la tua data di nascita
ti verr� rispedita alla mail originaria. Se hai cambiato mail o non riesci a leggerla... scrivimi.

<?php closetable();?>
<!---

<b>Sono <i>gi�</i> registrato <i>e</i> ricordo la password:</b><br>
<i>(ovvero appartengo a una ristretta �lite di rodati navigatori)</i><br/>
<b>attenzione, ho modificato il sistema di attribuzione dei GP: incrementano al + una volta al giorno, quindi non rompete 
i coglioni e fate il login solo quando serve. Sempre vostro, Pal.</b>

--->
<?php  openTable2(); ?>
<form method="post" action="login.php">
inserisci l'username<br>
<input type="text" name="nickname" size="15"><br>
inserisci la password<br>
<input type="password" name="password" size="15" ><br>
<br>
<input type="submit" value="entra"></form>
<?php  closeTable2(); ?>
</div>
<?php 
}
	include "footer.php";

?>





