<?php  



include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


//if ($ISPAL)	visualizzaformz();

//MODIFICA CARICA

$idcarica=(QueryString("id"));
$modificaCarica= ($idcarica != "");


$ordine = QueryString("AGGIUNGI_NON_MODIF_MA_ORD_VALE");
$AGGIUNGISOLO = ($ordine !="");



		// verifica e gestione dell'autopalleggiamento da form

$operazione= Form("hidden_operazione");
if ($operazione != "")
	{
      $linkOrdine="modifica_ordine.php?idord=".Form("id_ordine"); // servir� x tornare POI alla pag ord

	if ($operazione=="1")	// FORM NORMALE
		{
		 autoInserisciTabella("cariche","NON CLICCARE QUA A SINISTRA "
			."MA PI� IN BASSO SU 'OSSERVA...' CORREZIONE tbds");
	 	 scrivi(rossone("OK! Inserimento1 fatto!"));
		}
	if ($operazione=="5")	// FORM NORMALE CON DEFAULT DI CUI HAI APPENA VOLUTO SALVARE LE MODIFICHE
		{autoAggiornaTabella("cariche","id_carica");
	 	 scrivi(rossone("OK! Aggiornamento5 fatto"));
		 tornaindietro("guarda la carica cos� modificata","$AUTOPAGINA?id=".Form("my_hidden_id"));
		}
	if ($operazione=="3")	// CANCELLA x IDCARICA
		{if ($ISPAL) visualizzaformz();
		 echo "guardo prima se ci sono nomine ad essa associate...";
		  $resDubbio=mq("select count(*) from nomine where id_carica=".Form("my_hidden_id"));
		  $rs=mysql_fetch_row($resDubbio);
		  $quante=intval($rs[0]);
		 echo " ne ho trovate $quante...";
		 if ($quante != 0)
			{die("troppe! Cancellale prima!!! Marrano! Che cerchi di compromettere l'integrità...");}
		 echo "Ok. cerco ora di cancellare la carica che sai tu...";
		 $res=mq("select id_ordine FROM cariche WHERE id_carica=".Form("my_hidden_id"));
		 if (!($rs=mysql_fetch_array($res)))
			{scrivib(rossone("non trovo l'ordine cui appartiene, errorone!")) ;
			 bona();
			}
		 $ordine=$rs[0];
		 autoCancellaTabella("cariche","id_carica"); // id numrico
		 echo rosso("ok3...");
		 ridirigerai("modifica_ordine.php?idord=".$ordine); //scrivi("Torna all'ordine");
		 bona();
		}
	if ($operazione=="13")	// CANCELLA NOMNINE DI UNA CERTA  IDCARICA
		{autoCancellaTabella("nomine","id_carica"); // id numrico
		 ridirigi("modifica_carica.php?id=".Form("my_hidden_id")); //scrivi("Torna all'ordine");
		 bona();
		}
	if ($operazione=="4")	// MODIFICA
		{if ($ISPAL)
			visualizzaformz();
		 scrivi(rossone("TU BI IMPLEMENTED IET :("));
		 $res=mq("select * from cariche where id_carica=".Form("my_hidden_id"));
		 if (!($recSet=mysql_fetch_array($res)))
			{scrivib(rosso("Attenzione, record non trovato... esco.<br>"));
			 bona();
			}
		 scrivi("<center>");
		 $ordine=$recSet["ID_Ordine"];
			formbegin();
			formhidden("hidden_operazione","5");
			formhidden("id_ordine",$ordine);
			formhidden("my_hidden_id",Form("my_hidden_id"));
			scrivi("<table border=3><tr><td>");
			scrivi("<center>");
			scrivi("<h2>modifica carica</h2>");
			formtextln("nomecarica",$recSet["nomecarica"]);
			if ($ISPAL)
				scrivi(rosso("<br>attento ric il capocitt� potrebbe non essere contemplato"
					." nel DB remoto, provalo in remoto!<br>"));
			invio();
			scrivi("dignit�: ");
			popolaComboDignita("dignit�",$recSet["Dignit�"]);
			invio();
			$sql3="SELECT id_carica,nomecarica FROM cariche WHERE id_ordine=".$ordine
				." AND NOT (id_carica = ".$recSet["ID_CARICA"].")";
			if ($ISPAL) scrivib($sql3);
			scrivi("che sta <i>direttamente</i> sotto a:");
			popolaComboConEccezionePrescelta("ID_CAR_STASOTTOA",$sql3,$recSet["ID_CAR_staSottoA"],"-1","NESSUNA");
				// adesso una bella combo con numerilli da 0 a 30 + opzione di 
				// NESSUNA cardin. max... e il gioco � fatto
			//QWERTY
			scrivi("<br><b>Cardinalit� massima</b>: ");
			popolaComboNumerilliConAlias("cardinalit�max",0,30,$recSet["Cardinalit�Max"],0,"qualunque");
			scrivi("<br>(leggasi <i>massimo numero di goliardi che<br>possono avere "
				."questa carica in un certo istante</i>):<br>");
			formScelta2("attiva",TRUE,FALSE,"da attivo","da vecchio",($recSet["Attiva"]?1:2));
			invio();
			formScelta2("HC",TRUE,FALSE,"H.C.","non HC",($recSet["HC"]?1:2));
			invio();
			hline(80);
			formtextarea("note",$recSet["note"],10,30)	;
			hline(80);
			scrivi("L'importanza della carica e' un numero cardinale che vuole modellare (nei limiti con cui un NUMERO da solo possa farlo, badate bene) l'importanza dellacarica. Quando nella pagina dell'ordine voi vedete una serie di attivi, quelli sono visualizzati per importanza. Detta importanza viene presa da qui. Ora, metteteci pure il valore che volete, ma sarebbe BELLO che cioascuno adottasse valori simili. Propongo: "
				."<br>\n<b>300</b>. Capocitta';"
				."<br>\n<b>200</b>. Capoordine;"
				."<br>\n<b>100+</b>. Nobile generico;"
				."<br>\n<b>50</b>. capopopolo;"
				."<br>\n<b>0</b>. merdina;"
				."<br>\nE ora, scannatevi pure!<br/>\n"
			);
			formtext("m_nImportanza",$recSet["m_nImportanza"]);
			scrivi("</td></tr>\n<tr><td><center>");
			formbottoneinvia("zalva modiFICHE");
			formend();
				//	scrivi("<input type='submit' value='salva modifiche'>\n</form>\n");
			scrivi("</center></td></tr></table></table>");
			hline();
		}

	if ($operazione=="2")	// WIZARD FORM 10 cariche
		{
			// costruisco 2 array con cariche e dignit�
		 $arrCarica  = Array();
		 $arrDignita = Array();
		 $i=1;
		 $arr1=Array("id_ordine","dignit�","nomecarica","cardinalit�Max","attiva","HC","id_car_stasottoa");
		 $stasottoA="-1";
		 $ord2=Form("id_ordine");
		 while (($str=(Form("nomecarica".$i)))!="" )
		  	{scrivib("Aggiunta numero ".$i."<br>\n");
			 if (str == "")
				break;
				//	 scrivid($str."<br>\n");
			 $arrDignita[i]=Form("dignit�".$i);
			 $arrCarica[i]=$str;
			 $arr2=Array($ord2,$arrDignita[$i],$str,-1,"true","false",$stasottoA);
			 autoInserisciTabellaByTwoArray("cariche",$arr1,$arr2);
			 $res=mq("SELECT id_carica FROM cariche WHERE id_ordine=".$ord2
				." AND nomecarica='".$str."' ORDER BY id_carica DESC");
			 $rs=mysql_fetch_array($res);
			 if (mysql_num_rows($res)==0)
				{
				 scrivi(rossone("deve ancora arrivare al db l'informazione... sob!"));
				 bona();
				}
			 $stasottoA=$rs["id_carica"];
			 $i++;
			}
		scrivid("Questo nomecarica valeva: ".$str);		
		if ($DEBUG)
			{scrivi("<br>DEBUG! ti fo vedere 1) le cariche x dignit� e carica, 2) x carica e dignit�<br>\n");
			 popolaComboArray("cariche",$arrDignita,$arrCarica);
			 popolaComboArray("cariche",$arrCarica,$arrDignita);
			}
		 scrivi(rossone("OK!"));
		 scrivi("<a href='modifica_ordine.php?idord=".$ord2."'>Torna alla pagina dell'ordine</a>"
			." x vedere i cambiamenti. Adesso mi scoccia cercare il suo id...");
		 bona();
		}

	// FOOTER x tutti i servizi
	 tornaindietro("Osserva cambiamenti nell'Ordine",$linkOrdine);
//	 scrivi("<h3><a href='".$linkOrdine."'>Osserva cambiamenti nell'Ordine</a><br>\n</h3>");			 
	bona();
	}

