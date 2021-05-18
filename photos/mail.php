<?php
require('admin/config.php');
if($mail == '0'){
	echo '<meta http-equiv="refresh" content="0; URL=index.php">';
	exit;
}
/*

Attachment Mailing Program Version 1.0
Copyright (c) 2003 David Hamilton All rights reserved.
This program is free for any non-commercial use.
Visit www.potentialcreations.com for more PHP solutions!

COMMERICAL USERS:
If you use this program for a commerical use, or use
it as part of a commerical project you must:
A)Provide a a link to: www.potentialcreations.com
B)Contact sales@potentialcreations.com for a low-cost license.

DISCLAIMER 

THIS SOFTWARE IS PROVIDED ON AN "AS-IS" BASIS WITHOUT WARRANTY OF ANY KIND.
DEVELOPER SPECIFICALLY DISCLAIMS ANY OTHER WARRANTY, REPRESENTATION OR CLAIM 
EXPRESS OR IMPLIED, INCLUDING ANY WARRANTY OF MERCHANTABILITY, ACCURACY, QUALITY, 
PERFORMANCE, OR FITNESS FOR A PARTICULAR PURPOSE. IN NO EVENT SHALL 
THE DEVELOPER BE HELD LIABLE FOR ANY DAMAGES OF ANY KIND RESULTING FROM THE DIRECT, 
OR INDIRECT USE OR MISUSE OF THIS SOFTWARE. BY USING THIS SOFTWARE YOU AGREE TO 
HOLD THE DEVELOPER HARMLESS FROM AND AGAINST ANY AND ALL CLAIMS, LOSSES, 
LIABILITIES AND EXPENSES , EVEN IF DEVELOPER HAS BEEN ADVISED OF 
THE POSSIBILITY OF SUCH POTENTIAL LOSS OR DAMAGE.

*/


function mail_attach($to,$from,$subject,$body,$fname,$data,$priority=3,$type="Application/Octet-Stream"){
				 
			 $mime_boundary = "<<<:" . md5(uniqid(mt_rand(), 1));
             $fdata = chunk_split(base64_encode($data));
             
             $headers .= "From: $from\r\n";
             $headers .= "To: $to\r\n";
             $headers .= "MIME-Version: 1.0\r\n";
			 $headers .= "X-Priority: $priority\r\n";
             $headers .= "Content-Type: multipart/mixed;\r\n";
             $headers .= " boundary=\"" . $mime_boundary . "\"\r\n";
             $mime = "This is a multi-part message in MIME format.\r\n";
             $mime .= "\r\n";
             $mime .= "--" . $mime_boundary . "\r\n";
             $mime .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
             $mime .= "Content-Transfer-Encoding: 7bit\r\n";
             $mime .= "\r\n";
             $mime .= $body . "\r\n";
             $mime .= "--" . $mime_boundary . "\r\n";
             $mime .= "Content-Disposition: attachment;\r\n";
             $mime .= "Content-Type: $type; name=\"$fname\"\r\n";
             $mime .= "Content-Transfer-Encoding: base64\r\n\r\n";
             $mime .= $fdata . "\r\n";
             $mime .= "--" . $mime_boundary . "\r\n";
             mail($to, $subject, $mime, $headers);
}
?>
<html>
<head>
<title>Imageview 5 :: Mail</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="data/style/user.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20"><table width="60" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60"><a href="fileview.php?album=<?php echo $_GET['album']; ?>&file=<?php echo $_GET['file']; ?>" target="_self"><img src="data/images/icons/back.png" width="20" height="20" border="0" align="left">Back</a></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
<?php
  if($_GET['action'] == 'send'){
	$message = 'Hello '.$_GET['txtname'].',
	You have recieved an image from '.$_GET['txtfromname'].'.
	You will find the '.$_GET['file'].' attached to this message.
	
	-----------------------------------------------
	Imageview :: http://www.blackdot.be';
	$filename='albums/'.$_GET['album'].'/'.$_GET['file'];
	$fh=fopen($filename,"r");
	$data=fread($fh,filesize($filename));
	mail_attach($_GET['txtmail'],'Imageview@blackdot.be','Imageview :: '.$_GET['file'],$message,$_GET['file'],$data,3);
  	echo '<center>E-mail has been send to:&nbsp;'.$_GET['txtmail'].'</center>';
  }else{
?>
	  <form name="frmmail" id="frmmail" method="get" action="mail.php">
	  <table width="300"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
	    <td colspan="2" style="border-bottom-color: #000000; border-bottom-color: #000000; border-bottom-style: solid; border-bottom-width: 1px;">From:</td>
	    </tr>
	  <tr> 
	   <td width="50">Name:</td>
	   <td><input name="txtfromname" type="text" id="txtfromname" style="width: 250px;"></td>
	  </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="2" style="border-bottom-color: #000000; border-bottom-color: #000000; border-bottom-style: solid; border-bottom-width: 1px;">To:</td>
	    </tr>
	  <tr>
	  <td width="50">Name:</td>
	  <td width="150"><input name="txtname" type="text" style="width: 250px;"></td>
	  </tr>
	  <tr>
	  <td width="50">E-mail:</td>
	  <td width="150"><input name="txtmail" type="text" style="width: 250px;">	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">Attachement: <?PHP echo $_GET['file']; ?></td>
	    </tr>
	  <tr>
	  <td colspan="2"><center>
	  <input name="submit" type="submit" class="button" id="action" value="Send"><input name="file" type="hidden" value="<?php echo $_GET['file']; ?>"><input name="album" type="hidden" value="<?php echo $_GET['album']; ?>"><input name="action" type="hidden" value="send">
	  </center></td>
	  </tr>
	  </table>
	  </form>
<?php
	}
?>
	</td>
  </tr>
</table>
</body>
</html>
