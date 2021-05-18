<?php
	require('admin/config.php'); 
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
				echo '<meta http-equiv="refresh" content="0; URL=locked.php?album='.$_GET['album'].'&file='.$_GET['file'].'">'; 
				exit;
			}
		}
	}
	//recurve mkdir function
	function mkdirr($strPath, $mode = 0777){
		$old = umask(0);
	    return is_dir($strPath) or ( mkdirr(dirname($strPath), $mode) and mkdir($strPath, $mode) );
		umask($old);
	}
	//get index for next/preveus image
		if ($handle = opendir('albums/'.$_GET['album'])){
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
			}elseif($file == 'Thumbs.db'){
				// do nothing is thumbs.db
			}else{
				$filelist[count($filelist)] = $file;
			}
		}
	}
	reset($filelist);
	while (list($key, $val) = each($filelist)) {
		if($val == $_GET['file']){
			$index = $key;
		}
	}
	$inext = $index+1;
	if($inext == count($filelist)){
		$inext = 0;
	}
	$iback = $index-1;
	if($iback == -1){
		$iback = (count($filelist)-1);
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Imageview 5 :: File View</title>
<link href="data/style/user.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="data/javascript/menu/milonic_src.js" type="text/javascript"></script>
<script	language="JavaScript">
if(ns4)_d.write("<scr"+"ipt language=JavaScript src=data/javascript/menu/mmenuns4.js><\/scr"+"ipt>");		
  else _d.write("<scr"+"ipt language=JavaScript src=data/javascript/menu/mmenudom.js><\/scr"+"ipt>"); 
</script>
<script language="JavaScript" src="data/javascript/menu/menu_data.php?album=<?php echo $_GET['album'];?>&file=<?php echo $_GET['file'];?>" type="text/javascript"></script>
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" style="border-bottom-color: #000000; border-bottom-style: solid; border-bottom-width: 1px;"><table height="20" border="0" cellpadding="0" cellspacing="0">
      <tr align="left" valign="middle">
        <td width="70"><a href="fileview.php?album=<?php echo $_GET['album']; ?>&file=<?php echo $filelist[$iback]; ?>" target="_self"><img src="data/images/icons/back.png" width="20" height="20" border="0" align="absmiddle"></a><a href="albumview.php?album=<?php echo $_GET['album']; ?>" target="_self"><img src="data/images/icons/up.png" width="20" height="20" border="0" align="absmiddle"></a><a href="fileview.php?album=<?php echo $_GET['album']; ?>&file=<?php echo $filelist[$inext]; ?>" target="_self"><img src="data/images/icons/next.png" width="20" height="20" border="0" align="absmiddle"></a></td>
      	<?php if(($resizemenu == '1' && $imglib == 'gd') or ($resizemenu == '1' && $imglib == 'im' && $magickbin !== '')){ ?><td width="55"><a target="_self" href="#" onMouseOver="popup('AutoResize','mnuPlace')"><img src="data/images/icons/view.png" width="20" height="20" align="left" name="mnuPlace" id="mnuPlace">Size</a></td>
      	<?php } ?>
	  	<?php
			if($mail == "1"){
		?>
		<td width="60"><a href="<?php echo 'mail.php?album='.$_GET['album'].'&file='.$_GET['file']; ?>" target="_self"><img src="data/images/icons/mail.png" width="20" height="20" align="left">Mail</a></td>
		<?php
			}
		?>
		<td>Name:&nbsp;<?php echo $_GET['file'] ?></td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle" style="padding-top: 2px;">
	<?php
		if(!isset($_GET['size'])){
			$_GET['size'] = 100;
		} 
		if($cache == "0"){
			if($_GET['size'] == 100 && $annotate == ''){
				echo '<img src="albums/'.$_GET['album'].'/'.$_GET['file'].'">';
			}else{
				echo '<img src="viewimg.php?file=albums/'.$_GET['album'].'/'.$_GET['file'].'&size='.$_GET['size'].'">'; 
			}
		}else{
			if($_GET['size'] == 100 && $annotate == ''){
				echo '<img src="albums/'.$_GET['album'].'/'.$_GET['file'].'">';
			}else{
				if($_GET['size'] == 100 && $annotate == ''){
					echo '<img src="albums/'.$_GET['album'].'/'.$_GET['file'].'">';
				}else{
					//get filename + extention
					$filename = explode('.', $_GET['file']);
					$filename = str_replace('.'.$filename[(count($filename)-1)], '', $_GET['file']).'-'.$_GET['size'].'-'.sha1($annotate.$annotate_color).'.'.$filename[(count($filename)-1)];
					//check if file is in cache
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
						require('admin/classes/class.image.php');
						//remove older cache files
						if ($handle = opendir('./cache/'.$_GET['album'].'/')){
							while (false !== ($file = readdir($handle))){
								$temp = explode('.', $_GET['file']);
								if(substr($file, 0, strlen($temp[0].'-'.$_GET['size'].'-')) == $temp[0].'-'.$_GET['size'].'-'){
									unlink('./cache/'.$_GET['album'].'/'.$file);
								}
								$temp  = '';
							}
						}
						//create the resize class
						$MyImage = &new image();
						$MyImage->setup($magickbin, 80, true);
						
						if($annotate_color == ''){
							$annotate_color = '255,255,255';
						}
						//resize & annotate
						if($imglib == 'gd'){
							//get width, height and the type
							$im = getimagesize('albums/'.$_GET['album'].'/'.$_GET['file']);
							//get the new height and width
							if($_GET['size'] !== 100){
								$width = $im[0]*$_GET['size']/100;	
								$height = $im[1]*$_GET['size']/100;
							}
							$img = $MyImage->gd->load('albums/'.$_GET['album'].'/'.$_GET['file']);
							if($_GET['size'] !== 100){
								$img = $MyImage->gd->resize($img, $width, $height);
							}
							if($annotate !== ''){
								$img = $MyImage->gd->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), $annotate_color);
							}
							$MyImage->gd->save($img, 'cache/'.$_GET['album'].'/'.$filename);
						}elseif($imglib == 'im' && $magickbin !== ''){
							$img = $MyImage->imagemagick->load('albums/'.$_GET['album'].'/'.$_GET['file']);
							$img = $MyImage->imagemagick->resize($img, $_GET['size'].'%', $_GET['size'].'%');
							if($annotate !== ''){
								$img = $MyImage->imagemagick->annotate($img, $annotate, str_replace('\\', '/', realpath('./admin/classes/vera.ttf')), 'rgb('.$annotate_color.')');
							}
							$MyImage->imagemagick->save($img, 'cache/'.$_GET['album'].'/'.$filename);
						}
					}
					//server the cached image
					echo '<img src="cache/'.$_GET['album'].'/'.$filename.'">'; 
				}
			}
		}
	?>
	</td>
  </tr>
</table>
</body>
</html>
