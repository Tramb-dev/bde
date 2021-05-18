<?php
//include the class and config file
require('admin/config.php');
require('admin/classes/class.image.php');

//get the realpath of the image
$_GET['file'] = realpath($_GET['file']);
if(!file_exists($_GET['file'])){
	echo 'Image Not Found!!!';
	exit;
}

if(!isset($_GET['size'])){
	$_GET['size'] = 100;
}

//create the resize class
$MyImage = &new image();
$MyImage->setup($magickbin, 80, true);

if($annotate_color == ''){
	$annotate_color = '255,255,255';
}
//resize
if($imglib == 'gd'){
	//get width, height and the type
	$im = getimagesize($_GET['file']);
	//get the new height and width
	$width = $im[0]*$_GET['size']/100;	
	$height = $im[1]*$_GET['size']/100;
	$img = $MyImage->gd->load($_GET['file']);
	$img = $MyImage->gd->resize($img, $width, $height);
	if($annotate !== ''){
		$img = $MyImage->gd->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), $annotate_color);
	}
	$MyImage->gd->display($img);
}elseif($imglib == 'im' && $magickbin !== ''){
	$img = $MyImage->imagemagick->load($_GET['file']);
	$img = $MyImage->imagemagick->resize($img, $_GET['size'].'%', $_GET['size'].'%');
	if($annotate !== ''){
		$img = $MyImage->imagemagick->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), 'rgb('.$annotate_color.')');
	}
	$MyImage->imagemagick->display($img);
}
?>