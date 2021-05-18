<?php
include '../php/logo.php';
include '../php/titre.php';
include '../php/menu.php';
include '../php/defilement.php';
?>
<title>Contact du Bureau des El&egrave;ves de l'ISBP</title>
<style type="text/css">
<!--
.Layer1 {
	position:absolute;
	width: 60%;
	height: 70%;
	z-index:1;
	left: 30%;
	top: 200px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #339999;
}

-->
</style>
<!-- On utilise javascript pour crypter les adresses mails et éviter ainsi le spam -->
<script language='JavaScript' type='text/javascript'>
var pref1 = 'bertrand';
var pref2 = 'rav';
var suff = 'hotmail.com';
var pref3 = 'bde.isbp';
var suff2 = 'gmail.com'
function mailto2()
{  
	document.location.href = "mailto:" + pref1 + '_' + pref2 + "@" + suff;
}
function mailto1()
{
	document.location.href = "mailto:" + pref3 + "@" + suff2;
}
</script>
<div class="Layer1">
	<div align="center">
		Si vous désirez nous contacter pour de plus amples informations, vous pourrez nous joindre au :<br/><br/>
		BDE ISBP<br/>
		66, rue guy mocquet<br/>
		94800, Villejuif<br/>
		<a href="javascript:mailto1()">..::bde.isbp@gmail.com::..</a><br/>
		Vous pourrez nous retrouver simplement dans notre école ou dans notre local à cette même adresse.<br/><br/>
	Pour des questions sur le site n'hésitez pas mailez-moi à cette <a href="javascript:mailto2()">adresse</a>.
	</div>
</div>
<?php
include '../php/copyright.php';
?>