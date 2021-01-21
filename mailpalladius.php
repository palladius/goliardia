<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

$GMS="<a href='gms.php'>GMS</a>";

?>
<center>
					<h4>Manda una mail a palladius</h4>
						<h1>Sei sicuro?!?</h2>
Ho cominciato da poco a lavorare e ti assicuro che ho pochissimo tempo x me. Prima passavo 
un'oretta al giorno a mettere a posto tutti i ciappini del sito (dà la gestione a Tizio, metti la foto
di Caio, e così via), ora non posso più. 

<br><b>Se hai bisogno di sapere come funziona qualcosa</b>, manda un <?php  echo $GMS?> a un tuo
amministratore di fiducia (nelle FAQ vedi gli admin della tua città... se no manda un <?php  echo $GMS?> a uno che credi ne sappia): ciò implica tu sia sbur-user, cosa che all'inizio non sarai, dunque andiamo al passo successivo:

<br><b>Se sei ospite, manda una foto </b> a <?php  echo $TAG_MIO_AIUTANTE?> (ricordandoti di dirgli il tuo nome utente ESATTO: mica siamo tutti divinatori di Teutates!!!). Ciò che voi siete è ovvio PER VOI ma non PER NOI, you got it? Al più presto verrà messa su e sarai fatto user. Leggi bene le faq sui requisiti della foto (ao', non ci prendete mai! incredibile, dovrei fare uno studio sociologico a riguardo e prenderei la II laurea in psicologia). PS la foto dev'essere - tra l'altro - un JPG a te omonimo e inferiore ai 10 KB: se è 10.02 viene scartata. sono ingegnere, non ho mezze misure. se proprio non sei capace di rimpicciolirla magari il mio gentile aiutante può aiutarti, ma tu comincia <i>aiutando lui</i>!

<br>Se mi mandi mail inutili o cui leggendo le faq potresti rispondere da solo non ti risponderò, x un banale motivo: 
anche supponendo che il mio tempo valga quanto il tuo (ma se sei qui a cazzeggiare è alquanto improbabile), pensa quando N persone si mettono a scrivere: "mah, come si fa di qua?", "mah, come funziona quello?" e cosi' via.. a volte impiego meno tempo a implementare una nuova funzionalità che a scriverne la spiegazione! :-) Ho inventato le faq apposta x riportare il rapporto perdita-di-tempo (TTLR) da 1:N a 1:1. Aiutatemi, per favore. Non sono Mandrake, nè la 8.0, nè la 9.0 (questa la capisce solo Tit, vabbè).

<br>Ho pure implementato la possibilità di mandare messaggi <?php  echo $GMS?> a utenti fittizi di nome BUGS e DEVELOP (che vi serviranno x segnalare bug o migliorie al sito, rispettivamente, e vi sarò MOLTO grato se li userete!), oltre alla possibilità di scrivere al gruppi degli amministratori e degli amministratori VIP (una cerchia di pochi eletti e in via di estinzione ormai: solo uno frequenta assiduamente il sito).

<br>Se hai un problema che ritieni che possa essere risolto solo via mail (e x cui nessun altro ti possa aiutare)
o sei una ragazza carina e con le tette grosse e vuoi chiedermi di uscire, allora  scrivimi pure (la mail è: <?php  echo $WEBMASTERMAIL?>). <b>PER FAVORE INDICA CHI SEI, MAGARI TRA APICI, COME NOME UTENTE</b> (capita spesso che uno ti scrive con detto: non c'è la mia foto, xchè? e tu non sai manco chi sia sto qua. poi alla fine ci scrive vaffanculo. e tu dici: "aH! pure maleducato!" e scopri che quello è il suo nome goliardico... insomma, non sono un indovino, voi non avete idea di quante cose voi date x scontate, NON NE AVETE IDEA) ;-)

<?php 
	include "footer.php";
?>
