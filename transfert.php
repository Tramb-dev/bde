<?php
//la fonction en question
function suppression($dossier_traite)
{
//on ouvre le dossier
$repertoire = opendir($dossier_traite);

//on lance notre boucle qui lira les fichiers un par un
        while(false !== ($fichier = readdir($repertoire)))
        {
        //on met le chemin du fichier dans une variable simple
        $chemin = $dossier_traite."/".$fichier;
               
                //les variables qui contiennent toutes les infos nécessaires
                $infos = pathinfo($chemin);
               
//on n'oublit pas LA condition sous peine d'avoir quelques surprises :p
                if($fichier!="." AND $fichier!=".." AND !is_dir($fichier))
                {
                unlink($chemin);
                }
        }
closedir($repertoire); //on ferme !
}
$recherche_dossier = opendir("../creation");
$infos = array();
while(false != ($fichier = readdir($recherche_dossier)))
	{
	$infos = pathinfo($fichier);
	if ($_FILES['icone']['name'] == $infos['basename'])
	suppression($fichier);
	}
closedir($recherche_dossier);
if ($_FILES['icone']['error'] > 0) $erreur = "Erreur lors du tranfsert";
$dir = "../creation";
$resultat = move_uploaded_file($_FILES['icone']['tmp_name'], $dir);
if ($resultat) echo "Transfert réussi";
?>


<div align="center">
<form method="post" action="transfert.php" enctype="multipart/form-data">
<input type="file" name="upl" />
<input type="submit" value="OK" />
</form>
</div>

