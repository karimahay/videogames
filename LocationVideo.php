<!-- Connection à la base de donnée videogames -->
<?php

session_start();

$dsn = 'mysql:host=localhost; dbname=videogames';
$user = 'root';
$pass= '';
$options=array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
$ittissal = new PDO($dsn, $user, $pass, $options);
try{
	$ittissal = new PDO($dsn, $user, $pass, $options);
	$ittissal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} 
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}
// Login
if (!empty($_POST)) {
	extract($_POST);
	$valid=true;
	$pseudo=htmlspecialchars(trim($pseudo));
	$password=trim($password);

	if (empty($pseudo)) {
		$valid=false;
		$error_pseudo="Veuillez renseigner votre pseudo";
	}
	if (empty($password)) {
		$valid=false;
		$error_pseudo="Veuillez renseigner votre Mot de passe";
	}
	$requete = $ittissal->query('SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND password = :password', array('pseudo => $pseudo , password => $password'));
	// $requete =$requete->fetch();

	if (!$requete['pseudo']) {
		$valid=false;
		$error_pseudo="votre Mot de passe ne correspond pas";
		}
		if ($valid) {
			$_SESSION['id']= $requete['id'];
			$_SESSION['pseudo']= $requete['pseudo'];
			$_SESSION['password']= $requete['password'];

			header('Location: lister.php');
			exit();
		}
}

	?>


	<!DOCTYPE html>
	<html lang="fr">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="styleLogin.css">
		<title>Location Jeux Videos</title>


	</head>
	<body>
		<div class="Titre">
			<img src="Titre 2.png" style="width: 300px; height: 90px;">
		</div>
		<div class="container">
			<div class="header">
				<img src="40816fd4d6ee935902d99f20ccd2a690.png" style="width: 150px; height: 200px;">

				<form method="POST" action="#">

					<input type="text" name="pseudo" placeholder="Entrez votre identifiant" style="height: 20px; width: 300px;"/>	
					<br><br>	
					
					<input type="password" name="password" placeholder="Entrez votre mot de passe"style="height: 20px; width: 300px;" />				
					<br><br>

					<input type="submit" name="submit" value="Se Connecter" class="btn-login" style="height: 20px; width: 180px;" />
				</form>
			</div>
		</body>
		</html>