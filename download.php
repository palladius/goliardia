<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$PAZ_FOTO ="downloadz";

$sepIn="<table border=1><tr><td>".getImg("home.gif")."</td><td>";
$sepPostHome=""; 
$sepQuanteFoto=" </td><td> "; 
$separatore="</td></tr><tr><td>".getImg("cartella.gif")."</td><td>"; 
$sepOut="</td></tr></table>";
$script=$AUTOPAGINA;
$percorsobreve = (QueryString("pathbreve")); // contiene l'ultima directory


	// mangia un uppercase
function isFotoExt($ext)
{if ($ext != strtoupper($ext))
	if (isdevelop())
		bug("isfotoext() sta mangianod u non-upper....");
 return $ext=="GIF" || $ext=="JPG" || $ext=="BMP" || $ext=="PNG";
}

function BuildPath($perc,$nom)
{
//if (isdevelop()) echo rosso("dacci un occhio ric se buildpath fa ciò che vorresti... ($perc,$nom = $perc/$nom)");
return "$perc/$nom";
}


/*
while ($file = readdir($rep)){
	if($file != '..' && $file !='.' && $file !=''){ 
		if (is_dir($file)){
			$bAuMoinsUnRepertoire = true;
*/








function scriviReportDir($sottocartelle,$percorso)
{
 global $percorsobreve,$script;

// $nome=sottocartelle.item().Name;
   $nome=$sottocartelle;
   $completo = BuildPath($percorso,$nome);
 	 
 trtd();
  $nuovopaz= ($percorsobreve == "") // nella home
			? $nome
			: $percorsobreve ."/".$nome;
  scrivib("<a href='".$script."?pathbreve=".escape($nuovopaz)."'>");
  img("cartella.gif");
  scrivi("</a>\n");
 tdtd();
  scrivib(blu($nome));
 trtdEnd();
}



function scriviReportFile($files,$directoryiniziale)
{
 global $PAZ_FOTO,$ISPAL;
# if ($ISPAL) scrivi(rosso("<br>scriviReportFile, pazfoto/file/dir valgono: ($PAZ_FOTO) ($files) ($directoryiniziale)<br>"));
	
	$nome=$files;
	 if ($directoryiniziale == "")
		 $files = "$PAZ_FOTO/$files";  //da gestire la dir iniziale
	   else
		 #originale $files = "$PAZ_FOTO/$directoryiniziale/$files";  
		 $files = "$directoryiniziale/$files";  
	 $grand=intval(filesize($files) / 1000);
//	 $dataCR=toHumanDate(Date(filectime($files))); 
	 $dataCR=todatasbura((filemtime($files))); 
			// time di cambiamento dell'inode, era ciò che assomigliava + alla creazione...
	trtd();
	 scrivi("<a href=\"".$directoryiniziale."/".$nome."\">");
	 img("scarica.jpg");
	 scrivi("</a>\n");
	tdtd();
	 scrivib($nome);
	tdtd();
	 scrivii("(".$grand." KB)");	
	tdtd();
	 scrivi($dataCR);
//	tdtd();
//	 scrivi("DEBUG: pazbreve vale:  ".$percorsobreve);	
	trtdEnd();
}

function parentFolder($dir)
	{//echo ("[parentfolder($dir)]");
	 return "$dir/..";
	}

function mostraFilez($directoryiniziale)
{
global $percorsobreve,$script;
$presenteREADME=0;
tabled();
$partenza= $directoryiniziale;
$percorso = $partenza . "/" . $percorsobreve;
if ($percorsobreve=="") 
	$percorso=$partenza;
if (!(strpos($percorsobreve,"..") === FALSE)) 
	{$percorso=$partenza; $percorsobreve="";}
if (!is_dir($percorso)) 
	$percorso=$partenza;
$cartella = $percorso;

	// home
	trtd(); 
	 scrivib("<a href='".$script."'?path='".(ParentFolder($cartella))."'>");
	 img("home.gif");
	 scrivi("</a>");
	tdtd();
	 scrivib("Home");
	trtdEnd();




	//cartelle
//echo " cartella vale [$cartella]";
$handle=opendir($cartella);
while(FALSE !== ($sottocartelle= readdir($handle)))
	if($sottocartelle != '..' && $sottocartelle !='.' && $sottocartelle !='')
		if (is_dir("$cartella/$sottocartelle"))
			{$nome=$sottocartelle;
		 	 $completo = ("buildpaz($percorso,$nome)"); //?!?
		 	 scriviReportDir($sottocartelle,$percorso);
			}
	// filez
closedir($handle);
$handle=opendir($cartella);
while(FALSE !== ($files=readdir($handle)))
  {
#   echo "file1: $files"; 
   if (is_file("$cartella/$files"))
	{#echo " è un file: $files<br>"; 
	 if ($percorsobreve == "")
		 scriviReportFile("$files",$directoryiniziale);
	 else
		 scriviReportFile("$files",$directoryiniziale."/".$percorsobreve);
	 if ($files == "README" || $files == ".README")
 	 	$presenteREADME=1;
	}	
   }
tableEnd();
if ($presenteREADME)
#	scrivi(rosso("<h1>readmeeeeee</h1>"));
	{
	opentable();
	scrivi("<pre>");
	system("cat README");
	scrivi("</pre>");
	closetable();
	}
}




