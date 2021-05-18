<link href="data/style/user.css" rel="stylesheet" type="text/css">
<?php
require('admin/config.php');
require('admin/classes/class.image.php');
require('admin/classes/class.fileupload.php');
$fileman = new filemanager;
$MyImage = &new image();
$albumdir = 'albums/'.$_POST['album'].'/';
if(!is_dir($albumdir.'thumbs')){
	$umaskold = umask(0);
	mkdir($albumdir.'thumbs', 0777);
	umask($umaskold);
}
if(file_exists($albumdir.'data.dat')){
	require($albumdir.'data.dat');
}else{					
	$user_alb = '';
	$passwd_alb = '';
	$comment = '';
	$description = '';
	$lock = '';
	$upload = '';
	$group = '';
}
if($upload == '1'){
	$MyUpload = $fileman->UploadFile($_FILES['MyFile'], $albumdir, 1, 'image/jpeg|image/jpg|image/pjpeg|image/png|image/bmp|image/gif');
	if(!$MyUpload[0]){
		echo $MyUpload[1];
	}else{
		$MyImage->tools->extentiontolowercase($albumdir);
		if(file_exists($albumdir.$MyUpload[1])){
			if($imglib == 'gd'){
				$img = $MyImage->gd->load($albumdir.$MyUpload[1]);
				$img = $MyImage->gd->resize($img, $tn_size_width, $tn_size_height);
				$MyImage->gd->save($img, $albumdir.'/thumbs/tn_'.$MyUpload[1]);
			}elseif($imglib == 'im' && $magickbin !== ''){
				$img = $MyImage->imagemagick->load($albumdir.$MyUpload[1]);
				$img = $MyImage->imagemagick->resize($img, $tn_size_width, $tn_size_height);
				$MyImage->imagemagick->save($img, $albumdir.'/thumbs/tn_'.$MyUpload[1]);
			}else{
				echo '<center>Please select a library to use for thumbnail creation, or set the Imagemagick path!</center>';
				exit;
			}
		}
		echo '<center>Your image has been uploaded to <i>'.$_POST['album'].'</i>!</center>';
		echo '<meta http-equiv="refresh" content="3; URL=albumview.php?album='.$_POST['album'].'">';
	}
}else{
	echo '<center>You are not allowed to uplaod to <i>'.$_POST['album'].'</i>!</center>';
	echo '<meta http-equiv="refresh" content="3; URL=albumview.php?album='.$_POST['album'].'">';
}
?>