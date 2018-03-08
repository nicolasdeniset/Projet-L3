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
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
	}
	
	//-----------------------------------------------------
	// Détermination de la phase de traitement : 1er affichage
	// ou soumission du formulaire
	//-----------------------------------------------------
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['titre'] = "";
		$_POST['description'] = "";
		$_POST['duree'] = "";
		$_POST['fichier'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script formation.
		$erreurs = ajouter_formation();
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Ajouter une Formation");
	html_header($id);
	html_aside_main_debut(APP_PAGE_FORMATION);
	
	echo '<h1 class="page-header">Ajout d\'une formation</h1>';
		
	// Si il y a des erreurs on les affiche
	if ($nbErr > 0) {
		echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
		for ($i = 0; $i < $nbErr; $i++) {
			echo '<br>', $erreurs[$i];
		}
	}

    echo '<div class="item">',
          '<div class="row">',
            '<form method="POST" action="ajoutFormation.php" accept-charset="iso-8859-1" enctype="multipart/form-data">',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Titre de la formation<sup style="color:red">*</sup></label>',
                '<input id="titre" name="titre" type="text" class="form-control" placeholder="Entrez le titre de la formation">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Description de la formation<sup style="color:red">*</sup></label>',
                '<textarea id="description" name="description" type="textarea" class="form-control" placeholder="Entrez la description de la formation"></textarea>',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Durée de la formation<sup style="color:red">*</sup></label>',
                '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="5">',
              '</div>',
			  '<div class="form-group">',
                '<label class="control-label">Dans quel(s) pôle(s) a lieu cette formation ? <sup style="color:red">*</sup></label><br>';
				// Requête qui va récuperer les informations nous concernant (typeCompte).
				$S2 = "SELECT	idPoleFormation, villeCoordonnees
						FROM	poleformation, coordonnees
						WHERE	coordonneesPoleFormation = idCoordonnees";

				$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
				$i = 0;
				while ($D2 = mysqli_fetch_assoc($R2)) {
					echo '<input type="checkbox" id="pole',$i,'" name="pole[]" value="',$D2["idPoleFormation"],'"/>',
					' <label for="pole',$i,'"> ',$D2["villeCoordonnees"],' </label> ';
					$i++;
				}
				
				echo '</p>',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required">Disponiblité de la formation<sup style="color:red">*</sup></label><br>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="1" checked>Public</label>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="0">Privée</label>',
              '</div>',
              '<div class="col-md-12">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Créer la nouvelle formation</button>',
              '</div>',
            '</form>',
          '</div>';
		  
	html_aside_main_fin();
	echo '</body></html>';
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Fonction qui permet d'ajouter les informations reliées à une nouvelle
	* formation et qui vérifie que les changements sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la page formation.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function ajouter_formation() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();

		// Vérification du titre
		$txtTitre = trim(utf8_encode($_POST['titre']));
		if ($txtTitre == '') {
			$erreurs[] = 'Vous avez oublié le titre !';
		}
		$txtTitre = mysqli_real_escape_string($GLOBALS['bd'], $txtTitre);
		$S = "SELECT	count(*)
					FROM	formation
					WHERE	titreFormation = '$txtTitre'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		if ($D[0] > 0) {
			$erreurs[] = 'Une formation possède déjà ce titre';
		}
		
		// Vérification de la description
		$txtDescription = trim(utf8_encode($_POST['description']));
		if ($txtDescription == '') {
			$erreurs[] = 'Vous avez oublié la description !';
		}
		
		// Vérification de la durée
		$txtDuree = trim(utf8_encode($_POST['duree']));
		if ($txtDuree == '') {
			$erreurs[] = 'Vous avez oublié de mettre une durée !';
		}
		if(ctype_digit($txtDuree) != true) {
			$erreurs[] = 'Vous avez mis une durée incorrecte !';
		}
		
		// Vérification du fichier
		/*$dossier = "../upload/";
		$fichier = basename($_FILES['formation']['name']);
		$taille = filesize($_FILES['formation']['tmp_name']);
		$extension = strrchr($_FILES['formation']['name'], '.');
		
		if($extension != ".pdf") {
			$erreurs[] = 'Votre fichier n\'est pas au format PDF ';
		}*/
		
		//renomage du fichier
		/*rename("$fichier", "file" .time(). "1");
		
		if(!move_uploaded_file($_FILES['formation']['tmp_name'], $dossier . $fichier)) {
			$erreurs[] = "Erreur interne de transfert";
		}*/
		
		// Vérification des poles enseignant la formation
		$nbPole = count($_POST['pole']);
		if ($nbPole < 1) {
			$erreurs[] = 'Votre formation n\'est liée a aucun pole de formation';
		}

		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		// Ajout des informations.
		$txtDescription = mysqli_real_escape_string($GLOBALS['bd'], $txtDescription);
		$txtDuree = mysqli_real_escape_string($GLOBALS['bd'], $txtDuree);
		$fichier = mysqli_real_escape_string($GLOBALS['bd'], "PROJET_L3");
		$taille = mysqli_real_escape_string($GLOBALS['bd'], "145000");
		$formationDispo = mysqli_real_escape_string($GLOBALS['bd'], $_POST['optradio']);
		
		$S = "INSERT INTO formation SET
				titreFormation = '$txtTitre',
				descriptionFormation = '$txtDescription',
				documentFormation = '$fichier',
				tailleDocumentFormation = '$taille',
				dureeFormation = '$txtDuree',
				dispoFormation = '$formationDispo'";
		
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S2 = "SELECT	idFormation
			FROM	formation
			WHERE	titreFormation = '$txtTitre'
			AND	descriptionFormation = '$txtDescription'
			AND	dureeFormation = '$txtDuree'
			AND	dispoFormation = '$formationDispo'";

		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		$D2 = mysqli_fetch_row($R2);
		$idFormation = mysqli_real_escape_string($GLOBALS['bd'], $D2[0]);
	
		foreach($_POST['pole'] as $pole){
			$pole = mysqli_real_escape_string($GLOBALS['bd'], $pole);
			$S = "INSERT INTO propose SET
				formationPropose = '$idFormation',
				polePropose = '$pole'";
		
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		}
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>