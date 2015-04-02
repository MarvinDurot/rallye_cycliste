<?php
class Parcours extends TableObject {

	static public $keyFieldsNames = array('idParcours'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/*
	 * Transforme un parcours en option dans un select
	 */
    public function toSelect() {
    	echo '<option value="', $this->idParcours, '">', $this->type, $this->distance, '</option>'; 
    }   
    
    public function __toString() {
    	return "$this->type$this->distance";
    }
}
?>