<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


log2("logout  [".Session("nickname")."]");

session_unset();

if (isset($nickname))
	scrivi(h1("ARGH! so che ti chiami $nickname! ciò non è bene. prova a rifare il logout..."));
else
	scrivi(h1("logout riuscito, nessuno sai più chi sei, caro il mio ''. To'! Manco io. ;)"));


if (! (getUtente()=="palladius"))
{ridirigi("login.php");}
else
{
echo "al futuro i ciappini pal-only BIS...<br>";
/*
scrivi("Ora che è abbandonata::<br>\n")

scrivib("SESSION CONTENTS:<br>\n")
visualizzaArrayGenerico(Session.Contents)

scrivib("SESSION StaticObjects:<br>\n")
visualizzaArrayGenerico(Session.StaticObjects)
*/
}
?>
<?php 


scrivib("fatto. Sessione abbandonata<br>qui c'è il <a href='login.php'>LOGIN</a>...");

include "footer.php";

?>

