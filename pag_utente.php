<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


if (anonimo())
 	{
	 scrivi(rossone("Ma cosa vuoi mai guardare <i>tu</i>?!? Smamma!"));
	 bona();
	}


//scriviReportGoliardaDefault();



tabled()
?>
<tr><td valign="Top" colspan="40%">
		<h1><center>Ordini</h1>

		<h2><center>Tutti gli Ordini</h2>

<center><i>Con questa finestrella puoi visualizzare tutti i dati su 
un ordine che t'interessa; molto probabilmente non avrai il potere di alterare questi dati.</i>
<?php 


		scrivi("<center>");
		formbegin("modifica_ordine.php");
		 popolaComboOrdini("idord");
		 formbottoneinvia("fam vedar");
		formend();
//		scrivi("<input type='submit' value='fam vedar'>\n</form></center>\n");
		scrivi("</center>");
		

		/////////////////////////////////////////////
		//// query che stampa ordini singoli

scrivi("<h2>Ordini gestiti</h2>");
$sqlCitta  = "SELECT DISTINCT o.id_ord as _linkOrd,o.nome_veloce,o.m_fileImmagineTn as _fotoordine,o.sovrano as _sovrano,o.città "
		." FROM ordini o, gestione_ordini g, loginz l "
    		." WHERE g.id_login=l.id_login AND l.m_snome='$GETUTENTE'"
		." AND o.id_ord=g.id_ordine order by città,sovrano,nome_veloce asc";

$res  = mysql_query($sqlCitta)
	or ("erore query cita ".mysql_error());
$i=0;
$nessuno=FALSE;

scriviRecordSetConTimeout($res,50,"Gli ordini singoli","Quelli che seguono sono invece gli ordini che Palladio ha voluto potessi addirit"
        ."tura modificare; potrai aggiungere cariche per questi ordini e addirittura nominare gol"
        ."iardi con queste cariche... Nota bene, se sei un aficionados, che sono scomparse le gestioni per citta': troppi casini in fase di sviluppo");

hline(80);

		/////////////////////////////////////////////
		//// query che stampa città con a lato i suoi ordini

$sql0  = "select g.città from gestione_citta g, loginz l WHERE g.id_login=l.id_login "
    	. "AND l.m_sNome LIKE '$GETUTENTE' order by g.città";

$res0 = mysql_query($sql0)
	or sqlerror($sql0);
		/* la gestione delle citta' e' ora obsoleta...
scrivi("<h3>Intere città:</h3>");
tabled(); 
while ($row=mysql_fetch_array($res0)) {
	$citta=$row["città"];
	scrivi("<tr><td valign='top'><strong>".big($citta).":</strong></td><td>");
	$sqlCitta = "select id_ord,nome_veloce,m_fileImmagineTn,sovrano from ordini where città LIKE '".$citta."' $SERIOSTRING order by sovrano,nome_veloce asc";
	$resCitta = mysql_query($sqlCitta); 
	while ($rsCitta=mysql_fetch_array($resCitta)) {// x ogni ordine della città i-ma... stampa un bel link e magari un bel thumbnail!!!!!
		 scrivi(getOrdineConFotoStringByNameThumbConNome($rsCitta));
		 invio();
 	}
	trtdend();
}
scrivi("</TR></table>");
		*/




		////////////////////////////////////////////////
		////// GOLIARDI GESTITI



	scrivi("</td><td valign='Top' colspan='60%'>");


/////////
		scrivi("<h1><center>Goliardi</center></h1>");
		scrivi("<h2><center>Tutti i goliardi</center></h2>");
?>
<center><i>Con questa finestrella puoi visualizzare tutti i dati su
 un ordine che t'interessa; molto probabilmente non avrai il potere di alterare questi dati.</i>
