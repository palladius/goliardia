<?php 


/////////////////////////////////////////////////////////
//// qua ho riscritto al minimo indispensabile le funzioni x far funzionare la pagina delle statistiche
//// in attesa che funzioni.php riapra i battenti.

include "conf/setup.php";
#include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

/////////////////////////////
////// pagina vera e propria.

$dueGiorni=($ISPAL ? 20 : 2); // sarà 2 a regime, ora mi serve x debug

?>
<h1>Statistiche</h1>
<table width="<?php  echo $CONSTLARGEZZA600?>" border="0">
  <tr>
    <td width="30%" valign=top>
    <h2>Utenti</h2>
<?php 
$sql= ($ISPAL
	? "select l.m_snome as utente, m_dataiscrizione, (to_days(now())-to_days(m_dataiscrizione)) as giorniFa,provincia,m_nPX as GP,m_datalastcollegato as finger from loginz l where ((to_days(now())-to_days(m_dataiscrizione)) <= $dueGiorni) order by m_dataiscrizione desc"
	: "select l.m_snome as nome, m_dataiscrizione, (to_days(now())-to_days(m_dataiscrizione)) as giorniFa,provincia from loginz l where ((to_days(now())-to_days(m_dataiscrizione)) <= $dueGiorni) order by m_dataiscrizione desc");

$rs2=mysql_query($sql);
scriviRecordSetConTimeout($rs2,6,"Iscritti negli ultimi $dueGiorni giorni"); // a regime 10

$rs2=mysql_query( $ISPAL ?  "select m_snome as _fotoutente,m_snome as utente,m_bGuest as _guest,provincia,m_datalastcollegato as _data_alle,m_bserio as _serio,m_bsingle as _single FROM loginz order by (m_datalastcollegato) DESC"
	: "select m_snome as _fotoutente,m_snome as utente,m_bGuest as _guest,m_datalastcollegato as _data_alle,m_bserio as _serio,m_bsingle as _single FROM loginz order by (m_datalastcollegato) DESC" 
	);


scriviRecordSetConTimeout($rs2,10,"Gli ultimi collegati");
$rs2 = mysql_query("SELECT l.m_snome as _fotoutente,l.m_snome as nome,count(*) as quanti,20 as eta FROM messaggi m,loginz l where l.id_login=m.id_login  group by m.id_login,l.m_snome order by quanti desc");

scriviRecordSetConTimeout($rs2,10,"Quelli che han scritto più messaggi");
$rs=mysql_query("select m_snome as _fotoutente,m_snome as nome,m_npx from loginz order by (m_npx) deSC");
scriviRecordSetConTimeout($rs,10,"I più vicini alla caffettiera","Utenti che hanno piu' Goliard Points&trade; (ovvero che hanno fatto piu' login o favori sessuali a Palladius).");

$rs2=mysql_query("select m_snome,m_datalastcollegato from loginz where  (to_days(now())-to_days(m_datalastcollegato)) between -1 and 2 order by m_datalastcollegato desc");
scriviRecordSetConTimeout($rs2,30,"Ultimi Entrati ","Ultimi 30 entrati negli ultimi 2 giorni, ad essere precisi"); 

        "select m_snome,m_datalastcollegato from loginz where  (to_days(now())-to_days(m_datalastcollegato)) between -1 and 2 order by m_datalastcollegato desc"

?>


  </td>

  <td width="30%" valign=top>
<?php 

# NON VA ma sembr carino
#$rs2=mysql_query("select m_snome as _fotoutente,m_snome as nome,provincia FROM loginz WHERE provincia LIKE '".$_SESSION["provincia"]."' order by (m_datalastcollegato) DESC");
#scriviRecordSetConTimeout($rs2,20,"Quelli della mia città","(ordinati x ultimo collegamento)");
?>



   <h2>Ordini</h2>
 
<?php 
$sql = "SELECT o.m_fileImmagineTn AS _fotoordine, nome_veloce, id_ord AS _linkOrd, COUNT(*) AS quanti FROM ordini o, goliardi g WHERE g.id_ordine = o.id_ord GROUP BY m_fileImmagineTn, nome_veloce, id_ord ORDER BY quanti DESC";
$rs=mysql_query($sql);
$ret = scriviRecordSetConTimeout($rs,10,"Quelli con piu' goliardi");
if (! $ret && $ISPAL ) {
  echo h1("eRore PAL!");
  echo pre("Errore con: $sql");
}
?>



<?php 
$rs=mysql_query("select m_fileImmagineTn as _fotoordine,nome_veloce,count(*) AS quanti from ordini o,nomine n,cariche c where c.id_carica=n.id_carica AND c.id_ordine=o.id_ord group by m_fileImmagineTn,nome_veloce order by quanti DESC");
scriviRecordSetConTimeout($rs,15,"Ordini con + nomine inserite");


if (isdevelop()) {
	scrividevelop("prova a scrivere sta query da bene, con mysql...!!!")
?> 
<br>
(s'intende: 100 pti x ogni carica <i>attiva</i> da capoordine, 10 x ogni carica nobiliare ricoperta,1 per ogni carica popolare...)

<?php 
$rs=mysql_query("select `Nomegoliardico`,count(*) as quante from goliardi g, nomine n, cariche c where n.id_goliarda=g.id_gol AND c.id_carica=n.id_carica group by g.id_gol,g.`Nomegoliardico` order by quante desc");
scriviRecordSetConTimeout($rs,10,"Il goliarda con + Active Pointz®");
}

?>

<?php 
$rs=mysql_query("select `Nomegoliardico`,c.attiva,c.`dignità`,count(*) as quante from goliardi g, nomine n, cariche c where n.id_goliarda=g.id_gol AND c.id_carica=n.id_carica and c.hc=0 group by g.id_gol,g.`Nomegoliardico`,c.attiva,c.`dignità` order by quante desc");

scriviRecordSetConTimeout($rs,20,"Il goliarda con + Nomine","(s'intende: 100 pti x ogni carica <i>attiva</i> da capoordine, 10 x ogni carica nobiliare ricoperta,1 per ogni carica popolare...)");


?>
  </td>
 </tr>
</table>

<?php 
include "footer.php";
?>
