<?php 


include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


function fancyInizio($tit="?!?!? EROOOOOOOORE")
{
echo "<p>";
//img("freccia-f.gif' align='center");
img("freccia-f.gif");
echo " <b>$tit</b>. ";
}

function fancyFine()
{
scrivib("</p>\n");
}



?>
<H1>
<?php  img("persone/palladius.jpg",50); ?>
 Vuoi dare una mano? 
<?php  img("persone/palladius.jpg",50); ?>
</h1>
(aggiornato al: 12.16 01/02/2004)
</center>
</center>


<?php  fancyInizio("BUGS"); ?>

VERIFICA I BUGZ. Crea, distruggi modifica usando date sballate, nomi assurdi, ... cerca di ingannare il db in ogni modo crea una cosa A riferita a B poi cancella B e guarda se la vedi ancora, e cois' via.
	Anche solo le parrrrrole scirtte amle: si sa che sono dislessdico e che scrivo in fretta... <b>FAMMI IL SANTO PIACERE DI SEGNALARMELI ATTRAVERSO I GMS AL GRUPPO @BUGS</b> (se no che li ho inventati a fare?); EVITA MSN E COSì VIA: non sempre ho tempo al momento, e farmi un copia incolla ruga. ricordate: verba volant, nomina ac avverbia rimanent.

<?php  
fancyFine();
fancyInizio("ERORI-uorningz-nòtiziz"); 
?>

Altra cosa, non banalissima ma neanche difficile, per i più laboriosi: il sito è configurato in modalità DEBUG, quindi in parole povere
	se ci sono degli errori nel codice che ho scritto compariranno le parole "ERROR","WARNING"  o "NOTICE", in ordine inverso di
	calamità. il 90% di questi msg li vediamo tutti, e mi piacerebbe me li segnalaste. ma, x sfighe varie, alcuni tag html potrebbero avere del codice al loro interno (ad es. quando popolo una casella di scelta, tanto x intenderci) sballato. in tal caso, il vostro html sarebbe 'pulito', ma il sorgente html conterrebbe le parole '<b>warning</b>','<b>error</b>' o '<b>notice</b>'. buffamente i + terribili sono i notice e i warning, poichè un error fa fallire la pagina e ce ne si accorge ben da sè... x chi di voi abbia un po' le mani in pasta, se volete dare ogni tanto un occhio ai sorgenti html che il browser vi sputa e vedere se contiene quelle 3 keyword, mi fate un piacerone. Azzie!
<?php  
fancyFine();
fancyInizio("sql indesiderato"); 
?>



guarda se tra i tanti ciappini che fai vedi righe di codice SQL (le riconosci poichè iniziano con "INSERT/SELECT/DELETE/UPDATE" e suonano tipo: 
<u>"select * from tabella where key='value' and sticazzi > stialtri ORDER BY lung_pene"</u>. l'obiettivo del sito è che tu NON veda le query fatte...

<?php  
fancyFine();
fancyInizio("prestazioni (non sessuali)"); 
?>

guarda quanto va veloce, se secondo te si comporta stranamente rispetto al sito vecchio, se la chat è + lenta o + veloce, e così via.

<?php  
fancyFine();
fancyInizio("prestazioni (sessuali)"); 
?>
Se i tuoi 2 XXIII cromosomi hanno forma simile e puoi giocare coi giochi MB (ovvero hai dai 7 ai 70 anni), <i>dammela</i>. Il sito ne beneficerà per quel che concerne la veste grafica e andrà anche molto + veloce. Provare x credere.
<?php  
fancyFine();
fancyInizio("Per programmatori di PHP (new!)"); 
?>
<b>Se ne sapete di PHP, ho appena reso disponibile (sotto downloadz) i sorgenti del sito. dato che non ho piu' tempo, almeno ora potrete mettere mano al codice (ovviamente saro' sempre io o chi x me a metterlo effettivamente sul sito, se no immaginate che casino). Se avete problemi o comunicazioni mandatemi una mail, ci tengo a sapere chi vuole contribuirte e di che strumenti ha bisogno. </b>
<?php  
fancyFine();
fancyInizio("il lato buono dell'hacking"); 
?>

hackeralo in ogni modo. cerca di fare sql injection (se sai cosa sono), furto di sessione, cambia i form e osserve ciò che riesci a fare che - secondo te- il sito non dovrebbe lasciare fare.
	e qui viene il punto + difficile: <b>DIMMELO</b>.
<?php  
fancyFine();
fancyInizio("donazioni"); 
?>

Se vuoi fare una donazione per aiutare il progetto OPENGOLIARDIA (presto sarà opensource, ammesso che la cosa sia ritenuta ragionevole dallo staff tecnico, ma è solo questione di tempo), questa 
	è ben accetta. Più che soldi, son gradite bocce di vino e - in caso tu sia di sesso femminile o un ragazzo carino come Spanami - di favori sessuali. In effetti,
	se volete dare un contributo (dato che la pecunia non mi piace, o meglio: non in questo modo) potreste comprarmi una maglietta con la mia
	brutta faccia sopra: costano 5  e vi assicuro che le ho pagate circa l'80%, e se sapete qualcosa di economia capite cosa vuol dire. Ho una
	rimnanenza di magazzino pari al 60% dell'investimento, quindi.. PLIS! prendetemene una. Farete + felice ME e soprattutto tutte le ragazze che 
	vi vedranno in giro st'estate con questa belizzima maglietta dai toni alla moda (sempre che non la compriate nel 2008!), frutto della cooperazione 
	tra Farina 00, Pariettus e me. Pensate alla gnocca che passa x strada, vi ferma e vi fa: chi è quel coglione lì nella maglietta? E voi: "mah, un mio amico matto di FE",... parla che ti parla, da coscia nasce coscia, mal comune mezzo gaudio... magari ve la guzzate pure!
<?php  
fancyFine();
fancyInizio("Grafica pura"); 
?>
Se sai <b>disegnare</b> e vuoi creare icone o disegni x il sito, sono sempre graditi. Ma di brutto brutto brutto, né? Oppure se vedi immagini con sfondo bianco che cozzano con lo sfondo, ti scrichi il jpg, gli togli lo sfondo bianco e lo salvi come GIF e me lo mandi... fatica 0,001. risultato notevole... fa tu!

<?php  
fancyFine();
fancyInizio("Grafica html"); 
?>

sei un grafico HTML e anche se non sei bravo a mano libera sai usare effetti e creare SKIN?!? Presto sarà disponibile uno ZIP con l'attuale SKIN che il sito usa. 
	potrai studiarla, variarla e liberamente di nuove. Se conosci i CSS puoi prendere il foglio di stile attuale e cambiarlo (se proprio non sei capace da solo
	, te lo faccio scaricare io <b><a href="skin/<?php  echo $NOMESKIN?>/style/style.css">QUA</a></b> :D), e mandarmelo. Se mi piace,
	in futuro la gente potrà usare quello anzichè questo (tutti dicono che le mie scelte di colori fan cagare: anzichè criticare, fate di meglio! 
	Come se io <i>amassi</i> fare pure il grafico, oltre che il genio!).<br/>

<?php  
fancyFine();
fancyInizio("x finire"); 
?>

per qualunque cosa, suggerimento, consiglio, eccetera, esiste il gruppo (sotto GMS) 
	<b><a href ="gms.php?per=@bugs">@BUG</a></b> x i bug reportz: sfruttatelo. Se invece avete suggerimenti per lo sviluppo del sito (tipo: che carino sarebbe se mettessi questa nuova bazza strana...) mandate un gms a @develop. Grazie.


<?php 

include "footer.php";
?>
