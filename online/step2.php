<?php
// Teste la session
session_start();
if (!isset($_SESSION['email'])) {
	header("Location: step1.php");
	exit(0);
} else
	$email = $_SESSION['email'];

if (isset($_SESSION['code'])) {
	header("Location: step3.php");
	exit(0);
}

// Récupération des fonctions principales
require_once('php/functions.php');
	
// Initialisation des erreurs
$_POST['erreur'] = false;

if (isset($_POST['confirmer'])) {
	if (valide($email, $_POST['codeEnvoye'])) {
		valider($email);
		$_SESSION['code'] = $_POST['codeEnvoye'];
		header("Location: step3.php");
		exit(0);
	} else {
		$_POST ['erreur'] = true;
		$_POST ['message'] = "Le code de validation n'est pas correct !";
	}
}

if (isset($_POST['renvoyer'])) {
	nouveauCode($email);
	$_POST ['message'] = "Un nouveau code de validation vous a été envoyé !";
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
					<h2>Etape 2/4 - Validation de l'adresse email</h2>
					<div class="progress">
						<div class="progress-bar progress-bar-striped active"
							role="progressbar" aria-valuenow="50" aria-valuemin="0"
							aria-valuemax="100" style="width: 50%">							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row vertical-offset-50">
			<div class="col-lg-offset-1 col-lg-3">
				<p>Un email vient de vous être envoyé, veuillez saisir le code que
					vous avez reçu.</p>
				<form class="form" action="step2.php" method="POST">
					<div class="form-group">
						<label for="codeEnvoye">Code de validation :</label> <input
							type="text" class="form-control" name="codeEnvoye" value="">
					</div>
					<div class="pull-right">
						<button type="submit" name="renvoyer[]" class="btn btn-success">Renvoyer
							le code</button>
						<button type="submit" name="confirmer[]" class="btn btn-success">Valider</button>
					</div>
				</form>
			</div>
		</div>
		<div id="message" class="row vertical-offset-50">
			<div class="col-lg-offset-1 col-lg-3">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>