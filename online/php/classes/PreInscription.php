<?php
class PreInscription extends TableObject {

	static public $keyFieldsNames = array('idPreInscription'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/*
	 * Affiche une pré-inscription dans une ligne de tableau	
	 */
	public function toTableRow() {
		$parcours = new ParcoursDAO(MaBD::getInstance());
		echo '<tr>
				<td>', $this->nom, '</td>
    		  	<td>', $this->prenom, '</td>
			  	<td>', $this->sexe, '</td>
			  	<td>', $this->dateNaissance, '</td>
			  	<td>', $this->federation, '</td>
			  	<td>', $this->clubOuVille, '</td>
	          	<td>', $this->departement, '</td>
			  	<td>', $parcours->getOne($this->parcours), '</td>
			  </tr>';
	}
	
	/*
	 * Affiche une pré-inscription dans un formulaire en ligne
	 */
	public function toForm() {
		$parcours = new ParcoursDAO(MaBD::getInstance());
		echo '<div class="row center-text">
				<div class="col-lg-12">
					<form method="POST" action="', $_SERVER['PHP_SELF'], '">
						<input type="hidden" name="id" value="', $this->idPreInscription, '">
							<div class="col-lg-2">
								<p>', $this->nom, ' ', $this->prenom, '</p>
							</div>
							<div class="col-lg-2">
								<p>', $this->dateNaissance, '</p>
							</div>
							<div class="col-lg-1">
								<p>', $this->sexe, '</p>
							</div>
							<div class="col-lg-1">
								<p>', $this->federation, '</p>
							</div>
							<div class="col-lg-2">
								<p>', $this->clubOuVille, '</p>
							</div>
							<div class="col-lg-1">
								<p>', $this->departement, '</p>
							</div>
							<div class="col-lg-2">
								<p>', $parcours->getOne($this->parcours), '</p>
							</div>				
							<button type="submit" class="icon-button" name="delete[]">
								<span class="glyphicon glyphicon-remove"></span>
							</button>						
			 		</form>
				</div>
			</div>';
	}
}
?>