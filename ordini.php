<?php 


/////////////////////////////////////////////////////////
//// qua ho riscritto al minimo indispensabile le funzioni x far funzionare la pagina delle statistiche
//// in attesa che funzioni.php riapra i battenti.

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";




$rs=mysql_query(
	#"select o.m_fileImmagineTn as _fotoordine,nome_veloce,count(*) as quanti from ordini o,goliardi g where g.id_ordine=o.id_ord group by m_fileImmagineTn,nome_veloce order by quanti DESC"
	#"select Città as PR, o.m_fileImmagineTn as _fotoordine,nome_veloce, from ordini o ORDER BY città DESC"
	"select id_ord as _linkOrd, Città , o.m_fileImmagineTn as _fotoordine, nome_veloce, emailordine as _emailOrdine , indirizzo as indirizzoufficiale FROM ordini o WHERE m_bserio=1 ORDER BY città , nome_veloce ASC"
);
scriviRecordSetConTimeout($rs,200,"Ordini presenti nel sito","Come potete notare, questa e' un'agenda completa creata e pensata affinche' sia piu' facile raggiungere i capiordine di ogni ordine d'Italia");
?>



<table width="<?php  echo $CONSTLARGEZZA600?>" border="1"> <tr> <td width="30%" valign=top>
  </td>
 </tr>
</table>

<?php 
include "footer.php";
?>
