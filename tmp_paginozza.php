<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


if (! $ISPAL)
	bona();

$frase = "SELECT * \n FROM loginz\n WHERE m_snome like '%pal%'";


$querysql=post("querysql");

openTable();

openTable();
echo "<h1>query generica inutile</h1>";
closeTable();

if ("" != (post("hidden_1")))
{$querysql=stripslashes($querysql);
 echo "<h2>Risultato query </h2>($querysql)<br/>";
 $res=mysql_query($querysql)
	or scrivib("mysql_error(): ".mysql_error());
 scriviRecordSetConTimeout($res,10);
 $frase=$querysql;
}

?>
<form method='post' action='tmp_paginozza.php'>
<textarea name='querysql' rows=10 cols=40 value='value'>
 <?php  echo $frase?>
</textarea>
<br>
<input type=hidden name='hidden_1' value='42'>
<input type='submit' value='invia query'>
</form>
<?php 


tdtd();

openTable();
echo "<h1>comando generico inutile</h1>";
closeTable();

$frase="ls -al | sendmail palladius@goliardia.org";

if (isset($hidden_2))
{
 echo "<h2>Risultato comando </h2>('$comando')<br/>";
 openTable();
 echo "<pre>";
 system($comando)
	or scrivib("system_error()..");
 echo "<pre>";
 closeTable();
 $frase=$comando;
}

?>
<form method='post' action='tmp_paginozza.php'>
<textarea name='comando' rows=10 cols=40 value='value'>
 <?php  echo $frase?>
</textarea>
<br>
<input type=hidden name='hidden_2' value='84'>
<input type='submit' value='invia query2'>
</form>
<?php 


closeTable();

//phpinfo();


include "footer.php";

?>


