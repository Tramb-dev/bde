<?php
include './php/titre.php';
include './php/logo.php';
include './php/menu.php';
include './php/defilement.php';
?>
<title>BDE Adr&eacute;naline, le seul BDE qui d&eacute;chire ...</title>

<!-- On intègre les news -->
<div id="Layer2" style="position:absolute; left:30%; top:170px; width:50%; height:50%; z-index:2">
<?php include("./news/news.php"); ?>
</div>

<?php
include("./php/copyright.php");
?>