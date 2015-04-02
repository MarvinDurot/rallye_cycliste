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

if (isset ( $_POST ['confirmer'] )) {
	if (valide ( $email, $_POST ['codeEnvoye'] )) {
		valider ( $email );
		$_SESSION ['code'] = $_POST ['codeEnvoye'];
		header ( "Location: step3.php" );
		exit ( 0 );
	} else {
		$_POST ['erreur'] = true;
		$_POST ['message'] = "Le code de validation n'est pas correct !";
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
					<h2>Etape 3/4 - Saisie des pré-inscriptions</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">				
				<?php afficherPreInscriptions('user2@mail.com'); ?>				
			</div>
		</div>
		<div class="col-lg-12">
			<form>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-ok">&nbsp;</span> Inscrire un
							cycliste
						</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-lg-2">
								<label>Nom</label> <input class="form-control input-sm" id="nom"
									name="nom" type="text" placeholder="Nom..." autofocus>
							</div>
							<div class="col-lg-2">
								<label>Prénom</label> <input class="form-control input-sm"
									id="prenom" name="prenom" type="text" placeholder="Prénom...">
							</div>
							<div class="col-lg-1">
								<label>Sexe</label> <select class="sel" id="sexe">
									<option value="H">H</option>
									<option value="F">F</option>
								</select>
							</div>
							<div class="col-lg-2">
								<label>Date de naissance</label> <input
									class="form-control input-sm" id="date" name="date" type="date"
									placeholder="AAAA-MM-JJ">
							</div>

							<div class="col-lg-1">
								<label>Fédé.</label><select class="sel" id="federation"></select>
							</div>
							<div class="col-lg-2">
								<label>Ville ou Club</label> <input
									class="form-control input-sm" id="clubOuVille"
									name="clubOuVille" type="text" placeholder="Ville ou Club...">
							</div>
							<div class="col-lg-1">
								<label>Dép.</label> <input class="form-control input-sm"
									id="departement" name="departement" type="text"
									placeholder="Ex: 07">
							</div>
							<div class="col-lg-1">
								<label>Parcours</label> <select class="sel" id="parcours"></select>
							</div>

							<input type="text" value="<?php echo $_SESSION['email']; ?>"
								name="inscriveur" id="inscriveur" class="hide">

						</div>
					</div>

					<div class="panel-footer clearfix">
						<div class="pull-right">
							<button type="submit" class="btn btn-primary" id="valider">Valider</button>
						</div>
					</div>
				</div>
			</form>

			<div id="message" class="row vertical-offset-50">
				<div class="col-lg-offset-1 col-lg-3">
				<?php afficherMessage(); ?>
			</div>
			</div>
		</div>

</body>
</html>