<?php
mysql_connect("localhost", "bde-isbp", "MBRT3Y88");
mysql_select_db("bde-isbp");

// On r�cup�re les 3 derni�res news
$retour = mysql_query('SELECT * FROM news ORDER BY id DESC LIMIT 0, 3');
while ($donnees = mysql_fetch_array($retour))
{
?>

<div class="news">
    <p><h3>
        <?php echo stripslashes($donnees['titre']); ?>
		<strong>par <?php echo stripslashes($donnees['pseudo']); ?></strong>
        <em>le <?php echo date('d/m/Y � H\hi', $donnees['timestamp']); ?></em>
    </h3></p>
   
    <p>
    <?php
    // On enl�ve les �ventuels antislash PUIS on cr�e les entr�es en HTML (<br />)
    $contenu = nl2br(stripslashes($donnees['contenu']));
    echo $contenu;
    ?>
    </p>
</div>
<?php
} // Fin de la boucle des news
?>