<?php
include 'titre.php';
include 'logo.php';
include 'menu.php';
include 'defilement.php';
?>

<style type="text/css">
<!--
#Layer1, background_planning {
	position:absolute;
	width:687px;
	height:421px;
	z-index:1;
	left: 180px;
	top: 120px;
}
-->
</style>

<?php
function choixParDefaut($planning) // Création de la fonction qui garde en mémoire le mois choisi
{
$par_defaut = ''; // On crée une variable (vide par défaut) que l'on retournera à la fin

    if (isset($_POST['planning'])) // Si le visiteur a choisi un mois
    {
        if ($_POST['planning'] == $planning) // Si ce mois correspond au mois que l'on est en train de traiter
        {
            $par_defaut='selected="selected"'; // Alors on modifie la variable que l'on retournera et on lui met selected
        }
    }

return $par_defaut; // On ne retourne rien si ce n'était pas le mois choisi, selected si c'était le bon mois
}

?>
<div id="background_planning">
<img src="fond_calendrier.png" />
</div>
<div id="Layer1">
	<div align="center">
	<form method="post">
	<select name="planning">
	    <option value="septembre" <?php echo ChoixParDefaut('septembre'); ?>>Septembre 2006</option>
		<option value="octobre" <?php echo ChoixParDefaut('octobre'); ?>>Octobre 2006</option>
	    <option value="novembre" <?php echo ChoixParDefaut('novembre'); ?>>Novembre 2006</option>
    	<option value="decembre" <?php echo ChoixParDefaut('decembre'); ?>>Décembre 2006</option>
		<option value="janvier" <?php echo ChoixParDefaut('janvier'); ?>>Janvier 2007</option>
		<option value="fevrier" <?php echo ChoixParDefaut('fevrier'); ?>>Février 2007</option>
		<option value="mars" <?php echo ChoixParDefaut('mars'); ?>>Mars 2007</option>
		<option value="avril" <?php echo ChoixParDefaut('avril'); ?>>Avril 2007</option>
		<option value="mai" <?php echo ChoixParDefaut('mai'); ?>>Mai 2007</option>
		<option value="juin" <?php echo ChoixParDefaut('juin'); ?>>Juin 2007</option>
	</select>
	<input type="submit" value="OK" />
	</form>
	</div>

<?php
if (isset($_POST['planning'])) // On vérifie si le visiteur a déjà choisi un mois
{
	$mois = 'planning/' . htmlentities($_POST['planning']) . '.php';
	include $mois;
}
else
{
	include 'planning/septembre.php';
}
?>
</div>
<?php
include 'copyright.php';
?>
