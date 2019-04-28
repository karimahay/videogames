<?php
// Connexion à BD videogames

// $dsn = 'mysql:host=localhost; dbname=videogames';
// $user = 'root';
// $pass= '';
// $options=array(
// 	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
// );

$objPDO = new PDO($dsn, $user, $pass, $options);

// Requete d'insertion 
$PDOstat=$objPDO->prepare('INSERT INTO videogames VALUES (NULL, :Titre, :Version, :Plateform, :published, :developed)');
// on va lier chaque champs saisie à une valeur

$PDOstat=bindValue(':Titre', $_POST['Titre'], PDO::PARAM_STR);
$PDOstat=bindValue(':Version', $_POST['Version'], PDO::PARAM_STR);
$PDOstat=bindValue(':Plateform', $_POST['Plateform'], PDO::PARAM_STR);
$PDOstat=bindValue(':published', $_POST['published'], PDO::PARAM_STR);
$PDOstat=bindValue(':developed', $_POST['developed'], PDO::PARAM_STR);




?>