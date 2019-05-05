<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

function mostraFoto($directoryiniziale) {
	global $directoryiniziale,$AUTOPAGINA;
	$partenza= ($directoryiniziale); 
	$percorso = String(QueryString("path"));
	if ($percorso=="") 
			$percorso=$partenza;
		else 
			$temp .=" percorso: ".$percorso;
	if ($percorso.indexOf("../") != -1) $percorso=$partenza;
	$fso2=new ActiveXObject("Scripting.FileSystemObject");
	if (!fso2.FolderExists($percorso)) 
		$percorso=$partenza;
	$cartella= fso2.GetFolder($percorso);
	$temp="scemo chi legge";
	$ultima = $percorso.lastIndexOf('/');
	$titolo = $percorso.substr($ultima+1,strlen($percorso)-$ultima);

	scrivi("<h1>".$titolo."</h1>");
	scriviln("<p><center>");
	scrivi("<big><big>");
	scrivi("[<a href='$AUTOPAGINA'?path='".($cartella.ParentFolder)."'><b>Home</b></a>");

		// sottocartelle
	$sottocartelle=Enumerator($cartella.SubFolders);

	while(!$sottocartelle.atEnd())
		{$nome=$sottocartelle.item().Name;
		 $completo = fso2.BuildPath($percorso,$nome);
		 $querystring = "?path=".escape($completo); // trasforma spazi in %20 e cosi via
		 $N=quantefoto($cartella."/".$sottocartelle.item().Name); //"??"
		 $prova123=querystring.substring($querystring.indexOf("immagini/")+9);
		 $link ="<font size=-1><a href='".$script.$querystring."'>".$sottocartelle.item().Name
			." <b><i>(".$N." foto)</i></b></a></font>";
		 echo (" | ".$link);
		 $sottocartelle.moveNext();
	}
	scrivi("</big></big>");
	Response.Write("] </center></p>");

		// filez ora...
	$num=0;
	$colonna=-1;
	$fotostring="<center><table BORDER=0 CELLSPACING=2 CELLPADDING=5 WIDTH=\"100%\" BGCOLOR=\"#F0F0F0\" ><tr>";
	$descrizionistring="";
	$files=Enumerator($cartella.Files);

	while(!$files.atEnd())
		{$nome=$files.item().Name;
		 $grand=Math.round($files.item().size / 1000);
		 $files.moveNext();
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
			 $thumbnailino=mettiAltroTnSeTroppoGrande($percorso,$nome,10000,$directoryiniziale);
			 $fotostring.="<td ALIGN=CENTER><a href='".$linkino."'><img SRC='".$thumbnailino
				."' alt=\"".$linkino."\" NOSAVE BORDER=0  width=80></a></td>";
			 $descrizionistring.="<td ALIGN=CENTER VALIGN=TOP><font size=-1><a href='"
				.$linkino."'>".$nome."</a></font><br>"
		 	."<i>".$grand." KB</i></td>";
			}
		}
		$fotostring.="</tr><tr>".$descrizionistring."</tr></table></center>";
	?>
		<h1>Le foto in questa directory sono <i>(<?php  echo num?>)</i>:</h1><br>
		<?php  echo fotostring?>
<?php 
}

mostraFoto("../../goliardia/immagini/"); 

if (strlen(String($_SERVER["QUERYSTRING"]))==0) // se l'array delle query string è vuoto... boh!
{
?>
Qui sopra trovi un link a tutte le directory di foto che ho creato. X ora ce ne sono solo due: FOTONE e THUMBNAIL. Nelle prime, ci sono tutte le foto che voi potete buttar su di dimensione massima 100k. Nella seconda trovate tutti i thumbnail buttati su da voi in automatico!!! Se tutto va bene, un giorno li metterò tutti.  <br>
Nella lista di cose da fare, ho anche di legare le foto a un contesto, in modo che possiate fare la ricerca x goliarda o x città o x ordine e che magari cliccandoci via dia un link a tutti i goliardi con quella foto lì (non è garantita a priori l'unicità, non trovate?).  <br>

Ah, già, le foto più grandi di tot KB (non avendo un creatore di thumbnail all'istante) sono sostituite da una simpatica immagine pacco. Ci ho messo mezz'ora a farla quindi spero che la gradiate; è quella scritta verde e viola, x intenderci.
<br>
Altro dirvi non vo', che la mia festa ch'anco tardi a venir non mi sia grave.
<br>
ciaaaaaaaaaaaaaaaaaao!
<?php 
}
include "footer.php";
?>