<?php 

		scrivi("<center>");
		formbegin("pag_goliarda.php");
		popolaComboGoliardi("idgol");
		formbottoneinvia("fammi vedé");
		formend();

 $sql    = "select count(*) as quanti from goliardi g,loginz l"
	  . " WHERE l.m_sNome = '" .$GETUTENTE."' "
	  . " AND l.id_login=g.id_login ";

 $res =mysql_query($sql);
 $rs=mysql_fetch_array($res);
scrivi("<h2><center>Goliardi in Gestione (tot: ".$rs["quanti"].")</center></h2>");
scrivi("<h3><center>goliardi tuoi (tot: ".$rs["quanti"].")</center></h3>");




?>
<i>Questi sono i goliardi registrati da te o regalati a te, afferiscono direttamente a te; 
in un mondo ideale dovresti averne solo uno (te stesso)
 ma se ci pensi può anche aver senso che tu registri x esempio l'intero tuo ordine e tu 
abbia in <em>possesso</em> N goliardi. In futuro potrai comunque
 regalarli ad altri utenti.</i>
<?php 



//$nickname=String(getUtente())

 $nick=$GETUTENTE;

 $sql    = "select * from goliardi g,loginz l, ordini o "
	 . " WHERE l.m_sNome = '" . $nick ."' "
	 . " AND l.id_login=g.id_login "
	 . " AND o.id_ord=g.id_ordine "
	 . " ORDER BY g.nomegoliardico";


 $foto="";
 $strFoto="";

 $ress=mysql_query($sql)
	or sqlerror($sql);


	scrivi("<table class='nuovogoliarda'><center>\n"); 
				// riga di aggiunta goliarda nuovo
		trtd();
		freccizzaFrase("<b >Crea Nuovo Goliarda</b>");
		tdtd();
		formbegin("nuovogoliarda.php");
		formtextBr("dinomegoliardico",$nick." (ad esempio, non cliccare come un pecorone)");
		if (isGuest())
			scrivi("NON PUOI AGGIUNGERE goliardi xche' ospite...");
		else	
			{tdtd();
			 formbottoneinvia("aggiungi");
			 formend();
			trtdend();
//			scrivi("<input type='submit' value='AGGIUNGI'>\n</form>\n</td>\n</tr>\n");
			}
	scrivi("</table><table ><center>\n");

	while($recSet=mysql_fetch_array($ress))
		scriviReport_GoliardOrdine($recSet);

	scrivi("</center></table>");
	


scrivi("<h3><center>Goliardi in ulteriore gestione</center></h3><center>");

?>
<i>Questi sono i goliardi registrati da altri o dati ad altri, che
 per qualche arcano motivo si ritiene che anche tu possa metterci mano
 su (per usare un late binding alla inglese); se ritieni che x qualche
 motivo alcuni di questi goliardi debbano essere <em>tuoi</em>, segnalalo
 o al webmaster o (meglio, dato che è una variazione di minore entità) a 
un amministratore o direttamente al possessore del goliarda incriminato. 
Grattzie. :-)

</i><?php 



 $nick=$GETUTENTE;

 $sql    = "select * FROM  goliardi g,loginz l, ordini o,ulteriori_gestioni_goliardiche u "
	  . " WHERE l.m_sNome = '$nick ' "
	  . " AND l.id_login = u.id_login "
	  . " AND u.id_gol=g.id_gol "
	  . " AND o.id_ord=g.id_ordine "
	  . " ORDER BY g.nomegoliardico";

 $resSet = mysql_query($sql)
	or sqlerror($sql);

 $foto="";
 $strFoto="";


#if (.EOF)
#	 scrivi("<h4>Non possiedi ulteriori goliardi!</h4>");

#	scrivi("<table ><center>\n");
	opentable();
	trtdend();
	while($recSet=mysql_fetch_array($resSet))
		scriviReport_GoliardOrdine($recSet);
	closetable();

#	scrivi("</center></table>");

	echo("</center>"); 
	



	
scrivi("</td></tr></table>"); // quella grande, principale!


include "footer.php";
?>

