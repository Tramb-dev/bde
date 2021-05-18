<?php


if (isset($_GET['login']) AND isset($_GET['mot_de_passe'])) // on verifie si les variables existent
{
	if ($_GET['login'] != NULL AND $_GET['mot_de_passe'] != NULL) // on vérifie si les variables contiennent quelque chose
	{
	mysql_connect("localhost", "root", "");
	mysql_select_db("test");
    
	// On récupère les infos
    $retour = mysql_query('SELECT * FROM session WHERE login=' . $_GET['login']);
    $donnees = mysql_fetch_array($retour);
	
	$login = $donnees['login'];
	$mot_de_passe = $donnees['mot_de_passe'];
    $admin_bde = $donnees['admin_bde'];
	
	// On compare les deux mots de passe
		if ($_GET['mot_de_passe'] == $mot_de_passe) 
		{
		$id_news = $donnees['id'];
		?>
			<SCRIPT LANGUAGE="JavaScript">
			function redirect()
			{
			window.location="index.php"
			}
			setTimeout("redirect()",0000); // delai en millisecondes
			</SCRIPT>
		<?php
			while ($admin_bde == yes)
			{ 
				?>
				<html><body>test</body></html>
				<?php
			}
		}
		else
		{
		$id_news = 0;
		mysql_close();
		}
	}
}
?>
<form action="index.php" method="post">

		<p>
		<label>Pseudo : <input type="text" size="10" name="login" tabindex="10" /><br /></label>
		<label>Message :  <input type="password" size="10" name="mot_de_passe" tabindex="20" /><br /></label>

		<input type="submit" value="Envoyer" />
		</p>
		</form>