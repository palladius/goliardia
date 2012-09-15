<?php 
	#####################################################
	# $Id: vuota.php 26 2009-09-08 18:45:44Z riccardo $
	#####################################################
global $skinPreferita;
extract($_POST,EXTR_OVERWRITE);
extract($_GET,EXTR_OVERWRITE);

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";

?>
	<h1>Pagina vuota di prova</h1>
<?php 
include "footer.php";
?>
