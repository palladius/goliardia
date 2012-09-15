<?php 


/////////////////////////////////////////////////////////
//// qua ho riscritto al minimo indispensabile le funzioni x far funzionare la pagina delle statistiche
//// in attesa che funzioni.php riapra i battenti.

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";




//////////////////////////////////////////
////// pagina vera e propria.


?>
<table width="<?php  echo $CONSTLARGEZZA600?>" border="1">
 <tr>
  <td width="30%" valign=top>
   <h1>Agenda e-mail degli utenti del sito</h1>

<p>In pratica le cose stanno cosi': agli iscritti <i>vecchi</i> (ovvero prima dell'invenzione del flag 'mail poubblica') il valore di mail pubblica e' settato a FALSO. Ai nuovi viene chiesto. A tutti e' comunque permesso cambiare la propria scelta (nella pagina utente, basta cliccare sulla propria foto in alto).</p>

<?php 

	# cambiato 20050923: impongo l'isgoliard=true
$rs2=mysql_query("select m_snome as NomeUtente,m_hemail as _email,msn,provincia as goliarda from loginz where m_bmailpubblica=1 AND m_bisgoliard=1 ORDER BY provincia,m_snome");
	# cambiato 20060108: 
$rs2=mysql_query("select m_snome as utente,m_hemail as _email,msn,icq as skype, provincia as goliarda from loginz where m_bmailpubblica=1 AND m_bisgoliard=1 ORDER BY provincia,m_snome");
scriviRecordSetConTimeout($rs2,1729,
	"Agenda degli utentiregistrati",
	"Questa lista contiene, in ordine alfabetico, gli Utenti consenzienti a mettere la propria E-mail pubblica, che risultano NON FILISTEI e registrati"); // a regime 10
?>




  </td>
 </tr>
</table>

<?php 
include "footer.php";
?>
