<?php
/*
 * Fonction communes aux étapes d'inscription en ligne
 */

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

// Chargement des DAO
$utilisateurs = new UtilisateursDAO ( MaBD::getInstance () );
$inscriptions = new PreInscriptionsDAO ( MaBD::getInstance () );
$parcours = new ParcoursDAO(MaBD::getInstance());

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
	// mail ( $email, $sujet, $message );
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
	$liste = $inscriptions->getPreInscritpionParEmail ( $email );
	if ($liste !== null) {
		echo '<table class="table table-condensed">
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
					<tbody class="no-border">';
		foreach ( $liste as $p )
			$p->toTableRowForm ();
		echo '</tbody>					
				</table>';
	}
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