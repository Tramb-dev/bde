<?php
require('admin/config.php');
//build cookie path
$parts = explode('/', $_SERVER['REQUEST_URI']);
for($i = 0; $i <= count($parts)-2; $i++){
	$path = $path.$parts[$i].'/';
}


//save settings
if(isset($_GET['action'])){
	if(strtolower($_GET['action']) == 'save'){
		if(!isset($_GET['UserInt'])){
			$_GET['UserInt'] = 'normal';
		}
		if(isset($_GET['remember'])){
			setcookie("user_settings", $_GET['mode'].'|'.$_GET['UserInt'],time()+60*60*24*30, $path);
		}else{
			setcookie("user_settings", $_GET['mode'].'|'.$_GET['UserInt'],0,$path);
		}
	}elseif(strtolower($_GET['action']) == 'default'){
		setcookie("user_settings", '',time() - 3600,$path);
	}
	echo '<script type="text/javascript">parent.location.href = "index.php";</script>';
	exit;
}else{
	if(isset($_COOKIE['user_settings'])){
		$user_settings = explode('|', $_COOKIE['user_settings']);
		$view = $user_settings[0]; 
	}
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Imageview 5 :: User Settings</title>
<link href="data/style/user.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" style="border-bottom-color: #000000; border-bottom-style: solid; border-bottom-width: 1px;">
	<table height="20" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="65"><a href="javascript:history.go(-1)" target="_self"><img src="data/images/icons/back.png" width="20" height="20" border="0" align="left">Back</a></td>
		<td width="70"><a href="index.php?admin" target="_parent"><img src="data/images/icons/admin.png" width="20" height="20" border="0" align="left">Admin</a></td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><form action="usercp.php" method="get" name="frmUserSettings" target="_self" id="frmUserSettings"><table width="300" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td colspan="2"  style="border-bottom-color: #000000; border-bottom-color: #000000; border-bottom-style: solid; border-bottom-width: 1px;">User Settings:</td>
      </tr>
      <tr>
        <td width="100">Display Mode: </td>
        <td><select name="mode" id="mode" style="width: 100px;">
          <option value="thumbnail" <?php if($user_settings[0] == 'thumbnail'){ echo 'selected'; }; ?>>Thumbnail</option>
          <option value="list" <?php if($user_settings[0] == 'list'){ echo 'selected'; }; ?>>List</option>
        </select>
          </td>
      </tr>
      <tr>
        <td>User Interface:</td>
        <td><select name="UserInt" id="UserInt" style="width: 100px;">
          <option value="normal" <?php if($user_settings[1] == 'normal'){ echo 'selected'; }; ?>>Normal</option>
          <option value="light" <?php if($user_settings[1]  == 'light'){ echo 'selected'; }; ?>>Light</option>
        </select></td>
      </tr>
      <tr>
        <td colspan="2"><center><input name="remember" type="checkbox" id="remember" value="1">Remember Settings</center></td>
        </tr>
      <tr>
        <td colspan="2" align="center" valign="middle"><input name="action" type="submit" id="action" value="Save">
          <input name="action" type="submit" id="action" value="Default"></td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
</body>
</html>
