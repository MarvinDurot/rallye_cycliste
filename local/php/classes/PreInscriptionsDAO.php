<?php
// Classe pour l'accès à la table INSCRIPTION
class PreInscriptionsDAO extends DAO {
	protected $table = "PREINSCRIPTIONS";
    protected $class = "PreInscription";
    
    /*
     * Retourne les préinscription d'une adresse mail
     * @param: l'email de l'inscriveur
     * @return: un tableau de pré-inscriptions (TableObject)
     */
    public function getPreInscriptionParEmail($inscriveur){
    	$res = array();
    	$stmt = $this->pdo->prepare("SELECT * FROM PREINSCRIPTIONS WHERE inscriveur=?");
    	$stmt->execute(array($inscriveur));
    	foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
    		$res[] = new PreInscription($row);
    	return $res;
    }
}
?>
