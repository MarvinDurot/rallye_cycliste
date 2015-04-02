<?php
require_once ('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

// Initialisation des erreurs
$_POST ['erreur'] = false;

// Récupération des DAO
$connector = MaBD::getInstance ();
$preinscriptions = new PreInscriptionsDAO ( $connector );
$inscriptions = new InscriptionsDAO ( $connector );

/*
 * Affiche les pré-inscriptions (nom, prénom) dans un tableau
 */
function afficherPreInscriptions() {
	global $preinscriptions;
	if (isset ( $_POST ['rechercher'] )) {
		$lesPreInscrits = $preinscriptions->getPreInscriptionParEmail ( $_POST ['email'] );
		if (!empty($lesPreInscrits)) {
			echo '<table class="table table-striped">	
						<thead>
							<tr><th>Nom</th><th>Prénom</th></tr>
					  	</thead>
						<tbody>';
			foreach ( $lesPreInscrits as $unPreInscrit )
				echo '<tr><td>', $unPreInscrit->nom, '</td><td>', $unPreInscrit->prenom, '</td></tr>';
			echo '</tbody>
				</table>';
			afficherBoutonValidation ();
		} else {
			$_POST ['erreur'] = true;
			$_POST ['message'] = "Il n'y a pas de pré-inscription associée cette adresse mail !";
		}
	}
}

/*
 * Affiche le bouton permettant de valider les pré-inscriptions
 */
function afficherBoutonValidation() {
	echo '<form action="preinscriptions.php" method="POST">			
			<input type="hidden" value="', $_POST ['email'], '" name="email">
				<div class="pull-right">
					<button type="submit" class="btn btn-success btn-lg" name="valider">Valider</button>
				</div>
		 </form>';
}

/*
 * Valide une pré-inscription, l'insère dans la table INSCRIPTIONS
 * et la supprime de la table PREINSCRIPTION
 */
if (isset ( $_POST ['valider'] )) {
	$inscriveur = $_POST ['email'];
	$lesPreInscrits = $preinscriptions->getPreInscriptionParEmail ( $inscriveur );
	foreach ( $lesPreInscrits as $unPreinscrit ) {
		$newInscriptions = new Inscription ( array (
				'idInscription' => DAO::UNKNOWN_ID,
				'estArrive' => 0,
				'nom' => $unPreinscrit->nom,
				'prenom' => $unPreinscrit->prenom,
				'sexe' => $unPreinscrit->sexe,
				'dateNaissance' => $unPreinscrit->dateNaissance,
				'federation' => $unPreinscrit->federation,
				'clubOuVille' => $unPreinscrit->clubOuVille,
				'departement' => $unPreinscrit->departement,
				'parcours' => $unPreinscrit->parcours,
				'inscriveur' => $_SESSION ['login'] 
		) );
		
		$inscriptions->insert ( $newInscriptions );
		$preinscriptions->delete ( $unPreinscrit );
	}
	$_POST ['message'] = "Insertion effectuée avec succès !";
}

/*
 * Affiche un message d'erreur ou d'information
 */
function afficherMessage() {
	if (isset ( $_POST ['message'] ) && isset ( $_POST ['erreur'] )) {
		if ($_POST ['erreur'])
			echo '<div class="alert alert-danger center-text" role="alert">', $_POST ['message'], '</div>';
		else
			echo '<div class="alert alert-info center-text" role="alert">', $_POST ['message'], '</div>';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<title>Pré-Inscriptions</title>
</head>
<body>
		<?php require_once('php/menu.php');?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Validation des pré-inscriptions</h1>
			</div>
		</div>
		<div class="row vertical-offset-20">
			<div class="col-lg-offset-4 col-lg-4">
				<form class="form-inline" action="preinscriptions.php" method="POST">
					<legend>
						<span class="glyphicon glyphicon-check">&nbsp;</span>Valider des
						pré-inscriptions
					</legend>
					<div class="form-group">
						<input class="form-control" type="email" name="email"
							placeholder="Adresse Email..." required autofocus>
						<button type="submit" class="btn btn-primary" name="rechercher[]">Rechercher</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row vertical-offset-20">
			<div class="col-lg-offset-4 col-lg-4 col-lg-offset-4">
				<?php afficherPreInscriptions();?>
			</div>
		</div>
		<div class="row vertical-offset-50">
			<div class="col-lg-offset-2 col-lg-8">
				<?php afficherMessage(); ?>
			</div>
		</div>
	</div>
</body>
</html>