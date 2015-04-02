<?php
/*
 * Fonction communes aux étapes d'inscription en ligne
 */

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

// Chargement des DAO et déclaration des variables globales
$utilisateurs = new UtilisateursDAO ( MaBD::getInstance () );
$inscriptions = new PreInscriptionsDAO ( MaBD::getInstance () );
$parcours = new ParcoursDAO ( MaBD::getInstance () );

// Déclaration des constantes
const PRIX = 10;
const FEDERATIONS = [ 
		'NL',
		'FFCT',
		'FFC',
		'UFOLEP',
		'FSGT',
		'FFTri' 
];

/*
 * Teste si un email est déjà présent dans la base
 * @param: un email
 * @return: un booléen
 */
function test($email) {
	global $utilisateurs;
	$u = $utilisateurs->getOne ( $email );
	if ($u === null)
		return false;
	else
		return true;
}

/*
 * Teste si une paire email / code est valide
 * @param: un email, un code
 * @return: un booléen
 */
function valide($email, $code) {
	global $utilisateurs;
	return $utilisateurs->check ( $email, $code );
}

/*
 * Valide un utilisateur dans la base
 * @param: un email
 */
function valider($email) {
	global $utilisateurs;
	$u = $utilisateurs->getOne ( $email );
	$u->valider ();
	$utilisateurs->update ( $u );
}

/*
 * Ajoute un utilisateur dans la base en lui affectant
 * un code aléatoire qu'il lui est envoyé par mail
 * @param: un email
 */
function ajouterUtilisateur($email) {
	global $utilisateurs;
	$code = envoyerMailValidation ( $email );
	$u = new Utilisateur ( array (
			'email' => $email,
			'code' => $code,
			'valide' => false 
	) );
	$utilisateurs->insert ( $u );
}

/*
 * Envoie un email de confirmation et
 * @param: un email
 * @return: un code aléatoire de 8 caractères
 */
function envoyerMailValidation($email) {
	global $utilisateurs;
	$code = genererCode ();
	$sujet = "Rallye de la fête du vin : code de validation";
	$message = "Voici le code qui vous permettra de valider votre email :\n";
	$message .= $code;
	echo $code;
	mail ( $email, $sujet, $message );
	return $code;
}

/*
 * Génère un nouveau code, l'envoie par mail et met à jour la base
 * @param: un email
 */
function nouveauCode($email) {
	global $utilisateurs;
	$code = envoyerMailValidation ( $email );
	$u = $utilisateurs->getOne ( $email );
	$u->changeCode ( $code );
	$utilisateurs->update ( $u );
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
 * Affiche les inscriptions d'un email dans un tableau contenant des formulaires
 * (sauf si l'email n'est associé à aucune inscription)
 * @param: un email
 */
function afficherPreInscriptions($email) {
	global $inscriptions;
	if (checkRef ( $email )) {
		foreach ( $inscriptions->getPreInscritpionParEmail ( $email ) as $i )
			$i->toForm ();
	}
}

/*
 * Charge les parcours dans un select
 */
function chargerParcours() {
	global $parcours;
	foreach ( $parcours->getAll () as $p )
		$p->toOption ();
}

/*
 * Charge les fédérations dans un select
 */
function chargerFederations() {
	foreach ( FEDERATIONS as $f )
		echo '<option value="', $f, '">', $f, '</option>';
}

/*
 * Supprimer une pré-inscription dans la base
 * @param: l'id de la pré-inscription à supprimer
 */
function supprimerInscription($id) {
	global $inscriptions;
	$i = $inscriptions->getOne ( $id );
	$inscriptions->delete ( $i );
}

/*
 * Ajoute une pré-inscription dans la base
 * @param: l'id de la pré-inscription à supprimer
 */
function ajouterInscription() {
	global $inscriptions;
	$_POST ['idPreInscription'] = DAO::UNKNOWN_ID;
	foreach ( $inscriptions->getColumnNames () as $cName )
		$fields [$cName] = $_POST [$cName];
	$obj = new PreInscription ( $fields );
	$inscriptions->insert ( $obj );
}

/*
 * Vérifie les champs département et date de naissance
 */
function checkInputs() {
	// TODO : à compléter
	return true;
}

/*
 * Envoie un email avec le recapitulatif des pré-inscriptions de l'utilisateur et le prix total
 */
function envoyerMailRecap($email) {
	global $inscriptions;
	$prix = 0;
	$sujet = "Inscription(s) au Rallye cycliste de la fête des vins";
	$message = "Bonjour,\n\nVoici le récapitulatif de vos pré-inscriptions :\n-----\n";
	foreach ( $inscriptions->getPreInscritpionParEmail ( $email ) as $i ) {
		$message .= $i;
		$prix = $prix + PRIX;
	}
	$message .= "\n=== Prix TOTAL ===\n$prix euros\n\n";
	$message .= "\nN'oubliez pas de vous présentez au poste d'inscription avec votre adresse mail !\n";
	$message .= "\nCordialement.";
	mail ( $email, $sujet, $message );
}

/*
 * Affiche le récapitulatif des pré-inscriptions d'un utilisateur
 * @param: un email
 */
function afficherRecap($email) {
	global $inscriptions;
	if (checkRef ( $email )) {
		foreach ( $inscriptions->getPreInscritpionParEmail ( $email ) as $i )
			$i->toTableRow ();
	}
}

/*
 * Vérifie si un utilisateur dispose d'au moins une pré-inscription dans la base
 * @param: un email
 * @return : un booléen
 */
function checkRef($email) {
	global $inscriptions;
	$liste = $inscriptions->getPreInscritpionParEmail ( $email );
	if ($liste === null)
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
			echo '<div class="alert alert-danger center-text" role="alert">', $_POST ['message'], '</div>';
		else
			echo '<div class="alert alert-info center-text" role="alert">', $_POST ['message'], '</div>';
	}
}
?>