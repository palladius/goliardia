<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


$NUMVOTIDAFAREMEZZI = 10;

function turboVoto()
{
global $NUMVOTIDAFAREMEZZI ;
for($i=0;$i<$NUMVOTIDAFAREMEZZI ;$i++)
	randomizzaGiocoCoppie();
	#formGiocoCoppie($NUMVOTIDAFAREMEZZI  % 2);
}

scrivi("<h1>qui voterete fino a $NUMVOTIDAFAREMEZZI persone!!!!</h1>");
scrivi("<h2>Non bastano? <a href='$AUTOPAGINA'>Ricarica la pagina</a>, riprova dai!!!</h2>");

scrivi("<h4>Attenzione: molti credono che qui poichè trovate da votare un fottio (diciamo 30) di persone, con un solo click votiate 30 persone. in realtà, invece, quando votate anche tutti e poi cliccate sotto alv oto di x, inviate SOLO il voto di x. cui prodest? vi chiederete voi?<b>PS</B>. non ho mai detto che sta pagina sia pulita. è un banale ciclo for di un fottio di VOTA una persona random. se ve ne manca una a forza di ricaricare funzionerà pure prima o poi nooooooo?????</h4>");

tabled();
trtd();
	turboVoto();
tdtd();
	turboVoto();
#tdtd();
#	turboVoto();
trtdEnd();
tableEnd();

include "footer.php";
?>
