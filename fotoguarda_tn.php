<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

if ($ISPAL) 
	echo rosso("temo che percorso breve vada gettato da querystring o form... lo rendo vuoto x ora.");
$percorsobreve="";


scrivi("<h3>");
linkaCumulativoBasatoSuStringa($percorsobreve,TRUE,FALSE);
scrivi(HTMLEncode(">>>")." $titolo</h3>");
scriviln("<p><center>");
scrivi("<big><big>");

$sepIn="<table><tr><td>".getImg("home.gif")."</td><td>";
$sepPostHome=""; 
$sepQuanteFoto=" </td><td> "; 
$separatore="</td></tr><tr><td>".getImg("cartella.gif")."</td><td>"; 
$sepOut="</td></tr></table>";


scrivi($sepIn."<a href='$AUTOPAGINA'?path='".($cartella.ParentFolder)."'><b>Home</b></a>");
scrivi($sepPostHome);
	// sottocartelle
scrivi("anzichè cercare nei file interni devo cercare nel DB le foto indicizzate che contengano quella frase...");
$sottocartelle=Enumerator($cartella.SubFolders);
while(!$sottocartelle.atEnd())
	{$nome=sottocartelle.item().Name;
 	 $completo = fso2.BuildPath(percorso,nome);
	 if (String($percorsobreve) != "") // ERI GIA DENTRO A UN FIGLIO...
		 $querystring = "?pathbreve=".escape($percorsobreve."/".$nome); // trasforma l'ultima cosa e basta
	else 
		 $querystring = "?pathbreve=".escape($nome); // trasforma l'ultima cosa e basta
	
	$N=quantefoto($cartella."/".($sottocartelle.item().Name));
	$prova123=querystring.substring(querystring.indexOf("immagini/")+9);	 // 9 è la strlen di 'immagini '
	$link="<font size=-1><a href='".$script.$querystring."'>".($sottocartelle.item().Name)
		.$sepQuanteFoto." <i>(".($N/2)." foto)</i></a></font>";
	echo($separatore.$link);
	sottocartelle.moveNext();
}
echo($sepOut."</center></p>");
scrivi("</big></big>");

// filez ora...
$num=0;
$colonna=-1;
$fotostring="<center><table BORDER=0 CELLSPACING=1 CELLPADDING=1 WIDTH=\"100%\" BGCOLOR=\"#F0F0F0\" ><tr>";
$descrizionistring="";
$files=new Enumerator($cartella.Files);
while(! $files.atEnd())
	{$nome=$files.item().Name;
	 $grand=Math.round($files.item().size / 1000);
	 $dataCR=toHumanDate(Date($files.item().DateCreated));
	 $files.moveNext();
	 if (isThumbnail($nome))
			{//break; non si puote... :(
			}
	 else
		{
		 $ext=strtoupper($nome.substr($nome.lastIndexOf(".")+1,3));
	      if ($ext=="GIF" || $ext=="JPG" || $ext=="BMP" || $ext=="PNG") 
			{$num++;
	             $colonna++;
			 if ($colonna==$QUANTIARIGA) // arrivati a fine riga
				{$colonna=0;
				 $fotostring.="</tr><tr>".$descrizionistring."</tr><tr>";
				 $descrizionistring="";
				}				
			$linkino=mettiAltroTnSeTroppoGrande($percorso,$nome,100000000,$directoryiniziale);
			$haunsuoThumbnail=esisteSuoThumbnail($percorso,$nome);
				 //linkino=nome
			$thumbnailino=$linkino;   //mettiAltroTnSeTroppoGrande($percorso,$nome,10000,$directoryiniziale);
			$fotostring.="<td ALIGN=CENTER><img SRC='" ;
			$fotostring .= (haunsuoThumbnail 	? getTnByFoto(thumbnailino) : thumbnailino);
			$fotostring .="' alt=\"".$linkino."\" NOSAVE BORDER=0  width=80></a></td>";
			$descrizionistring.="<td ALIGN=CENTER VALIGN=TOP><font size=-1><a href='visualizza_fo"
				."to.asp?LINKNUOVOBREVE=".$percorsobreve."/".$nome."&KB=".$grand."&datacr="
				.$escape($dataCR)."'>".$togliEstensione($nome)
				."</a></font><br>";
		//	descrizionistring.="percorso[".$percorso."] nome[".$nome."]<bR>";
		//	descrizionistring.="percorsobreve[".$percorsobreve."] nome[".$nome."]<bR>";
			$descrizionistring.= "<i>$grand KB</i><br>$dataCR</td>";
			}
		}
	}
	$fotostring.="</tr><tr>".$descrizionistring."</tr></table></center>";
		// qui vengono i link alle cartelle precedenti ;)
	//linkaCumulativoBasatoSuStringa(percorsobreve,true,false);
	?>
		<h3><?php  echo $titolo?> <i>(<?php  echo $num?> foto)</i></h3><br>
	<?php 

if ($num!=0)
	{
	?>
		<?php  echo $fotostring?>
	<?php 
	}
	else 
	{
	 echo "<big><b>Nessuna foto, spiacente</b></big><br>";
	}


// questa funzione chiama TUTTA la pagina!!!!!!
mostraFoto($PAZ_FOTO_AVVENIMENTI);

include "footer.php";
?>
