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
	
	if($estAdmin == 0) {
		// Requête qui va récuperer les informations concernant toutes les formations (titre, description, durée, fichier etc..).
		$S2 = "SELECT	idFormation, titreFormation, descriptionFormation, documentFormation, dureeFormation
				FROM	formation";
	}
	else {
		// Requête qui va récuperer les informations concernant toutes les formations (titre, description, durée, fichier etc..).
		$S2 = "SELECT	idFormation, titreFormation, descriptionFormation, documentFormation, dureeFormation
				FROM	formation
				WHERE	dispoFormation = '1'";
	}

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
		
		if($nbIDFormation > 0) {
			for($i = 0;$i < $nbIDFormation; $i++){
				if (! isset($_POST["btnValider1$i"])) {
					$nbErr[$i] = 0;
					$_POST["motivation$i"] = "";
				} else {
					$erreurs[$i] = candidater($idFormation[$i],$i,$estAdmin);
					$nbErr[$i] = count($erreurs[$i]);
				}
			}
		}
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script formation.
		$listeFormationID = array();
		$listeFormationID = rechercher_formation();
		$nbIDFormation = count($listeFormationID);
		
		if($nbIDFormation > 0) {
			for($i = 0;$i < $nbIDFormation; $i++){
				if (! isset($_POST["btnValider1$i"])) {
					$nbErr[$i] = 0;
					$_POST["motivation$i"] = "";
				} else {
					$erreurs[$i] = candidater($listeFormationID[$i],$i,$estAdmin);
					$nbErr[$i] = count($erreurs[$i]);
				}
			}
		}
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
		
		if(!isset($_POST['btnValider'])) {
			if($nbIDFormation > 0) {
				for($i = 0;$i < $nbIDFormation; $i++){
					if ($nbErr[$i] > 0) {
						echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
						for ($j = 0; $j < $nbErr[$i]; $j++) {
							echo '<br>', $erreurs[$i][$j];
						}
					}
					$S4 = "SELECT	idCandidature
							FROM	candidature
							WHERE	typeCandidature = '1'
							AND		experienceCandidature = '$idFormation[$i]'
							AND		compteCandidature = '$estAdmin'
							AND		traiteeCandidature = '0'";

					$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
					$D4 = mysqli_fetch_row($R4);
					$dejaCandidater = $D4[0];
					
					$date = date('Ymd');
					$S5 = "SELECT DISTINCT etudiantAsuivi
							FROM propose, asuivi
							WHERE idPropose = formationAsuivi
							AND formationPropose = '$idFormation[$i]'
							AND (certificationAsuivi = '1' OR dateFinAsuivi > '$date')";

					$R5 = mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($GLOBALS['bd'], $S5);
					$D5 = mysqli_fetch_row($R5);
					$dejaEnFormation = $D5[0];
					$stat = statistique_formation($idFormation[$i]);
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
								'<td>',$stat[0],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants acceptés</th>',
								'<td>',$stat[1],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants diplomé</th>',
								'<td>',$stat[2],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants en formation</th>',
								'<td>',$stat[3],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre stages proposés</th>',
								'<td>',$stat[4],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre pôles de formation</th>',
								'<td>',$stat[5],'</td>',
							  '</tr>',
							'</tbody>',
						  '</table>',
						'</div>',
					  '</div>',
					  '<div class="row">';
						if($estAdmin == 2 && $dejaCandidater == NULL && $dejaEnFormation == NULL) {
							echo '<div class="col-md-12 col-sm-12">',

								  	"<div onclick=\"javascript:openGestion(['formationNumero".$i,"']);\">",
							            '<button href="#" class="btn btn-info btn-block">Candidater</button>',
							        '</div>',

								  '<form class="gestion" id="formationNumero'.$i,'" method="POST" action="formation.php">',
	                
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
							  '<a href="gestionFormation.php?id=',$idFormation[$i],'" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer la formation</a>',
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
					if ($nbErr[$i] > 0) {
						echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
						for ($j = 0; $j < $nbErr[$i]; $j++) {
							echo '<br>', $erreurs[$i][$j];
						}
					}
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
					
					$S4 = "SELECT	idCandidature
							FROM	candidature
							WHERE	typeCandidature = '1'
							AND		experienceCandidature = '$listeFormationID[$i]'
							AND		compteCandidature = '$estAdmin'
							AND		traiteeCandidature = '0'";

					$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
					$D4 = mysqli_fetch_row($R4);
					$dejaCandidater = $D4[0];
					
					$date = date('Ymd');
					$S5 = "SELECT DISTINCT etudiantAsuivi
							FROM propose, asuivi
							WHERE idPropose = formationAsuivi
							AND formationPropose = '$listeFormationID[$i]'
							AND (certificationAsuivi = '1' OR dateFinAsuivi > '$date')";

					$R5 = mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($GLOBALS['bd'], $S5);
					$D5 = mysqli_fetch_row($R5);
					$dejaEnFormation = $D5[0];
					$stat = statistique_formation($listeFormationID[$i]);
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
								'<td>',$stat[0],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants acceptés</th>',
								'<td>',$stat[1],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants diplomé</th>',
								'<td>',$stat[2],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre étudiants en formation</th>',
								'<td>',$stat[3],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre stages proposés</th>',
								'<td>',$stat[4],'</td>',
							  '</tr>',
							  '<tr>',
								'<th>Nombre pôles de formation</th>',
								'<td>',$stat[5],'</td>',
							  '</tr>',
							'</tbody>',
						  '</table>',
						'</div>',
					  '</div>',
					  '<div class="row">';
						if($estAdmin == 2 && $dejaCandidater == NULL && $dejaEnFormation == NULL) {
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
							  '<a href="gestionFormation.php?id=',$listeFormationID[$i],'" class="btn btn-success btn-block"><span class="fa fa-cogs" aria-hidden="true"></span>Gerer la formation</a>',
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
	* @return array $idFormation		Tableau des identifiants de Formation détectées.
	*/
	function rechercher_formation() {
		$idFormation = array();
		
		$titre = trim($_POST['titre']); // on recupère la chaine a qui nous sert de recherche
		$titre = mysqli_real_escape_string($GLOBALS['bd'], $titre);
		if($titre == ""){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
			return $idFormation;
		}
	
		// Requête de recherche de titre
		$S = "SELECT DISTINCT idFormation 
				FROM formation 
				WHERE titreFormation LIKE '%$titre%'
				AND		dispoFormation = '1'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		while ($D = mysqli_fetch_assoc($R)) {
				$idFormation[] = $D['idFormation'];
		}
			return $idFormation;
	}
	
	function candidater($idFormation, $i, $idCompte) {
		//-----------------------------------------------------
		// Vérification de la zone
		//-----------------------------------------------------	
		// Vérification du texte de motivation
		$txtMotivation = trim(utf8_encode($_POST["motivation$i"]));	
		if ($txtMotivation == '') {
			$erreurs[] = 'Le texte de motivation est obligatoire';
		}
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		$txtMotivation = mysqli_real_escape_string($GLOBALS['bd'], $txtMotivation);
		
		$S = "INSERT INTO candidature SET
				compteCandidature = '$idCompte',
				typeCandidature = '1',
				experienceCandidature = '$idFormation',
				lettreMotivCandidature = \"$txtMotivation\",
				traiteeCandidature = '0',
				accepteeCandidature = '0'";
		
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>