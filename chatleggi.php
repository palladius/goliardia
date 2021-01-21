<?php 
include "chatheader.php";

global $MAXMESSAGGI,$IMMAGINI;

if (! Session("nickname")) exit;
	
$nickname = Session("nickname");

function setRigaUtente($time)
{
global $nickname;
//livello	sbur-user
return $nickname . "@" . $time . "@". Session("SEX") ."@". intval(Session("livello")=="sbur-user");
}


$messaggi = getApplication("messaggi");
$frase = explode("\$",$messaggi);

//visualizzaArrayMini($frase);


$d = date("y-m-d h:i:s");
$t = time();

$online = getApplication("online");
$stringa_utente = explode("\$",$online);
$cisono = false;

//visualizzaArrayMini($stringa_utente);

for ($i=0;$i<sizeof($stringa_utente);$i++) {
  $aux = splitta("@",$stringa_utente[$i]);
  if ($aux[0]==$nickname) {	// aggiorno il time
    $stringa_utente[$i] = setRigaUtente( time() );	// metto il tempo giusto
    $cisono = TRUE;
  } else 
	if (isset($aux[1]))
	{
	    $delta = $t - intval($aux[1]);
	    if ($delta>600) $stringa_utente[$i] = ""; 
		// 600= 10 minuti, 1200=... boh spetta che prendo la calcolatrice
		// son secondi, è tornato a 10 minuti... anzi facciamo 20
		// aumentato delta t da 60000 a 600'000 (un minuto a 10 minuti...)
		//php VENERDI speriamo sian millisecondi, se son secondi diventa ENORME!
	  }
}
if (!$cisono) // aggiorno application("ONLINE")
  $stringa_utente[sizeof($stringa_utente)] =  setRigaUtente($t);


$online = "";

// visualizzaArrayMini($stringa_utente);
 
for ($i=0;$i<sizeof($stringa_utente);$i++)
{ if ($stringa_utente[$i]!="") 
	{
    	if ($online!="") 
		$online .= "\$";
    	$online .= $stringa_utente[$i];
	}
} 
setApplication("online",$online);

?>
<html>
<head>
  <title>Carlessoèunfigo® Chat</title>
  <meta http-equiv="refresh" content="8">
  <meta http-equiv="Pragma" content="no-cache">
<style>
    a {text-decoration: none; color: navy}
    a:hover {color: red}
</style>

  </head>
<body class='bkg_chat'>

<center><table cellspacing="0" cellpadding="0" width="<?php  echo $CONSTLARGEZZA600?>" height="20" border="0"><tbody><tr><td>



<table border="0" width="150" align="right">

<?php  
	if (isAdminVip())	// x i soli superadmin
{
?>	
	<tr><td  align='right' class=bkg_chat><b>
	<i>admin:</i>
	 <a href="chatscrivi.php?speciale=svuotachat" target="scrivi">
	 <font size='-4'>CLEARCHAT</font></a>
	</b>&nbsp;</td></tr>
<?php 
}



for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i]!="") {
	$tmppp = splitta("@",$stringa_utente[$i]);
	$nome = $tmppp[0];
	// da togliere
	//$nome .= " ($tmppp[1])";
?>

	<tr><td  align='right' class=bkg_chat><b>
	<a href="chatscrivi.php?per=<?php  echo escape($nome)?>" target="scrivi" class="InizialeMaiuscola">
	<?php  echo $nome?></a>
<?php  if ((Session("livello"))=="sbur-user")
{
?>	
	<a href="chatscrivi.php?braghe=<?php  echo escape($nome)?>" target="scrivi" >
	 <font size='-4'><img src="<?php  echo $IMMAGINI?>/giu(inbraghe).gif" border="0"></font></a>
	<a href="chatscrivi.php?surge=<?php  echo escape($nome)?>" target="scrivi" class="InizialeMaiuscola">
	<font size='-4'><img src="<?php  echo $IMMAGINI?>/su(surge).gif" border="0"></font></a>

<?php  } ?>
	</b>&nbsp;</td></tr>
	
<?php 
  }
?>
<!---	<center><tr><td>
	  <img src="<?php  echo $IMMAGINI?>/icone/nobarplaying.gif" height="110">
	</td></tr></center>
--->
</table>

<?php 
// Stampo i messaggi correnti

for ($i=0;$i<sizeof($frase);$i++) {
  $aux = splitta("@",$frase[$i]);
//	echo "<i>".$frase[$i]."</i><br/>";

  if (sizeof($aux)>3 && ($aux[2]=="" || $aux[1]==$nickname || $aux[2]==$nickname ||  $aux[2]=="__SPECIALE__")) 
	{
	//  if (aux.length>3 && (aux[2]=="" || aux[1]==nickname || aux[2]==nickname
	//       || nickname=="palladius" || aux[2]=="__SPECIALE__")) {

    if (contiene(strval($aux[3]),"/a"))
	{//echo "contiene BIS!"; / emote
	 $aux[2]="__SPECIALE__" ;
	 $aux[3]=substr($aux[3],3);
	}

    if ($aux[3]!="" && $aux[2] != "__SPECIALE__" && $aux[2] != "") // 2: msg x qualcuno, non speciale
	{	 
    ?>
		<font size='-1'><?php  echo $aux[0]?></font> 
	    <font color='blue'><b class=inizialemaiuscola><?php  echo $aux[1]?></b></font>
	    <font color='green' size='-1'><i>(per <b class=inizialemaiuscola><?php  echo $aux[2]?></b>)</i></font>
         - <?php  echo $aux[3]?><br>
	<?php 
	}
	else
    if ($aux[2]=="__SPECIALE__" ) 						// 3: amote (tipo il /a di energy)....
	{	 //emote
	?>
		<font size='1' ><?php  echo $aux[0]?></font>
		<font class='emote'><i class='inizialemaiuscola'><?php  echo $aux[1]?></i> <i><?php  echo $aux[3]?></i></font>.
		<br>
	<?php 
	}
	else
	{										// 4: da qualcuno x qualcuno o normale 
											// (ma dovrebbe esser solo normale)
     	echo("<font size='1'>" .$aux[0] . "</font> ");
    	echo("<font color='blue'><b class=inizialemaiuscola>" .$aux[1] . "</b></font> ");
    	if ($aux[2]!="") 
		echo(" <font color='green' size='-1'><i>(per <b>" .$aux[2] ."</b>)</i></font> ");	
//    	echo(" - ");
    	echo($aux[3] . ".<br>");
    	// debug: echo($aux[3] . ".(2: ".$aux[2]."; 3: ".$aux[3].")<br>");
	}
  }
}




?>
</td>
</tr>
</tbody></table>




