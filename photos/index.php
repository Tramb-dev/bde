<?php
if(!file_exists('admin/config.php')){
	header('Location: install.php');
	exit;
}
require("admin/config.php");

//check if album is provided
if(!isset($_GET['album'])) {
	$_GET['album'] = $default_album;
}

//build URL's
if(isset($_GET['admin'])){
	if($_COOKIE['isadmin'] !== $username.$password){
		echo '<meta http-equiv="refresh" content="0; URL=admin/login.php">';
		exit; 
	}
	$MenuURL = 'admin/menu.php';
	$ContentURL = 'admin/settings.php';
}elseif(isset($_GET['help'])){
	$MenuURL = 'help/menu.htm';
	$ContentURL = 'help/main.htm';
}else{
	if(isset($_GET['file'])){
		$ContentURL = 'fileview.php?album='.$_GET['album'].'&file='.$_GET['file'];
		if(isset($_GET['size'])){
			$ContentURL = $ContentURL.'&size='.$_GET['size'];
		}
	}else{
		$ContentURL = 'albumview.php?album='.$_GET['album'];
	}
	$MenuURL = 'albumlist.php?album='.$_GET['album'];
}

//determen ui
if(isset($_COOKIE['user_settings'])) {
	$user_settings = explode('|', $_COOKIE['user_settings']);
}else{
	$user_settings = explode('|', '|normal'); //use defaults
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Les photos des f&ecirc;tes du BDE Adr&eacute;naline : Week-End d'Int&eacute;gration, ski, journ&eacute;e d'Int&eacute;gration ...</title>
<meta name="description" content="Imageview 5 :: By Jorge Schrauwen (http://www.backdot.be)">
<meta name="keywords" content="imageview, jorge, schrauwen, jorge schrauwen, image, photo, picture, gallery, php, blackdot">
<link rel="Shortcut Icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="data/style/index.css">
<link rel="Developer" href="http://www.blackdot.be" title="Blackdot.be" />
</head>
<?php include('data/gui/'.$user_settings[1] .'.php'); ?>
</html>
