<!-- Connection à la base de donnée videogames -->

<?php
$dsn = 'mysql:host=localhost; dbname=videogames';
$user = 'root';
$pass= '';
$options=array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$ittissal = new PDO($dsn, $user, $pass, $options);

$pdostat=$ittissal->prepare('SELECT * FROM videogames');
$executeIsOk=$pdostat->execute();



// pagination
$ligneParPage = 10;
$videoTotalReq= $ittissal->query('SELECT id FROM videogames');
$ligneTotal=$videoTotalReq->rowCount();
$pagesTotal= ceil($ligneTotal/$ligneParPage);

if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] >0 AND $_GET['page'] <= $pagesTotal) {
	$_GET['page']= intval($_GET['page']);
	$pageCourante= $_GET['page'];
}else{
	$pageCourante=1;
}

$depart=($pageCourante-1)*$ligneParPage;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="styleBD.css">
	<link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Exo+2|Kanit|Merriweather+Sans" rel="stylesheet">
</head>
<body>

	<!-- LOGO et menu -->
	<div class="header" >
		
		<img src="40816fd4d6ee935902d99f20ccd2a690.png" id="phoenix">
		<img src="Titre 2.png" id="titree">
		<nav>
			<ul>
				<li><a href="#affiche" > Afficher </a></li>
				<li><a href="#modifier"> Modifier</a></li>
				<li><a href="#ajout"> Ajouter</a></li>
				<li><a href="#Supprimer"> Supprimer</a></li>
			</ul>
		</nav>
		<!-- La barre de recherche -->
		<form  method="GET" >
			<input id="chercher" type="search" name="q" placeholder="Recherche par titre" style="margin-left: -50%;"/>
			<input id ="boutton" type="submit" value="Valider" style="width: 100px; background-color:#6E0B14; color: white;" />
		</form>		
	</div>

	<!-- Barre recherche php-->
	<?php
	$jeux=$ittissal->query('SELECT Title FROM videogames ORDER BY id');
	if (isset($_GET['q']) AND !empty($_GET['q'])) {
		$q=htmlspecialchars($_GET['q']);
		$jeux=$ittissal->query('SELECT Title FROM videogames WHERE Title LIKE "%'.$q.'%" ORDER BY id');		
	}
	?>
	


	<!-- Le programme contiendra les sections: Afficher / Modifier / Ajouter / Supprimer   -->


	<section id="affiche"> 
		<!-- Matrice d'affichage des champs demandés -->
		<content class="container">
			<table align="center">
				<tr align="center" id="entete">
					<th>Réf</th>
					<th>Titre</th>
					<th>Version</th>
					<th>Plateforme</th>
					<th>Publié par</th>
					<th>Développé par</th>
				</tr>

				<!-- Interroger la base de donnée videogames -->
				<?php

				$videog = $ittissal->query('SELECT *
					FROM developers INNER JOIN videogames ON developers.id=videogames.idDeveloper ORDER BY videogames.id LIMIT '.$depart.', '.$ligneParPage);

				$platform = $ittissal->query('SELECT *
					FROM platform INNER JOIN videogames ON platform.id=videogames.idPlatform
					ORDER BY videogames.id LIMIT '.$depart.', '.$ligneParPage);

				$editeurs = $ittissal->query('SELECT *
					FROM publishers INNER JOIN videogames ON publishers.id=videogames.idPublisher
					ORDER BY videogames.id LIMIT '.$depart.', '.$ligneParPage);


// Afficher la liste des jeux videos dispo dans un tableau
			
				while ($infos = $videog->fetch()) 
					{    $platforme = $platform->fetch();
						$edits = $editeurs->fetch(); 
						?>

						<tr align="center">
							<td class="id" style="border-color: black;"><p><?=$infos['id']?></p></td>
							<td class="intitulé"><p><?=$infos['Title']?></p></td>
							<td class="release"><p><?=$infos['ReleaseDate']?></p></td>
							<td class="nom"><p><?=$platforme['name']?></p></td>
							<td class="publishers"><p><?=$edits['name']?></p></td>
							<td class="developers"><p><?=$infos['name']?></p></td>
						</tr>

						<?php
						}
						?>

				</table>
			</content>
		</section>
		<!-- suite pagination / Affichage numero de pages -->
		<?php
		for ($i=1; $i<=$pagesTotal ; $i++) { 
			if ($i==$pageCourante) {
				echo $i.' <> ';
			}else{
				echo '<a href="lister.php?page='.$i.'  ">  '.$i.'</a> || ';

			}
		}
		?>

		<!-- Modifier un jeu video via un fomulaire -->
<!-- <section id="modifier">
	
</section>
-->
<!-- Ajouter un jeu video via un fomulaire -->
<!-- <section id="ajout">
	<form action="add.php" method="POST">
		<table border="0" align="center" cellspacing="6" cellpadding="5">
			<tr align="left">
				<td>Titre</td>
				<td><input type="text" name="Titre"></td>
			</tr>
			<tr align="left">
				<td>Version</td>
				<td><input type="text" name="Version"></td>
			</tr>
			<tr align="left">
				<td>Plateforme</td>
				<td><input type="text" name="Plateforme"></td>
			</tr>
			<tr align="left">
				<td>Publié par</td>
				<td><input type="text" name="published"></td>
			</tr>
			<tr align="left">
				<td>développé par</td>
				<td><input type="text" name="developed"></td>
			</tr>
			<tr align="left">
				<td>Constructeur</td>
				<td><input type="text" name="constract"></td>
			</tr>

			<tr align="center">
				<td colspan="2" ><input type="submit" value="Ajouter" style="border-radius: 5%; width: 100px;"></td>
			</tr>
		</table>
	</form>
	
</section>

-->


</body>
</html>