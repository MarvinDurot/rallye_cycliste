<?php
// Teste la session
session_start ();
if (! isset ( $_SESSION ['code'] )) {
	header ( "Location: step2.php" );
	exit ( 0 );
}
if (isset ( $_SESSION ['recap'] )) {
	header ( "Location: step4.php" );
	exit ( 0 );
}

// Récupération des fonctions principales
require_once ('php/functions.php');

// Initialisation des erreurs
$_POST ['erreur'] = false;

// Supprimer une inscription
if (isset ( $_POST ['delete'] )) {
	supprimerInscription ( $_POST ['id'] );
	$_POST ['message'] = "L'inscription a bien été supprimée !";
}

// Ajouter une inscription
if (isset ( $_POST ['ajouter'] )) {
	if (checkInputs ()) {
		ajouterInscription ();
		$_POST ['message'] = "L'inscription a bien été ajoutée !";
	} else {
		$_POST ['erreur'] = true;
		$_POST ['message'] = "La saisie est invalide !";
	}
}

// Valider les inscriptions
if (isset ( $_POST ['valider'] )) {
	$_SESSION ['recap'] = true;
	header ( "Location: step4.php" );
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
					<h2>Etape 3/4 - Saisie des pré-inscriptions</h2>
					<div class="progress">
						<div class="progress-bar progress-bar-striped active"
							role="progressbar" aria-valuenow="75" aria-valuemin="0"
							aria-valuemax="100" style="width: 75%"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row vertical-offset-20">
			<div class="col-lg-4 col-lg-offset-1">
				<form method="POST" action="step3.php">
					<div class="form-group">
						<label>Nom :</label> <input class="form-control input-sm"
							name="nom" type="text" placeholder="Nom..." required autofocus>
					</div>
					<div class="form-group">
						<label>Prénom :</label> <input class="form-control input-sm"
							name="prenom" type="text" placeholder="Prénom..." required>
					</div>
					<div class="form-group">
						<label>Sexe :</label> <select class="sel" name="sexe">
							<option value="H">H</option>
							<option value="F">F</option>
						</select>
					</div>
					<div class="form-group">
						<label>Date de naissance :</label> <input
							class="form-control input-sm" name="dateNaissance" type="date"
							placeholder="JJ-MM-AAAA" required>
					</div>
					<div class="form-group">
						<label>Fédé. :</label> <select class="sel" name="federation">
									<?php chargerFederations();?>
								</select>
					</div>
					<div class="form-group">
						<label>Ville ou Club</label> <input class="form-control input-sm"
							name="clubOuVille" type="text" placeholder="Ville ou Club..."
							required>
					</div>
					<div class="form-group">
						<label>Dép.</label> <input class="form-control input-sm"
							name="departement" type="text" placeholder="Ex: 07" required>
					</div>
					<div class="form-group">
						<label>Parcours</label> <select class="sel" name="parcours">
									<?php chargerParcours();?>
								</select>
					</div>
					<input type="hidden" value="<?php echo $_SESSION['email']; ?>"
						name="inscriveur" id="inscriveur"> <input type="hidden"
						name="estArrive" value="0">
					<div class="pull-right">
						<button type="submit" class="btn btn-success" name="ajouter[]">Ajouter</button>
					</div>
				</form>
			</div>
			<div class="col-lg-7">
				<div class="row">
					<?php afficherPreInscriptions($_SESSION['email']); ?>
				</div>
				<div class="row vertical-offset-20">
					<div class="col-lg-offset-2 col-lg-8">
						<?php afficherMessage(); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row vertical-offset-50">
			<div class="col-lg-12">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>