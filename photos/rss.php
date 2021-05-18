<?php 
header('content-type: application/xml'); //application/rss+xml
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
	require('admin/classes/class.crypt.php');
	//create Crypto
	$crypto = new Crypto();
	$crypto->password = 'imageview';
	//round One
	$user_alb = $crypto->encrypt($user_alb);
	$passwd_alb = $crypto->encrypt($passwd_alb);
	if($_GET['UID'] !== $user_alb.$passwd_alb){
		exit;
	}
}
//recurve mkdir function
function mkdirr($strPath, $mode = 0777){
	$old = umask(0);
	return is_dir($strPath) or ( mkdirr(dirname($strPath), $mode) and mkdir($strPath, $mode) );
	umask($old);
}

/*
Function BuildItemList
*/
function BuildItemList($album){
	//create the resize class
	require('admin/classes/class.image.php');
	
	$MyImage = &new image();
	$MyImage->setup($magickbin, 80, true);
	
	if($annotate_color == ''){
		$annotate_color = '255,255,255';
	}
	require('admin/config.php');
	$data = "";
	$base = "";
	$nl = "\r\n";
	//check for ending /
	if(substr($album, strlen($album)-1, 1) !== '/'){
		$album = $album.'/';
	}
	$base = 'http://';
	$base = $base.$_SERVER['HTTP_HOST'];
	$base = $base.substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-7);
	if($cache == "0"){
		if($annotate !== ''){
			$base = $base.'viewimg.php?file=';
		}
		$base = $base.'albums/';
	}else{
		if($annotate == ''){
			$base = $base.'albums/';
		}else{
			$base = $base.'cache/';
		}
	}
	$base = $base.$album;
	//Generate Content
	if ($handle = opendir('albums/'.$album)){
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
			}elseif(is_file('albums/'.$album.$file)){
				if(substr($file, 0, 5) !== 'hide_'){
					if(eregi("(.)+\\.(jp(e){0,1}g$|gif$|png$|bmp$|tiff$)",$file)){
						$data = $data.'<item>'.$nl;
						$data = $data.'<title>'.$file.'</title>'.$nl;
						if(($cache == "0") || ($annotate == '')){
							$data = $data.'<link>'.$base.$file.'</link>'.$nl;
						}else{
							//get filename + extention
							$filename = explode('.', $file);
							$filename = str_replace('.'.$filename[(count($filename)-1)], '', $file).'-100-'.sha1($annotate.$annotate_color).'.'.$filename[(count($filename)-1)];
							if(!file_exists('./cache/'.$_GET['album'].'/'.$filename)){
								//if not remove all out of date copies, and create a new one
								//cache dir exists?
								if (!is_dir('./cache/')){
									$old = umask(0);
									mkdir('./cache/', 0777);
									umask($old);
								}
								//album dir exists?
								if (!is_dir('./cache/'.$_GET['album'].'/')){
									mkdirr('./cache/'.$_GET['album'].'/', 0777);
								}
								
								//remove older cache files
								if ($handle_del = opendir('./cache/'.$_GET['album'].'/')){
									while (false !== ($file_del = readdir($handle_del))){
										$temp = explode('.', $file_del);
										if(substr($file_del, 0, strlen($temp[0].'-100-')) == $temp[0].'-100-'){
											unlink('./cache/'.$_GET['album'].'/'.$file_del);
										}
										$temp  = '';
									}
								}
							
								//resize & annotate
								if($imglib == 'gd'){
									$img = $MyImage->gd->load('albums/'.$_GET['album'].'/'.$file);
									if($annotate !== ''){
										$img = $MyImage->gd->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), $annotate_color);
									}
									$MyImage->gd->save($img, 'cache/'.$_GET['album'].'/'.$filename);
								}elseif($imglib == 'im' && $magickbin !== ''){
									$img = $MyImage->imagemagick->load('albums/'.$_GET['album'].'/'.$file);
									if($annotate !== ''){
										$img = $MyImage->imagemagick->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), 'rgb('.$annotate_color.')');
									}
									$MyImage->imagemagick->save($img, 'cache/'.$_GET['album'].'/'.$filename);
								}	
							}
							$data = $data.'<link>'.$base.$filename.'</link>'.$nl;
						}
						//$data = $data.'<description></description>'.$nl;
						$data = $data.'</item>'.$nl;
					}
				}
			}
		}
	}
	return $data;
}
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>Imageview 5 :: <?php echo $_GET['album']; ?></title>
    <link>http://www.blackdot.be</link>
    <description><?php echo $description; ?></description>
	<generator>Imageview 5 :: By Jorge Schrauwen</generator>
    <language>en-us</language>
	<?php
		echo BuildItemList($_GET['album']);
	?>
  </channel>
</rss>