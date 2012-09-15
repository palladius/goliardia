<?
	include 'conf/setup.php';
?>
<h1> 
<?= php_uname('n'); ?>: qwerty La c'e' la provvidenza !
</h1>
Pagina di test .. e il test funge di brutto
<PRE> Alcuni dati:
SVNID  =  $Id: test.php 28 2009-09-09 07:14:00Z riccardo $
SVNURL =  $Url$
CONF:
	ENVIRONMENT = <? global $ENVIRONMENT ; print $ENVIRONMENT; ?> 
	SITENAME = <? global $SITENAME ; print $SITENAME; ?> 
HOST =    <?= php_uname('n'); ?> 
DATA =    <?= date(DATE_RFC822); ?>   
PHP_VER = <?= phpversion()?> 
</PRE>
