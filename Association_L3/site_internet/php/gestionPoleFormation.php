<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	$idPole = $_GET["id"];
	
	// Requête qui va récuperer les informations nous concernant (typeCompte).
	$S = "SELECT	typeCompte
			FROM	compte
			WHERE	idCompte = '$id'";

	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
	$D = mysqli_fetch_row($R);
	
	$estAdmin = $D[0];
	// On vérifie que l'utilisateur est un admin et qu'il a le droit d'ajouter des formations.
	if($estAdmin != 0) {
		header('location: poleFormation.php');
		exit();			// EXIT : le script est terminé
	}
	$S3 = "SELECT	coordonneesPoleFormation, nbBenevolesPoleFormation
							FROM	poleformation
							WHERE	idPoleFormation = '$idPole'";
	$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
	$D3 = mysqli_fetch_row($R3);
	$coordonneesPoleFormation = $D3[0];
	$nbBenevolesPoleFormation = $D3[1];
	$S4 = "SELECT	nomCoordonnees, prenomCoordonnees, emailCoordonnees, telephoneCoordonnees, adresseCoordonnees, villeCoordonnees 
							FROM	coordonnees
							WHERE	idCoordonnees = '$coordonneesPoleFormation'";
	$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
	$D4 = mysqli_fetch_row($R4);
	$nomCoordonnees = $D4[0];
	$prenomCoordonnees = $D4[1];
	$emailCoordonnees = $D4[2];
	$telephoneCoordonnees = $D4[3];
	$adresseCoordonnees = $D4[4];
	$villeCoordonnees = $D4[5];
	$stat = statistique_pole($idPole);
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Gestion de Pole de Formation");
	html_header($id);
	html_aside_main_debut(APP_PAGE_POLE);
	
	echo '<a href="poleFormation.php" class="btn btn-retour">Retour</a>',
			'<h1 class="page-header">Gestion du Pole de ',$villeCoordonnees,'</h1>',
			'<div class="item">',
					'<div class="row">',
						'<div class="col-md-6 col-sm-12">',
						'<h3>Pole de ', $villeCoordonnees ,'</h3>',
						  '<p class="small">Gérant : ',$prenomCoordonnees,' ',$nomCoordonnees,'</p>',
						  '<p class="small">Adresse : ',$adresseCoordonnees,'</p>',
						  '<p class="small">Email : ',$emailCoordonnees,'</p>',
						  '<p class="small">Téléphone : ',$telephoneCoordonnees,'</p>',
						'</div>',
						'<div class="col-md-6 col-sm-12">',
						'<h3>STATISTIQUES</h3>',
							'<table class="table table-striped">',
								'<tbody>',
									'<tr>',
										'<th>Nombre de formations proposées</th>',
										'<td>',$stat[0],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre étudiants</th>',
										'<td>',$stat[1],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre étudiants diplomé</th>',
										'<td>',$stat[2],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre de bénévoles</th>',
										'<td>',$nbBenevolesPoleFormation,'</td>',
									'</tr>',
								'</tbody>',
							'</table>',
						'</div>',
					'</div>',
					'<div class="row">',
						'<div class="col-md-12">',
							'<div class="col-md-6">',
							  "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionDesFormations', 'gestionPole']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer les formations du pole</button>",
							'</div>',
							'<div class="col-md-6">',
							  "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionPole', 'gestionDesFormations']); return false;\"><span class=\"fa fa-cogs\" aria-hidden=\"true\"></span>Modifier les informations du pole</button>",
							'</div>',
						'</div>',
					'</div>',
					
					'<div id="gestionDesFormations" class="gestion row">',
					'</div>',
		
					'<div id="gestionPole" class="gestion row">',
					'</div>',
			'</div>';
					
	
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________
	
?>