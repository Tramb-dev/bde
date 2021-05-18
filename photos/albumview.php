<?php 
require("admin/config.php");
require('admin/classes/class.fileupload.php');

//get user specified view mode
if(isset($_COOKIE['user_settings'])){
	$user_settings = explode('|', $_COOKIE['user_settings']);
	$view = $user_settings[0]; 
}

//load the data from the album
if(file_exists('albums/'.$_GET['album'].'/data.dat')){
	require('albums/'.$_GET['album'].'/data.dat');
}else{					
	$user_alb = '';
	$passwd_alb = '';
	$comment = '';
	$description = '';
	$lock = '';
	$upload = '';
	$group = '';
}
if($lock == '1'){
	if($_COOKIE['isadmin'] !== $username.$password){
		if(!$_COOKIE['authID'] == $_GET['album']){
			echo '<meta http-equiv="refresh" content="0; URL=locked.php?album='.$_GET['album'].'">'; 
			exit;
		}
	}
}

/*
Function BuildThumbnailList, BuildList, BuildSlideList, GetFileSize
*/
function BuildThumbnailList($album, $tn_col){
	require("admin/config.php");
	$error = "";
	$data = "";
	$tn_nr = 0;
	//check for ending /
	if(substr($album, strlen($album)-1, 1) !== '/'){
		$album = $album.'/';
	}
	if(file_exists($album.'data.dat')){
		require($album.'data.dat');
	}else{					
		$user_alb = '';
		$passwd_alb = '';
		$comment = '';
		$description = '';
		$lock = '';
		$upload = '';
		$group = '';
	}
	//Generate Content
	if($show_comment == 1){
		if($comment !== ''){
			if($comment !== '<br />'."\r\n"){
				$comment_yes = true;
			}else{
				$comment_yes = false;
			}
		}else{
			$comment_yes = false;
		}
	}else{
		$comment_yes = false;
	}

	if(($upload == 1) || ($comment_yes == true)){
    	echo '<div style="border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #000000; margin-bottom: 4px;">';
		if($upload == 1){
			echo '<form action="upload-user.php" method="post" name="frmUpload" enctype="multipart/form-data" style="margin-bottom: 0px;">Upload:&nbsp;<input name="MyFile" type="file" id="MyFile" style="height: 21px;"><input name="album" type="hidden" id="album" value="'.$_GET['album'].'"><input name="action" type="submit" id="action" value="Upload" style="height: 21px;"></form>';
		}
		echo $comment;
		echo '</div>';
	}
	$data = $data.'<center>';
	if ($handle = opendir($album)){
		while (false !== ($file = readdir($handle))) {
			if($file == '.'){
				// do nothing is parent
			}elseif($file == '..'){
				// do nothing is parent
			}elseif($file == '...'){
				// do nothing is parent
			}elseif($file == 'thumbs'){
				// do nothing is thumbs folder
			}elseif($file == 'data.dat'){
				// do nothing is data.dat
			}elseif(is_file($album.$file)){
				if(substr($file, 0, 5) !== 'hide_'){
					if(eregi("(.)+\\.(jp(e){0,1}g$|gif$|png$|bmp$|tiff$)",$file)){
						$tn_nr = $tn_nr + 1;
						$tn_file = 'data/images/nothumb.jpg';
						if(file_exists($album.'thumbs/tn_'.$file)){
							$tn_file = $album.'thumbs/tn_'.$file;
						}else{
							$error = $error.$file.'|';
						}
						$data = $data.'<a target="_self" href="fileview.php?album='.$_GET['album'].'&file='.$file.'"><img src="'.$tn_file.'"></a>';
						if($tn_col !== 'auto'){
							if($tn_nr > $tn_col -1){
								$tn_nr = 0;
								$data = $data.'<br>';
							}else{
								$data = $data.'&nbsp;';
							}
						}else{
							$data = $data.'&nbsp;';
						}
					}
				}
			}
		}
	}
	$data = $data.'</center>';
	if($error !== ""){
		if($smart_tn == 1){
			$data = '<center>Some thumbnails are missing!<br>';
			$data = $data.'Please wait while Imageview creates them.</center>';
			$data = $data.'<meta http-equiv="refresh" content="0; URL=admin/createthumbs.php?album='.$_GET['album'].'&files='.$error.'">';
		}
	}			
	return $data;
}

