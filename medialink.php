<?php 

	include 'intro.php';

	#############################################
	# medialink.php
	#############################################


	echo h1("medialink: youtube etc...");
	
	echo "Questa nuova pagina vuol essere un ponte sulla rete, e contiene rferimenti a tutto ci� che ci pu� essere di esterno,
	se vi vengono idee mandatemele e io le aggiungo, per ora sono supportati:
		- Youtube
		- Foto
		- Url
		- media cartelle
	";
	
		# campi per devel:
	# ID_media
	# titolo(255)
	# descrizione(255?)
	# url (255)
	# url-thumb
	# id_figliodi (ID_media)
	# privacy (vedi joomla)		# 0,10,20
	# idutentesegnalante
	
	# idrisorsa				# 3 se punta a user palladius, 457 se punta a goliarda palladius
	# tiporisorsa			# user // goliarda //
	
	?>
	<pre>
		CONTENT di jumla:
		
	 id   		int(11)  	   	UNSIGNED  	 No    	   	auto_increment   
	 title  	varchar(100) 	utf8_general_ci 	  	No   	  	  	 
	 title_alias  	varchar(100) 	utf8_general_ci 	  	No   	  	  	 
	 introtext  	mediumtext 	utf8_general_ci 	  	No   	  	  	 
	 fulltext  	mediumtext 	utf8_general_ci 	  	No   	  	  	 
	 state  	tinyint(3) 	  	  	No   	0  	  	 
	 sectionid  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 mask  		int(11) 	  	UNSIGNED 	No   	0  	  	 
	 catid  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 created  	datetime 	  	  	No   	0000-00-00 00:00:00  	  	 
	 created_by  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 created_by_alias  	varchar(100) 	utf8_general_ci 	  	No   	  	  	 
	 modified  	datetime 	  	  	No   	0000-00-00 00:00:00  	  	 
	 modified_by  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 checked_out  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 checked_out_time  	datetime 	  	  	No   	0000-00-00 00:00:00  	  	 
	 publish_up  	datetime 	  	  	No   	0000-00-00 00:00:00  	  	 
	 publish_down  	datetime 	  	  	No   	0000-00-00 00:00:00  	  	 
	 images  	text 	utf8_general_ci 	  	No   	  	  	 
	 urls  		text 	utf8_general_ci 	  	No   	  	  	 
	 attribs  	text 		utf8_general_ci 	  	No   	  	  	 
	 version  	int(11) 	  	UNSIGNED 	No   	1  	  	 
	 parentid  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 ordering  	int(11) 	  	  	No   	0  	  	 
	 metakey  	text 	utf8_general_ci 	  	No   	  	  	 
	 metadesc  	text 	utf8_general_ci 	  	No   	  	  	 
	 access  	int(11) 	  	UNSIGNED 	No   	0  	  	 
	 hits  		int(11) 	  	UNSIGNED 	No   	0  	  	 
	
	
	<?php 
	
	
	
	
?>