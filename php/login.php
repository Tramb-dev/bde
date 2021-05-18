<?php
// On démarre la session
session_start();
$loginOK = false;  // cf Astuce

// On n'effectue les traitement qu'à la condition que
// les informations aient été effectivement postées
if ( isset($_POST) && (!empty($_POST['login'])) && (!empty($_POST['pwd'])) ) {

  extract($_POST);  // je vous renvoie à la doc de cette fonction
mysql_connect("localhost", "root", "");
mysql_select_db("test");
  // On va chercher le mot de passe afférent à ce login
  $sql = "SELECT * FROM session WHERE login = '".addslashes($login)."'";
  $req = mysql_query($sql) or die('Erreur SQL : <br />'.$sql);
 
  // On vérifie que l'utilisateur existe bien
  if (mysql_num_rows($req) > 0) {
     $data = mysql_fetch_assoc($req);
   
    // On vérifie que son mot de passe est correct
    if ($_POST['pwd'] == $data['mdp']) {
      $loginOK = true;
    }
  }
}

// Si le login a été validé on met les données en sessions
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