<?php
require_once ('php/session.php');
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<title>Rallye de la fête des vins</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">
				<img class="img-responsive img-circle" src="img/banner.png">
			</div>
		</div>
		<div class="row vertical-offset-50">
			<div class="page-header center-text">
				<h1>Bienvenue</h1>
				<p>Cet outil permet de s'inscrire au Rallye de la fête des vins de
					St Peray.</p>
				<p>Pour démarrer l'inscription appuyez sur le bouton ci-dessous.</p>
				<p>
					<a class="btn btn-primary btn-lg" href="step1.php" role="button" id="start">Commencer</a>
				</p>
			</div>
		</div>
	</div>
</body>
</html>