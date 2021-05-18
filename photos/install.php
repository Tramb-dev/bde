<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Imageview 5 :: Install</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="data/style/user.css">
<style type="text/css">
	html, body{
		height: 100%;
	}
</style>
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
		<?php
			$umaskold = umask(0);
			if(!file_exists('admin/config.php')){
				if(mkdir('albums', 0777)){
					if(touch('admin/config.php')){
						chmod('admin/config.php', 0777); 
						//write default config file
						$nl = "\r\n";
						$tab = "\t";
						$newconf_full = '<?php'.$nl;
						$newconf_full = $newconf_full.$tab.'$username = "9FCEH";'.$nl;
						$newconf_full = $newconf_full.$tab.'$password = "YdSZ";'.$nl;
						$newconf_full = $newconf_full.$tab.'$show_comment = "1";'.$nl;
						$newconf_full = $newconf_full.$tab.'$default_album = "";'.$nl;
						$newconf_full = $newconf_full.$tab.'$view = "thumbnail";'.$nl;
						$newconf_full = $newconf_full.$tab.'$tn_col = "5";'.$nl;
						$newconf_full = $newconf_full.$tab.'$tn_size_width = "100";'.$nl;
						$newconf_full = $newconf_full.$tab.'$tn_size_height = "100";'.$nl;
						$newconf_full = $newconf_full.$tab.'$tn_quality = "80";'.$nl;
						$newconf_full = $newconf_full.$tab.'$imglib = "gd";'.$nl;
						$newconf_full = $newconf_full.$tab.'$magickbin = "";'.$nl;
						$newconf_full = $newconf_full.$tab.'$annotate = "";'.$nl;
						$newconf_full = $newconf_full.$tab.'$annotate_color = "255,255,255";'.$nl;
						$newconf_full = $newconf_full.$tab.'$cache = "0";'.$nl;
						$newconf_full = $newconf_full.$tab.'$resizemenu = "0";'.$nl;
						$newconf_full = $newconf_full.$tab.'$mail = "0";'.$nl;
						$newconf_full = $newconf_full.$tab.'$rss = "1";'.$nl;
						$newconf_full = $newconf_full.$tab.'$smart_tn = "1";'.$nl;
						$newconf_full = $newconf_full.'?>';
						$file = fopen('admin/config.php','w+');
						fwrite($file, $newconf_full);
						fclose($file);
						//end default config
						echo 'Imageview 5 has successfully been installed!<br>Username: <i>admin</i><br>Password: <i>1234</i><br>';
						echo 'Go to: <a target="_parent" href="index.php?admin">Admin</a> - <a target="_parent" href="index.php?help">Help</a>';
					}else{
						echo 'Imageview 5 could not be installed!<br>';
						echo 'Try settings chmod to 0777 for the admin folder!';
						rmdir('albums');
					}
				}else{
					echo 'Imageview 5 could not be installed!<br>';
					echo 'Try settings chmod to 0777 for the main folder.';
				}
			}else{
				@chmod('admin/config.php', 0777); 
				@chmod('albums', 0777); 
				echo 'Imageview 5 has allready been installed!<br><a target="_parent" href="index.php">Back</a>';
			}
			umask($umaskold);
		?>
	</td>
  </tr>
</table>
</body>
</html>
