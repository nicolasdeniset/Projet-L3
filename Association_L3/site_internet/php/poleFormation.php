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
	$idPole = array();
	
	$S2 = "SELECT	idPoleFormation
				FROM	poleformation";
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	while ($D2 = mysqli_fetch_assoc($R2)) {
		$idPole[] = $D2['idPoleFormation'];
	}
	
	if (!isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbIDPole = count($idPole);
		$_POST['titre'] = "";
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script stage.
		$idPole = rechercher_pole();
		$nbIDPole = count($idPole);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Poles de Formations");
	html_header($id);
	html_aside_main_debut(APP_PAGE_POLE);
	
	echo '<h1 class="page-header">Nos poles de formations</h1>';
	
	if($estAdmin == 0) {
       echo '<a href="ajoutPoleFormation.php" class="btn btn-success btn-block"><span class="fa fa-plus"></span>AJOUTER UN NOUVEAU POLE</a>';
	}
	
	echo '<form class="form-inline" method="POST" action="poleFormation.php" accept-charset="iso-8859-1">',
          '<div class="form-group">',
            '<input type="text" class="form-control" name="titre" id="search" placeholder="Nom du pole">',
          '</div>',
          '<button type="submit" class="btn btn-inline"  name="btnValider"><span class="fa fa-search"></span>Rechercher</button>',
        '</form>';
		
	if(!isset($_POST['btnValider']) && $nbIDPole == 0) {
		echo '<h3> Aucun pole n\'est disponible a l\'heure actuelle. </h3>';
	}
	if(isset($_POST['btnValider']) && $nbIDPole == 0) {
		echo '<h3> Aucun pole possèdant ce nom a été trouvé. </h3>';
	}	
	if($nbIDPole > 0) {
		for($i = 0;$i < $nbIDPole; $i++){
			$S3 = "SELECT	coordonneesPoleFormation, nbBenevolesPoleFormation
							FROM	poleformation
							WHERE	idPoleFormation = '$idPole[$i]'";
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
			$stat = statistique_pole($idPole[$i]);
				
			echo '<div class="item">',
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
				  '<div class="row">';
			if($estAdmin == 0) {
				echo '<div class="col-md-12 col-sm-12">',
						'<a href="gestionPoleFormation.php?id=',$idPole[$i],'" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer le pole de formation</a>',
					 '</div>';
			}
			echo '</div>',
				'</div>';
		}
	}
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Fonction qui permet de rechercher les informations concernant un
	* pole à partir de son titre.
	* Si on trouve des titres renvoie un tableau d'id des poles.
	*
	* @return array $idPole		Tableau des identifiants de pole détectées.
	*/
	function rechercher_pole() {
		$idPole = array();
		
		$titre = trim($_POST['titre']); // on recupère la chaine a qui nous sert de recherche
		$titre = mysqli_real_escape_string($GLOBALS['bd'], $titre);
		if($titre == ""){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
			return $idPole;
		}
	
		// Requête de recherche de titre
		$S = "SELECT DISTINCT idPoleFormation 
				FROM poleformation, coordonnees 
				WHERE villeCoordonnees LIKE '%$titre%'
				AND	coordonneesPoleFormation = idCoordonnees";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);	
		while ($D = mysqli_fetch_assoc($R)) {
				$idPole[] = $D['idPoleFormation'];
		}
		return $idPole;
	}