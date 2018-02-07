<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	$bd = bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	
	// Requête qui va récuperer les informations nous concernant (mdpCompte, questionCompte, reponseCompte, typeCompte, coordonneesCompte).
	$S = "SELECT	mdpCompte,questionCompte,reponseCompte,typeCompte,coordonneesCompte
			FROM	compte
			WHERE	idCompte = '$id'";

	$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);
	$D = mysqli_fetch_row($R);
	
	// Traitement des variables obtenues.
	$txtPasse = $D[0];	
	$txtQuestion = $D[1];
	$txtReponse = $D[2];
	$txtTypeCompte = $D[3];
	$idCoordoneesCompte = $D[4];
	
	// Requête qui va récuperer les informations nous concernant (mdpCompte, questionCompte, reponseCompte, typeCompte, coordonneesCompte).
	$S2 = "SELECT	emailCoordonnees,telephoneCoordonnees,adresseCoordonnees,codePostalCoordonnees,villeCoordonnees,paysCoordonnees
			FROM	coordonnees
			WHERE	idCoordonnees = '$idCoordoneesCompte'";

	$R2 = mysqli_query($bd, $S2) or bd_erreur($bd, $S2);
	$D2 = mysqli_fetch_row($R2);
	
	// Traitement des variables obtenues.
	$txtEmail = $D2[0];	
	$txtTelephone = $D2[1];
	$txtAdresse = $D2[2];
	$txtCodePostal = $D2[3];
	$txtVille = $D2[4];
	$txtPays = $D2[5];
	
	//-----------------------------------------------------
	// Détermination de la phase de traitement : 1er affichage
	// ou soumission du formulaire
	//-----------------------------------------------------
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['email'] = $txtEmail;
		$_POST['password1'] = $txtPasse;
		$_POST['password2'] = $txtPasse;
		$_POST['question'] = $txtQuestion;
		$_POST['answer'] = $txtReponse;
		$_POST['phone'] = $txtTelephone;
		$_POST['address'] = $txtAdresse;
		$_POST['cp'] = $txtCodePostal;
		$_POST['city'] = $txtVille;
		$_POST['country'] = $txtPays;
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script compte.
		$erreurs = change_user($id, $idCoordoneesCompte);
		$nbErr = count($erreurs);
	}
	
	if (isset($_POST['btnValider3'])) {
		supprimer_user($id,$idCoordoneesCompte);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Paramètre Compte");
	html_header($id);
	html_aside_main_debut("","","","","","","","","","class=\"active\"");
	
	echo '<h1 class="page-header">Gestion de compte</h1>';
	
	// Si il y a des erreurs on les affiche
	if ($nbErr > 0) {
		echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
		for ($i = 0; $i < $nbErr; $i++) {
			echo '<br>', $erreurs[$i];
		}
	}
	
    echo '<div class="row">',
          '<form method="POST" action="gestionCompte.php" accept-charset="iso-8859-1">',
            '<div class="form-group">',
              '<label class="control-label required" for="email">Email<sup style="color:red">*</sup></label>',
              '<input id="email" name="email" type="text" class="form-control" placeholder="Entrez votre adresse mail" value="',$txtEmail,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="password">Mot de passe<sup style="color:red">*</sup></label>',
              '<input id="password" name="password1" type="password" class="form-control" placeholder="mot de passe">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="password">Confirmer le mot de passe<sup style="color:red">*</sup></label>',
              '<input id="password" name="password2" type="password" class="form-control" placeholder="mot de passe">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="question">Question secrète (en cas de perte de mot de passe)<sup style="color:red">*</sup></label>',
              '<input id="question" name="question" type="text" class="form-control" placeholder="Entrez votre question secrète" value="',$txtQuestion,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="answer">Réponse secrète<sup style="color:red">*</sup></label>',
              '<input id="answer" name="answer" type="text" class="form-control" placeholder="Entrez votre réponse secrète" value="',$txtReponse,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="phone">Téléphone<sup style="color:red">*</sup></label>',
              '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrez votre numéro de téléphone" value="',$txtTelephone,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
              '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue" value="',$txtAdresse,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
              '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrez votre code postal" value="',$txtCodePostal,'">',
            '</div>',
            '<div class="form-group">',
              '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
              '<input id="city" name="city" type="text" class="form-control" placeholder="Entrez votre ville" value="',$txtVille,'">',
            '</div>',

            '<div class="form-group">',
              '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
              '<input id="country" name="country" type="text" class="form-control" placeholder="Entrez votre pays" value="',$txtPays,'">',
            '</div>',
            '<div class="col-md-12">',
              '<div class="col-md-4">',
                '<button type="submit" onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer votre compte ?\'))" value="supprimer" class="btn btn-inline btn-danger btn-block" name="btnValider3"><span class="fa fa-trash-o" aria-hidden="true"></span>Supprimer compte</button>',
              '</div>',
              '<div class="col-md-4">',
                '<button type="reset" class="btn btn-inline btn-info btn-block" name="btnValider2">Annuler changement</button>',
              '</div>',
              '<div class="col-md-4">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Sauvegarder changement</button>',
              '</div>',
            '</div>',
          '</form>',
        '</div>';
	
	html_aside_main_fin();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Permet de connecter un utilisateur si aucun problème n'est détecté.
	*
	* fonction qui permet de changer les informations reliées au compte de
	* l'utilisateur et qui vérifie que les changements sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la même page.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function change_user($id, $idCoordoneesCompte) {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		$bd = bd_connexion();
		
		// Vérification du mail
		$txtMail = trim($_POST['email']);
		if ($txtMail == '') {
			$erreurs[] = 'L\'adresse mail est obligatoire';
		} elseif (strpos($txtMail, '@') === FALSE
		|| strpos($txtMail, '.') === FALSE)
		{
			$erreurs[] = 'L\'adresse mail n\'est pas valide';
		}
		
		// Vérification du mot de passe
		$txtPasse = trim($_POST['password1']);
		if ($txtPasse == '') {
			$erreurs[] = 'Le mot de passe est obligatoire';
		}

		$txtVerif = trim($_POST['password2']);
		if ($txtPasse != $txtVerif) {
			$erreurs[] = 'Le mot de passe est diff&eacute;rent dans les 2 zones';
		}
		
		// Vérification de la question
		$txtQuestion = trim($_POST['question']);
		if ($txtQuestion == '') {
			$erreurs[] = 'La question est obligatoire';
		}
		
		// Vérification de la réponse
		$txtReponse = trim($_POST['answer']);
		if ($txtReponse == '') {
			$erreurs[] = 'La r&eacute;ponse est obligatoire';
		}
		
		// Vérification du téléphone
		$txttelephone = trim($_POST['phone']);
		if ($txttelephone == '') {
			$erreurs[] = 'Le t&eacute;l&eacute;phone est obligatoire';
		}
		$long2 = strlen($txttelephone);
		if ($long2 != 10)
		{
			$erreurs[] = 'Le t&eacute;l&eacute;phone doit avoir 10 chiffres';
		}
		
		// Vérification de l'adresse
		$txtAdresse = trim($_POST['address']);
		if ($txtAdresse == '') {
			$erreurs[] = 'L\'adresse est obligatoire';
		}
		
		// Vérification du code postal
		$txtCp = trim($_POST['cp']);
		if ($txtCp == '') {
			$erreurs[] = 'Le code postal est obligatoire';
		}
		$long3 = strlen($txtCp);
		if ($long3 != 5)
		{
			$erreurs[] = 'Le code postal doit avoir 5 chiffres';
		}
		
		// Vérification de la ville
		$txtVille = trim($_POST['city']);
		if ($txtVille == '') {
			$erreurs[] = 'La ville est obligatoire';
		}

		// Vérification du pays
		$txtPays = trim($_POST['country']);
		if ($txtPays == '') {
			$erreurs[] = 'Le pays est obligatoire';
		}	
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		// Mise à jour des informations.
		$txtPasse = mysqli_real_escape_string($bd, md5($txtPasse));
		$txtQuestion = mysqli_real_escape_string($bd, $txtQuestion);
		$txtReponse = mysqli_real_escape_string($bd, $txtReponse);
		$txtMail = mysqli_real_escape_string($bd, $txtMail);
		$txttelephone = mysqli_real_escape_string($bd, $txttelephone);
		$txtAdresse = mysqli_real_escape_string($bd, $txtAdresse);
		$txtCp = mysqli_real_escape_string($bd, $txtCp);
		$txtVille = mysqli_real_escape_string($bd, $txtVille);
		$txtPays = mysqli_real_escape_string($bd, $txtPays);
		
		$S = "UPDATE	compte
					SET	mdpCompte = '$txtPasse', questionCompte = '$txtQuestion', reponseCompte = '$txtReponse'
					WHERE	idCompte = '$id'";

		$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);
		
		$S2 = "UPDATE	coordonnees
					SET	emailCoordonnees = '$txtMail', telephoneCoordonnees = '$txttelephone', adresseCoordonnees = '$txtAdresse',
						codePostalCoordonnees = '$txtCp', villeCoordonnees = '$txtVille', paysCoordonnees = '$txtPays'
					WHERE	idCoordonnees = '$idCoordoneesCompte'";

		$R2 = mysqli_query($bd, $S2) or bd_erreur($bd, $S2);
		
		header ('location: gestionCompte.php');
		exit();			// EXIT : le script est terminé
	}
	
	/**
	* Permet de connecter un utilisateur si aucun problème n'est détecté.
	*
	* fonction qui permet de changer les informations reliées au compte de
	* l'utilisateur et qui vérifie que les changements sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la même page.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function supprimer_user($id, $idCoordoneesCompte) {
		$bd = bd_connexion();
		
		$S = "DELETE FROM compte
					WHERE	idCompte = '$id'";

		$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);
		
		$S2 = "DELETE FROM coordonnees
					WHERE	idCoordonnees = '$idCoordoneesCompte'";

		$R2 = mysqli_query($bd, $S2) or bd_erreur($bd, $S2);
		
		header ('location: accueil.php');
		exit();			// EXIT : le script est terminé
	}
?>