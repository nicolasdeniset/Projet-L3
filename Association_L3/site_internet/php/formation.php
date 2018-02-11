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
	$idFormation = array();
	$titreFormation = array();
	$descriptionFormation = array();
	$documentFormation = array();
	$dureeFormation = array();
	
	// Requête qui va récuperer les informations concernant toutes les formations (titre, description, durée, fichier etc..).
	$S2 = "SELECT	idFormation, titreFormation, descriptionFormation, documentFormation, dureeFormation
			FROM	formation
			WHERE	dispoFormation = '1'";

	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	while ($D2 = mysqli_fetch_assoc($R2)) {
		$idFormation[] = $D2['idFormation'];
		$titreFormation[] = $D2['titreFormation'];
		$descriptionFormation[] = $D2['descriptionFormation'];
		$documentFormation[] = $D2['documentFormation'];
		$dureeFormation[] = $D2['dureeFormation'];
	}
	
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbIDFormation = count($idFormation);
		$_POST['titre'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script formation.
		$listeFormationID = array();
		$listeFormationID = rechercher_formation();
		$nbIDFormation = count($listeFormationID);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Formations");
	html_header($id);
	html_aside_main_debut("","","class=\"active\"","","","","","","","");
	
	echo '<h1 class="page-header">Nos formations</h1>';
	
		if($estAdmin == 0) {
			echo '<a href="ajoutFormation.php" class="btn btn-success btn-block"><span class="fa fa-plus"></span>AJOUTER UNE NOUVELLE FORMATION</a>';
		}

       echo '<form class="form-inline" method="POST" action="formation.php" accept-charset="iso-8859-1">',
          '<div class="form-group">',
            '<input type="text" class="form-control" name="titre" id="inputEmail" placeholder="Titre de la formation">',
          '</div>',
          '<button type="submit" class="btn btn-inline" name="btnValider"><span class="fa fa-search"></span>Rechercher</button>',
        '</form>';
		
		//if(count($listeFormationID) == 0) {
		
		if(!isset($_POST['btnValider'])) {
			if($nbIDFormation > 0) {
				for($i = 0;$i < $nbIDFormation; $i++){
					echo '<div class="item">',
					  '<div class="row">',
						'<div class="col-md-6 col-sm-12">',
						  '<h3>', $titreFormation[$i] ,'<small>#',$idFormation[$i],'</small></h3>',
						  '<p class="small">Durée de formation : ',$dureeFormation[$i],' semaines</p>',
						  '<p>',$descriptionFormation[$i],'</p>',
						'</div>',
						'<div class="col-md-6 col-sm-12">',
						  '<h3>STATISTIQUES</h3>',
						  '<table class="table table-striped">',
							'<tbody>',
							  '<tr>',
								'<th>Nombre candidatures</th>',
								'<td>6</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants acceptés</th>',
								'<td>4</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants diplomé</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants en formation</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre stages proposés</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre pôles de formation</th>',
								'<td>4</td>',
							  '</tr>',
							'</tbody>',
						  '</table>',
						'</div>',
					  '</div>',
					  '<div class="row">';
						if($estAdmin != 0) {
							echo '<div class="col-md-12 col-sm-12">',
							  '<a href="#about" class="btn btn-info btn-block"><span class="fa fa-eye" aria-hidden="true"></span>Acceder à la formation</a>',
							'</div>';
						}
						if($estAdmin == 0) {
							echo '<div class="col-md-12 col-sm-12">',
							  '<a href="gestionFormation.php" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer la formation</a>',
							'</div>';
						}
					  echo '</div>',
					'</div>';
				}
			}
			else {
				echo '<h3> Aucune formation n\'est disponible a l\'heure actuelle. </h3>';
			}
		}
		else {
			if($nbIDFormation > 0) {			
				for($i = 0;$i < $nbIDFormation; $i++){
					$S3 = "SELECT	titreFormation, descriptionFormation, documentFormation, dureeFormation
							FROM	formation
							WHERE	dispoFormation = '1'
							AND		idFormation = '$listeFormationID[$i]'";

					$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
					$D3 = mysqli_fetch_row($R3);
					
					$titre = $D3[0];
					$description = $D3[1];
					$document = $D3[2];
					$duree = $D3[3];
					echo '<div class="item">',
					  '<div class="row">',
						'<div class="col-md-6 col-sm-12">',
						  '<h3>', $titre ,'<small>#',$listeFormationID[$i],'</small></h3>',
						  '<p class="small">Durée de formation : ',$duree,' semaines</p>',
						  '<p>',$description,'</p>',
						'</div>',
						'<div class="col-md-6 col-sm-12">',
						  '<h3>STATISTIQUES</h3>',
						  '<table class="table table-striped">',
							'<tbody>',
							  '<tr>',
								'<th>Nombre candidatures</th>',
								'<td>6</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants acceptés</th>',
								'<td>4</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants diplomé</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants en formation</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre stages proposés</th>',
								'<td>2</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre pôles de formation</th>',
								'<td>4</td>',
							  '</tr>',
							'</tbody>',
						  '</table>',
						'</div>',
					  '</div>',
					  '<div class="row">';
						if($estAdmin != 0) {
							echo '<div class="col-md-12 col-sm-12">',
							  '<a href="#about" class="btn btn-info btn-block"><span class="fa fa-eye" aria-hidden="true"></span>Acceder à la formation</a>',
							'</div>';
						}
						if($estAdmin == 0) {
							echo '<div class="col-md-12 col-sm-12">',
							  '<a href="gestionFormation.php" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer la formation</a>',
							'</div>';
						}
					  echo '</div>',
					'</div>';
				}
			}
			else {
				echo '<h3> Aucune formation possèdant ce titre a été trouvé. </h3>';
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
	* Fonction qui permet de rechercher les informations concernant une
	* formation à partir de son titre.
	* Si on trouve des titres renvoie un tableau d'id des formations.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function rechercher_formation() {
		$idFormation = array();
		$titreFormation = array();
		
		$titre = trim($_POST['titre']); // on recupère la chaine a qui nous sert de recherche
		$titre = mysqli_real_escape_string($GLOBALS['bd'], $titre);
		if($titre == ""){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
			return $idFormation;
		}
	
		// Requête de recherche de titre
		$S = "SELECT	titreFormation
					FROM	formation";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		while ($D = mysqli_fetch_assoc($R)) {
			if(strpos($D['titreFormation'],$titre) !==  false){ // si le "titre" est contenu dans le titre de la formation alors on l'ajoute a notre array "titreFormation"
				$titreFormation[] = $D['titreFormation'];
			}
		}
		
		// On récupère les ID dont nous avons besoin
		foreach ($titreFormation as $Cle => $Valeur) {
					$S2 = "SELECT	idFormation
						FROM	formation
						WHERE 	titreFormation = '$Valeur'";
					$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
					$D2 = mysqli_fetch_row($R2);
					$idFormation[] = $D2[0];
		}
		
		$nbID = count($idFormation);
		if($nbID > 0){
			return array_values(array_unique($idFormation)); // on retourner l'array sans aucun double.
		}else{
			return $idFormation;
		}
	}
?>