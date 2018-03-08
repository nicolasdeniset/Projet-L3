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
	if($estAdmin != 0 && $estAdmin != 1) {
		header('location: stage.php');
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
		$_POST['titre'] = $_POST['name'] = "";
		$_POST['firstname'] = $_POST['email'] = "";
		$_POST['phone'] = $_POST['address'] = "";
		$_POST['cp'] = $_POST['city'] = "";
		$_POST['country'] = $_POST['description'] = "";
		$_POST['duree'] = $_POST['compagnyName'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script stage.
		$erreurs = ajouter_stage();
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Ajouter un stage");
	html_header($id);
	html_aside_main_debut(APP_PAGE_STAGE);
	
	echo '<h1 class="page-header">Ajout d\'un stage</h1>';
	
	// Si il y a des erreurs on les affiche
	if ($nbErr > 0) {
		echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
		for ($i = 0; $i < $nbErr; $i++) {
			echo '<br>', $erreurs[$i];
		}
	}
	
       echo '<div class="item">',
          '<div class="row">',
            '<form method="POST" action="ajoutStage.php" accept-charset="iso-8859-1" >',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Titre du stage<sup style="color:red">*</sup></label>',
                '<input id="titre" name="titre" type="text" class="form-control" placeholder="Entrez le titre du stage">',
              '</div>',
				   '<div class="form-group">',
				   '<label class="control-label required" for="compagnyName">Sélectionner le nom de l\'entreprise proposant le stage<sup style="color:red">*</sup></label><br>';
				   if($estAdmin == 0) {
						$S2 = "SELECT nomEntrepriseCompte, idCompte 
								FROM compte 
								WHERE nomEntrepriseCompte != ''";
						$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
						$D2 = mysqli_fetch_row($R2);
						echo '<select name="compagnyName">',
							'<option value="',$D2[1],'">',$D2[0],'</option>';
						while ($D2 = mysqli_fetch_assoc($R2)) {
							echo '<option value="',$D2['idCompte'],'">',$D2['nomEntrepriseCompte'],'</option>';
						}
					}
				   else {
					   $S2 = "SELECT nomEntrepriseCompte, idCompte 
								FROM compte 
								WHERE idCompte = '$id'";
						$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
						$D2 = mysqli_fetch_row($R2);
						echo '<select name="compagnyName">',
							'<option value="',$D2[1],'">',$D2[0],'</option>';
				   }
						echo '</select>',
					  '</div>',
					   '<div class="form-group">',
					   '<label class="control-label required" for="formationName">Sélectionner la formation nécessaire pour obtenir ce stage<sup style="color:red">*</sup></label><br>';
						$S3 = "SELECT titreFormation, idFormation 
								FROM formation";
						$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
						$D3 = mysqli_fetch_row($R3);
						echo '<select name="formationName">',
							'<option value="',$D3[1],'">',$D3[0],'</option>';
						while ($D3 = mysqli_fetch_assoc($R3)) {
							echo '<option value="',$D3['idFormation'],'">',$D3['titreFormation'],'</option>';
						}
				    echo '</select>',
                  '</div>',
				   '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrez son nom">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrez son prénom">',
                  '</div>',                   
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrez son adresse mail">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrez son numéro de téléphone">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse du stage<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal du stage<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrez son code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville du stage<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrez sa ville">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays du stage<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrez son pays">',
                  '</div>',
			  '<div class="form-group">',
                '<label class="control-label required" for="name">Description du stage<sup style="color:red">*</sup></label>',
                '<textarea id="description" name="description" type="text" class="form-control" placeholder="Entrez la description du stage"></textarea>',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Durée du stage<sup style="color:red">*</sup></label>',
                '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="5">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required">Disponiblité du stage<sup style="color:red">*</sup></label><br>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="1" checked>Public</label>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="0">Privée</label>',
              '</div>',
              '<div class="col-md-12">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Créer le nouveau stage</button>',
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
	* stage et qui vérifie que les ajouts sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la page stage.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function ajouter_stage() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		
		$txtTitre = trim(utf8_encode($_POST['titre']));
		$idCompteEntreprise = trim(utf8_encode($_POST['compagnyName']));
		$idFormation = trim(utf8_encode($_POST['formationName']));
		$txtNom = trim(utf8_encode($_POST['name']));
		$txtPrenom = trim(utf8_encode($_POST['firstname']));
		$txtMail = trim(utf8_encode($_POST['email']));
		$txttelephone = trim(utf8_encode($_POST['phone']));
		$txtAdresse = trim(utf8_encode($_POST['address']));
		$txtCp = trim(utf8_encode($_POST['cp']));
		$txtVille = trim(utf8_encode($_POST['city']));
		$txtPays = trim(utf8_encode($_POST['country']));
		$txtDescription = trim(utf8_encode($_POST['description']));
		$txtDuree = trim($_POST['duree']);
		
		// Vérification du titre
		if ($txtTitre == '') {
			$erreurs[] = 'Vous avez oublié le titre !';
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
		
		// Vérification de la description
		if ($txtDescription == '') {
			$erreurs[] = 'Vous avez oublié la description !';
		}
		
		// Vérification de la durée
		if ($txtDuree == '') {
			$erreurs[] = 'Vous avez oublié de mettre une durée !';
		}
		if(ctype_digit($txtDuree) != true) {
			$erreurs[] = 'Vous avez mis une durée incorrecte !';
		}
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		// Ajout des informations.
		$txtTitre = mysqli_real_escape_string($GLOBALS['bd'], $txtTitre);
		$txtNom = mysqli_real_escape_string($GLOBALS['bd'], $txtNom);
		$txtPrenom = mysqli_real_escape_string($GLOBALS['bd'], $txtPrenom);
		$txtMail = mysqli_real_escape_string($GLOBALS['bd'], $txtMail);
		$txttelephone = mysqli_real_escape_string($GLOBALS['bd'], $txttelephone);
		$txtAdresse = mysqli_real_escape_string($GLOBALS['bd'], $txtAdresse);
		$txtCp = mysqli_real_escape_string($GLOBALS['bd'], $txtCp);
		$txtVille = mysqli_real_escape_string($GLOBALS['bd'], $txtVille);
		$txtPays = mysqli_real_escape_string($GLOBALS['bd'], $txtPays);
		$txtDescription = mysqli_real_escape_string($GLOBALS['bd'], $txtDescription);
		$txtDuree = mysqli_real_escape_string($GLOBALS['bd'], $txtDuree);
		$stageDispo = mysqli_real_escape_string($GLOBALS['bd'], $_POST['optradio']);
		$idCompteEntreprise = mysqli_real_escape_string($GLOBALS['bd'], $idCompteEntreprise);
		$idFormation = mysqli_real_escape_string($GLOBALS['bd'], $idFormation);
		
		$S = "INSERT INTO coordonnees SET
				nomCoordonnees = '$txtNom',
				prenomCoordonnees = '$txtPrenom',
				emailCoordonnees = '$txtMail',
				telephoneCoordonnees = '$txttelephone',
				adresseCoordonnees = '$txtAdresse',
				codePostalCoordonnees = '$txtCp',
				villeCoordonnees = '$txtVille',
				paysCoordonnees = '$txtPays'";
		
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S2 = "SELECT idCoordonnees
				FROM coordonnees
				WHERE nomCoordonnees = '$txtNom'
				AND prenomCoordonnees = '$txtPrenom'
				AND emailCoordonnees = '$txtMail'
				AND adresseCoordonnees = '$txtAdresse'
				AND codePostalCoordonnees = '$txtCp'
				AND villeCoordonnees = '$txtVille'
				AND paysCoordonnees = '$txtPays'";
				
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		$D2 = mysqli_fetch_row($R2);
		$idCoordonnees = $D2[0];
		
		$S3 = "INSERT INTO stage SET
				titreStage = '$txtTitre',
				entrepriseStage = '$idCompteEntreprise',
				descriptionStage = '$txtDescription',
				coordonneesStage = '$idCoordonnees',
				dureeStage = '$txtDuree',
				dispoStage = '$stageDispo'";
		
		mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		
		$S4 = "SELECT idStage
				FROM stage
				WHERE titreStage = '$txtTitre'
				AND entrepriseStage = '$idCompteEntreprise'
				AND descriptionStage = '$txtDescription'
				AND coordonneesStage = '$idCoordonnees'
				AND dureeStage = '$txtDuree'
				AND dispoStage = '$stageDispo'";
				
		$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
		$D4 = mysqli_fetch_row($R4);
		$idStage = $D4[0];
		
		$S5 = "INSERT INTO certificationrequise SET
				stageCertificationRequise  = '$idStage',
				formationCertificationRequise = '$idFormation'";
		
		mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($GLOBALS['bd'], $S5);
		
		header('location: stage.php');
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>