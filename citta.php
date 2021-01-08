<?php 

include "conf/setup.php";
#include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


//PROMEMORIA: crea una pagina di CITTA e regioni che si linkano a vicenda... regione di altre nazioni è NAZIONE, compresa ITALIA...
// e metti che query sql se eseguite non caricano anche le notevoli (troppo peso)

$DIM_ICONCIONA = 80;
$DIM_ICONCINA = 40;


$operazione=Form("hidden_operazione"); // postata e da ELABORARE

if(!empty($operazione))
	{
	if ($operazione=="inserisciProvincia")
		{scrivi("INSERISCO PROVINCIA NUOVA!");
		 autoInserisciTabella("regioni");
		}
	else bug("Operazione [$operazione] ignota.");
	}


function popolaComboRegione($ID,$dflt)
{
$sql = "select distinct regione,regione from regioni ORDER BY regione";
if (empty($dflt))
		popolaComboBySqlDoppia_Key_Valore($ID,$sql,"Emilia");
  else
		popolaComboBySqlDoppia_Key_Valore($ID,$sql,$dflt);
}


function getImgCitta($citt,$h=200)
{
return   "<img src=\"immagini/citta/".strtolower($citt).".gif\" height=\"".$h."\" align='Center'>";
}

$MYPROVINCIA= (Session("provincia")); // c'era strtolower

$cittascelta=$MYPROVINCIA;

if ((QueryString("citta")) != "")
	{$cittascelta=(QueryString("citta")); // lowercase
	}


function scriviReportCitta($rs)
{
global $AUTOPAGINA,$MYPROVINCIA;
#$citta= ($rs["nomecitta"]); // c'era strtolower
$citta= strtolower($rs["nomecitta"]); // c'era strtolower
$E_LA_MIA =  ( $citta == $MYPROVINCIA);

?>
<tr>
 <td>
  <!-- <img src="immagini/citta/<?php  echo $citta?>.gif" height="30"> -->
 </td>
 <td>
  <b class='citta'><a href="<?php  echo $AUTOPAGINA?>?citta=<?php  echo $rs["nomecitta"]?>">
   <?php  if ($E_LA_MIA ) scrivi(rosso($citta));
		else scrivi($citta);
   ?>
  </a></b>
 </td>
</tr>
<?php 
}



function scriviColonnaCitta($m_bCittaNostrana)
{
$res2=mysql_query("select * FROM regioni where ".($m_bCittaNostrana ? "NOT" : "")."(regione = 'Nazione') ORDER BY nomecitta");

?>
<h1>
	<?php  echo  ($m_bCittaNostrana ? "Città (citta)" : "Nazioni")?>
</h1>
<?php 
tabled();
 while ($rs2=mysql_fetch_array($res2))
	 scriviReportCitta($rs2);
tableEnd();
}






$res2=mysql_query("select * from regioni WHERE nomecitta LIKE '".Session("provincia")."'");
if (mysql_num_rows($res2)==0)
	{scrivib(rossone("ATTENZIONE!!! La tua provincia (ora ha valore '<i>".Session("provincia")."</i>') non esiste nel database. Vai nella sezione UTENTE, in basso, e correggila con qualcosa di appropriato; magari in futuro contatta il webmaster affinché aggiunga la città/nazione in cui ti trovi adesso..."));
	 bona();
	}


//if ($ISPAL) echo rosso("la città esiste? rcord matchanti: <b>".mysql_num_rows($res2)."</b>==1?!?");





