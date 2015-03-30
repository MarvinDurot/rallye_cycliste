<?php
class Statistiques {
	protected $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	
	/* 
	 * Fonction pour obtenir le nombre d'inscriptions total
	 * @return : un entier
	 */
	public function getEffectifTotal() {
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS");		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['effectif'];	
	}
	
	/*
	 * Fonction qui donne le nombre d'inscriptions par type de parcours
	 * @return : un tableau associatif (type parcours => effectif)
	 */
	public function getEffectifParParcours() {
		$res = array();
		$stmt = $this->pdo->query("select type, count(*) as effectif from INSCRIPTIONS join PARCOURS on parcours=idParcours group by parcours");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res[$row['type']] = $row['effectif'];
		}	
		return $res;
	}
	
	public function getClubs() {
		$res = array();
		$stmt = $this->pdo->query("select clubOuVille from INSCRIPTIONS");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res[] = getClub($row['clubOuVille']);
		}
		return $res;
	}
	
	private function getClub($club) {
		$fields = array();
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif, departement FROM INSCRIPTIONS WHERE clubOuVille=$club");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifTotal'] = $row['effectif'];
		$fields['departement'] = $row['departement'];
		
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS WHERE clubOuVille=$club WHERE sexe='H'");	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifHommes'] = $row['effectif'];
		$fields['effectifFemmes'] = $fields['effectifTotal'] - $fields['effectifHommes'];
		
		$stmt = $this->pdo->prepare("SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE clubOuVille=$club AND TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19");		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifMineurs'] = $row['effectif'];
		
		return new Club($fields);
	} 
		
	/*
	 * Fonction qui donne la répartition des inscriptions sur un champs donné
	 * @params : un nom de champs, un type de parcours (optionnel)
	 * @return : un DataSet
	 */
	public function getNumberOfInscriptionsByField($fieldName, $type="") {
		$labels = array(); $values = array();
		
		if (empty($type)) {			
				$stmt = $this->pdo->prepare("select ?, count(*) as effectif from INSCRIPTIONS join PARCOURS on idParcours=parcours group by ? having type=?");
				$stmt->execute(array($fieldName, $type, $fieldName));
			} else {
				$stmt = $this->pdo->prepare("select ?, count(*) as effectif from INSCRIPTIONS group by ?");
				$stmt->execute(array($fieldName));				
			}
			
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$labels[] = $row[$fieldName];
			$values[] = $row['effectif'];
		}
		
		return new DataSet($labels, $values);
	}
	
	public function getNumberOfInscriptionsByAge() {
		// TODO : à compléter
	}
	
	public function getBiggest($fieldName, $type, $number) {
		/* 	SELECT $fieldName, COUNT(*) as effectif
			FROM inscription join parcours on idParcours=parcours
			WHERE type=uppercase($type) AND federation<> 'NL' AND departement=$departement
			GROUP BY $fieldName HAVING count(*)=
			(
    			SELECT MAX(nbMembre) 
    			FROM
    			(SELECT COUNT(*) as nbMembre 
         		FROM inscription join parcours using(idParcours) 
         		WHERE type='ROUTE' AND federation<>'NL' AND departement=7
         		GROUP BY clubOuVille); */
	}
	
	public function getTwoBiggestClubs($departement) {
		// select clubOuVille, count(*) as effectif from INSCRIPTIONS group by clubOuVille  
	}
	
	public function getClubWithMostGirls() {
		
	}
	
	public function getNumberOfGirlsByClub() {
		// select count(*) from INSCRIPTION where 
	}
	
	public function getYoungest($sexe) {
		$stmt = $this->pdo->prepare("select TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) as age from INSCRIPTIONS Where sexe=? order by age ASC  limit 1");
		$stmt->execute(array($sexe));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['age'];	
	}
}
?>