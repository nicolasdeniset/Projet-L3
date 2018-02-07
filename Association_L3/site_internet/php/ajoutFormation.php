<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	$bd = bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	
	// Requête qui va récuperer les informations nous concernant (typeCompte).
	$S = "SELECT	typeCompte
			FROM	compte
			WHERE	idCompte = '$id'";

	$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);
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
		// cette fonction redirige la page sur le script compte.
		$erreurs = ajouter_formation($bd);
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Paramètre Compte");
	html_header($id);
	html_aside_main_debut("","","class=\"active\"","","","","","","","");
	
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
            '<form method="POST" action="ajoutFormation.php" accept-charset="iso-8859-1">',
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
                '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="85">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Fichier de la formation<sup style="color:red">*</sup></label>',
                '<input id="fichier" name="fichier" type="file" class="" placeholder="Entrez le fichier de la formation">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required">Disponniblité de la formation<sup style="color:red">*</sup></label><br>',
                '<label class="radio-inline"><input type="radio" name="optradio" checked>Public</label>',
                '<label class="radio-inline"><input type="radio" name="optradio">Privée</label>',
              '</div>',
              '<div class="col-md-12">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block"><span class="fa fa-check" aria-hidden="true"></span>Créer la nouvelle formation</button>',
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
	function ajouter_formation($bd) {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		
		// Vérification du titre
		$txtTitre = trim($_POST['titre']);
		if ($txtTitre == '') {
			$erreurs[] = 'Vous avez oublié le titre !';
		}
		
		// Vérification de la description
		$txtDescription = trim($_POST['description']);
		if ($txtDescription == '') {
			$erreurs[] = 'Vous avez oublié la description !';
		}
		
		// Vérification de la durée
		$txtDuree = trim($_POST['duree']);
		if ($txtDuree == '') {
			$erreurs[] = 'Vous avez mis une durée incorrecte !';
		}
		
		// Vérification du titre
		$txtTitre = trim($_POST['titre']);
		if ($txtTitre == '') {
			$erreurs[] = 'Vous avez oublié le titre !';
		}
		
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
	}
?>