<?php
// Teste la session
session_start ();
if (! isset ( $_SESSION ['recap'] )) {
	header ( "Location: step3.php" );
	exit ( 0 );
}

// Récupération des fonctions principales
require_once ('php/functions.php');

// Initialisation des erreurs
$_POST ['erreur'] = false;

// Retourner sur le module de saisie
if (isset ( $_POST ['retour'] )) {
	unset ( $_SESSION ['recap'] );
	header ( "Location: step3.php" );
	exit ( 0 );
}

// Valider les pré-inscriptions
if (isset ( $_POST ['valider'] )) {
	envoyerMailRecap ();
	header ( "Location: end.php" );
	exit ( 0 );
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
					<h2>Etape 4/4 - Validation des pré-inscriptions</h2>
				</div>
			</div>
		</div>
		<div class="row vertical-offset-20">
			<div class="col-lg-12">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Sexe</th>
							<th>Date de naissance</th>
							<th>Fédération</th>
							<th>Club ou Ville</th>
							<th>Département</th>
							<th>Parcours</th>
						</tr>
					</thead>
					<tbody>
						<?php //afficherRecap(); ?>
					</tbody>
				</table>
				<form action="step4.php" method="POST">
					<div class="pull-right">
						<button type="submit" class="btn btn-success btn-md"
							name="retour[]">Retour</button>
						<button type="submit" class="btn btn-primary btn-md"
							name="valider[]">Valider toutes les pré-inscriptions</button>
					</div>
				</form>
			</div>
		</div>

		<div id="message" class="row vertical-offset-50">
			<div class="col-lg-12">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>