-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generato il: 30 Ago, 2006 at 04:05 PM
-- Versione MySQL: 4.1.9
-- Versione PHP: 4.3.10
-- 
-- Database: `og_vuoto`
-- 

-- TOLTE STE RIGHE BY RIC PER CREAZIONE CUSTOM DEL DB...
-- CREATE DATABASE `og_vuoto` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
-- USE og_vuoto;

-- --------------------------------------------------------

-- 
-- Struttura della tabella `appuntamenti`
-- 
-- Creazione: 25 Ago, 2006 at 04:59 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 04:59 PM
-- 

DROP TABLE IF EXISTS `appuntamenti`;
CREATE TABLE `appuntamenti` (
  `ID_appuntamento` int(11) NOT NULL auto_increment,
  `Nome` varchar(50) default NULL,
  `tipodiappuntamento` varchar(50) default NULL,
  `luogo` longtext,
  `data_inizio` datetime default NULL,
  `data_fine` datetime default NULL,
  `città` varchar(50) default NULL,
  `Abdicabilita` int(11) default NULL,
  `recapitogoliarda1` int(11) default NULL,
  `recapitogoliarda2` int(11) default NULL,
  `recapitogoliarda3` int(11) default NULL,
  `id_login` int(11) default NULL,
  `note` longtext,
  `data_invio` datetime default NULL,
  PRIMARY KEY  (`ID_appuntamento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `appuntamenti`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `canzoni`
-- 
-- Creazione: 25 Ago, 2006 at 04:59 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 04:59 PM
-- 

DROP TABLE IF EXISTS `canzoni`;
CREATE TABLE `canzoni` (
  `ID_canzone` int(11) default NULL,
  `titolo` varchar(255) default NULL,
  `id_login` int(11) default NULL,
  `Data_creazione` datetime default NULL,
  `Autore` varchar(255) default NULL,
  `m_bSeria` tinyint(1) NOT NULL default '0',
  `Corpo` longtext,
  `Note` longtext,
  `tipo` varchar(32) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `canzoni`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `cariche`
-- 
-- Creazione: 25 Ago, 2006 at 04:59 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 06:41 PM
-- 

DROP TABLE IF EXISTS `cariche`;
CREATE TABLE `cariche` (
  `ID_CARICA` int(11) NOT NULL auto_increment,
  `ID_Ordine` int(11) default NULL,
  `nomecarica` varchar(50) default NULL,
  `ID_CAR_staSottoA` int(11) default NULL,
  `CardinalitàMax` int(11) default NULL,
  `Dignità` varchar(50) default NULL,
  `Attiva` tinyint(1) NOT NULL default '0',
  `HC` tinyint(1) NOT NULL default '0',
  `note` varchar(150) default NULL,
  PRIMARY KEY  (`ID_CARICA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dump dei dati per la tabella `cariche`
-- 

INSERT INTO `cariche` VALUES (1, 1, 'Gran Capo', -1, 0, 'capoordine', 1, 0, 'solo il gran capo può ambire a questa carica');
INSERT INTO `cariche` VALUES (2, 1, 'Capetto', 1, 0, 'nobile', 1, 0, 'nota');
INSERT INTO `cariche` VALUES (3, 1, 'Altro capetto', 1, 0, 'nobile', 1, 0, 'du vicari is meigl che uan');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `colorefeluca`
-- 
-- Creazione: 25 Ago, 2006 at 04:59 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:05 PM
-- 

DROP TABLE IF EXISTS `colorefeluca`;
CREATE TABLE `colorefeluca` (
  `ID_COLOREFELUCA` int(11) NOT NULL auto_increment,
  `Facoltà` varchar(50) default NULL,
  `colore_default` varchar(50) default NULL,
  `città` varchar(50) default NULL,
  PRIMARY KEY  (`ID_COLOREFELUCA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- 
-- Dump dei dati per la tabella `colorefeluca`
-- 

INSERT INTO `colorefeluca` VALUES (1, 'Architettura', 'nero', 'Bologna');
INSERT INTO `colorefeluca` VALUES (2, 'Belle arti', 'zucchero', 'Bologna');
INSERT INTO `colorefeluca` VALUES (3, 'Biologia', 'giallo', 'Bologna');
INSERT INTO `colorefeluca` VALUES (4, 'Biotecnologia', 'verde', 'Bologna');
INSERT INTO `colorefeluca` VALUES (5, 'CTF', 'verde', 'Bologna');
INSERT INTO `colorefeluca` VALUES (6, 'Economia', 'giallo', 'Bologna');
INSERT INTO `colorefeluca` VALUES (7, 'Farmacia', 'rosso', 'Bologna');
INSERT INTO `colorefeluca` VALUES (8, 'Filosofia', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (9, 'Fisica', 'verde', 'Bologna');
INSERT INTO `colorefeluca` VALUES (10, 'Giurisprudenza', 'blu', 'Bologna');
INSERT INTO `colorefeluca` VALUES (11, 'Informatica', 'verde', 'Bologna');
INSERT INTO `colorefeluca` VALUES (12, 'Ingegneria', 'nero', 'Bologna');
INSERT INTO `colorefeluca` VALUES (13, 'Interprete e Traduttore', 'amaranto', 'Bologna');
INSERT INTO `colorefeluca` VALUES (14, 'Lettere', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (15, 'Lingue', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (16, 'Magistero', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (17, 'Matematica', 'verde', 'Bologna');
INSERT INTO `colorefeluca` VALUES (18, 'Medicina', 'rosso', 'Bologna');
INSERT INTO `colorefeluca` VALUES (19, 'Pedagogia', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (20, 'Scemenze politiche', 'bluone', 'Bologna');
INSERT INTO `colorefeluca` VALUES (21, 'Scienze della Comunicazione', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (22, 'Storia', 'bianco', 'Bologna');
INSERT INTO `colorefeluca` VALUES (23, 'altro…', 'marrone', 'Bologna');
INSERT INTO `colorefeluca` VALUES (24, 'Veterinaria', 'rosso', 'Bologna');
INSERT INTO `colorefeluca` VALUES (25, 'Economia', 'grigio', 'Torino');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `contenuti`
-- 
-- Creazione: 25 Ago, 2006 at 04:59 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 04:59 PM
-- 

DROP TABLE IF EXISTS `contenuti`;
CREATE TABLE `contenuti` (
  `idcontenuto` int(11) NOT NULL auto_increment,
  `titolo` varchar(255) default NULL,
  `idlogin` int(11) default NULL,
  `contenuto` longtext,
  `datacreazione` datetime default NULL,
  `m_nLivelloSegretezza` int(11) default NULL,
  `m_battivo` tinyint(1) NOT NULL default '0',
  `m_bInAttesa` tinyint(1) NOT NULL default '0',
  `tipo` varchar(32) default NULL,
  `idloginpubblicante` int(11) default NULL,
  `m_bSerio` tinyint(1) NOT NULL default '0',
  `datapubblicazione` datetime default NULL,
  PRIMARY KEY  (`idcontenuto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `contenuti`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `eventipresenze`
-- 
-- Creazione: 25 Ago, 2006 at 05:00 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:00 PM
-- 

DROP TABLE IF EXISTS `eventipresenze`;
CREATE TABLE `eventipresenze` (
  `id_presenza` int(11) NOT NULL auto_increment,
  `id_utente` int(11) default NULL,
  `id_appuntamento` int(11) default NULL,
  `probabilita` int(11) default NULL,
  `commento` varchar(255) default NULL,
  `m_nquantitotale` int(11) default NULL,
  `datacreazione` datetime default NULL,
  PRIMARY KEY  (`id_presenza`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `eventipresenze`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `facolta`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 03:47 PM
-- 

DROP TABLE IF EXISTS `facolta`;
CREATE TABLE `facolta` (
  `ID_FACOLTA` int(11) default NULL,
  `Facolta` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `facolta`
-- 

INSERT INTO `facolta` VALUES (4, 'Sociologia');
INSERT INTO `facolta` VALUES (0, 'Psicologia');
INSERT INTO `facolta` VALUES (1, 'Architettura');
INSERT INTO `facolta` VALUES (2, 'Belle arti');
INSERT INTO `facolta` VALUES (3, 'Biologia');
INSERT INTO `facolta` VALUES (5, 'CTF');
INSERT INTO `facolta` VALUES (6, 'Economia');
INSERT INTO `facolta` VALUES (7, 'Farmacia');
INSERT INTO `facolta` VALUES (8, 'Filosofia');
INSERT INTO `facolta` VALUES (9, 'Fisica');
INSERT INTO `facolta` VALUES (10, 'Giurisprudenza');
INSERT INTO `facolta` VALUES (11, 'Informatica');
INSERT INTO `facolta` VALUES (12, 'Ingegneria');
INSERT INTO `facolta` VALUES (13, 'Interprete e Traduttore');
INSERT INTO `facolta` VALUES (14, 'Lettere');
INSERT INTO `facolta` VALUES (15, 'Lingue');
INSERT INTO `facolta` VALUES (16, 'Magistero');
INSERT INTO `facolta` VALUES (17, 'Matematica');
INSERT INTO `facolta` VALUES (18, 'Medicina');
INSERT INTO `facolta` VALUES (19, 'Pedagogia');
INSERT INTO `facolta` VALUES (20, 'Scemenze politiche');
INSERT INTO `facolta` VALUES (21, 'Scienze della Comunicazione');
INSERT INTO `facolta` VALUES (22, 'Storia');
INSERT INTO `facolta` VALUES (23, 'altro…');
INSERT INTO `facolta` VALUES (24, 'Veterinaria');
INSERT INTO `facolta` VALUES (25, 'Chimica');
INSERT INTO `facolta` VALUES (26, 'Chimica industriale');
INSERT INTO `facolta` VALUES (27, 'Astronomia');
INSERT INTO `facolta` VALUES (28, 'Agraria');
INSERT INTO `facolta` VALUES (29, 'ISEF');
INSERT INTO `facolta` VALUES (31, 'Cons. beni culturali');
INSERT INTO `facolta` VALUES (32, 'Archeologia');
INSERT INTO `facolta` VALUES (34, 'Biotecnologie');
INSERT INTO `facolta` VALUES (50, 'scienze statistiche');
INSERT INTO `facolta` VALUES (51, 'enologia');
INSERT INTO `facolta` VALUES (52, 'Scienze e Tecnologie Alimentari');
INSERT INTO `facolta` VALUES (142, 'scienze naturali');
INSERT INTO `facolta` VALUES (423, 'Geologia');
INSERT INTO `facolta` VALUES (6303, 'Scienze Ambientali');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `faq`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 03:47 PM
-- 

DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `idfaq` int(11) NOT NULL auto_increment,
  `domanda` varchar(255) default NULL,
  `risposta` longtext,
  `data` datetime default NULL,
  PRIMARY KEY  (`idfaq`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

-- 
-- Dump dei dati per la tabella `faq`
-- 

INSERT INTO `faq` VALUES (1, 'come faccio a diventare Utente Registrato da Guest sfigato quale sono ora', 'allora... per diventare User da guest, io devo avere due semplici tuoi dati (x mia scelta): una tua foto e un\\''email. la seconda non va bene se me la manda un tuo amico o se la scrivi nel sito: mi deve arrivare una mail DA quell\\''indirizzo. Per quel che riguarda la foto,  non è che sia molto pretenzioso: è sufficiente un JPG da pochi KB (3-5, max  tassativo 10) che ritragga il tuo viso. Questo è FONDAMENTALE poichè x come è implementato ora il gioco delle coppie se tu sei USER ma non hai foto succedono dei casini. e 2+2 potrebbe far 5. capito?!? quindi chiedo 2 piccole cose... se poi non sei capace di  fare il thumbnail fatti aiutare da uno degli amministratori (che trovi sempre in chat a cazzeggiare) o tutt\\''al + da me. ok?!? non per polemizzare, ma mi tocca ritagliare 4 5 foto al giorno e ne ho un pelino le palle (eppur capaci, pare!) piene. :-)\0', '2002-09-25 23:07:57');
INSERT INTO `faq` VALUES (2, 'come faccio a cambiare la mia foto', 'è semplice: non puoi. Solo io per ora posso buttar su foto. L\\''unica eccezione è lo spazio di upload (clicca su FOTO e guarda in basso) che ti permette di buttare le foto in un\\''isolotta stagna del server accessibili SOLO a me. Quindi è un po\\'' come spedirmele, con l\\''unica differenza che in quell\\''area ci guardo meno spesso.\0', '2002-09-25 23:11:46');
INSERT INTO `faq` VALUES (3, 'Quanto sei figo, oh Pal, da 1 a 10?!?', 'il mio realismo m\\''impedisce di rispondere come taluni di voi ritengono, ovvero 11. mi dovrò accontentare di stare dunque coi piedi per terra.\r\n\r\n10.\0', '2002-09-25 23:18:29');
INSERT INTO `faq` VALUES (4, 'Cosa sono ste FAQ?!?', 'X chi non lo sapesse, le FAQ sono in tutti i siti seri (condizione necessaria, ma non sufficiente, evidentemente!!!) e servono a dire una cosa una volta x tutte evitando di essere assillati da mail che chiedono tutte la stessa cosa: come faccio a X?!? a cosa serve Y?!? \r\n\r\nIn questo spazio cercherò di rispondere alle vostre domande + frequenti. E ovviamente, ridirezionerò qui chiunque mi faccia domande già risposte...\r\n\r\ncercherò altresì di essere esauriente in modo che non mi diciate: "ok ho capito, ma poi quella cosa....?!??!"\r\n\r\nok??!ciao a tutti\0', '2002-09-25 23:19:31');
INSERT INTO `faq` VALUES (5, 'Come funziona il Gioco delle Coppie', 'allora, il Gioco delle Coppie sembra un normale voto MA NON E\\'' un poll come gli altri. semplicemente, se tu sei utente registrato, a ogni pagina che carichi ti verrà estyratta a sorte una persona (utente registrato e foto dotato) del sesso opposto. \r\nA quel punto potrai votarla con un numero, dei commenti e un flag di trombabilità e baciabilità.\r\n\r\nSe prima o poi anche questa persona ti voterà, PUFF! nel gioco delle coppie vedrai probabilmente la vs coppia nella top ten , vedrai questa persona far coppia con te nelle coppie personali, e vedrai i commenti delle tue spasimanti nella stessa pagina.\r\n\r\nse sei donna, rileggi tutto invertendo i con e e a con o. se è difficile vieni a casa mia che te lo spiego.\r\n\r\nok?!?\r\n\r\nPS x ora NON c\\''è modo di togliere dall\\''estrazione una persona che ti fa cagare, nè di votare una che ti piace... semplicemente aspetta e vota chiunque ti capiti, a maggior ragione se non ti piace!!! prima o poi sto gioco non ti romperà più i coglioni, parola di statistico.\0', '2002-09-27 15:18:30');
INSERT INTO `faq` VALUES (6, 'come funziona il motore di riCERCA', 'intanto grazie x la domanda.\r\n\r\nDunque, il motore di ricerca è un prototipo in grado di cercare la parola scelta tra le foto, i goliardi, gli utenti, .... e di visualizzare le informazioni.\r\n\r\nE\\'' importante capire che x ora se inserite le parole "palladius amphibia" lui cerca la stringa INTERA e ovviamente (!?!) non trova niente. Un giorno metterò un parserino che scompone la frase nelle parole e fa la query automaticamente in OR, ma è un lavoraccio. x ora cuccatevi questo. \r\n\r\nX i messaggi, le persone e le FAQ il comportamento è ovvio. X chi non lo sapesse, x le foto c\\''è un\\''architettura <i>a duplice sussunzione</i> alla base della coppia DB/FileSystem, e ve la spiegherò: \r\n\r\n- da un lato ci sono i file, con le singole foto.\r\n- dall\\''altra, ci siamo io e gli amministratori che abbiamo modo di mettere un titolo e una desacrizione x ogni foto e soprattutto di dire al DataBase <i>CHI c\\''è</i> dentro alla foto. Lui memorizza queste info e se voi cercate Palladius, non solo trovate le foto che mi hanno nel titolo o nella descrizione (nella colonna di sinistra della ricerca), ma anche in quelle in cui io compaio (e ovviamente, qualcuno s\\''è degnato di dirlo al DB).\r\n\r\nx quel che concerne l\\''ultima parentesi, esiste un modo x fare l\\''ìautodetect, è il mio lavoro dopotutto, ma... questa è un\\''altra storia.\r\n\0', '2002-09-29 20:04:45');
INSERT INTO `faq` VALUES (7, 'dove cacchio sono le foto?!?', 'Allora, per trovare le foto, clicchi su FOTO in alto.\r\n\r\npoi clicchi su  "GUARDA TUTTE LE FOTO (col nuovo TN service®)".\r\n\r\npoi ti si apre un visulaizzatore che in alto ti fa vedere tutte le subdirectory (x es: DISORGANIZZATE E FOTO).\r\nle prime sono schifezze messe un po\\'' alla carlona, le seconde contengono invece tutte le foto serie (indicizzate, con titolo, x data, ...)\r\n\r\ntu clicchi su FOTO.\r\n\r\ne poi clicchi su 2002. (x ora è disponibile solo quest\\''anno).\r\n\r\necco che finalmente trovi tutte le date che t\\''interessano (spero).\r\n\r\nPS le foto delle singole persone (i thumb) li ho tolti xchè qualcuno ha rotto i coglioni. Non offendetevi. Sono foto di sistema, fatte x essere viste quando lo dico io, e non quando lo dite voi.\r\nse però volete vedere la foto di X, digitate X nel motore di ricerca e se è un utente registrato o un goliarda registrato da qualche utente... bè vedrete il thumb che v\\''interessa.\r\n\0', '2002-09-30 10:38:39');
INSERT INTO `faq` VALUES (8, 'ho la foto di un ordine/persona/csa simpatica: come la butto su?!?', 'mandemela via mail. \r\n\r\nSe è + grossa di 200 KB, spediscimela al lavoro: rcarlesso@deis.unibo.it\0', '2002-10-02 15:09:36');
INSERT INTO `faq` VALUES (9, 'Posso contribuire mandandoti foto io?!? E farti pure i thumbnail?!?', 'soccia, magari!!!\r\n\r\nallroa se qualcuno di voi volesse contribuire mandandomi foto di eventi, vi spiego qual è la struttura base del mio FS: per ogni evento metto TUTTE le foto in una directory, con un nome significativo che tipicamente inizia con AA-MM-GG  che guarda caso è la rappresentazione inglese delle date (+ intelligente della nostra, una volta tanto, poiché l\\''ordine lessicografico, o alfabetico x il popol bue,  corrisponde a quello cronologico). \r\n\r\nAll\\''interno della directory vi sono 2 foto x ogni foto (maccome?!?): la versione grande e il suo thumbnail. entrambe devono rispettare dei vincoli: le piccole (thumb) devono essere di MENO di 10 KB, possibilmente 3 o 4, e stare nelle dimensioni 150x150 pixel; le grandi devono stare pure loro in un range: 640x640.\r\n\r\nche formato strano, direte voi, il 640x640 non esiste, idiota... e invece l\\''idea è: la dimensione dev\\''0essere tale che la foto deve stare ENTRO quei limiti, ovviamente se è verticale (portrait) ci starà al più una 480x640, se è orizzontale (landscape) 640x480.\r\n\r\nE\\'' altresì importante che la coppia abbia un naming del genere: sia "XXX.jpg" il nome della foto, allora il relativo thumbnail si dovrà chiamare "tn_xxx.jpg".\r\n\r\nPS non speditemi via mail 5 mega alla volta! Se dpovete spedire, fate 2 mega alla volta, aspettate un ACK  da me e andate avanti cosi\\''... per tali moli mandatemele all\\''Università (rcarlesso@deis.unibo.it).\r\n\r\nGrazie dei contributi.\0', '2002-10-13 20:55:53');
INSERT INTO `faq` VALUES (10, 'Che figata sto sito, come posso contribuire?!?', 'Grazie intanto del complimento, o tu utente caro.\r\n\r\nSe sei un grafico e vuoi farmi bottoncini, iconcine personalizzate, VOLENTIERI.\r\n\r\nSe vuoi lavorare al foglio di stile (se sai cos\\''è) basta che te lo scarichi, lo elabori e me lo mandi. se ne fate tanti posso implementare anche l\\''idea di SKIN x il sito, molto in voga ultimamente: uno rosino, uno blu serio, e così via.\r\n\r\nSe mi segnali dei bug mi fai sempre felice.\r\n\r\nSe mi offri da bere quando ci vediamo e, in caso  tu sia gnocca-dotato (volgarmente detto femmina) e me la voglia dare, meglio ancora.\r\n\r\nGrazie.\r\n\r\nPS se non fai nulla di tutto questo e lo visiti, non dimenticarti di mandarmi puntualmente delle mail segnalandomi quanto sono figo/bravo/bello/alto/con non troppa pancia che comunque è bella/prestante/bravo a suonare il piano/pieno di idee e così via. Chiedete a Cavedano se siete a corto di idee.\0', '2002-10-13 21:01:47');
INSERT INTO `faq` VALUES (11, 'com''è la bazza dell''Amministratore?!?', 'Allora. Tra di voi ci sono alcuni (pochi, 5 o 6) amministratori che hanno alcuni privilegi in più dell\\''user: possono creare sondaggi, mandare in braghe, scrivere nel testo in alto e infine concedere in gestione ordini e goliardi alla gente.\r\n\r\nNon sono cose così grosse, ma c\\''è chi vi ambisce. Se mi conoscete un po\\'', non rompetemi i voglioni su: perchè lui sì e io no? perchè la cosa mi fa imbestialire. Diciamo che ritengo ingegneristico avere un amministratore per città, ammesso che abbia qualche conoscenza di informatica E si colleghi spesso, se no non mi serve a neinte, anche perchè la \\''rientranza\\'' della struttura del sito (DB+pagine) è garantita per gli utenti ma NON per gli amministratori, quindi non voglio gente che possa far casini (vero lorduccio?!?).\r\n\r\nGrazie.\0', '2002-10-23 10:36:59');
INSERT INTO `faq` VALUES (12, 'come mai nell''ordine X non ci sono? Eppure sono il super cazzola con triplo scappellamento a sx!!!', 'allora. C\\''è una differenza fondamentale tra due entità che può trarre in inganno voi tutti: utenti e goliardi.\r\n\r\nUtente è colui che si registra, dà un username una password una data di nascita, un sesso (bitonale) e una mail per intenderci.\r\n\r\nGoliarda è un\\''altra cosa: lo crei dalla pagina GETSIONI sopra CREA NUOVO GOLIARDA ed è un\\''emtità dotata di molte cose in più e qualcuna in meno (indirizzo, nome goliardico, nome nobiliare, fuckoltà, ... ma non data di nascita x esempio).\r\n\r\nSe tu ti sei registrato come XXX devi poi anche creare il goliarda che probabilmente si chiamerà XXX YYY (X è il nome goliardico, Y quello nobiliare) ma potrebbe essere tranquillamente ZZZ YYY (x esempio Astrolabius potrebbe registrarsi come Roulettus).\r\n\r\nNe approfitto per dire che non voglio doppioni nel sito: utenti con 2 login o goliardi registrati due volte. Il computer non è un genio e non può controllarlo AUTOPMATICAMENTE e quindi ci pensate voi (oltre agli admin, a posteriori, a fare della garbage collection) a non inserire doppioni. Quando ne trovo punisco pesantemente l\\''utente che ha fatto sta cosa, tipicamente relegandolo a guest e togliendogli l\\''eventuale administratorhood.\r\n\r\nPerchè utente e goliarda sono entità separate? x il banale motivo che la relazione è uno a enne e voi potreste essere l\\''unico internettizzato dell\\''ordine di StiCazzi e allora registrerete SOLO voi stessi come Magnus Magister di Sticazzi e anche SC1,SC2,SC3, ..., SCn come merdine di Sticazzi. Mi son spiegato? Avrete automaticamente in gestione tutta sta gente. se poi SC42 un giorno si collega come utente, gli regalerete sè stesso e gli darete in Ulteriore Gestione altri goliardi (magari i suoi sub-popolani)-\r\n\r\nSpero che adessio abbiate una più profonda comprensione della Scamorza.\r\n\r\nMA MI RACCOMANDO, NIENTE DOPPIONI\r\n\r\n------\r\nzio Pal , più figo e paziente che mai\0', '2002-10-23 10:40:02');
INSERT INTO `faq` VALUES (13, 'perchè non hai ancora buttato su le foto di XXX?', 'ma porca pupazza, mica sono una macchinetta!\r\n\r\nin II luogo, ci metto un pacco di tempo a far le foto poichèp richiedono 4 stadi separati di bassa durata e in stretta dipendenza temporale (scaricare foto, portarle sul MIO computer, creare i thumb, masterizzare e portarli al lavoro e dal lavoro uploadarli).\r\n\r\ncapite anche voi che in questa catena mi costa uguale fare 1 foto come 1000 quindi aspetto di averne tante.\r\n\r\neccheccazzo. In braghe tutti.\0', '2002-10-23 12:52:07');
INSERT INTO `faq` VALUES (14, 'La tua chat è di un lento da far schifo!!  e mi chiedevo se stavi muovendoti in tal senso per velocizzarla un pochito....^_^', 'allora, lo so. l\\''implementazione attuale è INTRINSECAMENTE lenta, mi spiace. Ho fatto del mio meglio x renderla il + veloce possibile. Più di così non si può.\r\n\r\nSe qualcuno ha in mente una diversa teconologia (es: java) con sorgenti da poter modificare, ben venga. se non è modificabile sarebbe SI più veloce, ma perderemmo le faccine e le sostituzioni che amate tanto.\r\n\r\nSe mai avrò un mese di vacanza scriverò un messenger fatto da me con tutte le foto e le erre moscie e allora SI che potrò appesantirlo quanto cacchio mi pare.\r\n\r\nOk?!?\r\n\r\n\0', '2002-10-23 15:49:43');
INSERT INTO `faq` VALUES (15, 'ti ho spedito XXX ma non hai aggiornato il sito in tal senso. Why?!?', 'Allora, ricevo una trentina di mail al giorno tra iscrizioni, foto (aggiungi questa, dati vari eccetera). Vorrei rendervi chiaro un paio di cose:\r\n\r\n1) quando mi scrivete ditemi SONO l\\''utente XXX. non posso sempre andare a guardare chi è  Luca Cippalippa e Guglielmo Pancaldi. Grazie,. Siete 400, la mia memoria è solo da 64 k.\r\n\r\n2) mandatemi cose vostre, a mo\\'' di identificazione dallo stesso indirizzo email da cui avete fatto l\\''iscrizione: io sono sicuro che quello è il  vostro indirizzo dato che la password vi viene comunicata li\\''. grazie.\r\n\r\n3) la foto... quante volte ve lo devo dire? una foto VOSTRA (non di un animale) che occupi meno di 10 KB, col vostro viso. che vi possa identificare. non una in cui palpate una tetta eccetera. foto di tal genere van benissimo, le sto raccogliendo tutte in una directory apposta, ma non vanno bene x la promozione a user.  ok?\r\n\r\n4) domande sul sito. se mi volete segnalare un bug, ve ne ringrazio. ma se NON sapete come funziona una cosa, leggete le faq, chiedete in chat a uno che ne sa + di voi. non scrivetemi se non è proprio l\\''ultima spiaggia. grazie.\0', '2002-11-17 10:48:06');
INSERT INTO `faq` VALUES (16, 'UTENTI e GOLIARDI', 'RAGAZZI QUESTA FAQ è IMPORTANTISSIMA DA CAPIRE, ECCHECCACCHIO.\r\n\r\nx come è stato fatto il database, ci sono due entità che potrebbero generare scompiglio e che dovete capire: utenti e goliardi.\r\n\r\nutente è una cosa che fa login, per esempio PALALDIUS con una certa pwd (per esempio PWD) e una data di iscriuzione e dati simili che mi servono x autenticare la vostra permanenza (che speriamo esser risultata di vostro gradimento). la foto è automaticamente SUONOME.JPG x forza x motivi che son difficili da spiegare\r\n\r\nGOLIARDA (nel sito) è un esserino che sta nel data base dotato di nome, cognome, nome goliardico, nome nobiliare, foto, ordine di nascita (che magari verrà cambiato con ordine di appartenenza) eccetera. \r\nquesta entità appartiene a un solo utente (che invece può averne 0 come 1000) che ne è il creatore o gli viene regalato. può essere dato in gestione a altri utenti. può essere investito di nomine (collegamanti  tra il goliarda e la carica XXX). \r\n\r\nQUINDI FATEMI IL SANTO PIACERE SE SIETE XXX GRAN YYY DELL\\''ORDINE ZZZ , NON scrivete il vostro nome utente come GRANYYY ma come XXX. grazie. e nel nome goliardico NON METTETE xxx gran yyy, ma aspettate di vedere se nel vostro ordine la carica di yyy è stata inserita; allora quando avrete in gestione il goliarda XXX potrete \\''investirlo\\'' della carica di YYY. capito? spero di si\\''.\r\n\r\nse no comprate 5 settimane enigmistiche e cimentatevi col quesito della susi e l\\''angolo della sfinge. grazie.\0', '2002-11-19 14:28:07');
INSERT INTO `faq` VALUES (17, 'FOTO utenti e goliardi', 'un\\''altra cosa che continuate a non capire è che  un utente XXX può avere una foto e il goliarda XXX un\\''altra foto.\r\n\r\nSicuramente l\\''utente XXX avrà come nome foto XXX.jpg, ma il goliarda non è obbligato ad averla uguale, chi l\\''ha in gestione decide che foto mettergli. Se vedete un goliarda di cui manca la foto ma il cui utente ce l\\''ha, è sufficiente che chi l\\''ha in gestione modifichi il campo FOTO su SUONOME.JPG. non è difficle eh?!?\0', '2002-12-06 11:46:48');
INSERT INTO `faq` VALUES (18, 'come mai non si legge + il numero delle risposte ai messaggi?!?', 'ragazzi l\\''avevo già scritto. porca pupazzqa.\r\n\r\nok.\r\n\r\nil discorso è che il sito va + lento dell\\''altro, non so perchè, allora ho fatto una cazzuta analisi (non nel senso di DEL CAZZO ma nel senso di SBURA xchè sburto è chi l\\''ha fatta e le idee avute) ed è venuto fuori che la home caricava in 41-42 secondi cosi\\'' distribuiti: 20,5 secondi x calcolare il numero di figli di messaggi; 20-21 secondi x il gioco delle coppie (?!? giuro) e meno di un secondo x il resto.\r\n\r\nrisultato: il gioco delle coppie (parlo della form di voto casuale) è stato bandito a priori dalla HOME (compare solo nelle altre pagine) e cosi\\'' il numero di reply.\r\nil sito nella home è 40 volte + veloce. anche se non siete ingegneri penso sia un numerello che vi può piacere e un compromesso che potete accettare.\r\n\r\nspero. se no... amen raga\\''.\r\n\r\n:-(\r\n\r\nPS ANCHE X ME ERA COMODO.\0', '2002-12-15 15:20:50');
INSERT INTO `faq` VALUES (19, 'mi hai cancellato un messaggio, bastardo!', 'Tipicamente se cancello un msg è perchè chi lo scrive è cosi\\'' pirla da mettere una parola lunga, diciamo, 50 caratteri.\r\n\r\nl\\''effetto è che dato che explorer e famiglia bella non vanno a capo da sè, l\\''impaginazione di tutte le pagine che contengono quel messaggio viene stravolta e spesso diventa illweggibile.\r\n\r\nquindi lo cancello, tu riscrivilo, tanto è gratis, magari senza la parolona.\r\n\r\nmi son spiegato?\r\n\r\ngrazie della collaborazione\0', '2002-12-16 16:13:52');
INSERT INTO `faq` VALUES (20, 'cos''è sta cosa che in chat anche l''ultimo coglione mi manda nudo?!? argh!!! come funziona la cosa?!?', 'allora, il mefistofelico zio Pal credendo e sapendo di farvicosa gradita ha complicato il gioco cosi\\'':\r\n\r\n1 - chiunque può mandare in braghe chiunque (+ avant forse complicherò il modello in modo da creare immunità simmmetriche alla surgeazione, vedi dopo)\r\n\r\n2 - si può surgere solo una persona (compresi se stessi ovviamente) se si hanno >= Goliard Pointz di quanti ne abbia chi ha mandato questa in braghe.\r\n\r\n3 - solo chi ha 10000 px o + può mandare nudi, se no in braghe. le classifiche dei goliard pointz + alti le trovate nella pagina delle statistiche. i miei sono esattamente onesti + 42000 regalatimi da me stesso. approposito, grazie Pal.\r\n\r\n:-)\r\n\r\ntodo chiaro?!?\0', '2002-12-16 21:19:22');
INSERT INTO `faq` VALUES (21, 'Che cacchio vuol dire associare un goliarda a me stesso?!?!? non ci capisco piu niente', 'allora, come già detto, ragazzi, c\\''è differenza nel sito tra UTENTE e GOLIARDA: il primo è un\\''entità che si collega, che una password e dei goliard pointz, tanto x intenderci; un goliarda invece è un\\''entità dotata di nome, cognome, nome goliardico, fotina (eventualmente diversa dal nome!), ortdine di appartenenza, ed è suscettibile di ulteriori associazioni con nomine goliardiche eccetera eccetera. \r\n\r\nOra veniamo alla domanda: se uno che ti conosce ha creato il goliarda XXX e tu ti sei finalmente registrato come utente XXX il database non è un genio, e non sa se sei sempre tu o no. ecco allora che sotto UTENTE trovi la possibilità, dalla prima volta che ti colleghi, di associare un goliarda a te stesso, in relazione 1 a 1. dopo che l\\''hai fatto è difficile togliere quest\\''assocviazione, metti caso che ti sia sbagliato. Ovviamente, quest\\''associazione potrebbe non essere ancora possibile, perché per esempio non è stato ancora il goliarda associato... in tal caso basta prima crearlo e POI associarlo correttamente, capito?\r\n\r\nl\\''utilità?!? sono fatti miei come diceva raz de caz. comunque sia, ci sono ottimi motivi (per esempio, posso autodedurre da questa associazione da che città venite... o cose simili).\r\n\r\nUn bacione a tutti.\0', '2003-01-30 17:03:13');
INSERT INTO `faq` VALUES (22, 'Come si fa ad aggiungere un evento?', 'allora, banalmente nella HOME cliccate a destra, nel modulo eventi, su aggiungi evento.\r\n\r\nPoi avete a disposizione un titolo a vostra scelta, x esempio BACCANALE DI COMPLEANNO DELL\\''ORDINE DI STAMINCHIA, e il suo tipo (nell\\''esempio, ALTRA CENA, poichè è una cena ma non di un tipo esplicitamente messo nei tipi...); mettete la città goliardica + vicina all\\''evenbto (effettivamente, talvolta potrebbe non essere disponibile il luogo preciso, ma non c\\''è problema, lo scriverete nelle note). Poi avete 3 goliardi da associare, di cui comparirà numero di telefono e email se disponibili; poi avete NOTE e LUOGO da riempire discorsivamente a vostro piacimento x far capire gli estremi dell\\''evento.\r\n\r\nInfine, c\\''è anche la data d\\''inizio e di fine. L a seconda è INUTILE ai fini del DB; la prima invece è importante perchè colloca l\\''evento nel tempo: se fate l\\''ERRORE GROSSOLANO di aggiungere l\\''evento nel pasato, ovviamente esso non comparirà!!! cosi\\'' come se lom presentate troppo in anticipo: sappiate che il modulino x ora visualizza TUTTI gli eventi dei prossimi 2 (o 3? boh) mesi, quindi se c\\''è un evento del 2004 mettetelo pure ma non aspettatevi di vederlo. Capito?\r\n\r\nInfine, dovrei avervi dotato della possibilità di CANCELLAE un evento fatto da voi... basta cliccare sulla X nella home. chiaro? \r\n\r\nGrazie. Lo so.\0', '2003-02-14 16:47:40');
INSERT INTO `faq` VALUES (23, 'Pal, sei cosi'' fico, goliardicamente intendo. Quando diventi nuovo Fittone?!?', 'Anzitutto terrei a precisare a voi esteri che da noi non si dice Fittone ma Gran Maestro del Fittone, differentemente dalle sineddochi applicate in altre città.\r\n\r\nTengo inoltre a precisare che, per quanto sia amato, simpatico e bravino (ma senza esagerare), c\\''è tutto un iter non scritto che andrebbe rispettato. A differenza di quel che potete immaginare, a Bologna non ci vivo più da un pezzo e le matricoline manco mi riconoscono, figurati poi se le alte sfere mi vogliono con loro. Oddio, c\\''è stato effettivamente un momento in cui poteva capitare, ma non è andata (Scarpe diem, Trota Gnam)... quindi toglietevelo dalla testa, ok?\r\n\r\nScusate la FAQ seria, e fuortematica, ma con tutte le persone che mi rompono i coglioni a riguardo (e vi giuro, è un onore che lo riteniate sensato) mi ero rotto di dire sempre le stesse cose.\r\n\r\nRicordate, non sono (stato) un capoordine, non Barone, e non è facile legittimarmi nonostante sia una delle personalità politiche d\\''Italia... ma fama (e bellezza :D) non vuol dire potere, in goliardia, e aggiungerei... per fortuna. O forse, come ritengono taluni, sono semplicemente coglione io, il che poi va bene lo stesso.\r\n\r\n:-)\0', '2003-03-14 13:36:58');
INSERT INTO `faq` VALUES (24, 'DOVE CACCHIO SONO LE FOTO?!? (7-4-03)', 'ehm...\r\nle ho tolte dal sito x motivi di spazio.\r\nMi sto ingegnando x darle in outsurcing, linkandole dal sito (spiegazione x non ingegneri/economisti: le metto su un altro sito però i loro titoli sono nel MIO sito, e quindi riesco a generare dei link che voi ci cliccate e vi portano esattamente nella foto che andate cercando). Purtroppo però nessun sito offre i 2 3 requisiti che mi servono x farlo...\r\n\r\nquindi se avete voglia di aiutarmi, cercate un sito che:\r\n\r\n1) dia spazio illiitato (o cmq almeno un gighettino).\r\n2) conceda alla foto di essere riferita da altro sito (x provare, buttate su la foto in SITO1/foto1.jpg e da UN ALTRO SITO SITO2/index.html mettete un riferimento a quella foto e vedete se si vede).\r\n3) dia accesso ftp (sai, con tutte le foto c h eci sono...)\r\n\r\nse voi buonanime riuscite a trovare un sito che faccia questo, datemelo chiavi in mano e io vi rimetto le foto. :-)\r\n\r\ngrazie e... we apologize for the inconvenience ;-)\0', '2003-04-07 09:23:38');
INSERT INTO `faq` VALUES (25, 'Non trovo l''email del tale utente, come mai?!?', 'x garantire la vostra privacy ho messo l\\''email dell\\''utente <i>PRIVATA</i>. se volete renderla pubblica, avete MOLTI trucchi possibili:\r\n\r\n1) metterla anche nel goliarda a voi associato e renderla PUBBLICA;\r\n2) metterla in un altro campo pubblico dell\\''utente(note, gusti sessuali, icq, msn, ... ma è meglio icq xchè è sintatticamente diversa e non confondibile...): se mette nel campo ICQ del vostro profilo utente: MIA EMAIL è XXXX@YYYY.ZZ\r\nla gente lo vede, no?\r\n\r\nSpero la cosa vi vada bene., faccio cosi\\'' nel VOSTRO interesse, dato che le mie bimbe nel sito poi se no vengono intasate di marpioni che dicono "ciao sono TTTTT, quanto porti di reggiseno"... ora invece è garantito che quelle mail arrivino da UNA SOLA persona :D\0', '2003-05-14 12:23:47');
INSERT INTO `faq` VALUES (26, 'Come funzionano i messaggi privati?!?', 'Allora, NON CREDIATE che se cliccate su PRIVATO nei messaggi questo giunga a destinazione. e chi dovrebbe essere l\\''unico destinatario di tali msg? sempre io? c\\''è l\\''email per quello....\r\n\r\noppure  YYYYYY laddove il titolo sia "x YYYYYY"?!? ah...banale, poi se mettete "per YYYYYY" dovrebbe andare lo stesso? e se mettete "per felina" dovrebbe capire il mio programma che è "x felina stregonia"? ma chi sono, io, babbo natale?\r\n\r\ninoltre riflettete, se ci sono 1000 utenti e tutti mandano 1 msg agli altri, devo mantenere un DB di circa 1\\''000\\''000 di msg (x la precisione n(n-1)). e tutto x i vostri scambi? lasciamo alle mail queste cose: il sito è piccolo e già intasato con quel che c\\''è. sarebbe STRArallentato inutilmente.\r\n\r\nveniamo a COSA FA: se un msg è privato, gli utenti non registrati non dovrebbero leggerlo. attualmente, però, gli utenti NON registrati non leggon null\\''altro che la HOME :D quindi il probl non si pone :D:D:D\r\n\r\nnn vogliatemene, ok?\0', '2003-05-14 12:25:24');
INSERT INTO `faq` VALUES (27, 'Com''è che a volte voto 10 persone di fila e ora non voto più nessuno/a nel Gioco delle Coppie?!?', 'Allora, l\\''equazione è semplice: anzitutto ho tolto dalla HOME, per alleggerirla, ogni possibilità che compaia il fatidico "form di voto" (quel rettangolino che quando compare vi permette di votrae una persona. Per ogni altra pagina del sito, l\\''algoritmo funziona cosi\\'':\r\n\r\n- tira un dado. se esce 4,5,6 non far nulla.\r\n- se 1,2,3 tira un dado a N facce dove N è il numero di persone del sesso opposto.\r\n- se l\\''utente l\\''ha già votata, non far nulla\r\n- altrimenti, pubblica il form di voto.\r\n\r\ncapisci anche tu che se le donne registrate son 100 e tu ne voti 99, il form comparirà in una pagina (non home) ogni 200!!! se ci son 100 donne e ne hai votate 80, invece, una pagina su 10 (100-80 / 100 * 2) conterrà una form di voto.\r\n\r\nsembra stupido, ma:\r\n- se scegliessi una persona a caso tra i non votati, la query sarebbe costosa (non solo in assoluto, ma cnhe come costo computazionale: quadratico anzichè lineare)\r\n- se non voti proprio tutte non muore nessuno.\r\n- se ci son troppi voti, molti si rompono i coglioni...\r\n- se non lasciassi la cosa al caso, persone passerebbero interi pomeriggi a completare il voto... senza dar + esami.\0', '2003-05-23 21:29:31');
INSERT INTO `faq` VALUES (28, 'come mai clicco su una foto e mi fa il logout?!?', 'il motivo ha a che fare con la gestione dei cookies nel sito. Vi basti sapere che c\\''è un modo banale x evitarlo:\r\n\r\n- digitate www.goliardia.it nel browser e quando vi dà home o login fate il BOOKMARK di questa pagina: non dovrebbe più capitarvi. \r\n\r\nInfatti capita se avete ancora l\\''indirizzo vecchio, numerico. Il sito è sempre lo stesso, ma ha un NOME diverso, e a nomi diversi corrispondono \\''sessioni\\'' diverse.\r\n\r\nso che non avete capito il perchè, ma la soluzione è facile: aggiornate il Bucmarc!\0', '2003-06-02 12:58:16');
INSERT INTO `faq` VALUES (29, 'ho pochi GPz! come posso alzarli?!?', 'Come dice sempre Hakuna: il giudice sono io, ma sono corruttibilissimo!!!\r\n\r\nVediamo il listino prezzi, da pagarsi direttamente al povero Webmaster.\r\n\r\n\r\n- Bacco:\r\nBoccia di vino buono.......................50 GP\r\nBoccia di vino cattivo.......................10 GP\r\n\r\n- Tabacco\r\nPacchetto Philip Morris Gialle.............10 GP\r\nStecca di Philip Morris Gialle.............101 GP\r\n\r\n- Venere\r\nBacio sine lingua.................................1 GP\r\nBacio (magna) cum lingua...................10 GP\r\nFellatio.............................................300 GP\r\nRapporto completo............................300 GP\r\n\r\n\r\n:-)\r\n\r\n(La direzione si riserva di ritoccare i prezzi, secondo le necessità del mercato)\0', '2003-06-02 19:47:36');
INSERT INTO `faq` VALUES (30, 'come mai mi trovo a votare la stessa persona + volte nel Gioco delle Coppie?', 'E\\'' un\\''impressione, tutto funziona. \r\nSemplicemente, appena hai votato X, la volta dopo lui va a pescare tra le persone NON VOTATE ANCORA esclusa al più X; questo vuol dire che se avete votato appena uno, questo vi si potrebbe riproporre nell aprox schermata MA se lo rivotate il secondo voto (giustamente) non funziona...\r\nAltra cosa, se trovate voti tripli (solo nella pagina del gioco delle coppie la form triplica x velocizzare la cosa...) potete comunque votare sempre uno solo alla volta! Solo quello dei tre voti su cui cliccate INVIA vien votato, gli altri 3 no. Se volete a tutti i costi votarli tutti e 3, votate il primo, su OK cliccate su BACK nel browser, votate il secondo, poi il terzo e infine magari vi fate un bel refresh o cliccate banalmente su Gioco delle Coppie  xvedere le cose aggiornate.\r\n\r\nCiao!\0', '2003-07-19 13:02:19');
INSERT INTO `faq` VALUES (58, 'Voglio aggiungere un ordine, come faccio?!?', '\r\nVerrano inseriti <B>SOLO</B> ordini che:\r\n\r\n- siano stati <B>storicamente importanti</B>\r\n\r\no che\r\n\r\n-sono attualmente <B>ATTIVI</B>, e con almeno <B><I>6,9</I></B> persone a farne parte.\r\n\r\nCi sentiremo perfettamente liberi di contattare una persona che riteniamo fidata in quella città, \r\n\r\ne di rigettare eventualmente la richiesta. \r\n\r\n\r\nPer inserire un ordine, fare richiesta (via e-mail) ad un <I>admin-vip</I>:\r\n\r\n[<U>lista degli admin-vip</U>:\r\n- Palladius\r\n- Cavedano\r\n- Gimmygod\r\n- Manolus\r\n- Vipera\r\n- Ophelia\r\n- Pariettus]\r\n\r\nQuando si fa richiesta per aggiungere un ordine, fornire quei <B>DATI</B> che si trovano normalmente nei vari "campi" della pagina di un ordine, vale a dire:\r\n\r\n- nome semplice\r\n- nome lungo\r\n- sigla\r\n- città\r\n- se è ordine sovrano o vassallo; di quale ordine è eventualmente vassallo\r\n- storia dell''ordine\r\n- indirizzo del capoordine (per inviti)\r\n- motto dell''ordine\r\n- etc', '2006-01-30 13:38:23');
INSERT INTO `faq` VALUES (32, 'ma Pal, xké t''incazzi tanto con false identità?!?', 'Ragazzi, i problemi sono due:\r\n\r\n- Il primo, e più grosso è legale. C\\''è qualcuno che si è iscritto a nome di un goliarda defunto (e NON in senso goliardico), e poi a nome di una persona esistente (con foto!) e che non ne era a conoscenza. Il fatto è che questa persona lo viene a sapere, è facile che s\\''incazzi come una biscia e NON SEMPRE uno la prende in ridere. Io sicuramente NON la prendo in ridere x il banale motivo che come ben sapete lavoro mediamente 1 oretta al giorno sul sito da + di un anno, non ci guadagno una lira, non ci spendo una lira e vi assicuro che se capita un casino non sono legalmente abbastanza paraculato (x mia ignoranza giuridica, giuro!) x uscirne pulito; ovvero, detto in termini matematici, se A incula B, B denuncia A e in prigione ci vanno sia A che Pal. Chiaro? Ve l\\''assicuro, ho ascoltato un paio di lezioni sul diritto informatico nel mio Master e vi assicuro che bisogna essere peggio delle SS come webmaster x esser puliti. e non sono cosi\\'' bravo, fidatevi.\r\n\r\n- Il secondo motivo x cui odio gli scammuffi (e vorrei che si sentisse in colpa chi crea utenti finti ma davvero FINTI e inesistenti e quindi non si sente in colkpa x il punto UNO) è che utenti farlocchi occupano SPAZIO SUL DATABASE. il database + è grosso + è lento in accesso (come è + lento cercare parole in un vocabolario di 3000 pagine che in un glossario di 3 pagine), e un utente NON occupa una manciatina di byte nel db, ma molte di più. Se create un utente finto che rimanga GUEST, poco male. ho fatto in modo che un guest, con poche eccezioni, non possa intaccare minimamente il Database se non nella tabella utenti. quindi effettivamente occupa non troppo spazio. (ma se potete evitare, GRAZIE). se invece siete cosi\\'' figli di puttana da mandarmi una foto e convincermi che è vero (e spesso me ne accorgo e m\\''incvazzo come una biscia, forse capite il perchè), questo utente comincia a crescere smisuratamente in dimensioni. Questo sito non potrà ospitare gente nuova all\\''infinito, + cresce + rallenta e  ogni utente finto toglie spazio a un utente vero, se volete. x questo vi chiedo X FAVORE di non farli. anzi, addirittura, se ci sono utenti veri che si son rotti i coglioni e passano una volta ogni 3 mesi, ditegli di chiedermi di disiscriverli... sempre x regalare spazio a chi ne ha bisogno.\r\n\r\nQuesto, tra parente, è anche il motivo x cui mi incazzo x le minchiate scritte nel sito... pensate che ogni msg che scrivete ha un piccolo costo... scrivetelo se pensate che a qualcuno gliene freghi qualcosa, ok? Grazie.\0', '2003-08-01 12:09:50');
INSERT INTO `faq` VALUES (33, 'hai dei Ringraziamenti da fare?!?', 'Grazie x la domanda. sì\r\n\r\nCi sono però delle persone che vorrei ringraziare - oltre a me stesso - x la corretta crescita, manutenzione e stabilità del sito. \r\n\r\n1) Un grazie ai vari amministratori che, in maniera invisibile a me (quindi trascurerò SICURAMENTE dei nomi, non vedendo chi fa cosa), fanno un premuroso labor limae togliendo goliardi doppi, cariche sbagliate, e cosi\\'' via. Un grazie soprattutto a Cavedano, Gimmygod, Manolus e Mandingus ma anche a tutti gli altri! \r\n\r\n2) Grazie a NPP x il dominio www.goliardia.it e x le russe che mi presenterà ora che sono single. :-)\r\n\r\n3) Grazie a Faryna x il lato grafico. Ricordo che chiunque voglia collaborare anche son semplici iconcine è il benvenuto. Notate che tutte le iconcine in alto, nella home eccetera sono opera sua. E\\'' un anno che lo fa, sola soletta, pioniera in questa fredda e desolata landa... Anche il vicino è verde. Aiutatelo.\r\n\r\n4) Grazie ai miei amici (no, non sono diventato nord americano, tranquilli) delle tre palle dei teroni (Termy, Pariettus in primis) x i Bug segnalatimi, e anche a Placidus. Grazie anche a Buddha di GE che testa gentilmente il mio sito x vedere se è robusto ad attacchi hacker.\r\n\r\n5) Grazie a Buddha di GE che cerca di darmi una mano conn la chat e le foto (e ovviamente un grazie bis a Npp).\r\n\r\n6) grazie a tutte le donne che mi hanno dato 10 dando prova di aver compreso perfettamente cosa sia la goliardia. Un grazie ancora + commosso, strutto, esatto, esautorato, aperitivo, volubile, rautita,  semeiuta, unanime ;), accorato, preciso e succinto, tettomane a tutte quelle che me l\\''hanno data ma soprattutto che me la daranno.\r\n\r\nx apparire tautologo e demagogo fino in fondo, devo dire: grazie a tutti voi che coi vostri contributi tenete questo sito bello, vivo e interessante. anche se è vero, mi suona falso quindi ritiro l\\''ultima frase.\0', '2003-08-25 17:09:14');
INSERT INTO `faq` VALUES (34, 'Com''è sta nuova bazza del Single e del Serio nella pagina Utente?!?', 'Allora, ho introdotto questi 2 nuovi flag booleani (attributi di tipo vero/falso) con 2 scopi diversi:\r\n\r\nsingle: questo aiuta la componente prettamente rosa del sito. Siete liberi di farne ciò che volete.. non siete obbligati a usarlo correttamente, potete mettere il valore che volete, non andrete di certo in prigione se il valore è scorretto. :-))) se questo valore vi dà fastidio fate una petizione x toglierlo (o meglio ansconderlo).\r\n\r\nserio: questo secondo me è una genialata simile all\\''antiprof x dare una veste + sobria al sito. molte cose avranno d\\''ora in poi l\\''attributo serio o meno. se uno si definisce SERIO (sconsigliato x tutti!!!) non saranno visibili ordini pacco come gli Asinelli, il Giappone, eccetera, e magari - mi risevro di decidere se sia sensato o meno - darò un\\''impostazione + sobria anche alla grafica. Mi raccomando è una serietà semantica e non sintattica, legata ai contenuti e NON alla loro presentaazione. X ora questo secondo lavoro è lasciato all\\''antiprof.\r\n\r\nspero di essermi fatto chiaro.\0', '2003-08-27 23:11:17');
INSERT INTO `faq` VALUES (35, 'Scusa ma perchè i messaggi non entrano nell''ordine in cui li inserisco, ma entrano un po'' alla cazzo?', 'Ah, saperlo!!! \r\n\r\nI havent the più pallida aidia.\r\n\r\nperò ho un\\''idea: forse va con l\\''ora del client, e se tu scrivi dopo ma sei indietro di 5 minuti, rispondi a un msg PRIMA di lui... può essere? Se no non so come spiegarmelo.\0', '2003-09-02 21:42:52');
INSERT INTO `faq` VALUES (36, 'Come funzionano i Linkz?!?', 'I link sono un prodigio di programmazione.\r\nMo\\'' vi spiego dato che qualcuno ha problemi.\r\nUn link è banalmente l\\''associazione tra un titolo, una descrizione, e un link utile x internet. Tipico: vedi un titolo e una descrizione arrapanti, clicchi e PUFF sei nel luogo (se dovete crearne uno ricordate di farlo cominciare con "http://" ok?!?).\r\nHo voluto aggiungere una minchiatina: se compilate l\\''URL FOTO (solo x + esperti) ed effettivamente linka a un\\''icona, questa verrà in futuro associata a fianco del titolo.\r\n\r\nE la genialità dov\\''è? Ho fatto in modo di CONTESTUALIZZARE i link. Potete dire quando create un link che esso \\''ha a che fare\\'' con un Utente, un Goliarda, un Ordine o una CIttà. Il computer non è un indovino e che ne sa lui che se scrivete "Ordine dei druidi" deve esser cosi\\'' furbo da metterlo nella pagina dei druidi e magari di Torino?!? Non può (e non venitemi a dire che potrebbe fare una ricerca della parola, se no uno cre al\\''ordine della ICS e ogni descrizione che contenga una X va in quella pagina? Assurdo!). \r\n\r\nAllora che fate?\r\nSe associate un link all\\''utente X, chiunque vada nella sua scheda informativa vedrà quel link. Se la associate al goliarda X, non sucecde nulla. Anzi, è deprecato, forse in futuro lo toglierò: a che serve x goliardi se c\\''è x utenti? che senso ha mettere un link x il goliarda X se poi lui manco s\\''iscrive al sito? almeno che perda 5 minuti no?!? :-) E se lo linkate alla città va nella scheda informativa delle città. Se lo linkate all\\''ordine va nella scheda dell\\''ordine E nella scheda della città che lo \\''ospita\\''.\r\n\r\nVi piace come idea?!? Il mio multi-puntatore può essere anche programmato come meta-puntatore e associare un link a un Link e creare così una catena gerarchica di link, ma... servirebbe?\r\n\r\nPS i link non si modificano. son così idioti che, se fate un errore, lo rifate da capo e cancellate il vecchio. Ora si può.\r\n\r\nGrazie\0', '2003-09-03 17:55:57');
INSERT INTO `faq` VALUES (37, 'Sulla questione Sborrolo Strufugnus e il forum', 'Cito Sborrolo, data 7-9-03 (appena alzato e ancora mezzo ubriaco, io)\r\n\r\n"Caro Palladius,\r\n\r\nnon so se stai notando anche tu ma qui c\\''e\\'' pieno di gente che sta venedo turbata.\r\nNon parlo di Buddha, Lord\\''o, o Farina (i quali hanno dentini per difendersi).\r\nParlo di personaggi che educatamente hanno chiesto di limitare il doloroso clima conflittuale, di non scrivere troppo che faticano a leggere, di non scrivere troppo frequentemente che faticano a trovare i messaggini dei loro amici.\r\n(Il fatto che questi siano goliardi turba ME molto profondamente).\r\n\r\nQuesti personaggi sembrano deiderare una "conversazione da cocktail" ovvero una conversazione idilliaca, dallo scopo prettamente socilizzante, e, soprattuto, totalmente priva di contenuti.\r\n\r\nPer molti, pero\\'', e\\'' piu\\'' divertenete leggere pagine dove siano scritte "cose"... concetti anche sbagliati... ma concetti.\r\n\r\nE\\'' molto difficile tecnicamente aggiungere una pagina (con le stesse regole di questa) in cui sia lecito esprimere concetti, parlare di tutto, discutere di tutto con la spietatezza che solo i goliardi sanno avere, e... litigare (ovvero applicare la dialettica cioe\\'' il metodo che i goliardi usa(va)no per crescere)?\r\n\r\nInsomma, si puo\\'' avere un bar virtuale?\r\n\r\nMi farebbe piacere avere la tua opinione ed anche quella di tutti gli altri.\r\n\r\nGuido"\r\n\r\nRisposta palladiana:\r\n\r\n"Ti rispondo sia da tecnico che da moderatore.\r\n\r\nDa moderatore ti posso dire:\r\n che sono pienamented  d\\''accordo a metà col mister, e non prenderla come ignavia (è il modo migliore x farmi incazzare: amo prendere posizioni, magari le cambio ogni 5 secondi!):\r\n1) a me personalmente il vostro flaming piace. mi piace che ci si scanni xchè questa è a suo modo goliardia e a me piace, nonostante io la faccia in altro modo (se la faccio! ma la faccio io? me lo son chiesto spesso).\r\n2) avete turbato da un punto di vista OGGETTIVO il forum. avete cambiato la frequenza di refresh, aldilà dei contenuti. Prima c\\''erano tot_1 messaggi al giorno (mediamente) mediamente tot_2 lunghi. Occhio e croce i msg della giornata stavan tutti nella prima pagina. pochi (io no sicuro) vanno nella II pagina, e se mandi un msg che richiede followup o che cmq interessa taluni, se shifta alla II pagina cade nel dimenticatoio. Mea culpa, se vuoi. Ma è così e finora ha funzionato.\r\n\r\nDa tecnico ti dico:\r\nHo pensato spesso a tipizzare il forum. in ogni altro sito dinamico il forum è proprio così, hai N titoli (tipo: varie, cazzate, novitàSuArgentaCapitaleDelMondo, Computer, barzellette, e così via) e la gente clicca sull\\''argomento (o topic, con chiare alusioni sessuali) e si trova tutti i POST sull\\''argomento.\r\nSarebbe ifnormaticamente assurdo raddoppiare il forum creando una tabella SORELLA di quella dei msg, x modularità (se un giorno decido di voler un terzo forum ci metto una vita a farlo di nuovo). è molto + ingegneristico aggiungere un campo alla tabella con il TIPO. ci ho pensato da molto. ma l\\''appetito vien mangiando, dopo non ci sarebbe + solo VARIE e GOLIARDIAVERA ma magari anche NEWSESTERIECENE, PETTEGOLEZZI e così via. allora SI che non avrei + 2 pagine di msg, il che è accettabile, ma dovrei obbligare TUTTI, anche coloro a cui la situazione \\''pre-struf-sbor\\'' andava da dio, a trovarsi dapprima una pagina con i topics, cliccare sul topic desiderato e vedersi il proprio\\'' topic. sembra una banalità, un click in +, ma xderebbe di immediatezza. cesserebbe di esistere concettualmente l\\''ultimo msg, ma ci sarebbe l\\''ultimo msg di UN topic... e nella home che metto? un tipo designato (x es VARIE, che idealmente raccoglie il foprum precedente)? ci ho pensato. ma questo darebbe un peso a VARIE maggiore degli altri. e non verrebbe forse la tentazione a un provocatore che vuol lanciare un flaming e a uno stronzo che vuol mettere un link al suo sito e così via... di mettere queste info su VARIE poichè èp un canale \\''forte\\''? immagina le conseguenze: ci sarà il topic XXX vuoto xchè non ci va mai nessuno e uno sa che se vuol esser letto lo deve mettere su varie... e poi... ancora.. se vuoi fare goliardia, sai A PRIORI in che topic andrà? o io (povero io, me tapino!) devo anche prevedere che quando un thread (thread=msg padre + tutti i suoi figli) apparentemente VARIO si \\''infiamma\\'' devo poi spostarlo su GOLIARDIA? soccia che fatica... mi capisci?\r\n\r\nin poche parole: x mantenere l\\''immediatezza che contraddistingue e ha contraddistinto l\\''interazione in questo sito risp agli altri già fatti occorrerebbe tipizzare il forum SI, ma con un tipo a default (VARIE) che sarebbe il solito. ma così facendo si rischierebbe di vedere gli altri deserti.\r\n\r\nHo pubblicato questa come faq. Gradirei si facesse un sondaggio e che voi VOTASTE su cosa preferite. tecnicamente a me conviene mantenere tutto com\\''è non x motivi gattopardiani ma x xderci meno tempo :-) ma se è nell\\''interesse dell\\''e-comunità, lo faccio volentieri. ma non voglio dopo ore di sbattimento che qualcuno mi dica: stronzo era meglio prima. \r\n\r\nNulla è gratis, ogni scelta progettuale ha pregi e difetti e sinceramente credo di avere una visibilità maggiore della vostra. Una volta tanto vi ho posto tutti i miei pensieri x esser sullo stesso piano e rimettermi (non vomitarmi, nonostante l\\''alcool sia molto) al vostro giudizio."\0', '2003-09-07 11:05:24');
INSERT INTO `faq` VALUES (77, 'Come mai nel Gioco delle Coppie dice che ho votato 187 persone su 186?!? Sei diventato matto?', 'No, paradossalmente è giusto così.\r\n\r\nAlmeno nel mio malato cervello.\r\n\r\nSemplicemente quando dice <i>"Hai votato X persone su Y"</i>, il primo valore è il numero di donne che hai votato, mentre Y è il numero di donne votabili. Non è semanticamente necessario che X <= Y se ci pensate.\r\nUna donna che diventa guest non è votabile, ma si tiene il proprio voto, quindi...\r\n\r\nOddio forse più che rispondere a sta faq facevo prima a modificare il codice per far sì che X sia l''insieme delle votate NON GUEST, ma tant''è...', '2006-05-09 17:12:15');
INSERT INTO `faq` VALUES (78, 'Come collego un goliarda a un utente?', 'Collegare utenti e goliardi è una cosa che il mio prof di DB non ha gradito, ma all''orale gli ho detto che era buona cosa, e alla fine ho ravanto un bel 30L nonostante questo ''baco di progettazione''. Quindi se non lo capite, è ok, mea culpa!\r\n\r\nNon ricordo bene le condizioni necessarie, ve ne do una sufficiente.\r\n\r\n1. L''utente dev''essere sbur-user. Se no non si va da nessuna parte (per essere sbur-user dovete O mandarmi una foto O darmela)\r\n2. All''utente va regalato il goliarda\r\n3. Una volta fatto, andate nella sua pagina, e tra le opzioni dovrebbe comparire ciò che volete.\r\n\r\nPrego, Diegus (o <i>Di Punto Pinàe</i> come dice qualcuno)', '2006-05-24 17:40:44');
INSERT INTO `faq` VALUES (39, 'Nel gioco delle coppie mi compaiono + persone a pagina da votare: come funziona?!?', 'Allora, molti di voi si chiedono se vedendo 3 persone da votare (con 3 bottoni VOTA!) basta un click e le voti tutte e 3. la risposta, mi spiace, è NO. semplicemente x fretta ho messo una form che anzichè tirare una sola volta i \\''dadi\\'' li tira 3 volte: possono uscire 0 come 3 persone da votare (questo mi pare solo nella pagina del gioco delle coppie).\r\nquindi vale sempre UN CLICK=UN VOTO, mai di +. se cercate disperatamente di votare una persona, nel gioco delle coppie c\\''è un piccolo link VOGLIO VOTARE DI PIU. cliccateci e troverete un\\''amplissima scelta di voto. ci sarà il vostro LUI/LEI li\\''? è presumibile.\r\n\r\n:-)\0', '2003-09-10 22:54:27');
INSERT INTO `faq` VALUES (40, 'Ero user e mi hai fatto ospite. Why?', 'Ho reso ospiti tutti coloro che avevano una città sbagliata. Un tempo era possibile. Correggetela e io vi riabilito. lo faccio solo x coerenza del DB, non x rabbia, fidatevi.\0', '2003-09-11 22:41:16');
INSERT INTO `faq` VALUES (41, 'Cosa sono e a cosa servono le frecce verdi a fianco al nome nei messaggi???', 'La freccia sostituisce l\\''UP che c\\''era da mesi al posto dell\\''attuale freccetta. A che serve? I rari casi.\r\n\r\nSupponiamo che voi col motore cerchiate "SESSO" e troviate un msg X che lo contiene, che è figlio di un msg Y. Cliccandoci vedete solo il msg X e non sapete di chi è figlio. Allora cliccate su UP e puff, vi visualizza il msg padre (Y) che tra i tanti figli conterrà ovviamente X.\r\n\r\nCosì avete una migliore contestualizzazione di ciò che andavate cercando.\r\n\r\nVe piase?\r\n\r\nPS in ogni altro caso sì, è inutile. :-)\0', '2003-09-14 17:07:32');
INSERT INTO `faq` VALUES (42, 'Come mai non  riesco più a votare la persona XXX?', 'Avere una foto non vuol dire essere votabili: solo un USER dell\\''altro sesso è votabile. è possibile che uno diventi guest e torni normale senza che voi ve ne accorgiate, è addirittura possibile che votiate un user e che dopmani diventi guest. questo spiega la frase "hai votato 100 persone su 99"!!! Dato che ultimamente ho reso guest ogni persona con città o data di nascita sbagliata, potete immaginare il casino. ma si rimetterà a posto. voi votate chi vi capita E MUTI.\0', '2003-09-14 17:47:57');
INSERT INTO `faq` VALUES (43, 'perchè non ho in gesdtione il mio ordine? Perchè non ho il tal goliarda che mi spetta di diritto? Scazzo!', 'Ma come puoi pensare (non lo sai ma ho fatto una pausa di 20 secondi x omettere parolacce) che tu ti iscrivi al sito e PUFF! autmaticamente ti ritrovi il tuo ordine eccetera? è impossibile! ecco xchè semplicemente me lo chiedi via mail e se la richiesta è ragionevole la accontento... no?\0', '2003-09-14 19:22:37');
INSERT INTO `faq` VALUES (44, 'Non riesco ad associare un goliarda X a un utente!! (bis)', 'Attenzione, non ricordo bene perchè, consideratelo un bug, ma è difficile che riesca ad associare un goliarda a un utente se questo è GUEST. quindi se volete associare un goliarda a un utente PRIMA l\\''utente deve diventare sbur user, POI gli regalate il goliarda (si può solo se è SBUR USER) e infine cliccando sulla sua foto, il suo profilo vi darà A DEFAULT proprio lui... capito?\r\n\r\nbè, provate, l\\''iter è obbligato ma sensato, no?\r\n\r\nmagari in futuro ci sarà una scorciatoia, ma a me preme che le cose siano fattibili, se poi son anche facili è tutto grasso che cola (ma NON dalla mia pancia, evidentemente... dato che ancora non me lo vedo) \0', '2003-10-28 22:03:15');
INSERT INTO `faq` VALUES (69, 'Come cappero si fanno i link?', 'Digitare: \r\n<B>{ url ; [link desiderato] } </B>\r\n\r\nil tutto di seguito, <I>senza spazi</I>. \r\n\r\nCome qui \r\n\r\n[parentesi graffa]url;http://www.goliardia.it[parentesi graffa] \r\n\r\nSe non si pasticcia, il risultato finale è questo: \r\n{url;http://www.goliardia.it} \r\n\r\nP.S. \r\nparentesi graffa aperta: Alt Gr + shift + "è" \r\nparentesi graffa chiusa: Alt Gr + shift + "+" ', '2006-02-15 09:26:02');
INSERT INTO `faq` VALUES (74, 'Come si fa a scrivere in corsivo, sottolineare, fare il bacio, etc. ?', '\r\nPer il <I>corsivo</I>:\r\n\r\nracchiudere le parole da scrivere in <I>corsivo</I> tra:\r\n\r\n[simbolo "minore di"] I [simbolo "maggiore di"] e [simbolo "minore di"] /I [simbolo "maggiore di"]\r\n\r\nPer il <B>grassetto</B>:\r\n\r\nracchiudere le parole da scrivere in <B>grassetto</B> tra:\r\n\r\n[simbolo "minore di"] B [simbolo "maggiore di"] e [simbolo "minore di"] /B [simbolo "maggiore di"].\r\n\r\n\r\nPer <U>sottolineare</U>:\r\n\r\nracchiudere le parole da scrivere in <I>corsivo</I> tra:\r\n\r\n[simbolo "minore di"] U [simbolo "maggiore di"] e [simbolo "minore di"] /U [simbolo "maggiore di"].\r\n\r\n\r\nIn altre parole, \r\nsi usano i <B>tag HTML</B> per corsivo, grassetto, sottolineature, etc.\r\n\r\n\r\nCi sono anche altri tag HTML attivi.\r\n\r\n\r\nPer fare il bacio sbrilluccicoso (K):\r\n\r\nK maiuscolo tra parentesi tonde.\r\n', '2006-02-16 12:51:44');
INSERT INTO `faq` VALUES (75, 'Che è successo al sito?!?', 'Oggi, in data 17 aprile 06, ho migrato finalmente il sito cui lavoravo da gennaio. \r\nLe differenze sono poche, a occhio, comunque fateci l''abitudine. Ci sono BUGZ qua e là, se me li segnalate via mail (non GMS, non Contavalli, non MSN) ve ne sono molto grato.\r\nUna cosa bella è che ora il motore di ricerca cerca anche tra i messaggi...\r\nGrazie.', '2006-04-17 19:21:49');
INSERT INTO `faq` VALUES (46, 'Come funzionano le coppie nel sito nuovo?', 'Sinceramente non ne ho gran idea. Le ho fatte ieri di fretta. non so come saranno tra 1 o 2 weeks (who''ll live will see), ma posso dirvi come sono ora: sulla pagina utente della persona X se è user e di ssesso opposto vi compare la possibilità di votarla. PUNTO. quando qualcuna mi voterà vi dirò che si vede.\r\n\r\nvoi popolate il DB, intanto, che io mi dedico ad altro, per ora, x tornare sul gdc in futuro (e vi assicuro che ne ho in serbo tante...)\r\n\r\n;-)', '2004-01-19 21:04:24');
INSERT INTO `faq` VALUES (50, 'Posso creare un ordine?', 'NO.\r\nE'' un potere lasciato solo a pochissimi eletti... immaginate un mondo in cui oltre agli ordini storici si vengono a vedere anche mille ordini pacco assolutamente inutili e/o inventati?\r\nSe volete aggiungere un ordine, ci sono due passi da fare:\r\n1) (fondamentale) convincermi via mail che l''ordine vada inserito. es: mancano gli Uccellacci di Voghera o la Greca a Bologna e mi fate capire che ha un senso metterli nel sito (dirò di sì, in buona approssimazione se l''ordine ESISTE o è esistito E avete qualche goliarda da aggiungervi, di modo che non rimanga vuoto vuoto).\r\n2) quando vi darò l''assoluzione, tirar devi sto cordone... ehm no scusate; quando vi dirò sì, guarderete in un ordine a caso, estrapolerete le informazioni necessarie, e mi manderete via mail una schedina compilativa dell''ordine stesso. Se guardate un ordine a caso, troverete: nome lungo, nome breve, storia, note, indirizzo di casa del referente (x inviti), ... poi che ne so. Le cose posson cambiare, quindi guardateci!\r\n\r\nCiao!!', '2004-06-04 10:11:47');
INSERT INTO `faq` VALUES (51, 'Amore, come faccio a indire un sondaggio?', 'E'' semplice: soplo un ADMIN può farlo. Quindi chiedete a un admin.', '2004-09-25 12:59:59');
INSERT INTO `faq` VALUES (49, 'Posso cambiare il mio nome? E la mia mail??!?', 'rispettivamente NO e SI.\r\n\r\nMi spiace, ma il vostro nome è cablato nel db insieme alla vostra mail.\r\nPer farvi cambiare di nome, dovrei creare delgi automatismi che non ho ancora trovato il tmepo di fare (tipo controllare che non esista già e rinominare la foto di conseguenza, se c''è)\r\n\r\n\r\nPer farvi cambiare mail, invece, andate sotto UTENTE e vi mettete la nuova mail. Ovviamente x essere sicuro che sia onesta (per potervi contattare se ci son problemi, eccetera) la vostra password verrà cambiata immediatamente dopo e quindi vi verrà spedita alla nuova mail.\r\n\r\n E mi raccomando, se la mail che avete messo all''iscrizione non la leggete più, mandatemi la ''nuova''! come vedete non vi mando merda ogni settimana come fanno certi putribondi figuri in altri siti! \r\nperò se si creano casini vorrei che la mailbox rispondesse e non mi desse errori. se non mi rispondete in tempi utili x i problemi che sorgono, rischio di cancellarvi l''account, quindi... fate vobis.', '2004-04-19 22:30:19');
INSERT INTO `faq` VALUES (52, 'Cosa vuol dire che il sito è migrato?', 'Sono un tecnico e da tecnico vi rispondo. \r\nQuando voi digitate "www.goliardia.it" andate su un server gestito da {{user;NPP}} (le doppie graffe sono una mia sega mentale autoesplicativa che in futuro forse implementerò), ovvero NonPigliaPesci da Peroscia, che spara i vostri collegamenti su un server gestito da Buddha (il pesopiuma Doge di Genova) che fa gentilmente l''HOSTING vero e proprio del sito.\r\nCiò significa che se Buddha decide di cambiare macchina (cioèp migra ad esempio da Miami a Francoforte, com'' accaduto ai primi di Ottobre 2004) occorre: \r\n- copiare le pagina da là a qua\r\n- spostare il database (x intenderci i contenuti dinamici) da là a qua\r\n- configurare per benino i cazzilli (son tanti, ad esempio ciò che consente di loggare i vostri ingressi, di mandarvi le mail, di accedere al db, ...)\r\n\r\nI due problemi + vistosi sono:\r\n1) c''è un periodo non nullo in cui l''URL www.goliardia.it punta a un server inesistente, quindi voi esperite un disservizio\r\n2) c''è un periodo in cui il DB è stato salvato da là, spostato QUA, e continua a essere modificato da voi di là; quando tutti migran qua sembra che dei messaggi siano stati cancellati: è un''impressione (a parte le barzellette di Occhiaiolo).\r\n\r\nSe non sono stato chiaro e avete le tette grosse, chiamatemi e vi darò spiegazioni ulteriori.', '2004-10-06 23:22:24');
INSERT INTO `faq` VALUES (54, 'Gioco delle coppie: perchè risulto votato da 17 persone ma mi appaiono solo 12 voti? di cui uno a firma "?!?" che vuol dire??!?', 'Uno dei + fighi del sito mi scrive: "perchè risulto votato da 17 persone ma mi appaiono solo 12 voti? di cui uno a firma ''''?!?'''' che vuol dire? Grazie in anticipo".\r\n\r\nRipondo: se uno vi da un voto ANONIMO e vi dice: "mi fai cagare" il suon nome non compare nè apparirùà mai in coppia con voi. Quindi caro mio in 5 ti hanno votato in modo anonimo (sebbene il commento tu lo veda) e di queste 4 hanno cliccato e basta (commento nullo -> lo filtra lo zio Pal) mentre un''altra ti ha scritto "faccia di culo" ma era timida la ragazza.\r\n\r\nChiaro?!?\r\n\r\nPS Mi chiedono se posso leggere tutti i vostri commenti. La risposta è sì, ma non lo faccio. A voi crederci.', '2005-09-29 19:01:05');
INSERT INTO `faq` VALUES (56, 'Ho scordato la password e non riesco a farmela spedire via email.', 'Quando cliccate su "ho dimenticato la password", all''atto del login, c''è un oggettino semplice semplice che vi chiede chi siete e vi manda la password.\r\nIn quello spazio dovete digitare qualcosa e POI cliccare su "spediscimi la password". Il sistema prende il nome, cerca l''utente con quel nome, manda un''amail all''email segreta associata al nome (per motivi di privacy).\r\nSe all''atto dell''iscrizione sbagliate l''email, GIUSTAMENTE non riuscirete mai a ricevere quella password.\r\n\r\nSe vi capita che non vi arrivi niente e non sapete se è colpa vostra o del fatto che il sito non manda email, potete fare due cose:\r\n1 (consigliato). Chiedete a un vostro amico utente di provare a farsela spedire lui. Se a lui funziona, è un problema vostro. In tal caso, mandatemi un''email PROVENIENTE dall''email che volete sul sito e io provvederò a cambiarla.\r\n2 (non consigliato). Mi mandate una mail dicendo: tanti cari saluti sono Pippo e non va il login. Così retrocediamo all''età della pietra e devo perdere mezz''ora a capire chi siete e soprattutto che legame c''è tra: 1- PIPPO, 2- l''email da cui mi state mandando lo sbotro, 3- l''email che vorreste (ma devo inventarmela poiché voi non me la dite), 4- l''utente che siete nel sito che ovviamente NON sarà Pippo (se no sarebbe troppo facile).\r\n\r\nPS. Pigliatemi per il culo quanto volete ma queste sono cose realmente accadute, e pure spesso.', '2005-11-14 04:46:06');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `gestione_ordini`
-- 
-- Creazione: 25 Ago, 2006 at 05:02 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:02 PM
-- 

DROP TABLE IF EXISTS `gestione_ordini`;
CREATE TABLE `gestione_ordini` (
  `ID_GEST_ORDINI` int(11) NOT NULL auto_increment,
  `ID_ORDINE` int(11) default NULL,
  `ID_LOGIN` int(11) default NULL,
  PRIMARY KEY  (`ID_GEST_ORDINI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `gestione_ordini`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `giococoppie`
-- 
-- Creazione: 25 Ago, 2006 at 05:16 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:16 PM
-- 

DROP TABLE IF EXISTS `giococoppie`;
CREATE TABLE `giococoppie` (
  `idUtenteVotante` int(11) default NULL,
  `idUtenteVotato` int(11) default NULL,
  `m_bScoperebbe` tinyint(1) NOT NULL default '0',
  `m_bBacerebbe` tinyint(1) NOT NULL default '0',
  `dataVoto` datetime default NULL,
  `commento` varchar(255) default NULL,
  `m_nVoto` int(11) default NULL,
  `sexVotante` varchar(5) default NULL,
  `m_bPrivato` tinyint(1) NOT NULL default '0',
  UNIQUE KEY `idUtenteVotante` (`idUtenteVotante`,`idUtenteVotato`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `giococoppie`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `gms`
-- 
-- Creazione: 25 Ago, 2006 at 04:56 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:27 PM
-- 

DROP TABLE IF EXISTS `gms`;
CREATE TABLE `gms` (
  `id_gms` int(11) NOT NULL auto_increment,
  `data_invio` datetime default NULL,
  `m_bNuovo` tinyint(1) NOT NULL default '0',
  `idutentescrivente` int(11) default NULL,
  `idutentericevente` int(11) default NULL,
  `messaggio` varchar(255) default NULL,
  PRIMARY KEY  (`id_gms`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1531555177 ;

-- 
-- Dump dei dati per la tabella `gms`
-- 

INSERT INTO `gms` VALUES (1, '2006-08-25 16:56:41', 1, 1, 1, 'Benvenuto! Guarda i docs per capirci qualcosa...');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `goliardi`
-- 
-- Creazione: 25 Ago, 2006 at 05:16 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 06:35 PM
-- 

DROP TABLE IF EXISTS `goliardi`;
CREATE TABLE `goliardi` (
  `ID_GOL` int(11) NOT NULL auto_increment,
  `Nome` varchar(50) default NULL,
  `Cognome` varchar(50) default NULL,
  `DataProcesso` datetime default NULL,
  `Indirizzo` varchar(50) default NULL,
  `numcellulare` varchar(50) default NULL,
  `Nomegoliardico` varchar(50) default NULL,
  `Nomenobiliare` varchar(50) default NULL,
  `ID_Ordine` int(11) default NULL,
  `id_login` int(11) default NULL,
  `Dataiscrizione` datetime default NULL,
  `BolliAllIscrizione` int(11) default NULL,
  `email` varchar(50) default NULL,
  `contascazzi` int(11) default NULL,
  `privacy_mail` tinyint(1) NOT NULL default '0',
  `privacy_cell` tinyint(1) NOT NULL default '0',
  `privacy_address` tinyint(1) NOT NULL default '0',
  `foto` varchar(50) default NULL,
  `ID_FACOLTA` int(11) default NULL,
  `m_nPunti` int(11) default NULL,
  `m_bIsMaschio` tinyint(1) NOT NULL default '0',
  `titolo` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`ID_GOL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dump dei dati per la tabella `goliardi`
-- 

INSERT INTO `goliardi` VALUES (1, 'Riccardo', '-', '1998-12-31 00:00:00', 'via Pinco Pallo 41', '347-xxxxxxx', 'Palladius', 'BonTon', NULL, 1, NULL, NULL, 'email@email', NULL, 1, 1, 1, 'prova.jpg', 12, NULL, 0, '');
INSERT INTO `goliardi` VALUES (2, 'Mario', 'Rossi', '2003-12-31 00:00:00', 'null', 'null', 'Pincus', 'Pallus', 1, 1, '2006-08-25 18:35:46', NULL, 'null', NULL, 0, 0, 0, 'prova.jpg', 10, NULL, 0, 'null');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `indirizzi`
-- 
-- Creazione: 25 Ago, 2006 at 05:17 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:17 PM
-- 

DROP TABLE IF EXISTS `indirizzi`;
CREATE TABLE `indirizzi` (
  `ID_address` int(11) default NULL,
  `ID_Utente` int(11) default NULL,
  `ipHost` varchar(16) default NULL,
  `nomeHost` varchar(16) default NULL,
  `nomeUser` varchar(10) default NULL,
  `m_tDescrizione` varchar(80) default NULL,
  `m_bAttivo` tinyint(1) NOT NULL default '0',
  `m_nContaAccessi` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `indirizzi`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `linkz`
-- 
-- Creazione: 25 Ago, 2006 at 04:53 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 06:29 PM
-- 

DROP TABLE IF EXISTS `linkz`;
CREATE TABLE `linkz` (
  `ID_link` int(11) NOT NULL default '0',
  `titolo` varchar(255) default NULL,
  `id_login` int(11) default NULL,
  `id_oggettoPuntato` int(11) default NULL,
  `Data_creazione` datetime default NULL,
  `tipo` varchar(255) default NULL,
  `m_battiva` tinyint(1) NOT NULL default '0',
  `URLlink` varchar(255) default NULL,
  `URLlinkFoto` varchar(255) default NULL,
  `m_bfotoattiva` tinyint(1) NOT NULL default '0',
  `Descrizione` longtext,
  PRIMARY KEY  (`ID_link`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `linkz`
-- 

INSERT INTO `linkz` VALUES (1476196290, 'Pagina di Palladius', 1, -1, '2006-08-25 18:28:34', 'NESSUNO', 1, 'http://www.palladius.it/', 'http://www.palladius.it/palladius.jpg', 0, 'La pagina personale di Palladius');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `livelli`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 03:46 PM
-- 

DROP TABLE IF EXISTS `livelli`;
CREATE TABLE `livelli` (
  `idLivello` int(11) default NULL,
  `numLivello` int(11) default NULL,
  `titolo` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `livelli`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `loginz`
-- 
-- Creazione: 25 Ago, 2006 at 04:41 PM
-- Ultimo cambiamento: 29 Ago, 2006 at 08:34 AM
-- 

DROP TABLE IF EXISTS `loginz`;
CREATE TABLE `loginz` (
  `ID_LOGIN` int(11) unsigned NOT NULL auto_increment,
  `m_sNome` varchar(50) default NULL,
  `m_sPwd` varchar(50) default NULL,
  `m_hEmail` varchar(50) default NULL,
  `m_dataIscrizione` datetime default NULL,
  `m_thumbnail` varchar(50) default NULL,
  `id_goliarda_default` int(11) default NULL,
  `m_bAdmin` tinyint(1) NOT NULL default '0',
  `m_nPX` int(11) default NULL,
  `m_nLivello` int(11) default NULL,
  `m_bIsMaschio` tinyint(1) NOT NULL default '0',
  `m_bErreMoscia` tinyint(1) NOT NULL default '0',
  `m_bAttivo` tinyint(1) NOT NULL default '0',
  `m_bGuest` tinyint(1) NOT NULL default '0',
  `m_dataLastCollegato` datetime default NULL,
  `m_sNote` varchar(255) default NULL,
  `datanascita` datetime default NULL,
  `m_bIsGoliard` tinyint(1) NOT NULL default '0',
  `msn` varchar(50) default NULL,
  `interessi` varchar(255) default NULL,
  `icq` varchar(20) default NULL,
  `provincia` varchar(20) default NULL,
  `gustisessuali` varchar(255) default NULL,
  `m_bSerio` tinyint(1) NOT NULL default '0',
  `m_bSingle` tinyint(1) NOT NULL default '0',
  `m_bPunizione` tinyint(1) NOT NULL default '0',
  `m_snoteadmin` longtext,
  `m_bmailpubblica` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID_LOGIN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=4 ;

-- 
-- Dump dei dati per la tabella `loginz`
-- 

INSERT INTO `loginz` VALUES (1, 'prova', 'prova', 'prova@goliardia.org', '2002-04-28 00:00:00', 'Mario Rossi', 2, 1, 2, 0, 1, 1, 1, 0, '2006-08-29 08:15:11', 'Utente di prova\r\n\r\n', '1976-12-29 00:00:00', 1, 'palladiusbonton@msn.com', 'interessato a vedere <a href="http://www.palladius.it">\r\n\r\n', 'null', 'Bologna', 'sesso normale\r\n\r\n', 0, 0, 0, 'utente di prova', 1);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `messaggi`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:41 PM
-- 

DROP TABLE IF EXISTS `messaggi`;
CREATE TABLE `messaggi` (
  `id_msg` int(11) NOT NULL auto_increment,
  `titolo` varchar(150) default NULL,
  `id_login` int(11) default NULL,
  `messaggio` longtext,
  `data_creazione` datetime default NULL,
  `pubblico` tinyint(1) NOT NULL default '0',
  `id_figliodi_msg` int(11) default NULL,
  `id_tipo` int(11) default NULL,
  PRIMARY KEY  (`id_msg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dump dei dati per la tabella `messaggi`
-- 

INSERT INTO `messaggi` VALUES (3, 'qwefqw', 1, 'rqewe', '2006-08-25 17:41:09', 0, 0, 0);
INSERT INTO `messaggi` VALUES (2, 'Benvenuti su questo nuovo sito!', 1, 'Benvenuti sul sito!\r\nSono Palladius e questo sito non è altro che il codice nuovo e fiammante del sito che trovate in www.goliardia.it unito a un DB preparato ad hoc per non contenere tutti i dati sensibili che il sito in effetti ha.\r\nSiete liberi di provarlo e farlo crescere.', '2006-08-25 17:37:04', 0, 0, 0);
INSERT INTO `messaggi` VALUES (4, 'qwr', 1, 'qwerwer', '2006-08-25 17:41:13', 0, 3, 0);
INSERT INTO `messaggi` VALUES (5, 'sdgd', 1, 'sdfgsd', '2006-08-25 17:41:45', 0, 3, 0);
INSERT INTO `messaggi` VALUES (6, 'sdfgsdfg', 1, 'dsgd', '2006-08-25 17:41:49', 0, 3, 0);
INSERT INTO `messaggi` VALUES (7, 'sdg', 1, 'sdgdf', '2006-08-25 17:41:54', 0, 2, 0);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `nomine`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 06:42 PM
-- 

DROP TABLE IF EXISTS `nomine`;
CREATE TABLE `nomine` (
  `ID_NOMINA` int(11) NOT NULL auto_increment,
  `id_goliarda` int(11) default NULL,
  `id_carica` int(11) default NULL,
  `data_nomina` datetime default NULL,
  `data_fine_nomina` datetime default NULL,
  `id_goliarda_nominante` int(11) default NULL,
  `note` varchar(50) default NULL,
  `eventuale_numero_progressivo` int(11) default NULL,
  `id_utente_postante` int(11) default NULL,
  `data_inserimento_nomina` datetime default NULL,
  PRIMARY KEY  (`ID_NOMINA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dump dei dati per la tabella `nomine`
-- 

INSERT INTO `nomine` VALUES (1, 2, 1, '2006-08-25 18:41:54', '2006-08-25 18:41:54', 0, 'assolutamente x prova\r\n', 1, 1, '2006-08-25 18:41:54');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `ordini`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 06:47 PM
-- 

DROP TABLE IF EXISTS `ordini`;
CREATE TABLE `ordini` (
  `ID_ORD` int(11) NOT NULL auto_increment,
  `Nome_veloce` varchar(50) default NULL,
  `Nome_completo` varchar(50) default NULL,
  `Sigla` varchar(50) default NULL,
  `ID_ORD_Vassallo_di` int(11) default NULL,
  `Sovrano` tinyint(1) NOT NULL default '0',
  `Città` varchar(50) default NULL,
  `datadinascita` datetime default NULL,
  `Motto` varchar(50) default NULL,
  `m_fileImmagine` varchar(50) default NULL,
  `m_fileImmagineTn` varchar(50) default NULL,
  `note` longtext,
  `storia` longtext,
  `id_utente_creatore` int(11) default NULL,
  `data_creazione` datetime default NULL,
  `m_bSerio` tinyint(1) NOT NULL default '0',
  `indirizzo` varchar(150) NOT NULL default '',
  `emailordine` varchar(50) NOT NULL default '-',
  PRIMARY KEY  (`ID_ORD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dump dei dati per la tabella `ordini`
-- 

INSERT INTO `ordini` VALUES (1, 'Pinco', 'Sacer Ordo Pinco Pallus', 'SOPP', -1, 1, 'Bologna', '2006-08-25 18:33:23', 'Bacco su bacco è scavolo, e solo noi lo sappiamo', 'pincopallo.jpg', 'pincopallo.jpg', 'Note sull''ordine', 'Storia dell''ordine', 1, '2006-08-25 18:34:12', 1, 'indirizzo di casa', 'email ordine');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `polls_domande`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 09:15 PM
-- 

DROP TABLE IF EXISTS `polls_domande`;
CREATE TABLE `polls_domande` (
  `id_domanda` int(11) NOT NULL auto_increment,
  `TestoDomanda` varchar(150) default NULL,
  `id_poll` int(11) default NULL,
  `Foto` varchar(50) default NULL,
  `tipoFoto` varchar(50) default NULL,
  PRIMARY KEY  (`id_domanda`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dump dei dati per la tabella `polls_domande`
-- 

INSERT INTO `polls_domande` VALUES (1, 'Bello', 1, 'prova.jpg', 'persone');
INSERT INTO `polls_domande` VALUES (2, 'Brutto', 1, 'prova.jpg', 'persone');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `polls_titoli`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 09:15 PM
-- 

DROP TABLE IF EXISTS `polls_titoli`;
CREATE TABLE `polls_titoli` (
  `id_poll` int(11) NOT NULL auto_increment,
  `Titolo` varchar(50) default NULL,
  `Descrizione` longtext,
  `dataInizio` datetime default NULL,
  `dataFine` datetime default NULL,
  `dataCreazione` datetime default NULL,
  `id_utente_creatore` int(11) default NULL,
  PRIMARY KEY  (`id_poll`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dump dei dati per la tabella `polls_titoli`
-- 

INSERT INTO `polls_titoli` VALUES (1, 'Cosa pensi di questo sito?', 'Che cosa ne pensi di questo sito?', '2006-08-25 21:14:44', '2006-08-25 21:14:44', '2006-08-25 21:14:44', 1);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `polls_voti`
-- 
-- Creazione: 25 Ago, 2006 at 05:19 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:19 PM
-- 

DROP TABLE IF EXISTS `polls_voti`;
CREATE TABLE `polls_voti` (
  `id_voto` int(11) NOT NULL auto_increment,
  `id_utente` int(11) default NULL,
  `id_domanda` int(11) default NULL,
  PRIMARY KEY  (`id_voto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `polls_voti`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `query_notevoli`
-- 
-- Creazione: 25 Ago, 2006 at 05:32 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:32 PM
-- 

DROP TABLE IF EXISTS `query_notevoli`;
CREATE TABLE `query_notevoli` (
  `ID` int(11) NOT NULL auto_increment,
  `titolo` varchar(50) default NULL,
  `data_creazione` datetime default NULL,
  `note` varchar(50) default NULL,
  `encoded_query` longtext,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `query_notevoli`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `regioni`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 03:47 PM
-- 

DROP TABLE IF EXISTS `regioni`;
CREATE TABLE `regioni` (
  `nomecitta` varchar(50) default NULL,
  `sigla` varchar(50) default NULL,
  `regione` varchar(50) default NULL,
  `id_pseudoid` int(11) default NULL,
  UNIQUE KEY `sigla` (`sigla`),
  UNIQUE KEY `id_pseudoid` (`id_pseudoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `regioni`
-- 

INSERT INTO `regioni` VALUES ('Bologna', 'BO', 'Emilia', 1);
INSERT INTO `regioni` VALUES ('Perugia', 'PG', 'Umbria', 2);
INSERT INTO `regioni` VALUES ('Pavia', 'PV', 'Lombardia', 3);
INSERT INTO `regioni` VALUES ('Ferrara', 'FE', 'Emilia', 4);
INSERT INTO `regioni` VALUES ('Parma', 'PR', 'Emilia', 5);
INSERT INTO `regioni` VALUES ('Modena', 'MO', 'Emilia', 6);
INSERT INTO `regioni` VALUES ('Milano', 'MI', 'Lombardia', 7);
INSERT INTO `regioni` VALUES ('Genova', 'GE', 'Liguria', 8);
INSERT INTO `regioni` VALUES ('Torino', 'TO', 'Piemonte', 9);
INSERT INTO `regioni` VALUES ('Pisa', 'PI', 'Toscana', 10);
INSERT INTO `regioni` VALUES ('Firenze', 'FI', 'Toscana', 11);
INSERT INTO `regioni` VALUES ('Prato', 'PO', 'Toscana', 12);
INSERT INTO `regioni` VALUES ('Ivrea (TO)', 'XI', 'Piemonte', 13);
INSERT INTO `regioni` VALUES ('Urbino', 'UR', 'Marche', 14);
INSERT INTO `regioni` VALUES ('Trieste', 'TS', 'Friuli Venezia Giulia', 15);
INSERT INTO `regioni` VALUES ('Macerata', 'MC', 'Marche', 16);
INSERT INTO `regioni` VALUES ('Camerino (MC)', 'XC', 'Marche', 17);
INSERT INTO `regioni` VALUES ('Udine', 'UD', 'Friuli Venezia Giulia', 18);
INSERT INTO `regioni` VALUES ('Piombino (PI)', 'XB', 'Toscana', 19);
INSERT INTO `regioni` VALUES ('San Severo (FG)', 'XS', 'Puglia', 20);
INSERT INTO `regioni` VALUES ('Palermo', 'PA', 'Sicilia', 21);
INSERT INTO `regioni` VALUES ('Alghero (SS)', 'XA', 'Sardegna', 22);
INSERT INTO `regioni` VALUES ('Sassari', 'SS', 'Sardegna', 23);
INSERT INTO `regioni` VALUES ('Padova', 'PD', 'Veneto', 24);
INSERT INTO `regioni` VALUES ('Foggia', 'FG', 'Puglia', 25);
INSERT INTO `regioni` VALUES ('Italia', 'XX', 'Italia', 26);
INSERT INTO `regioni` VALUES ('Argenta', 'AG', 'Emilia', 27);
INSERT INTO `regioni` VALUES ('Inghilterra', 'YI', 'Nazione', 28);
INSERT INTO `regioni` VALUES ('Spagna', 'YE', 'Nazione', 29);
INSERT INTO `regioni` VALUES ('Belgio', 'YB', 'Nazione', 30);
INSERT INTO `regioni` VALUES ('Francia', 'YF', 'Nazione', 31);
INSERT INTO `regioni` VALUES ('America', 'YA', 'Nazione', 32);
INSERT INTO `regioni` VALUES ('Altro (in Italia)', 'Z1', 'Italia', 33);
INSERT INTO `regioni` VALUES ('Altro (estero)', 'YY', 'Nazione', 34);
INSERT INTO `regioni` VALUES ('Grottammare', 'XG', 'Marche', 35);
INSERT INTO `regioni` VALUES ('Diano Marina (IM)', 'IM', 'Liguria', 36);
INSERT INTO `regioni` VALUES ('Teramo', 'TE', 'Abruzzo', 37);
INSERT INTO `regioni` VALUES ('Olanda', 'YO', 'Nazione', 38);
INSERT INTO `regioni` VALUES ('Lecce', 'LE', 'Puglia', 39);
INSERT INTO `regioni` VALUES ('Ravenna', 'RA', 'Emilia', 40);
INSERT INTO `regioni` VALUES ('Catania', 'CT', 'Sicilia', 41);
INSERT INTO `regioni` VALUES ('Siena', 'SI', 'Toscana', 42);
INSERT INTO `regioni` VALUES ('Voghera (PV)', 'XV', 'Lombardia', 43);
INSERT INTO `regioni` VALUES ('Roma', 'RM', 'Lazio', 44);
INSERT INTO `regioni` VALUES ('Ozieri (SS)', 'XO', 'Sardegna', 101);
INSERT INTO `regioni` VALUES ('Livorno', 'LI', 'Toscana', 102);
INSERT INTO `regioni` VALUES ('Spoleto (PG)', 'XP', 'Umbria', 55);
INSERT INTO `regioni` VALUES ('Verona', 'VR', 'Veneto', 45);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `xxx_memoz`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 03:47 PM
-- 

DROP TABLE IF EXISTS `xxx_memoz`;
CREATE TABLE `xxx_memoz` (
  `chiave` varchar(50) NOT NULL default '',
  `valore` longtext,
  PRIMARY KEY  (`chiave`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `xxx_memoz`
-- 

INSERT INTO `xxx_memoz` VALUES ('benvenuto', 'Bela regaz! Sto ammodernando il sito (causa ferie sine viaggio); se qualcuno ha segnalazioni, consigli, cose da togliere o cose da aggiungere essi sono apprezzati. SOLO VIA MAIL PERO'' (n&eacute; al Contavalli, a meno che non siate gnocche, nè via MSN), all''indirizzo: <a href=''mailto:palladius@goliardia.org''>palladius@goliardia.org</a><br/> \r\n<br/>\r\nGrazie, \r\nPAL\r\n');
INSERT INTO `xxx_memoz` VALUES ('header', 'Benvenuti 5.0 nel sito <a href="http://www.goliardia.it">www.goliardia.it</a>!<br/>\r\n\r\nVi ricordo che:<br>\r\n1) Questo sito e'' aperto a tutti ma SOLO sotto iscrizione, questo per poter moderare meno il forum e per mantenere un po'' sotto controllo le informazioni. Se vi iscrivete, NON riceverete spam ne merdate varie poiche'' io stesso le odio, e odio infliggere cio'' che odio ricevere.<br>\r\n2) Il sito e'' diventato opensource (ovvero libero). Nella sezione downloadz, potete scaricare liberamente il codice, sotto licenza <a href=''http://www.gnu.org/licenses/''>GNU GPL</a>. Potete altresi'' (ieri sera mi son letto l''intera A dello Zingarelli) scaricare la skin del sito, modificarla e spedirmela; siete dei pigri maledetti, ma se mi date una mano i colori (volutamente) pacchiani del sito possono cominciare a offendere meno l''occhio. Mio babbo e'' oculista e siamo alla ottava villa. Ora basta!<br>\r\n<br>\r\n<b>PS</b> Un grazie a Buddha, Npp e Kash per hosting e ciappini vari; un grazie inoltre ai miei aiutanti (Quine, Vipera, Cavedano, Gimmygod, ...) che mi aiutano a tenere tutto un po'' pulito e in ordine....<br>\r\n<div align=right><i>(26 Aug 05, il webmaster <a href="http://www.palladius.it/">Palladius</a>)</i></div>');
INSERT INTO `xxx_memoz` VALUES ('fotoprimapagina', 'ricmondiali.jpg');
INSERT INTO `xxx_memoz` VALUES ('qgfdp', 'el Palladius Maricòn');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `xxx_vari`
-- 
-- Creazione: 25 Ago, 2006 at 03:46 PM
-- Ultimo cambiamento: 25 Ago, 2006 at 05:36 PM
-- 

DROP TABLE IF EXISTS `xxx_vari`;
CREATE TABLE `xxx_vari` (
  `chiave` varchar(50) default NULL,
  `valore` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `xxx_vari`
-- 

INSERT INTO `xxx_vari` VALUES ('benvenuto', 'benvenuto agosto 06');
INSERT INTO `xxx_vari` VALUES ('fotoindex', 'logolargo200.jpg');
        
