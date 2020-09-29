<?
	include 'conf/setup.php';
?>
<h1> 
<?= php_uname('n'); ?>: qwerty La c'e' la provvidenza !
</h1>
Pagina di test .. e il test funge di brutto.
Note this might be obsoleted by varz ;)
<PRE> Alcuni dati:
CONF:
	ENVIRONMENT = <? global $ENVIRONMENT ; print $ENVIRONMENT; ?> 
	SITENAME = <? global $SITENAME ; print $SITENAME; ?> 
HOST =    <?= php_uname('n'); ?> 
DATA =    <?= date(DATE_RFC822); ?>   
PHP_VER = <?= phpversion()?> 
</PRE>
