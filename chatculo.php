<?php  


include "chatheader.php";

global $IMMAGINI;



bragheInit();
$braghe=(getApplication("braghe"));
$arrbraghe=splitta("@",$braghe);

//  <meta http-equiv="refresh" content="30;URL=chatculo.php">

?>


<head>
  <meta http-equiv="refresh" content="20">
</head>
<center>
<table border="0" cellspacing="0" cellpadding="0" bgcolor=<?php  echo $coloresfondo?>>
<tbody>
<tr>
<td valign="top" colspan="2" class='bgviola'><img src="<?php  echo $IMMAGINI?>/pixel.gif" width="<?php  echo $CONSTLARGEZZA600?>" height="1" alt="" border="0"></td>
</tr>
</tbody>
</table>

</center>

<?php  



$paz_foto_persone = "$IMMAGINI/persone/";
$strFoto="\n<tr>";
$strNomi="\n<tr>";
$online = getApplication("online");
$stringa_utente = explode("\$",$online);


$zezzo="?!?";
$sburuser=1;


for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i] != "") 
  { $tmpArr=explode("@",$stringa_utente[$i]);
   $nome=$tmpArr[0];
   $zezzo=$tmpArr[2];
   $sburuser=$tmpArr[3];
   $inbraghe=FALSE;
   $inbraghestr = "in braghe";

	//verifico se è in braghe
  for ($j=0;$j<sizeof($arrbraghe);$j++)
	{
//	 echo rosso("arrb_j=".$arrbraghe[$j]);

	 $dati=explode("$",$arrbraghe[$j]);
	 if (sizeof($dati)<2) break;
	 $arrnomej=$dati[0];
	 $arrpxj = $dati[1];

	 if ($nome==$arrnomej) 
		{
			$inbraghe=TRUE;
		   if (intval($arrpxj) > 1000) 
			$inbraghestr=($zezzo=="M" ?"nudo":"nuda");
		}
	}

  if ($inbraghe)
	{$exnome   = $nome;
	 $nome    .= "</b><br><i>$inbraghestr</i><b>"; //("");
	 $strFoto .= "<td align=center width=50><a href='utente.php?nomeutente=$exnome' target='_blank'>"
			."<img src='$IMMAGINI/braghe".strtolower($zezzo).".jpg' alt='ha fatto il cattivo' "
			."border='0' align='Center' width='50'></a></td>";
	}
    else 
	if ($sburuser)
	 	$strFoto .= "<td align=center width=50>"
				.getFotoUtenteDimensionataRightNuovoFrame($nome,80)."</td>";
	else 
		$strFoto .= "<td align=center width=50><table><tr><td>"
			.getFotoUtenteDimensionataRightNuovoFrame($nome,30)
			."</td></tr><tr><td>"
			.getdefinizioni(
				"(<u>GUEST</u>)"
				,"affinchè $nome diventi utente deve spedire una foto a..."
						)
			."</td></tr></table></td>";
			// nON FUNZIONA! VA CON LA TA SESSIONE NON LA N-MA!!!  
  $strNomi .= "<center><td valign=top width='50' bgcolor='"
			.(($zezzo=='M')?"#AAFFFF":"#FFDDDD")
			."'><center class='inizialemaiuscola'>".$nome."</center></td></center>";
  }
 echo("<body class='bkg_chat'><table  align='center' border=0>");
 echo($strFoto."</tr>$strNomi</tr></table>");


if (Session("nickname")=="palladius" && Session("DEBUG"))
{echo("<bR>ONLINE: ".Application("online"));
 echo("<br>MSG: ".getApplication("messaggi"));
}
?>