function reportCittaScelta($citta)
{
 global $DIM_ICONCINA,$SERIOSTRING,$ISSERIO;
	  // ordini della città 
	
	$res= mysql_query("select m_fileImmagineTn as _fotoordine, id_ord as _linkOrd,nome_veloce, m_bInSonno as _inSonno , sovrano as _sovrano,m_nPrecedenzaCittadina AS preced FROM ordini WHERE città like '$citta' $SERIOSTRING AND m_bserio=1 order by _inSonno asc, sovrano desc, nome_veloce asc");
	#  7 gennaio come richiesto da moscatelli
	# qui il numerillo ha precedenza su tutto
	# qui il sovrano ha precednza su tutto, e il numerillo a seguire...
	$STRADMIN="";
	if (isAdmin()) {
		$STRADMIN="  , m_nPrecedenzaCittadina AS precedAdmin";
	}
	$res= mysql_query("select m_fileImmagineTn as _fotoordine, id_ord as _linkOrd,nome_veloce, m_bInSonno as _inSonno , sovrano as _sovrano $STRADMIN FROM ordini WHERE città like '$citta' $SERIOSTRING AND m_bserio=1 ORDER BY sovrano desc, m_nPrecedenzaCittadina asc, nome_veloce asc");
	scriviRecordSetConTimeout($res,50,"Ordini presenti in $citta");


	scrivi(h5(getImgCitta($citta,$DIM_ICONCINA)."Statistiche varie su ".$citta));

	$quantiqui = campo0("select count(*) FROM loginz WHERE provincia LIKE '$citta'");
	$quantitot = campo0("select count(*) FROM loginz");
	scriviCoppia("Quanti (su tutti):","$quantiqui/$quantitot");

	$maschi=campo0("select count(*) FROM loginz WHERE m_bismaschio=1 AND provincia LIKE '$citta'");
	scriviCoppia("Percentuale di maschi",$maschi."/".$quantiqui);

	$rs1=campo0("select count(*) FROM loginz WHERE m_bsingle=1 AND provincia LIKE '$citta'");
	scriviCoppia("Percentuale di single",$rs1."/".$quantiqui);

	$rs1=campo0("select avg(m_npx) FROM loginz WHERE provincia LIKE '$citta'");
	$rs2=campo0("select avg(m_npx) FROM loginz ");
	scriviCoppia("GP medi (cfr con globali)",approssima3($rs1)." vs. ".approssima3($rs2));

	scrivi(h5(getImgCitta($citta,$DIM_ICONCINA)."Link di ".$citta));

	$res=mysql_query("select * from regioni r, linkz l where r.nomecitta='$citta' AND r.id_pseudoid=l.id_oggettopuntato AND l.tipo = 'citta'");

	while ($rs=mysql_fetch_array($res))
		scriviReport_LinkMini($rs);

	scrivi(h5(getImgCitta($citta,$DIM_ICONCINA)."Link degli ordini di ".$citta));

	$res=mysql_query("select * from ordini o, linkz l where o.città='$citta' AND o.id_ord=l.id_oggettopuntato AND l.tipo = 'ordini'");

	while ($rs=mysql_fetch_array($res))
		scriviReport_LinkMini($rs);

	tdtdtop();


	  // lista utenti, spesso MOLTO LUNGA

	#scrivi(h4(getImgCitta($citta,$DIM_ICONCINA)."Amministratori presenti in ".$citta));
	$rs2=mysql_query("select m_snome as _fotoutente,m_snome as utente,m_hemail as _email FROM loginz WHERE provincia LIKE '"
	.$citta."' AND m_badmin=1 ORDER BY (m_snome) ASC");
	scriviRecordSetConTimeout($rs2,20,"Amministratori presenti in ".$citta);

	$sex= getSex();
        if (! $ISSERIO) {
	#scrivi(h4( getImgCitta($citta,$DIM_ICONCINA).(($sex=="M") ? "Tope" : "Manzi" )." presenti in ".$citta));
	$rs2=mysql_query("select m_snome as _fotoutente,m_snome as utente,m_bsingle "
	." as _single FROM loginz WHERE provincia LIKE '"
	.$citta."' AND m_bguest=0  AND m_bismaschio=".($sex=="F")." ORDER BY m_bsingle,(m_snome) ASC");
	scriviRecordSetConTimeout($rs2,20,(($sex=="M") ? "Tope" : "Manzi" )." presenti in ".$citta);
     } # fine serio	

	
	#scrivi(h4(getImgCitta($citta,$DIM_ICONCINA)."Utenti registrati presenti in ".$citta));
	
	$rs2=mysql_query("select m_snome as _fotoutente,m_snome as utente,provincia FROM loginz WHERE provincia LIKE '"
	.$citta."' AND m_bguest=0 ORDER BY (m_datalastcollegato) DESC");

	scriviRecordSetConTimeout($rs2,20,"Utenti registrati presenti in ".$citta);

	

 //closeTable();
}



//rs2=mysql_query("select * FROM regioni WHERE NOT (regione LIKE 'Nazione' )");

scrivi("<table width='100%' border='1'>");
trtd();

 scriviColonnaCitta(TRUE);

//tdtd();
tdtdtop();

scrivi("<center><h1>".getImgCitta($cittascelta,$DIM_ICONCIONA)."Scheda di ".($cittascelta).getImgCitta($cittascelta,$DIM_ICONCIONA)."</h1>");

	tabled();
	 trtd();
	  reportCittaScelta($cittascelta);
	 trtdEnd();
	tableEnd();


tttt();
 scriviColonnaCitta(FALSE);
tdtd();


$rs2=mysql_query("select count(*) as QUANTI_A_CITTA,nomecitta from regioni r, loginz l where l.provincia=r.nomecitta group by nomecitta ORDER BY QUANTI_A_CITTA DESC");
scriviRecordSetConTimeout($rs2,50,"Gente all'estero","Per sentirvi meno soli, cari erasmini");

scrivi("x ric: metti dopo SOLO città estere e nella query metti nome come _nazione, e nel viusalizzatore generico metti _nazione con bandierine di girarrostus...");
tableEnd();

#scrivi(h1("altro..."));
#$rs2=mysql_query("select count(*) as QUANTE_CITTA,regione from regioni group by regione order by quante_citta desc");
#scriviRecordSetConTimeout($rs2,20,"Utenti per regione");


	// copiato da poc'anzi
$MYPROVINCIA= (Session("provincia")); // c'era strtolower
$citta=$MYPROVINCIA;
if ((QueryString("citta")) != "")
	{$citta=(QueryString("citta")); // lowercase
	}

if (isadmin())
	{echo h2("osserva i colori feluca x città (<b>$citta</b>):");
	 $citta=strtolower($citta);
	 $res=mq("select distinct * from facolta order by facolta");
	 tabled();
	 while ($rs=mysql_fetch_array($res))
		{trtd();
		  echo $rs["Facolta"];
		 	//tdtd();
			$fac=getColoreFeluca($rs["Facolta"],$citta);
			$tabella="</td><td border=0 bgcolor='$fac' width=50 height=19>".getImg("feluca100.gif",30);
			//scrivi(getCoppiaTabella("Facoltà:",$rsOrd[1]." ".$tabella));
		 echo "$tabella";
		 trtdend();
		}
	tableend();
	}

include "footer.php";

?>
