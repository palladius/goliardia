<?php 

include "conf/setup.php";
include "skin/$skinPreferita/theme.php";
include "funzioni.php";
include "header.php";
include "classes/varz.php";

$arr_files = [
    "/Dockerfile-l1.VERSION",
    "/Dockerfile-l2.VERSION",
    "/CHANGELOG.L1",
  #  "/var/www/www.goliardia.it/entrypoint-8080.sh",
]
?>
    <h1>Docker Info per Riccardo</h1>

<h2>File System</h2>

<table border="1" >
<? foreach ($arr_files as &$file) { ?>
<tr>
    <td>
        <?= $file ?>
    <td>
        <b><pre><?=file_get_contents($file) ?></pre></b> 
<? } ?>
</table>

<h2>ENV</h2>

<div class="alert alert-primary" style="width:50%;text-align:left" >
    <pre><? echo get_varz_partial(); ?>
    </pre>
</div>

<h2>Database (v.<?= getMemozByChiave("db_ver") ?>)</h2>

DB_VER:  <b><?=  getMemozByChiave("DB_VER") ?></b>  <br/>
DB_TYPE: <b><?=  getMemozByChiave("DB_TYPE") ?></b> <br/>
DB_HOST/DB_NAME: vedi sopra <br/>

CHANGELOG:
<div class="alert alert-secondary" style="width:80%;text-align:left" >
     <pre><?=  getMemozByChiave("ceingLog") ?>
</div>

<h2>Code</h2>

Code version: 
CHANGELOG:
<div class="alert alert-warning" style="width:80%;text-align:left" >
     <pre><?= file_get_contents("/var/www/www.goliardia.it/CHANGELOG") ?>
</div>

<h2>Secrets</h2>

Fai vedere un paio di caratteri e poi tutte X...

<?
include "footer.php";
?>