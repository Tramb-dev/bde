<?php
// On d�marre la session
session_start();
$loginOK = false;  // cf Astuce

// On n'effectue les traitement qu'� la condition que
// les informations aient �t� effectivement post�es
if ( isset($_POST) && (!empty($_POST['login'])) && (!empty($_POST['pwd'])) ) {

  extract($_POST);  // je vous renvoie � la doc de cette fonction
mysql_connect("localhost", "root", "");
mysql_select_db("test");
  // On va chercher le mot de passe aff�rent � ce login
  $sql = "SELECT * FROM session WHERE login = '".addslashes($login)."'";
  $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);
 
  // On v�rifie que l'utilisateur existe bien
  if (mysql_num_rows($req) > 0) {
     $data = mysql_fetch_assoc($req);
   
    // On v�rifie que son mot de passe est correct
    if ($_POST['pwd'] == $data['mdp']) {
      $loginOK = true;
    }
  }
}

// Si le login a �t� valid� on met les donn�es en sessions
if ($loginOK) {
  $_SESSION['login'] = $data['login'];
  $_SESSION['pwd'] = $data['mdp'];
  header ('location: admin/admin_bde.php');
}
else {
			echo '<body onLoad="alert(\'Mauvais login/mot de passe !\')">';
            // puis on le redirige vers la page d'accueil
            echo '<meta http-equiv="refresh" content="0;URL=./index.php">';
}
?>