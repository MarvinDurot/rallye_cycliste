/* Module du pointage */

/* Déclaration des objets principaux */
var aCloner;
var tbd;

// Ajoute une ligne d'inscription dans le tableau
function addLine(inscription) {
	var nouv = aCloner.clone(true);
	var tds = nouv.children();
	tds.eq(0).text(inscription.nom);
	tds.eq(1).text(inscription.prenom);
	tds.eq(2).text(inscription.sexe);
	tds.eq(3).text(inscription.dateNaissance);
	
	if (inscription.estArrive == true) {
		nouv.css('background-color', '#A4D0F5');
	} else {
		nouv.click(function() {
			update(nouv, inscription.idInscription);
		});
	}

	nouv.appendTo(tbd);
}

// Chargement des inscriptions et affichage dans la table
function loadInscriptions() {
	var postData = {
		action : 'retrieveAll',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO'
	};

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			addLine(liste[i]);
		}
	}, 'json');
}

// Met à jour le pointage d'un cycliste
function update(jQtr, id) {
	var postData = {
		action : 'update',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO',
		idInscription : id,
		estArrive : 1
	};

	$.post('php/crud.php', postData, function(data) {
		if (data)
			jQtr.css('background-color', '#A4D0F5');
	}, 'json');
}

$(document).ready(function() {
	aCloner = $('table > tfoot > tr:last-child');
	tbd = $('table > tbody');

	loadInscriptions();
});
