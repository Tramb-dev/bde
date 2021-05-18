<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
body {
	background-color:#000000;
	background-image: url(../images/background.jpg);
	color: #FFFFFF;
}

a {
	color: #FFFFFF;
}

#Layer5 {
	position:absolute;
	width:273px;
	height:36px;
	z-index:2;
	left: 45%;
	top: 80px;
}
</style>
<!-- Prise en compte de la transparence des png sous IE. -->
<script type="text/javascript" src="/js/sm-iepng.js" defer="defer" charset="ISO-8859-1"></script>
</head>
<body>
<div id="Layer1" style="position:absolute; left:45%; top:10px; width:272px; height:61px; z-index:1"> 
<div align="center"><strong><font color="#FFFFFF" size="+4" face="Astrolyte, Harlow Solid Italic, serif">Adr&eacute;naline</font></strong></div></div>
<p>
	<div id="Layer5">
		<div align="center"><strong><font size="+1">
			<?php
			$al_texte = array('Une goutte suffit', 'Générateur de sensations', 'Your way of life'); // Slogan aléatoire
			$al_sortie = $al_texte[array_rand($al_texte)];
			echo $al_sortie; 
			?>
		</font></strong></div>
	</div>
</p>
