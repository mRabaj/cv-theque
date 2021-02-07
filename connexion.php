<?php
session_start();


require_once "functions/functions.php";

$datas=readCsv("csv/users.csv", ";");
if ($datas === false) {
  echo "ERREUR";
  exit;
}

$message="";

/* processus de déconnexion alors on vide la session et la cookie */
if (isset($_GET["action"])&&$_GET["action"]=="disconnect") {
  unset($_SESSION["name"]);
  if (isset($_COOKIE["connect"])) {
    
    setcookie("connect", NULL, 0, null, null, null, null);
  }
}

	/* si processus d'inscription tout juste finalisé message de confirmation */
	if (isset($_GET["register"])&&$_GET["register"]=="ok") {
		$message="Votre inscription a bien été effectuée. Veuillez vous connecter.";
  }
  
/* si processus de mot de passe perdu tout juste finalisé message de confirmation */
if (isset($_GET["resetpwd"])&&$_GET["resetpwd"]=="ok") {
  $message="La modification de votre mot de passe a bien été effectuée. Veuillez vous connecter.";
}

/* si un cookie existe on vérifie si celui-ci est valide et on connecte automatiquement la personne */
if (isset($_COOKIE["connect"])&&$_COOKIE["connect"]) {
  if (verifyToken($datas,$_COOKIE["connect"])) 
  {
    header("Location:index.php");
  }
}

/* si le compte est vérifié après saisie d'identifiant et mot de passe, on crée la session pour ce compte et on redirige vers la page d'accueil
	Si la case restez connecté est coché on crée le cookie pour authentifier automatiquement à la prochaine ouverture de la page dans le navigateur */
if ($_POST){
  
  $verify=verifyAccount($datas,$_POST["mail"],$_POST["pwd"]);
  if ($verify) {
    if (isset($_POST["remember"])&&$_POST["remember"]) {
      setcookie("connect", $verify, time() + (86400),null, null, false, true); // 86400 = 1 day	
    }

   header("Location:index.php");
  } else {
    $error="Identifiants incorrects";
  }

}

?>


<!DOCTYPE html>
<html>
<head>
	<title>CV-Thèque</title>
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
		

<section>	
		<div class="container">
		
<form action="connexion.php" method="post">
  <h1>CV-Thèque</h1>
  <div class="imgcontainer">
    <img src="http://placehold.it/150x150" alt="Avatar" class="avatar">
  </div>

  <div class="info" tabindex="0">
  <span class="infoicon">
    <i class="fa fa-info"></i>
  </span>
  <h1 class="titre_id">Important :</h1>
  <p class="description">Pour accéder à la démo, il vous faut les informations de connexion. Celles-ci sont les suivantes : login « admin » et mot de passe « admin »</p>
  
</div>
<b><?= $message ?></b>
  <article class="identifiant">
    <label for="idconnexion"><b>Email</b></label>
    <input type="text" placeholder="Votre login" name="mail" required value="<?php if (isset($_POST['mail'])&& $_POST['mail']){print $_POST['mail'];} ?>">

    <label for="pwd"><b>Mot de passe</b></label>
    <input type="password" placeholder="Votre mot de passe" name="pwd" required>

    <button class="btn" type="submit">Connexion</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Restez connectés
    </label>
  </article>

  <div class="container2" style="background-color:#f1f1f1">
    <span class="btn" type="button" class="register">Pas encore de compte ? <a href="register.php">Inscrivez-cous !</a> </span>
    <span class="psw"> Mot de passe <a class="reference" href="forgot-password.php">oublié </a> ?</span>
  </div>
  <footer>
		<p>&copy; 2020</p>
	</footer>
</form>

</div>	
	<div class="photo">
		<img src="http://placehold.it/600x900" >		

	</div>
	</section>
	
</body>
</html>