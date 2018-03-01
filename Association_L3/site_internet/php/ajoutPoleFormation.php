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
		header('location: poleFormation.php');
		exit();			// EXIT : le script est terminé
	}
	
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['name'] = $_POST['firstname'] = "";
		$_POST['email'] = $_POST['phone'] = "";
		$_POST['address'] = $_POST['cp'] = "";
		$_POST['city'] = $_POST['country'] = "";
		$_POST['gpsLatitude'] = $_POST['gpsLongitude'] = "";
		$_POST['nbBenevole'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script stage.
		$erreurs = ajouter_pole();
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Ajouter un pole de formation");
	html_header($id);
	html_aside_main_debut(APP_PAGE_POLE);
	
	echo '<h1 class="page-header">Ajout d\'un pole de formation</h1>';
	
	// Si il y a des erreurs on les affiche
	if ($nbErr > 0) {
		echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
		for ($i = 0; $i < $nbErr; $i++) {
			echo '<br>', $erreurs[$i];
		}
	}

	echo '<div class="item">',
          '<div class="row">',
            '<form method="POST" action="ajoutPoleFormation.php" accept-charset="iso-8859-1" >',
              '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du responsable<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrer son nom">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du responsable<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrer son prénom">',
                  '</div>',                   
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email du responsable<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrer son adresse mail">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone du responsable<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer son numéro de téléphone">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrer son code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrer sa ville">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrer son pays">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="gpsLatitude">Coordonnées GPS Latitude<sup style="color:red">*</sup></label>',
                    '<input id="gpsLatitude" name="gpsLatitude" type="number" step="any" class="form-control" placeholder="Entrer latitude">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="gpsLongitude">Coordonnées GPS Longitude<sup style="color:red">*</sup></label>',
                    '<input id="gpsLongitude" name="gpsLongitude" type="number" step="any" class="form-control" placeholder="Entrer longitude">',
                  '</div>',
				  '<div class="form-group">',
					'<label class="control-label required" for="name">Nombre de bénévole<sup style="color:red">*</sup></label>',
					'<input id="nbBenevole" name="nbBenevole" type="number" class="form-control" placeholder="Entrez le nombre de bénévoles" value="5">',
				  '</div>',
				  '<div class="col-md-12">',
					'<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Créer le nouveau pole</button>',
				  '</div>',
			'</form>',
		  '</div>',
			  
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Fonction qui permet d'ajouter les informations reliées à un nouveau
	* pole et qui vérifie que les ajouts sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la page poleFormation.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function ajouter_pole() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		
		$txtNom = trim(utf8_encode($_POST['name']));
		$txtPrenom = trim(utf8_encode($_POST['firstname']));
		$txtMail = trim(utf8_encode($_POST['email']));
		$txttelephone = trim(utf8_encode($_POST['phone']));
		$txtAdresse = trim(utf8_encode($_POST['address']));
		$txtCp = trim(utf8_encode($_POST['cp']));
		$txtVille = trim(utf8_encode($_POST['city']));
		$txtPays = trim(utf8_encode($_POST['country']));
		$txtLatitude = trim($_POST['gpsLatitude']);
		$txtLongitude = trim($_POST['gpsLongitude']);
		$txtNbBenevole = trim($_POST['nbBenevole']);
	}
	
	// Vérification du nom
		if ($txtNom == '') {
			$erreurs[] = 'Le nom est obligatoire';
		}
		
		// Vérification du prénom
		if ($txtPrenom == '') {
			$erreurs[] = 'Le pr&eacute;nom est obligatoire';
		}

		// Vérification du mail
		if ($txtMail == '') {
			$erreurs[] = 'L\'adresse mail est obligatoire';
		} elseif (strpos($txtMail, '@') === FALSE
		|| strpos($txtMail, '.') === FALSE)
		{
			$erreurs[] = 'L\'adresse mail n\'est pas valide';
		}
		
		// Vérification du téléphone
		if ($txttelephone == '') {
			$erreurs[] = 'Le t&eacute;l&eacute;phone est obligatoire';
		}
		$long2 = strlen($txttelephone);
		if ($long2 != 10)
		{
			$erreurs[] = 'Le t&eacute;l&eacute;phone doit avoir 10 chiffres';
		}
		if(ctype_digit($txttelephone) != true) {
			$erreurs[] = 'Le t&eacute;l&eacute;phone entré n\'est pas un numéro';
		}
		
		// Vérification de l'adresse
		if ($txtAdresse == '') {
			$erreurs[] = 'L\'adresse est obligatoire';
		}
		
		// Vérification du code postal
		if ($txtCp == '') {
			$erreurs[] = 'Le code postal est obligatoire';
		}
		$long3 = strlen($txtCp);
		if ($long3 != 5)
		{
			$erreurs[] = 'Le code postal doit avoir 5 chiffres';
		}
		if(ctype_digit($txtCp) != true) {
			$erreurs[] = 'Le code postal entré n\'est pas un numéro';
		}
		
		// Vérification de la ville
		if ($txtVille == '') {
			$erreurs[] = 'La ville est obligatoire';
		}

		// Vérification du pays
		if ($txtPays == '') {
			$erreurs[] = 'Le pays est obligatoire';
		}
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
?>