if ($AGGIUNGISOLO)
	{
	scrivi(rossone("aggiungo solo, nell'ordine numero ".$ordine));
	if(!utenteHaDirittoScritturaSuOrdineById($ordine))
		{scrivi(rossone("Non hai i privilegi x cambiare i dati!"));
		 bona();;
		}

	///////////////////////////////
	// FORM DI NUOVA CARICA

			scrivi("<center>");

		formbegin();
			scrivi("<table border=3><tr><td>");
			scrivi("<center>");
			scrivi("<h2>Crea/modifica carica</h2>");
			formtext("nomecarica","");
			invio();
			scrivi("dignit�: ");
			popolaComboDignita("dignit�");
			invio();
			$sql3="SELECT id_carica,nomecarica FROM cariche WHERE id_ordine=".$ordine;
			scrivi("che sta <i>direttamente</i> sotto a:");
			popolaComboConEccezionePrescelta("ID_CAR_STASOTTOA",$sql3,"-1","-1","NESSUNA");	
				// adesso una bella combo con numerilli da 0 a 30 + opzione 
				// di NESSUNA cardin. max... e il gioco � fatto
				//QWERTY
			scrivi("<br><b>Cardinalit� massima</b>: ");
			popolaComboNumerilliConAlias("cardinalit�max",0,30,0,0,"qualunque");
			scrivi("<br>(leggasi <i>massimo numero di goliardi che<br>possono avere ques"
				."ta carica in un certo istante</i>):<br>");
			formScelta2("attiva",TRUE,FALSE,"da attivo","da vecchio",1);
			invio();
			formScelta2("HC",TRUE,FALSE,"H.C.","non HC",2);
			invio();
			hline(80);
			formtextarea("note","",10,30)	;
			formhidden("hidden_operazione","1");
			formhidden("id_ordine",$ordine);
			scrivi("</td></tr>\n<tr><td><center>");
			formbottoneinvia("registra");
			formend();
			//scrivi("<input type='submit' value='registra'>\n</form>\n");
			scrivi("</center></td></tr></table>");
		hline();

?>
		<h2>Wizard: Crea un'intera gerarchia (*) tutta di botto che modificherai in seguito</h2>
<big>Clausole: le cariche saranno tutte ritenute attive e non HC, e senza note. Verr� semplicemente 
creata la lista discendente dal primo all'ultimo nome con i giusti legami goliardici, tale che il primo
(che sar� il capoordine o comunque un 'capofilone') non abbia nessuno sopra, il secondo discenda dal primo, 
 il terzo dal secondo e cos� via!<br><b>PS</b> Non ti preoccupare se questo wizard non fa <i>esattamente</i> ci�
 che vuoi: potrai sempre cambiare in futuro i dati; da ingegnere, non posso che dirti di cercare di <b>minimizzare</b> lo
  sforzo (che � dentro a ognuno di noi) tra ora e il futuro.
</big>

<?php 
		formbegin();
		tabled();
		scrivi("<tr><td><div align=right>");
			formtext("nomecarica1","");
		scrivi("</div></td><td>");
			formScelta3("dignit�1","capocitt�","capoordine","nobile","capocitt�","capoordine","nobile",2);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica2","");
		scrivi("</td><td>");
			formScelta2("dignit�2","capoordine","nobile","capoordine","nobile",2);
		scrivi("</td></tr><tr><td><div align=right>");







			formtext("nomecarica3","");
		scrivi("</td><td>");
			formScelta2("dignit�3","nobile","saio","nobile","saio",1);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica4","");
		scrivi("</td><td>");
			formScelta2("dignit�4","nobile","saio","nobile","saio",1);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica5","")	;
		scrivi("</td><td>");
			formScelta2("dignit�5","nobile","saio","nobile","saio",1);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica6","")	;
		scrivi("</td><td>");
			formScelta2("dignit�6","nobile","saio","nobile","saio",1);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica7","")	;
		scrivi("</td><td>");
			formScelta2("dignit�7","nobile","saio","nobile","saio",2);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica8","")	;
		scrivi("</td><td>");
			formScelta2("dignit�8","nobile","saio","nobile","saio",2);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica9","")	;
		scrivi("</td><td>");
			formScelta2("dignit�9","nobile","saio","nobile","saio",2);
		scrivi("</td></tr><tr><td><div align=right>");
			formtext("nomecarica10","");
		scrivi("</td><td>");
			formScelta2("dignit�10","nobile","saio","nobile","saio",2);
		scrivi("</td></tr>");

			formhidden("hidden_operazione","2")			;
			formhidden("id_ordine",$ordine);
			scrivi("</center>");

		tableEnd();
		scrivi("<center>");
		 formbottoneinvia("GOGO!");
		 formend();
		 invio();
		 //scrivi("<input type='submit' value='VAI!'>\n</form>\n<br>");
	}
