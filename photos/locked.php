<?php
	if(isset($_POST['login'])){
		require('albums/'.$_POST['album'].'/data.dat');
		require('admin/classes/class.crypt.php');
		//create Crypto
		$crypto = new Crypto();
		$crypto->password = 'imageview';
		//encrypt the user and pass
		$_POST['txtusername'] = $crypto->encrypt($_POST['txtusername']);
		$_POST['txtpassword'] = $crypto->encrypt($_POST['txtpassword']);
		//check if its correct
		if($user_alb == $_POST['txtusername'] && $passwd_alb == $_POST['txtpassword']){
			if(isset($_POST['remember'])){
				setcookie("authID", $_POST['album'],time()+60*60*24*30,"/");
			}else{
				setcookie("authID", $_POST['album'],0,"/");
			}
			if($_POST['file'] <> ''){
				echo '<meta http-equiv="refresh" content="0; URL=fileview.php?album='.$_POST['album'].'&file='.$_POST['file'].'">';
			}else{
				echo '<meta http-equiv="refresh" content="0; URL=albumview.php?album='.$_POST['album'].'">';
			}
			exit;
		}else{
			$_GET['album'] = $_POST['album'];
			$_GET['file'] = $_POST['file'];
			$_GET['msg'] = '<center><font color="red"><b>Login Failed!</b></font></center>';
		}
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Imageview 5 :: Locked Album</title>
<link href="data/style/user.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
	if(!isset($_GET['album'])){
		echo 'No album specified!';
	}else{
?>
<table width="350" height="250" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="70" valign="baseline" background="data/images/login_header.png">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	<form action="locked.php" method="post" name="frmLogin" target="_self" id="frmLogin">
		<?php if(isset($_GET['msg'])){ echo $_GET['msg']; } ?>
        <table width="240" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr>
            <td>Album:</td>
            <td><?php echo $_GET['album']; ?></td>
          </tr>
          <tr>
            <td width="80">Username:</td>
            <td><input name="txtusername" type="text" id="txtusername" title="Album UID"></td>
          </tr>
          <tr>
            <td width="80">Password:</td>
            <td><input name="txtpassword" type="password" id="txtpassword" title="Album Password"></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
                <input name="remember" type="checkbox" id="remember" value="1">
            Remember Me </div></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
                <input name="login" type="submit" id="login" value="Login">
                <input name="album" type="hidden" id="album" value="<?php echo $_GET['album']; ?>">
                <input name="file" type="hidden" id="file" value="<?php echo $_GET['file']; ?>">
            </div></td>
          </tr>
        </table>
    </form>
	</td>
  </tr>
</table>
<?php
	}	
?>
</body>
</html>
