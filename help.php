<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


			// INIZIO HELP AUTOMATICO
if (Session("px")<10)
{
openTable();
?>
<font color="navy">
<h3>HELP!</h3> 
Siccome sono le prime volte che ti colleghi in questo sito ti illumino un pelo su come barcamenarti su di esso, ok? Allora:<br>
<b>antiprof</b>: serve a trasformare le foto in foto + innocue e far sembrare il sito un po' + serio. cliccaci x attivarlo. ricliccaci x disattivarlo, come un interruttore.<br>
<b>canti</b>: contiene un bel po' di canti goliardici (e non).<br>
<b>chat</b>: ti permette di chattare con altri utenti attivi nel sito. Se hai msn, mettilo sul tuo profilo che la chat è intrinsecamente LENTA. potrai mandare messaggi privati e mandare/esser mandato in braghe usando i link a destra della chat.<br>
<b>coppie</b>: la pagina del gioco delle coppie, che contiene tutte le statistiche: da sbur-user puoi votare e essere votato, con commenti, voti numerici e desideri sessuali. In questa pagina trovi un sunto di quel che la gente pensa di te...<br>
<b>FAQ</b>: LEGGILE PRIMA DI ROMPERE I COGLIONI A ME. GRAZIE.<br>
<b>gestioni</b>: è il tuo pannello di controllo goliardico: contiene tutti i goliardi e gli ordini che hai in gestione, + due menu a tendina con tutti i goliardi e tutti gli ordini del sito. cliccando qua e là troverai le schede degli ordini e dei goliardi.<br>
<b>Home</b>: è la pagina in cui vieni catapultato all'inizio. Contiene: <br>
- a sinistra: il motore di ricerca, l'ultimo sondaggio, gli ultimi messaggi del forum, e gli ultimi utenti collegati.<br>
- al centro: un messaggio occasionale mio, una fotona a mio tiramento di culo e un'introduzioncina statica e ormai obsoleta (avete idee di che potrei metterci?!? ditemelo via mail!)<br>
- a destra: un link alla chat (con chi è attualmente in chat), gli appuntamenti del mese, e statistiche varie del sito che potrete trovare interessanti magari più avanti..<br>
<b>Linkz</b>: pagina con link postati da voi (pagine personali, degli ordini, e cosi' via)<br>
<b>Messaggi</b>: il cuore pulsante del sito, contiene i vostri messaggi e le foto di chi li manda: fico, nevvero?<br>
<b>Sondaggi</b>: trovate tutti i sondaggi aperti e chiusi. x ora è un po' incasinato, ma esaustivo. in futuro forse lo ripulirò.<br>
<b>Statistiche</b>: statistiche varie del sito. se siete interessati a sapere qualcosa che non leda la VOSTRA privacy, suggeritemelo via email, la mia fantasia è ormai in riserva... ma ci ho fatto molti km, fidatevi, son pur sempre un ingegnere :)<br>
<b>Utente</b>: attenzione, questo è il pannello di controllo del vostro profilo utente: usatelo e sappiatelo usare. Qui potete cambiare la vostra PASSWORD e tutti i dettagli del vostro profilo (tranne nome e email, che sono abbastanza critici: in tal caso chiedetemelo via mail, vedremo se è possibile)<br>
<br>
Non dimenticare di usare il </b>motore di ricerca</b>: digitando UN SOLO NOME (non provare con due nomi, poichè non funziona) troverà tutti i messaggi, le faq, i goliardi e gli utenti che abbiano a che fare con esso... è il modo + pratico x vedere se un goliarda che conosci esiste sul sito come Utente, Goliarda o entrambi (vedi FAQ x la differenza).<br>
Se vuoi essere promosso da guest a sbur-user e accedere cosi' a servizi supplementari, mandami una foto che rispecchi i crismi che troverai nelle FAQ.
</font>
<?php 
closeTable();
}
			// FINE HELP AUTOMATICO


?>


<?php 
#include "const/help.html";
include "footer.php";
?>
