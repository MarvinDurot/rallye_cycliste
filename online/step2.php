<?php

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

session_start();
if (!isset($_SESSION['email'])) {
	header("Location: step1.php");
	exit(0);
}

$email = $_SESSION['email'];

// Envoi du code de validation par mail
if (isset($_POST['confirmer']) || isset($_POST['renvoyer'])) {
	$_POST['codeValidation'] = envoyerMailValidation($email);
}

// Initialisation des erreurs
$_POST['erreur'] = false;

// Si le code est bon, on démarre une session et on ajoute l'utilisateur dans la base
if (isset($_POST['confirmer'])) {
	if ($codeValidation === $_POST['codeEnvoye']) {
		$_SESSION ['code'] = $codeValidation;
		$u = new Utilisateur ( array (
				'login' => $email,
				'mdp' => $_POST['codeEnvoye']
		) );
		$utilisateurs->insert ( $u );
	} else {
		$_POST ['erreur'] = true;
		$_POST ['message'] = "Le code de validation n'est pas correct !";
	}
}

if (isset($_POST['renvoyer'])) {
	$_POST['codeValidation'] = envoyerMailValidation($email);
}

/*
 * Envoie un email de confirmation
 * @param: un email
 * @return: un code aléatoire
 */
function envoyerMailValidation($mail) {
	global $utilisateurs;
	$code = genererCode ();
	$sujet = "Rallye de la fête du vin : code de validation";
	$message = "Voici le code qui vous permettra de valider votre email :\n";
	$message .= $code;
	echo $code;
	// mail ( $mail, $sujet, $message );
	return $code;
}

/*
 * Génère un code aléatoirement de 8 caractères
 * @return: un code aléatoire
 */
function genererCode() {
	$caracteres = array (
			"a",
			"b",
			"c",
			"d",
			"e",
			"f",
			0,
			1,
			2,
			3,
			4,
			5,
			6,
			7,
			8,
			9
	);
	$caracteres_aleatoires = array_rand ( $caracteres, 8 );
	$code = "";

	foreach ( $caracteres_aleatoires as $i )
		$code .= $caracteres [$i];

	return $code;
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
		<div class="row vertical-offset-50">
			<div class="col-lg-offset-1 col-lg-3">
				<p>Un email vient de vous être envoyé, veuillez saisir le code que
					vous avez reçu.</p>
				<form class="form" action="step1.php" method="POST">
					<div class="form-group">
						<label for="codeEnvoye">Code de validation :</label>
						<input type="text" class="form-control" name="codeEnvoye">
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
			<div class="col-lg-offset-1 col-lg-4">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>