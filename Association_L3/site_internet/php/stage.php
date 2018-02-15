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
	$idStage = array();
	
	if($estAdmin == 0) {
		// Requête qui va récuperer les informations concernant tout les identifiants de stage
		$S2 = "SELECT	idStage
				FROM	stage";
	}
	else {
		// Requête qui va récuperer les informations concernant tout les identifiants de stage
		$S2 = "SELECT	idStage
				FROM	stage
				WHERE	dispoStage = '1'";
	}

	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	while ($D2 = mysqli_fetch_assoc($R2)) {
		$idStage[] = $D2['idStage'];
	}
	
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbIDStage = count($idStage);
		$_POST['titre'] = "";
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script stage.
		$idStage = rechercher_stage($estAdmin);
		$nbIDStage = count($idStage);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Stages");
	html_header($id);
	html_aside_main_debut("","","","class=\"active\"","","","","","","");
	
	echo '<h1 class="page-header">Nos stages</h1>';
	
	if($estAdmin == 0) {
       echo '<a href="ajoutStage.php" class="btn btn-success btn-block"><span class="fa fa-plus"></span>AJOUTER UN NOUVEAU STAGE</a>';
	}

       echo '<form class="form-inline" method="POST" action="stage.php" accept-charset="iso-8859-1">',
          '<div class="form-group">',
            '<input type="text" class="form-control" name="titre" id="search" placeholder="Titre du stage">',
          '</div>',
          '<button type="submit" class="btn btn-inline"  name="btnValider"><span class="fa fa-search"></span>Rechercher</button>',
        '</form>';
		
		if(!isset($_POST['btnValider']) && $nbIDStage == 0) {
			echo '<h3> Aucun stage n\'est disponible a l\'heure actuelle. </h3>';
		}
		if(isset($_POST['btnValider']) && $nbIDStage == 0) {
			echo '<h3> Aucun stage possèdant ce titre a été trouvé. </h3>';
		}
		if($nbIDStage > 0) {
			for($i = 0;$i < $nbIDStage; $i++){
				$S3 = "SELECT	titreStage, entrepriseStage, descriptionStage, dureestage
							FROM	stage
							WHERE	idStage = '$idStage[$i]'";

				$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
				$D3 = mysqli_fetch_row($R3);
				$titre = $D3[0];
				$idEntrepriseStage = $D3[1];
				$description = $D3[2];
				$duree = $D3[3];
				
				$S4 = "SELECT	nomEntrepriseCompte
							FROM	compte
							WHERE	idCompte = '$idEntrepriseStage'";

				$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
				$D4 = mysqli_fetch_row($R4);
				$nomEntreprise = $D4[0];
				
				$stat = statistique_stage($idStage[$i]);
				
				echo '<div class="item">',
				  '<div class="row">',
					'<div class="col-md-6 col-sm-12">',
					  '<h3>', $titre ,'<small>#',$idStage[$i],'</small></h3>',
					  '<p class="small">Entreprise : ',$nomEntreprise,'</p>',
					  '<p class="small">Durée du stage : ',$duree,' semaines</p>',
					  '<p>',$description,'</p>',
					'</div>',
					'<div class="col-md-6 col-sm-12">',
					  '<h3>STATISTIQUES</h3>',
					  '<table class="table table-striped">',
						'<tbody>',
						  '<tr>',
							'<th>Nombre candidatures</th>',
							'<td>',$stat[0],'</td>',
						  '</tr>',
						  '<tr>',
							'<th>Nombre étudiants acceptés</th>',
							'<td>',$stat[1],'</td>',
						  '</tr>',
						  '<tr>',
							'<th>Nombre étudiants embauchés</th>',
							'<td>',$stat[2],'</td>',
						  '</tr>',
						  '<tr>',
							'<th>Nombre étudiants actuellement en stage</th>',
							'<td>',$stat[3],'</td>',
						  '</tr>',
						'</tbody>',
					  '</table>',
					'</div>',
				  '</div>',
				  '<div class="row">';
				if($estAdmin == 2) {
					echo '<div class="col-md-12 col-sm-12">',
							"<div onclick=\"javascript:openGestion(['formationBisNumero".$i,"']);\">",
							    '<button href="#" class="btn btn-info btn-block">Candidater</button>',
							'</div>',
							'<form class="gestion" id="formationBisNumero'.$i,'" method="POST" action="formation.php">',
								'<div class="form-group">',
									 '<br>',
					                 '<label class="control-label required">Qu\'est ce qui vous motive à faire cette formation ?</label>',
					                 '<textarea id="motivation" name="motivation'.$i,'" class="form-control" placeholder="Entrez vos motivations"></textarea>',
					            '</div>',
								'<button type="submit" class="btn btn-block btn-success" name="btnValider1'.$i,'">S\'inscrire</button>',
					        '</form>',
						'</div>';
				}
				if($estAdmin == 0) {
					echo '<div class="col-md-12 col-sm-12">',
					  '<a href="gestionStage.php" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer le stage</a>',
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
	* Fonction qui permet de rechercher les informations concernant une
	* formation à partir de son titre.
	* Si on trouve des titres renvoie un tableau d'id des formations.
	*
	* @return array $idFormation		Tableau des identifiants de Formation détectées.
	*/
	function rechercher_stage($estAdmin) {
		$idStage = array();
		
		$titre = trim($_POST['titre']); // on recupère la chaine a qui nous sert de recherche
		$titre = mysqli_real_escape_string($GLOBALS['bd'], $titre);
		if($titre == ""){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
			return $idStage;
		}
	
		// Requête de recherche de titre
		if($estAdmin == 0) {
			$S = "SELECT DISTINCT idStage 
					FROM stage 
					WHERE titreStage LIKE '%$titre%'";
		} else {
			$S = "SELECT DISTINCT idStage 
				FROM stage 
				WHERE titreStage LIKE '%$titre%'
				AND		dispoStage = '1'";
		}
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);	
		while ($D = mysqli_fetch_assoc($R)) {
				$idStage[] = $D['idStage'];
		}
		return $idStage;
	}
?>