function BuildList($album){
	$data = "";
	$data = $data.'<style>
	.MyTable {
		font:		Icon;
		border:		1px Solid ThreeDShadow;
		background:	#FFFFFF;
		color:		WindowText;
	}
	
	.MyTable thead {
		background:	ButtonFace;
	}
	
	.MyTable td {
		padding:	2px 5px;
	}
	
	.MyTable thead td {
		border:			1px solid;
		border-color:	ButtonHighlight ButtonShadow
						ButtonShadow ButtonHighlight;
		cursor:			default;
	}
	</style>';
	//check for ending /
	if(substr($album, strlen($album)-1, 1) !== '/'){
		$album = $album.'/';
	}
	require('admin/config.php');
	if(file_exists($album.'data.dat')){
		require($album.'data.dat');
	}else{					
		$user_alb = '';
		$passwd_alb = '';
		$comment = '';
		$description = '';
		$lock = '';
		$upload = '';
		$group = '';
	}
	//Generate Content
	$fileman = new filemanager;
	$data = $data.'<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="MyTable">';
	$data = $data.'<thead>';
	$data = $data.'<tr>';
	$data = $data.'<td><b>Filename</b></td>';
	$data = $data.'<td width="120"><b>Dimensions</b></td>';
	$data = $data.'<td width="80" style="border-right: 1px Solid ButtonFace;"><b>Size</b></td>';
	$data = $data.'</tr>';
	$data = $data.'</thead>';
	$data = $data.'<tbody>';
	if ($handle = opendir($album)){
		while (false !== ($file = readdir($handle))) {
			if($file == '.'){
				// do nothing is parent
			}elseif($file == '..'){
				// do nothing is parent
			}elseif($file == '...'){
				// do nothing is parent
			}elseif($file == 'thumbs'){
				// do nothing is thumbs folder
			}elseif($file == 'data.dat'){
				// do nothing is data.dt
			}elseif(is_file($album.$file)){
				if(substr($file, 0, 5) !== 'hide_'){
					if(eregi("(.)+\\.(jp(e){0,1}g$|gif$|png$|bmp$|tiff$)",$file)){
						$imgsize = getimagesize($album.$file);
						$imgsize = $imgsize[0].'x'.$imgsize[1];
						$filesize = $fileman->GetFileSize($album.$file);
						$data = $data.'<tr>';
						$data = $data.'<td><a target="_self" href="fileview.php?album='.$_GET['album'].'&file='.$file.'"><img src="data/images/icons/image.gif" align="absmiddle">&nbsp;'.$file.'</a></td>';
						$data = $data.'<td>'.$imgsize.'</td>';
						$data = $data.'<td align="right">'.$filesize[0].' '.$filesize[1].'</td>';
						$data = $data.'</tr>';
					}
				}
			}
		}
	}
	$data = $data.'</tbody>';
	if($show_comment == 1){
		if($comment !== ''){
			if($comment !== '<br />'."\r\n"){
				$comment_yes = true;
			}else{
				$comment_yes = false;
			}
		}else{
			$comment_yes = false;
		}
	}else{
		$comment_yes = false;
	}

	if(($upload == 1) || ($comment_yes == true)){
		$data = $data.'<thead>';
		$data = $data.'<tr>';
		$data = $data.'<td colspan="3" style="border-bottom: 1px Solid ButtonFace; border-right: 1px Solid ButtonFace; border-top: 1px Solid ThreeDShadow;">';
		if($upload == 1){
			$data = $data.'<form action="upload-user.php" method="post" name="frmUpload" enctype="multipart/form-data" style="margin-bottom: 0px;">Upload:&nbsp;<input name="MyFile" type="file" id="MyFile" style="height: 21px;"><input name="album" type="hidden" id="album" value="'.$_GET['album'].'"><input name="action" type="submit" id="action" value="Upload" style="height: 21px;"></form>';
		}
		$data = $data.$comment;
		$data = $data.'</td>';
		$data = $data.'</tr>';
		$data = $data.'</thead>';
	}
	$data = $data.'</table>';

	return $data;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Imageview 5 :: Album View</title>
<link href="data/style/user.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if($_GET['album'] !== ''){
	if($view == 'thumbnail'){
		echo BuildThumbnailList('albums/'.$_GET['album'], $tn_col);
	}elseif($view == 'list'){
		echo BuildList('albums/'.$_GET['album']);
	}
}
?>
</body>
</html>
