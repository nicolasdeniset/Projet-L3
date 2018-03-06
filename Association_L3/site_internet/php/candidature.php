<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	
	// Requête qui va récuperer les informations nous concernant (typeCompte).
	$S = "SELECT	typeCompte
			FROM	compte
			WHERE	idCompte = '$id'";

	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
	$D = mysqli_fetch_row($R);
	
	$estAdmin = $D[0];
	// On vérifie que l'utilisateur est un admin et qu'il a le droit d'ajouter des formations.
	if($estAdmin != 0) {
		header('location: accueil.php');
		exit();			// EXIT : le script est terminé
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Liste des Candidatures");
	html_header($id);
	html_aside_main_debut(APP_PAGE_CANDIDATURE);
	
	echo '<h1 class="page-header">Liste de toutes les candidatures</h1>',
			'<div class="row">',
				'<div class="col-md-12">',
					'<div class="col-md-4">',
						"<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidaturesInscription', 'gestionCandidaturesFormations', 'gestionCandidaturesStages']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures d'inscription</button>",
					'</div>',
					'<div class="col-md-4">',
						"<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidaturesFormations', 'gestionCandidaturesStages', 'gestionCandidaturesInscription']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures de formations</button>",
					'</div>',
					'<div class="col-md-4">',
						"<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidaturesStages', 'gestionCandidaturesInscription', 'gestionCandidaturesFormations']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures de stages</button>",
					'</div>',
				'</div>',
			'</div>',
			
			'<div id="gestionCandidaturesInscription" class="gestion row">',
				'<table class="table table-striped">',
					'<thead>',
					  '<tr>',
						'<th>ID</th>',
						'<th>Nom candidat</th>',
						'<th>Date d\'inscription</th>',
						'<th>Gestion</th>',
					  '</tr>',
					'</thead>',
					'<tbody>';
			$S = "SELECT	idCandidature, compteCandidature, nomCoordonnees, prenomCoordonnees, inscriptionCompte
					FROM	candidature, compte, coordonnees
					WHERE	compteCandidature = idCompte
					AND		coordonneesCompte = idCoordonnees
					AND		typeCandidature = '0'
					AND		traiteeCandidature = '0'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$i = 0;
			while ($D = mysqli_fetch_assoc($R)) {
				$idCandidature = $D['idCandidature'];
				$compteCandidature = $D['compteCandidature'];
				$nomCandidat = $D['nomCoordonnees'];
				$prenomCandidat = $D['prenomCoordonnees'];
				$dateInscriptionCompte = $D['inscriptionCompte'];
				echo '<tr>',
					'<td>',$idCandidature,'</td>',
					'<td>',$prenomCandidat,' ',$nomCandidat,'</td>',
					'<td>',$dateInscriptionCompte,'</td>',
					'<td>',
					'<form method="POST" action="profil.php">',
							'<input type="hidden" name="id_Membre" value="',$compteCandidature,'" />',
							'<input type="hidden" name="idCandidature" value="',$idCandidature,'" />',
							'<input type="hidden" name="pageDeRetour" value="candidature.php" />',
							'<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
					'</form>',
					'<form method="POST" action="candidature.php">',
						'<button type="submit" class="btn btn-inline" name="accepter',$i,'"><span class="text-success fa fa-check" aria-hidden="true"></span></button>',
						'<button type="submit" class="btn btn-inline" name="refuser',$i,'"><span class="text-danger fa fa-times" aria-hidden="true"></span></button>',
					'</form>',
					'</td>',
					'</tr>';
					if (isset($_POST["refuser$i"])) {
						$S = "SELECT	coordonneesCompte
								FROM	compte
								WHERE	idCompte = '$compteCandidature'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						$D = mysqli_fetch_row($R);
						$coordonneesCompte = $D[0];
						
						$S = "DELETE FROM compte
								WHERE	idCompte = '$compteCandidature'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						$S = "DELETE FROM coordonnees
								WHERE	idCoordonnees = '$coordonneesCompte'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						$S = "DELETE FROM candidature
								WHERE	idCandidature = '$idCandidature'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						header("location: candidature.php");
						exit();			// EXIT : le script est terminé
						ob_end_flush();
					}
					if (isset($_POST["accepter$i"])) {
						$S = "UPDATE	candidature
							SET	traiteeCandidature = '1', accepteeCandidature = '1'
							WHERE	idCandidature = '$idCandidature'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						$S = "UPDATE	compte
							SET	actifCompte = '1'
							WHERE	idCompte = '$compteCandidature'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						header("location: candidature.php");
						exit();			// EXIT : le script est terminé
						ob_end_flush();
					}
					$i++;
			}
	
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
?>