</td></tr>
</table>
<center>
<?php 
global $CONSTLARGEZZA600,$AUTOPAGINA,$DEBUG,$ISSERIO,$ISPAL,$POST_DEBUG,$DOVE_SONO,$IMMAGINI,$QGFDP,$VERSION, $PAGEVER, $dbdatabase ;
lineaViola($CONSTLARGEZZA600);
?> <center> <?php 
if ($DEBUG) {
	scrivi("<hr/>");
	scrivi(rossone("POST DEBUG:<br>"));
	 scrivi($POST_DEBUG);
	 hline();
	}
?>
<table width='<?php  echo $CONSTLARGEZZA600?>'>
	<tr>
		<td width='100' valign='top'>
			<div align=left>
				<?php  if (! $ISSERIO)
					img("persone/palladius.jpg",100);
				else
					img("logoFooterIside.jpg",100); 
				?>
			</div>
		</td>
		<td width='<?php  echo $CONSTLARGEZZA600-400?>' valign='top'>
			<center>
			<img src="<?php  echo $IMMAGINI?>/powered_mini.jpg" width='150'>
			<h6>
			[ <a href="index.php">Home</a> 
			<!--			| <a href="http://www.goliardia.it/joomla/">Sito Joomla</a>  -->
			| <a href='https://github.com/palladius/goliardia'>Code on gitHub</a> 
			| <a href="mailpalladius.php">contatta <?php  echo $QGFDP?></a> 
			| <a href="http://goliardia-development.palladi.us/" >Gol-DEV</a>
			| <a href="http://goliardia-staging.palladi.us/" >Gol-staging</a>
			| <a href="http://goliardia-prod2.palladi.us/" >Gol-prod2</a> (GKE)
			]</h6>
			</center>
		</td>
		<td width="100" valign='top'>
			<div align=right>
				<img src='immagini/palladius/palladius-lederhosen-aj.jpg' height='100' /> 
			</right>
		</td>
	</tr>
</table>
</center>
<?php  deltat() ?>
<table width='500' border=0><tr width='500'><td width='500'>
<?php 
 if ($DEBUG || contiene($AUTOPAGINA,"paginozza") || contiene($AUTOPAGINA,"antiprof")) {
	 visualizzaDebug();
	}
 ?>
</td></tr></table>

<small>
	<b><?php  echo $DOVE_SONO?></b>, 
   <!-- NON VA v: <b><?php  echo $VERSION ?></b> -->
   <!-- non ci interessa	 PHPver: <b><?php  echo $PAGEVER?></b>,  -->
	DB: <i><?php echo $dbdatabase ?></i> on 
	<!-- hostname -->
	 <b><u><?= getHostnameAndDockerHostname(); ?></u></b>, 
	(DB_VER <?= getMemozByChiave("db_ver") ?>, 
		<? echo get_rails_env() ?> )
	 CodeVer: <b><?= `cat ./VERSION` ?></b> ]
<?php 
 if ($ISPAL) { ?>
	<br/>(PALONLY:) , php v<?php  echo phpversion()?>
		<a href='http://pma-goliardia.palladi.us/'>PHPmyAdmin 2020 docker</a>
<?php  } ?>
</small> 
</body>
</html>
