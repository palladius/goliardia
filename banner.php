<?php 

# modificato x giuoco
# asdfgh

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";


function fancyInizio($tit="?!?!? EROOOOOOOORE")
{
echo "<p>";
//img("freccia-f.gif' align='center");
img("freccia-f.gif");
echo " <b>$tit</b>. ";
}

function fancyFine()
{
scrivib("</p>\n");
}


$titolo="$IMMAGINI/pubblicita-proPal";

flashTesto($titolo,1000,600);

echo "<h1>Fatto da Iside! X i miei adminvip...</h1>";

include "footer.php";
?>
