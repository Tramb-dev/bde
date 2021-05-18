<?php
/*
Function GetAlbums
*/
function GetAlbum($dir, $subpath){
	require('admin/config.php');
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
			}elseif(is_dir($dir.'/'.$file) == "1") {
				if(file_exists($dir.'/'.$file.'/data.dat')){
					require($dir.'/'.$file.'/data.dat');
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
				if($subpath !== ''){
					if(substr($subpath, -1) !== '/'){
						$subpath = $subpath.'/';
					}
				}
				if($group == 1){
					GetAlbum($dir.$file, $subpath.$file);
				}else{
					echo '<option value="'.$subpath.$file.'"';
					if($default_album == $subpath.$file){
						echo ' selected'; 
					}
					echo '>'.$subpath.$file.'</option>';
				}
			}
		}
	}
}
?>
<html>
<head>
<title>Imageview 5 :: RSS Feeds</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="data/style/user.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">	<form action="rss-index.php" method="post" name="frmRSS" target="_self" id="frmRSS">
	<?php
	if(!isset($_POST['action'])){
	?>
	      <table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td align="center">Select Album: </td>
        </tr>
        <tr>
          <td align="center"><select name="lsalbum" id="select">
              <?php echo GetAlbum('albums/', ''); ?>
          </select></td>
        </tr>
        <tr>
          <td align="center">
              <input name="action" type="hidden" id="action" value="lock">
              <input name="cmdGo" type="submit" id="cmdGo" value="Next"></td>
        </tr>
      </table>
	<?php
	}
	if($_POST['action'] == 'lock'){
		if(file_exists('albums/'.$_POST['lsalbum'].'/data.dat')){
			require('albums/'.$_POST['lsalbum'].'/data.dat');
		}else{					
			$user_alb = '';
			$passwd_alb = '';
			$comment = '';
			$description = '';
			$lock = '';
			$upload = '';
			$group = '';
		}
		if($lock){
		?>
		<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr align="left">
          <td width="80">Username:            </td>
          <td><input name="txtUser" type="text" id="txtUser"></td>
        </tr>
        <tr align="left">
          <td width="80">Password:            </td>
          <td><input name="txtPass" type="password" id="txtPass2"></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
              <input type="hidden" name="lsalbum" value="<?php echo $_POST['lsalbum'];?>">
              <input name="action" type="hidden" id="action" value="UnLock">
            <input name="cmdGo" type="submit" id="cmdGo" value="Next"></td>
        </tr>
      </table>
		<?
		}else{
			echo 'The Feed:<br>';
			echo '<input name="txtURL" id="txtURL" type="text" readonly="true" style="width: 200px;" value="http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-13).'rss.php?album='.$_POST['lsalbum'].'"><br>';
			echo '<input name="cmdClose" type="button" value="Close" style="margin-top: 1px;" OnClick="window.close();">';
			echo '<script language="javascript" type="text/javascript">document.getElementById(\'txtURL\').select();</script>';
			echo '<link rel="alternate" type="application/rss+xml" title="Imageview 5 :: '.$_POST['lsalbum'].'" href="http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-13).'rss.php?album='.$_POST['lsalbum'].'">';
		}
	}
	if($_POST['action'] == 'UnLock'){
		require('admin/classes/class.crypt.php');
		//create Crypto
		$crypto = new Crypto();
		$crypto->password = 'imageview';
		//round One
		$_POST['txtUser'] = $crypto->encrypt($_POST['txtUser']);
		$_POST['txtPass'] = $crypto->encrypt($_POST['txtPass']);
		//round Two
		$_POST['txtUser'] = $crypto->encrypt($_POST['txtUser']);
		$_POST['txtPass'] = $crypto->encrypt($_POST['txtPass']);
		echo 'The Feed:<br>';
		echo '<input name="txtURL" id="txtURL" type="text" readonly="true" style="width: 200px;" value="http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-13).'rss.php?album='.$_POST['lsalbum'].'&UID='.$_POST['txtUser'].$_POST['txtPass'].'"><br>';
		echo '<input name="cmdClose" type="button" value="Close" style="margin-top: 1px;" OnClick="window.close();">';
		echo '<script language="javascript" type="text/javascript">document.getElementById(\'txtURL\').select();</script>';
		echo '<link rel="alternate" type="application/rss+xml" title="Imageview 5 :: '.$_POST['lsalbum'].'" href="http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-13).'rss.php?album='.$_POST['lsalbum'].'&UID='.$_POST['txtUser'].$_POST['txtPass'].'">';
	}
	?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
