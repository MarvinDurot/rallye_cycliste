<?php
// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

session_start();
if (isset($_SESSION['email'])) {
	header("Location: step2.php");
	exit(0);
}

// Initialisation des erreurs
$_POST ['erreur'] = false;

// Récupération du DAO
$utilisateurs = new UtilisateursDAO ( MaBD::getInstance () );

// Gestion des événements //

if (isset($_POST['valider'])) {
	if ($_POST['email'] === $_POST['email2']) {
		if (! testDoublon ( $_POST['email'] )) {
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

if (isset($_POST['renvoyer'])) {
	envoyerMailValidation($email);
	$_POST ['message'] = "Un nouveau code de validation vous a été envoyé !";
}

// Fonctions //

/*
 * Teste si un email est déjà présent dans la base
 * @param: un email
 * @return: un booléen
 */
function testDoublon($mail) {
	global $utilisateurs;
	$u = $utilisateurs->getOne ( $mail );
	if ($u === null)
		return false;
	else
		return true;
}

/*
 * Affiche un message d'erreur ou d'information
 */
function afficherMessage() {
	if (isset ( $_POST ['message'] ) && isset ( $_POST ['erreur'] )) {
		if ($_POST ['erreur'])
			echo '<div id="erreur" class="alert alert-danger center-text" role="alert">', $_POST ['message'], '</div>';
		else
			echo '<div id="info" class="alert alert-info center-text" role="alert">', $_POST ['message'], '</div>';
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