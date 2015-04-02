<?php
// Teste la session
session_start();
if (isset($_SESSION['email'])) {
	header("Location: step2.php");
	exit(0);
}

// Récupération des fonctions principales
require_once('php/functions.php');

// Initialisation des erreurs
$_POST ['erreur'] = false;

if (isset($_POST['valider'])) {
	if ($_POST['email'] === $_POST['email2']) {
		if (! test ( $_POST['email'] )) {
			ajouterUtilisateur($_POST['email']);
			$_SESSION['email'] = $_POST['email'];
			header("Location: step2.php");
			exit(0);
		} else {
			$_POST ['erreur'] = true;
			$_POST ['message'] = "Vous avez déjà fait vos préinscriptions !";
		}
	} else {
		$_POST ['erreur'] = true;
		$_POST ['message'] = "Les emails ne correspondent pas !";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<title>Rallye de la fête des vins</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-1">
				<div class="page-header">
					<h2>Etape 1/4 - Saisie de l'adresse email</h2>
					<div class="progress">
						<div class="progress-bar progress-bar-striped active"
							role="progressbar" aria-valuenow="10" aria-valuemin="0"
							aria-valuemax="100" style="width: 10%">							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row vertical-offset-50">
			<div class="col-lg-offset-1 col-lg-4">
				<form class="form" action="step1.php" method="POST">
					<div class="form-group">
						<label for="email">Votre adresse email :</label> <input
							type="email" class="form-control" name="email"
							placeholder="exemple@mail.fr" autofocus required>
					</div>
					<div class="form-group">
						<label for="email2">Ressaisissez votre adresse email :</label> <input
							type="email" class="form-control" name="email2"
							placeholder="exemple@mail.fr" required>
					</div>
					<button type="submit" name="valider[]"
						class="btn btn-success pull-right">Valider</button>
				</form>
			</div>
		</div>
		<div id="message" class="row vertical-offset-50">
			<div class="col-lg-offset-1 col-lg-4">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>