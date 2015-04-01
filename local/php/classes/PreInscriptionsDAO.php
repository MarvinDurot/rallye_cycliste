<?php
// Classe pour l'accès à la table INSCRIPTION
class PreInscriptionsDAO extends DAO {
	protected $table = "PREINSCRIPTIONS";
    protected $class = "PreInscription";
    
    public function getPreInscritpionParEmail($inscriveur){
    	$res = array();
    	$stmt = $this->pdo->prepare("SELECT * FROM PREINSCRIPTIONS WHERE inscriveur=?");
    	$stmt->execute(array($inscriveur));
    	foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
    		$res[] = new PreInscription($row);
    	return $res;
    }
}
?>
