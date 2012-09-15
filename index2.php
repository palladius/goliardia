<?php 

include "intro.php";
#connettiDB();	

function paginaTrivial() {
	echo h1("Prova trivial");
}


$option = isset($_GET['option']) ? $_GET['option'] : '';	# pagina, es 'mandafoto'
$action = isset($_GET['action']) ? $_GET['action'] : '';	# azione della pagina, es: 'filerename'


#echo h1("DEB OPZ:'$option'");
#echo 'sdpoi psdfksfh ksfhl sjfh has';

switch ($option) {
	case 'trivial':		
		paginaTrivial(); break;
	case 'banner':
		echo h2("Prova Bruce BANNER"); break;
	case 'mandafoto':
		paginaMandafoto(); break;
	case 'jumlacontent':
		$id=9;
		foreach(array(2,6,9) as $id) {
			echo getJumlaContent($id);
		}
	default:  
		echo h1("no opz (prova option=XXX: trivial, banner, mandafoto!!!"); break;
	
}

include "footer.php";

?>

