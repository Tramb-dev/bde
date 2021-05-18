<?php
mysql_connect("localhost", "bde-isbp", "MBRT3Y88");
mysql_select_db("bde-isbp");

// On récupère les 3 dernières news
$retour = mysql_query('SELECT * FROM news ORDER BY id DESC LIMIT 0, 3');
while ($donnees = mysql_fetch_array($retour))
{
?>

<div class="news">
    <p><h3>
        <?php echo stripslashes($donnees['titre']); ?>
		<strong>par <?php echo stripslashes($donnees['pseudo']); ?></strong>
        <em>le <?php echo date('d/m/Y à H\hi', $donnees['timestamp']); ?></em>
    </h3></p>
   
    <p>
    <?php
    // On enlève les éventuels antislash PUIS on crée les entrées en HTML (<br />)
    $contenu = nl2br(stripslashes($donnees['contenu']));
    echo $contenu;
    ?>
    </p>
</div>
<?php
} // Fin de la boucle des news
?>