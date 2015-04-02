<?php
class Utilisateur extends TableObject {
	
	static public $keyFieldsNames = array('email'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function valider() {
		$this->valide = true;
	}
	
	public function changeCode($code) {
		$this->code = $code;
	}
}
?>