function mostraFoto($directoryiniziale)
{
if (isdevelop()) echo rosso("siamo in mostraFoto($directoryiniziale)!!!");
$partenza = ($directoryiniziale);
//scrivi(rossone("partenza: '$partenza' ".$(directoryiniziale==PAZ_FOTO_AVVENIMENTI?"OK":"DIVERSOOOOOO")."<br>"));
$script=$AUTOPAGINA;
$percorsobreve = String(Request.QueryString("pathbreve")); // contiene l'ultima directory
$percorso = "$partenza/$percorsobreve";
if ($percorsobreve=="") 
	$percorso=$partenza;
//scrivi(rossone("percorso vale: ".$percorso."...<br>"));
if (substr($percorsobreve,"..") != -1) 
	{$percorso=$partenza; $percorsobreve="";}

if (!is_dir($percorso)) 
	$percorso=$partenza;

$cartella= $percorso;
$temp="scemo chi legge";
$ultima = strrpos($percorso,'/');
$titolo = substr($percorso,$ultima+1,strlen($percorso)-$ultima);
if (isdevelop())
	echo rosso("percorso valeva ($percorso). Titolo usando substr "
		."vale ($titolo). guarda se bastava un basename...");

scrivi("<h3>");
 linkaCumulativoBasatoSuStringa($percorsobreve,TRUE,FALSE);
scrivi(htmlspecialchars(">>>")." ".$titolo."</h3>");
scriviln("<p><center>");
scrivi("<big><big>");

scrivi($sepIn."<a href='".$script."'?path='".ParentFolder($cartella)."'><b>Home</b></a>");
scrivi($sepPostHome);

scrivi("anzichè cercare nei file interni devo cercare nel DB le foto indicizzate che contengano quella frase...");

while($sottocartelle=readdir($cartella))
	{$nome=$sottocartelle;
 	 $completo = BuildPath($percorso,$nome);

	 if (!empty($percorsobreve)) // ERI GIA DENTRO A UN FIGLIO...
		 $querystring = "?pathbreve=".escape($percorsobreve."/".$nome); // trasforma l'ultima cosa e basta
	   else 
		 $querystring = "?pathbreve=".escape($nome); // trasforma l'ultima cosa e basta
	$N = quantefoto($cartella."/".$sottocartelle,FALSE);
	$N2= quantenonfoto($cartella."/".$sottocartelle,TRUE);
	$strProva123 = "immagini/";
	$prova123=substr($querystring,strpos($querystring,$strProva123)+strlen($strProva123));
	$link ="<font size=-1><a href='".$script+querystring."'>".$sottocartelle.$sepQuanteFoto
		." <i>(".($N/2)." foto, ".$N2." di altro)</i></a></font>";
	echo ($separatore.$link);
	}
echo ($sepOut."</center></p>");
scrivi("</big></big>");

	// filez ora...
$num=0;
$colonna=-1;
$fotostring="<center><table BORDER=0 CELLSPACING=1 CELLPADDING=1 WIDTH=\"100%\" BGCOLOR=\"#F0F0F0\" ><tr>";
$descrizionistring="";
while($files=readdir($cartella))
	{$nome=$files;
	 $grand=Math.round(filesize($files) / 1000);
	 $dataCR=toHumanDate(Date(filectime($files)));
	 if (isThumbnail($nome))
			{		
				//break; non si puote... :(
			}
		 else
		{
		 $ext=strtoupper( substr($nome,strrpos($nome,".")+1,3));
		 		// guarda che succede se lung != 3, tipo JPEG...
     		  if (isFotoExt($ext)) 
			{$num++;
	             $colonna++;
			 if ($colonna==$QUANTIARIGA) // arrivati a fine riga
				{$colonna=0;
				 $fotostring .= "</tr><tr>".$descrizionistring."</tr><tr>";
				 $descrizionistring="";
				}				
			$linkino=mettiAltroTnSeTroppoGrande($percorso,$nome,100000000,$directoryiniziale);
			$haunsuoThumbnail=esisteSuoThumbnail($percorso,$nome);
			$thumbnailino=$linkino;
			$fotostring .= "<td ALIGN=CENTER><img SRC='" ;
			$fotostring .= ($haunsuoThumbnail 	? getTnByFoto($thumbnailino) : $thumbnailino);
			$fotostring .= "' alt=\"".$linkino."\" NOSAVE BORDER=0  width=80></a></td>";
			$descrizionistring .= "<td ALIGN=CENTER VALIGN=TOP><font size=-1>"
				."<a href='visualizza_foto.php?LINKNUOVOBREVE="
				.($percorsobreve."/".$nome)."&KB=".$grand."&datacr=".escape($dataCR)."'>"
				.togliEstensione($nome)."</a></font><br>";
			$descrizionistring .= "<i>".$grand." KB</i><br>".$dataCR."</td>";
			} // if fotoext
		} // else di thumbnail
	} // fine while
	$fotostring.="</tr><tr>".$descrizionistring."</tr></table></center>";
		// qui vengono i link alle cartelle precedenti ;)
?>
	<h3><?php  echo $titolo?> <i>(<?php  echo $num?> foto)</i></h3><br>
<?php 
if ($num!=0)
	{
	 echo $fotostring;
	}
	else 
	{	
	 echo "<big><b>Nessun file, spiacente</b></big><br>";
	}
} // fine mostra foto





// questa funzione chiama TUTTA la pagina!!!!!!

scrivi(h1("pagina dei Downloadz"));

scrivii("Attenzione, qui non troverete le foto. qui troverete solo cose da scaricare di vario tipo.");

mostraFilez($PAZ_FOTO);
#mostraFilez("");

include "footer.php";

/*
while ($file = readdir($rep))
	if($file != '..' && $file !='.' && $file !='')
		if (is_dir($file))

anche scandir è fico:

$dir    = '/tmp';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

print_r($files1);
print_r($files2);


Outputs something like: 

Array
(
    [0] => .
    [1] => ..
    [2] => bar.php
    [3] => foo.txt
    [4] => somedir
)
Array
(
    [0] => somedir
    [1] => foo.txt
    [2] => bar.php
    [3] => ..
    [4] => .
)
*/

?>
