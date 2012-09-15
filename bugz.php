<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

if (! isadmin()) 
	{
	echo rosso("lo sforzo non è abbastanza possente in te..");
	bona();
	}

echo h1("Bugs per amministratori..");

			// x ora tutto inutile, lo lascio x scopi futuri (in futuo, scoperò?) ;-)
$arrAzioni = array (
	"sburuser senza foto"  => array ( 
					"descr" => "Utenti sboroni senza foto",
					"valDflt" => 0
						),
	"guest ingiusti"	 => array ( 
					"descr" => "Guest che purtuttavia hanno foto,daqta di nascita umana e città corretta",
					"valDflt" => 0
						)
			  );



?>
	fai x ogni bug una bversione BREVE e ua verisone lunga che ottineni cliccando, ok?
<?php 

function funzioncinaBugz($azione,$verboso)
{
global $IMMAGINI;
$tot=0;
switch ($azione)
{
case "sburuser senza foto":
	if($verboso)
	 h2("Utenti sboroni senza foto (BUGGONE!)");
	$res=mq("select * from loginz where m_bguest=0");
	tabled();
	while	 ($row=mysql_fetch_array($res))
		if (!esisteFile("$IMMAGINI/persone/".$row["m_sNome"].".jpg"))
		   {$tot++;
		    if ($verboso) 
			{trtd();
			 echo $row["m_sNome"];
			 tdtd();
			 echo $row["m_nPX"];
			trtdEnd();
			}
		   }
	tableend();
	return $tot;
case "guest ingiusti":
	if ($verboso) echo h2("guest con foto e città e data di nascita non nulla");
	$res=mq("select * from loginz l,regioni r where m_bguest=1 and l.provincia=r.nomecitta  "
		. " and not (datanascita = '1970-01-01') "
		. " and not (datanascita = '1982-02-07') "
		. " and not (datanascita = '') "
		. " and not (datanascita = 'null') "
		." limit 30");
	if ($verboso) tabled();
	while ($row=mysql_fetch_array($res))
	   if (esisteFile("$IMMAGINI/persone/".$row["m_sNome"].".jpg"))
	     {$tot++;
		if ($verboso)
		{trtd();
		 echo getTagFotoPersonaGestisceNullFast($row["m_sNome"].".jpg",50);
		 tdtd();
		 echo $row["m_sNome"];
		 tdtd();
		 echo $row["provincia"];
		 tdtd();
		 echo $row["datanascita"];
		trtdEnd();
		}
	     }
	if ($verboso) tableend();
	return $tot;
default:
	echo "attenzione, non so che mi hai dato (<i>$azione</i>)!";
	return -1;
}
}

function mettiTitoliByArray($arr)
{global $AUTOPAGINA;
 echo h4("Menuino:");
 while(list($k,$v)=each($arr))
	{
	 echo ("- <a href='$AUTOPAGINA?bug=$k'>$k</a>: ".rosso(funzioncinaBugz($k,FALSE))."<br>");
	}
 if (querystring("bug") != "")
	{
	echo h2("bug richiesto:");
	funzioncinaBugz(querystring("bug"),TRUE);
	}
}



//visualizzaarray($arrAzioni );
//funzioncinaBugz($azione,$verboso);
mettiTitoliByArray($arrAzioni);

include "footer.php";

?>
