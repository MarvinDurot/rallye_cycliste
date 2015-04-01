<?php
require_once ('php/session.php');


// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

$connector = MaBD::getInstance();
$mesPreinscriptions = new PreInscriptionsDAO($connector);

$mesInscriptions = new InscriptionsDAO($connector);


function afficherPreinscription(){
	global $mesPreinscriptions;
	echo '<table>';
	$i=0;
	if(isset($_POST['rechercher'])){
		$inscriveur = $_POST['mail'];
		$lesPreinscrits = $mesPreinscriptions->getPreInscritpionParEmail($inscriveur);
		foreach ($lesPreinscrits as $unPreinscrit){
			echo '<tr><td>'.$unPreinscrit->nom.'</td><td>'.$unPreinscrit->prenom.'</td></tr>';
			$i++;
		}
		if($i!==0){
			echo '<thead><tr><th>Nom</th><th>Prénom</th></tr></thead>';
			afficherBouttonValidation();
		}else{
			echo "Il n'y a pas de préinscritpion pour cette adresse mail";
		}
	}
	echo '</table>';
}

function afficherBouttonValidation(){
	echo '<form action="preinscriptions.php" method="post"><input type="submit" value="valider" name="valider"/><input type="hidden" value="'.$_POST['mail'].'" name="mail"/></form>';
}


//validation d'une préinscription, insertion dans INSCRIPTIONS et supression de PREINSCRIPTION
if(isset($_POST['valider'])){
	$inscriveur = $_POST['mail'];
	$lesPreinscrits = $mesPreinscriptions->getPreInscritpionParEmail($inscriveur);
	foreach ($lesPreinscrits as $unPreinscrit){
		$newInscriptions = new Inscription(array('idInscription' => DAO::UNKNOWN_ID,
									 	'estArrive' => 0,
										'nom' => $unPreinscrit->nom,
										'prenom' => $unPreinscrit->prenom,
										'sexe' => $unPreinscrit->sexe,
										'dateNaissance' => $unPreinscrit->dateNaissance,
										'federation' => $unPreinscrit->federation,
										'clubOuVille' => $unPreinscrit->clubOuVille,
										'departement' => $unPreinscrit->departement,
										'parcours' => $unPreinscrit->parcours,
										'inscriveur' => $_SESSION['login']));

		$mesInscriptions->insert($newInscriptions);
		$mesPreinscriptions->delete($unPreinscrit);
	}
	echo 'insertion effectué';
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
		<div class="row">
			<form action="preinscriptions.php" method="post">
				<input type="mail" name="mail" placeholder="mail" autofocus/>
				<input type="submit" name="rechercher" value="rechercher"/>
			</form>
		</div>
		<div>
				<?php afficherPreinscription();?>
		</div>
	</div>
</body>
</html>