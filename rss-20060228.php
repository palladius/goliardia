<?php 
	# vediamo un po'....
	#echo '<'.'?xml version="1.0" encoding="utf-8" ?'.'>\n';
?>
<rss version="2.0">
<channel>
	<title>Goliardia.it Notizie</title>
	<link>http://www.goliardia.it</link>
	<description>
		Le notizie di Goliardia.it
	</description>
	<!--
		<LANGUAGE>it-IT</LANGUAGE>
		<webmaster>palladius@goliardia.org (per segnalazioni sui contenuti del servizio </webmaster>
	-->
	<image>
	  <title>Palladius News</title>
	  <url>http://www.palladius.it/palladius.jpg</url>
	  <link>http://www.goliardia.it</link>
	  <width>100</width>
	  <height>150</height>
	</image> 
<?php 
# devo usare ITEM con figli TITLE,DESCRIPTION,LINK. Magari metti decription tra cdata: [CDATA[ descrizione ]]
?>
<item>
	<!-- <enclosure url="http://www.palladius.it/palladius.jpg" type="image/jpeg"/> -->
	<title>Prova titolo statico Carlesso</title>
	<description> Prova descrizione carlessiana del mio sito</description>
	<link>http://www.palladius.it/</link>
	<!-- <date> < ? System("date"); ? > </date> -->
</item>
<item>
	<title>prova2</title>
	<description> descr2 </description>
</item>
</channel>
</rss>
