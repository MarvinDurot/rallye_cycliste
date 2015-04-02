<?php
// Classe pour l'accès à la table UTILISATEUR
class UtilisateursDAO extends DAO {
	
	protected $table = "UTILISATEURS";
	protected $class = "Utilisateur";
	
	// Teste si une paire email/code est dans la table Utilisateurs
	public function check($email, $code)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM UTILISATEURS WHERE email=? AND code=?");
		$stmt->execute(array($email, $code));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($res === false)
			return false;
		else
			return true;
	}
}
?>
