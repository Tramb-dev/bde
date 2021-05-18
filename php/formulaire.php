<?php
include 'titre.php';
include 'logo.php';
include 'menu.php';
include 'defilement.php';
?>
<title>Contactez-nous</title>
<style type="text/css">
<!--
label {
	font-family: "Courier New", Courier, monospace;
	font-style: italic;
	color: #FFFFFF;
	text-align: center;
}

-->
</style>
<?php


if ($_POST['id'] == '')
{
	?>

	<form method="post" action="formulaire.php">
	   <p>
	   <label>Votre adresse email :<br/>
	   <input type="text" name="adresse_client" tabindex="10" />
	   </label><br/><br/>
	   <label>Ecrivez ici :<br/>
	   <textarea name="message" rows="20" cols="100" tabindex="20" ></textarea>
	   </label>
	   <input type="hidden" name="id" value="1" />
	   <input type="hidden" name="to_adresse" value="webmaster" />
	   <input type="hidden" name="objet" value="Message du site du BDE Adrénaline" />
	   <input type="submit" value="Envoyer" />
	   </p>
	</form>

	
	<?php
}
elseif ($_POST['id'] == 1)
{
	// La variable $verif, va nous permettre d'analyser si la sémantique de l'email est bonne
	$verif = '#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#';

	// On assigne et protége nos variables
	$votremail = $_POST['adresse_client'];
	$from = htmlentities('From: '.$votremail);
	$message = stripslashes(htmlentities($_POST['message']));

	if ($_POST['to_adresse'] == 'bde')
	{
		$destinataire = 'bde.isbp@gmail.com';
	}
	elseif ($_POST['to_adresse'] == 'webmaster')
	{
		$destinataire = 'bertrand_rav@hotmail.com';
	}
	else
	{
	echo 'petit malin va ... tu as essayé de m\avoir ? Que je ne t\'y reprennes plus !';
	}

	/* On place le sujet du message qui ici sera toujours le même puisque dans la partie Html on l'a mis en caché grace au type="hidden";) avec comme valeur "Vous avez un nouveau message"  */
	$objet = $_POST['objet'];

	// C'est bon on est OK, vérifions si l'email est valide, grâce à notre sympathique REGEX
	if(!preg_match($verif,$votremail))
	{
	        echo 'Votre email n\'est pas valide';
	}

	// On verifie si il y a un message
	elseif (trim($message)=="")
	{
	        echo 'Veuillez remplir le champ';
	}

	// Si tout est OK on envoie l'email
	else
	{
	        mail('bertrand_rav@hotmail.com',$objet,$message,$from);
			echo 'Le message a bien été envoyé. Pour retourner à la page d\'accueil, cliquez'?> <a href="../index.php" tabindex="2" title="Accueil">ici</a><?php ;
	}

}
?>