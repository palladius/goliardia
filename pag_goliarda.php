<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";



$nickname=$GETUTENTE;
$idgoliardico= (QueryString("idgol"));

$BISSS=(Form("idgol"));
$AUTOPOST=Form("hidden_operazione");

if (! empty($AUTOPOST)) 	{
	scrivi("<br>l'operazione è di tipo ".$AUTOPOST."...");

	if ($AUTOPOST=="condividi utente") 	{
		$rs=mysql_query("SELECT * from ulteriori_gestioni_goliardiche where id_login=".Form("id_login")." AND id_gol=".Form("id_gol"))
			or sqlerror($sql);

		if (mysql_num_rows($rs)>0) 			{
			scrivi("Ok, non sei scemo, l'accostamento non c'è già...");
			autoInserisciTabella("ulteriori_gestioni_goliardiche");
			}
		else 
			scrivi(rossone("Ma sei deficiente?!? L'accostamento esiste già!!! Fortuna che "
			."ho fatto il controllo e... in termini prestazionali... E IO PAGO! Un antico "
			."dilemma informatico DBstico: reattivo o proattivo? Reattivo costa meno, ma f"
			."inché c'è gente come te..."));

		}
	else if ($AUTOPOST=="regala utente") {
		$rs=mysql_query("update goliardi set id_login=".Form("id_login")
			." WHERE id_gol=".Form("id_gol"));
		 scrivi(big("Fatto, ho cambiato il creatore di questo goliarda nell'utente numero ".Form("id_login")));
		 tornaindietro("torn bek tu ze peig ov da goliard jast reghéil'd","pag_goliarda.php?idgol=".Form("id_gol"));
		}
	else if ($AUTOPOST=="togli concessione") 	{
	 autoCancellaTabella("ulteriori_gestioni_goliardiche","id");
	 scrivi(rosso("ok, <b>concessione tolta</b>."));
	}
	else scrivi(rossone("mah, strano, nessuna operazione nota, bensì '".$AUTOPOST."'... mah!"));
	bona();
	}

if (empty($idgoliardico))
	if (empty($BISSS)) 		{
		//////////////////////////////////////////////
		////// pag data senza ID...provo a fare una form x chiedere che goliarda cercavi...	
			formbegin();
			popolaComboGoliardi("idgol");
			formbottoneinvia("go go go");
			formend();
	//		scrivi("<input type='submit' value='GO GO GO'>\n</form>\n");

		scrivi(rossone("Mi spiace ma devo sapere che goliarda cerchi, brutto scemo!"));
		bona();
		}
	else $idgoliardico=$BISSS;

$NOMONE = "uninizialaized yett";
$nickVero = $GETUTENTE;
scrivid(rosso("Mi devo accertare che tu (".$nickname
		.") sia effettivamente abilitato a modificare ".$NOMONE."<br>\n"));

$dirittiScrittura = (isAdminVip() || utenteHaDirittoScritturaSuGoliardaById($idgoliardico));


 $sql    = "select * from goliardi WHERE id_gol=$idgoliardico";


 $resSet = mysql_query($sql)
	or sqlerror($sql);


 if (mysql_num_rows($resSet)==0)
	{$errore="Utente non trovato!<br>$DILLOALWEBMASTER<br>";
	 scrivi(rossone($errore));
	}
 else
	{ // eccoci qua, devo presentare in tabella i dati...
	$recSet=mysql_fetch_array($resSet);
	$NOMONE=rs_goliardi_getNomeGoliardicoCompleto($recSet);
	scrivi("<center>");
		//HEADER
	if ($dirittiScrittura)
		{
		scrivi("[ <a href=\"modifica_goliarda.php?idgol=".$recSet["ID_GOL"]."\">modifica goliarda</a> |");
		scrivi(" <a href='#cursushonorum'>modifica le sue nomine</a> | ");
		scrivi("<a href='#diritti'>modifica diritti degli utenti sul goliarda</a> ]<br>");
		}
	scrivi("<br><h1 class='goliarda'>".$NOMONE."  ");
	$fotoSua=rs_goliardi_getFotoPersona($recSet);
      if (! esisteFile($paz_foto_persone.$fotoSua))
				{ $strFoto=("<center>la foto '".$fotoSua
					."'<br>è NON DISPONIBILE</center></td>\n</tr>\n<tr>\n  <td>");
				  log("errore di foto non trovata: ".$paz_foto_persone.$fotoSua);
				}
	else
		scrivi(" <img src='".$paz_foto_persone.$fotoSua."' height=100 align='center' alt='".toglidireext($fotoSua)."'></h1> ");
	scrivi("</h1></center>\n");


 scrivi("<center>");
if ($dirittiScrittura)
	{
	// scrivi("<a href=\"modifica_goliarda.php?idgol=".$recSet["ID_GOL"]
	//	."\"><big><big>Concedi questo goliarda anche a un altro utente: </big></big></a><br><br>")
	}

	openTable();
	scriviReport_Goliarda($recSet);
	closeTable();
	invio();

	echo "</center>";

	// iniziamo il computo dei link eventualmente a lui correlati..
$res=mq("select * from linkz l, loginz u where u.id_login=l.id_login and tipo='goliardi' and id_oggettoPuntato=".$recSet["ID_GOL"]);
$n=mysql_num_rows($res);

if ($n != 0)
	{
	 echo h2("Links correlati al goliarda num ".$recSet["ID_GOL"]);
	 while ($rs=mysql_fetch_array($res))
		{
	 	 scriviReport_Link($rs);
		}
	}


if ($dirittiScrittura)
 scrivi("<big><a href=\"modifica_goliarda.php?idgol=".$recSet["ID_GOL"]
		."\">Modifica  <i class='goliarda'>".$recSet["Nomegoliardico"]."</i></a></big><br><br>");

	echo "</center>";

	scriviReportCursusHonorumById($recSet["ID_GOL"],$dirittiScrittura);


if ($dirittiScrittura)
{	invio();
	hline(50)	;

	scriviReportModificaDirittiUtentiSulGoliarda($recSet["ID_GOL"]);
}
 scrivi("</center>");
	echo "</center>";



if ($DEBUG_ON)
	{
	scriviRiga($recSet);
	}

	}
include "footer.php";
?>

