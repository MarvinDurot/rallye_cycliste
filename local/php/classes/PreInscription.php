<?php
class PreInscription extends TableObject {

	static public $keyFieldsNames = array('idPreInscription'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	public function __tostring() {
		return "$this->idInscription, $this->nom, $this->prenom, $this->sexe, $this->dateNaissance, $this->federation, $this->clubOuVille, $this->departement";
	}
}
?>