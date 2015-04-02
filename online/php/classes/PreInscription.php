<?php
class PreInscription extends TableObject {

	static public $keyFieldsNames = array('idPreInscription'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/*
	 * Affiche une pré-inscription sur une ligne de tableau
	 * avec formulaire caché contenant l'id de la pré-inscription
	 * et un bouton de suppression
	 */
	public function toTableRowForm() {
		echo '<form action="', $_SERVER['PHP_SELF'], '" method="POST">
    		  	<input type="hidden" value="', $this->idPreInscription, '" name="id">
    		  			<tr>
    		  				<td>', $this->nom, '</td>
    		  				<td>', $this->prenom, '</td>
							<td>', $this->sexe, '</td>
							<td>', $this->dateNaissance, '</td>
							<td>', $this->federation, '</td>
							<td>', $this->clubOuVille, '</td>
							<td>', $this->departement, '</td>
							<td>', $this->parcours, '</td>
							<td> <button class="icon-button">
								 	<span class="glyphicon glyphicon-remove"></span>
							 	</button>
							</td>
						</tr>';
	}
	
	/*
	 * Affiche une pré-inscription sur une ligne de tableau
	 */
	public function toTableRow() {
		echo '<tr>
    		  	<td>', $this->nom, '</td>
    		  	<td>', $this->prenom, '</td>
				<td>', $this->sexe, '</td>
				<td>', $this->dateNaissance, '</td>
				<td>', $this->federation, '</td>
				<td>', $this->clubOuVille, '</td>
				<td>', $this->departement, '</td>
				<td>', $this->parcours, '</td>
			  </tr>';
	}
}
?>