else
if ($modificaCarica)
	{
	scrivi(rossone("modifico la carica numero ".$idcarica));
	if (anonimo())
		{scrivi(rossone("cacchio vuoi?!? Pussa via!"));
		 bona();
		}
	$ID=QueryString("id");
	if ($ID == "") // � impossibile... non sarei in questo IFFONE se fosse indefinita
		{scrivi(rossone("TU BI IMPLEMENTED IET :-)"));
		 img("1.gif");
		 bona();
		}

	$sql="SELECT * FROM cariche c1 WHERE c1.id_carica=".$idcarica ;
		// i capi non hanno uno sta sotto a e darebbe query nulla
	$res=mq($sql);
	$rs=mysql_fetch_array($res);
	formBegin();
	formhidden("my_hidden_id",$ID);
	formhidden("hidden_operazione","3")	;
	formEnd();
	hline(30);
     scriviReport_Carica($rs,FALSE) 	;	
	hline(30);	 
	scriviRiga($res,$rs);
	hline(30);
	formBegin();
	formhidden("my_hidden_id",$ID);
	formhidden("hidden_operazione","4")		;
	formbottoneinvia("MODIFICA");
	formEnd();

	$idordineservedopo = $rs["ID_Ordine"];


	$resql=mq("select count(*) from nomine where id_carica=".$ID);
	$sql=mysql_fetch_array($resql);
	$num=intval($sql[0]);
	if ($num==0)
		{
		formBegin();
		formhidden("my_hidden_id",$ID);
		formhidden("hidden_operazione","3")	;	
		formbottoneinvia("CANCELLA QUESTA CARICA");
		formEnd();
		}
		else 
			echo rosso("mica ti permetto di cancellarla sta carica finch� � piena dentro, che credi?<br>");

	scrivi("Numero di nomine associate a questa carica: <b>".$num."</b><br>");	
	if ($num > 0 && isAdminVip())
	{ // metto l'opzione di cancellare TUTTE LE NOMINE
	formBegin();
	formhidden("my_hidden_id",$ID);
	formhidden("hidden_operazione","13");
	formbottoneinvia("CANCELLALE TUTTE E $num (le nomine)!");
	formEnd();
	}
	tornaindietro("torna all'ordine","modifica_ordine.php?idord=".$idordineservedopo);
	}
else
	{
	if ($idcarica=="")
		{echo rosso("non so che carica ti ho dato, fors emi son palleggiato male i dati. pardon. Muoio...");
		 bona();
		}
	$sql="select id_ordine from cariche where id_carica=".$idcarica;
	$res=mq($sql);
	$rs=mysql_fetch_array($res);
	$idord=$rs[0];
	scriviRecordSet($rs);
	scrivi(rossone(utenteHaDirittoScritturaSuOrdineById($idord)));
	}
include "footer.php";
?>
