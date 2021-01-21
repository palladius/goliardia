<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


echo "<center>";

echo h1("solo x adminvip, è prototipale ;) tbds...");

	/////////////////////////////// INTRO
if (anonimo())
{
	scrivi(rossone("x chi mi ha preso, x il coglione di turno? Mica ti faccio vedere/uploadare foto se manco so chi sei!!!!!!!"));
	bona();
}


	//////////////////////////////////// CHECKZ

//scrivi("guarda tutti i thumbnailz");

img("goliardon2.jpg",150);


//<a href="http://www.mandingus.too.it/" target="_new"><h1>Foto di Mandingus</h1></a>
//Le foto nel sito sono esaurite: son state concesse in outsourcing al ministro alle foto Mandingus. Ite ivi, spappari...



//scrivi("<h2><font color=red>attento</font>. Non ci sono + foto nel sito. questo è <i>TEMPORANEO</i>. mi scuso del disagio causato a voi marpioni. sto cercando una soluzione. Ciao!!! Evita di fare upload di foto dato che verranno probabilmente perse. Attendi una stabilizzazione (v. lyapunov) del sito e riprova. Ciao!</h2>");



if (isAdminVip())
{

scrivi("<h1>Guarda le mie mitiche foto!!!</h1>");

scrivi("<a href='fotoguarda.php'><big>GUARDA TUTTE LE FOTO UPLOADATE!!!</big></a><br>");

scrivi(bigg("<a href='fotoguarda_tn.php'><big>GUARDA TUTTE LE FOTO</big></a><br>"));

scrivi(bigg("<a href='fotoguarda_tn.php?pathbreve=FOTO%5C2002'><big>GUARDA LE FOTO del '02</big></a><br>"));
}



scrivi("<h3>Spediscimi una foto</h3><br>");

scrivi("Mi raccomando, non spedirmi un tuo thumbnail tramite il sito: nel caso spediscimelo via mail!!! Qui butta su foto secondarie, che hai scattato e che vorresti comparissero prima o poi (senza fretta) sul sito: le devo infatti spostare a mano perchè voi le possiate vedere...");

 tabled();
 scrivi("<tr><td><center>");
 scrivib("<u><big>Inserisci una fotografia!!!</u></big><br>");
 scrivi("<i>(x intenderci una di quelle belle foto grandi scattate alle matricolari che trovi ovunque...)</i>");

if ($UPLOADVA)
	{
	opentable();
	 echo h1("butta su una fotina (come tua foto personale)");
	 include "moduli/fileupload/upload_ric_fotone.php";
	 scrivi("descrizione: \n<input type='text' name='descrizione'  value='' size='50'>\n");
	closetable();
	}
//formupload(paz_upload_fotone,"Fotona",100000,100000);
// formbottoneinvia("Butta su!!!");
// scrivi("</form>");
 trtdend();
 tableEnd();







/// vediamo se quest'utente ha una foto o meno...



 tabled();
 scrivi("<tr><td><center>");
 scrivib("<u><big>Inserisci un thumbnail personale</big></u><br>");
 scrivi("<i>(x intenderci di quelle foto piccole piccole tipo ");
  img($paz_foto_persone."ribot.jpg",50);
 scrivi(" che occupino al max 10 KB e siano possibilmente jpg alti 200 pixel...)</i>");


//				 formupload($paz_foto_persone_bis,"thumb",10000);
//				 formhidden("utente",getUtente());
//				 invio();
//				 formbottoneinvia("Butta su");

scrivib("<br>Avrete notato che ho tolto l'upload dei vostri thumbnail: se avete fotografie vostre da mandarmi, fate MOLTO prima a spedirmele via mail! Grazie!!!");
scrivib(rosso("<br>\nMi raccomando! Se vuoi associare l'icona a un goliarda, è facile: basta buttar su una foto chiamata <u>ESEMPIO.JPG</u> e poi cambiare nei dati di quella persona i dati riguardanti la foto e mettere sotto foto il valore <u>ESEMPIO.JPG</u>. Se invece vuoi associare la foto al tuo utente (essendoti scocciato di quel punto interrogativo in alto a destra), devi assolutamente rinominare quella foto col tuo nome utente!!! esempio, se ti chiami <u>Pippo</u> devi rinominare la foto in <u>pippo.jpg</u>. Lo so, sono i misteri degl'ingegneri...<br/>Ultimo ma non ultimo"
	.": facendo così non succederà UN BEL NIENTE! però poi io potrò mettere la foto nella cartella apposita e POI attivarti!!!"));

				 scrivi("</form>");

 trtdend();
 tableEnd();









?>

</center>
<p>


<?php 
include "footer.php";
?>
