<?php 
require("admin/config.php");

/*
Function getAlbum
*/
function GetAlbum($dir, $count, $subcount){
	//check for ending /
	if(substr($dir, strlen($dir)-1, 1) !== '/'){
		$dir = $dir.'/';
	}
	//Generate Content
	if ($handle = opendir($dir)){
		while (false !== ($file = readdir($handle))) {
			if($file == "."){
				// do nothing is parent
			}elseif($file == "..") {
				// do nothing is parent
			}elseif($file == "...") {
				// do nothing is parent
			}elseif($file == "tmp") {
				// do nothing is parent
			}elseif(is_dir($dir.$file) == "1") {
				if(file_exists($dir.$file.'/data.dat')){
					require($dir.$file.'/data.dat');
				}else{					
					$user_alb = '';
					$passwd_alb = '';
					$comment = '';
					$description = '';
					$lock = '';
					$upload = '';
					$group = '';
				}
				$count = $count + 1;
				$parent = substr($dir, 7, strlen($dir)-7);
				if($group == 1){
					echo "d.add(".$count.", ".$subcount.", '&nbsp;".$file."', '', '".$description."', '', 'data/images/icons/folder_group.gif', 'data/images/icons/folder_group_open.gif');\n";
					$count = GetAlbum($dir.$file, $count, $count);
				}else{
					if($lock == 1){
						echo "d.add(".$count.", ".$subcount.", '&nbsp;".$file."', 'albumview.php?album=".$parent.$file."', '".$description."', 'frmcontent', 'data/images/icons/folder_locked.gif', 'data/images/icons/folderopen.gif');\n";
					}else{
						echo "d.add(".$count.", ".$subcount.", '&nbsp;".$file."', 'albumview.php?album=".$parent.$file."', '".$description."', 'frmcontent', 'data/images/icons/folder.gif', 'data/images/icons/folderopen.gif');\n";
					}
				}
			}
		}
	}
	return $count;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Imageview 5 :: Album List</title>
<link rel="stylesheet" type="text/css" href="data/style/user.css">
<link rel="stylesheet" type="text/css" href="data/style/dtree.css">
<script type="text/javascript" src="data/javascript/dtree.js"></script>
</head>

<body>
<div class="dtree">
<?php
	if($rss == 1){
		echo '<span style="width: 27; height: 14; position: absolute; right: 10px;"><a href="#" OnClick="window.open(\'rss-index.php\',\'\', \'status=0,toolbar=0,location=0,menubar=0,resizable=0,scrollbars=0,height=125,width=250\');"><img src="data/images/icons/xml.png" align="absmiddle"></a></span>';
	}
	/* 
	Create The dTree with all the albums and Groups
	*/
	echo '<script type="text/javascript">';
	echo "d = new dTree('d');";
	echo "d.config.useCookies = 1;";
	echo "d.config.inOrder = 0;";
	echo "d.config.useStatusText = 0;";
	echo "d.add(0,-1,'&nbsp;Albums');";
	GetAlbum('albums', 0, 0);
	echo "document.write(d);";
	echo "</script>";
?>
</div>
</body>
</html>
