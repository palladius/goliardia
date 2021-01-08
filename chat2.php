<?php  
	# cambiata l'8 dicembre come sfida al cvs
function Session($str) {
	if (empty($_SESSION["_SESS_$str"])) return "";
		return $_SESSION["_SESS_$str"];
}

function spapla($msg) { ?>
	<table bgcolor="#ffffdd" width=400>
		<tr>
			 <td><img src="immagini/ricarrabbiato.jpg" height="80"></td>
			 <td><center><?php  echo $msg?></center></td>
		</tr>
	</table>
<?php }

session_start();

if ("" == (Session("nickname"))) 
	{echo "<center>";
	spapla("MI SPIACE, il tuo nickname non lo ricosnosco. E' molto probabile che la tua sessione sia scaduta. Fa il "
		."<a href='index.php'>LOGIN</a>... "
		."(non ti riconosco come ".Session("nickname")."..)");
	 exit;
	}
?>
<html>
<head>
	<title>Chat di Palladius!</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="content-language" content="it"> 
<link rel="stylesheet" href="/public/css/Provaric.css" rel="stylesheet" type="text/css">
</head>
<?php 
if (! Session("antiprof")) {	// normale
	?>	
		<frameset rows="90,*,130"  frameborder="NO" border="2" framespacing="0"  class='bkg_chat'>
		<frame src="chatscrivi.php" scrolling="NO" noresize name="scrivi" class='bkg_chat'>
		<frame src="chatleggi.php" name="leggi" class='bkg_chat'>
		<frame src="chatculo.php" scrolling="NO" noresize name="footer" class='bkg_chat'>
		</frameset>
<?php  } else {	// antiproffato
		echo h1("con l'antiprof la chat x ora non va, mi spiace.");
	}	
?>


</html>
