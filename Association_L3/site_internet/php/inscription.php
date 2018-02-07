<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');
	
	//-----------------------------------------------------
	// Détermination de la phase de traitement : 1er affichage
	// ou soumission du formulaire
	//-----------------------------------------------------
	if (! isset($_POST['btnValider1'])) {
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['pseudo'] = $_POST['name'] = '';
		$_POST['firstname'] = $_POST['email'] = '';
		$_POST['password1'] = $_POST['password2'] = '';
		$_POST['question'] = $_POST['answer'] = '';
		$_POST['phone'] = $_POST['address'] = '';
		$_POST['cp'] = $_POST['city'] = '';
		$_POST['country'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs = inscrire_user();
		$nbErr = count($erreurs);
	}
	if (! isset($_POST['btnValider2'])) {
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr2 = 0;
		$_POST['pseudo'] = $_POST['compagnyName'] = '';
		$_POST['firstname'] = $_POST['email'] = '';
		$_POST['password1'] = $_POST['password2'] = '';
		$_POST['question'] = $_POST['answer'] = '';
		$_POST['phone'] = $_POST['address'] = '';
		$_POST['cp'] = $_POST['city'] = '';
		$_POST['country'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs2 = inscrire_entreprise();
		$nbErr2 = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("TEST CSS & DESIGN login");
	html_header();
	
	 echo '<div class="container">',
      '<div class="row">',

        '<main>',
        '<section>',
        '<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 col-sm-12 col-xs-12">',
          '<div class="account-holder">',
            '<h2 class="text-center">JE M\'INSCRIS</h2>';
			
			// Si il y a des erreurs on les affiche
			if ($nbErr > 0) {
				echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
				for ($i = 0; $i < $nbErr; $i++) {
					echo '<br>', $erreurs[$i];
				}
			}
			
			if ($nbErr2 > 0) {
				echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
				for ($i = 0; $i < $nbErr; $i++) {
					echo '<br>', $erreurs[$i];
				}
			}

            echo '<div class="row">',
              '<div id="studentChoice" class="text col-md-6 col-sm-12" onclick="javascript:openGestion([\'student\', \'company\']); return false;">',
                '<a href="#" class="btn btn-success btn-block">En tant qu\'étudiant</a>',
              '</div>',
              '<div id="companyChoice" class="text col-md-6 col-sm-12" onclick="javascript:openGestion([\'company\', \'student\']); return false;">',
                '<a href="#" class="btn btn-success btn-block">En tant qu\'entreprise</a>',
              '</div>',
            '</div>',

            '<form id="student" method="POST">',
                
                  '<div class="form-group">',
                    '<label class="control-label required" for="pseudo">Nom de compte<sup style="color:red">*</sup></label>',
                    '<input id="pseudo" name="pseudo" type="text" class="form-control" placeholder="Entrez votre nom de compte">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom de l\'étudiant<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrez votre nom">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom de l\'étudiant<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrez votre prénom">',
                  '</div>',
                                  
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrez votre adresse mail">',
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
                    '<input id="question" name="question" type="text" class="form-control" placeholder="Entrez votre question secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="answer">Réponse secrète<sup style="color:red">*</sup></label>',
                    '<input id="answer" name="answer" type="text" class="form-control" placeholder="Entrez votre réponse secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrez votre numéro de téléphone">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrez votre code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrez votre ville">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrez votre pays">',
                  '</div>',

                
                  '<button type="submit" class="btn btn-block btn-success" name="btnValider1">S\'inscrire</button>',
                
              '</form>',

               '<form id="company" method="POST">',
               
                  '<div class="form-group">',
                    '<label class="control-label required" for="pseudo">Nom de compte<sup style="color:red">*</sup></label>',
                    '<input id="pseudo" name="pseudo" type="text" class="form-control" placeholder="Entrez votre nom de compte">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="compagnyName">Nom de l\'entreprise<sup style="color:red">*</sup></label>',
                    '<input id="compagnyName" name="compagnyName" type="text" class="form-control" placeholder="Entrez le nom de votre entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du gérant<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrez le nom du gérant de l\'entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du gérant<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrez le prénom du gérant de l\'entreprise">',
                  '</div>',
                                  
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrez l\'adresse mail de l\'entreprise">',
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
                    '<input id="question" name="question" type="text" class="form-control" placeholder="Entrez votre question secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="answer">Réponse secrète<sup style="color:red">*</sup></label>',
                    '<input id="answer" name="answer" type="text" class="form-control" placeholder="Entrez votre réponse secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrez le numéro de téléphone de l\'entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrez le code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrez la ville">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrez le pays">',
                  '</div>',
                                
                  '<button type="submit" class="btn btn-block btn-success" name="btnValider2">S\'inscrire</button>',
                
              '</form>',

            '</div> ',      
          '</div>',
          '</section>',

        '</main> ',             
      '</div>',
    '</div>';
	
	html_pied("little");
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Permet d'inscrire un utilisateur si aucun problème n'est détecté.
	*
	* fonction qui vérifie que les informations de l'utilisateur sont correctes
	* et les ajoute à la base de donnée.
	* Si aucune erreur n'est détecté on connecte l'utilisateur et on le redirige
	* vers la page accueil.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function inscrire_user() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------
		$erreurs = array();

		// Vérification du pseudo
		$txtPseudo = trim($_POST['pseudo']);
		$long = strlen($txtPseudo);
		if ($long < 4
		|| $long > 30)
		{
			$erreurs[] = 'Le pseudo doit avoir de 4 &agrave; 30 caract&egrave;res';
		} else {
			// Vérification que le pseudo n'existe pas dans la BD
			$bd = bd_connexion();

			$txtPseudo = mysqli_real_escape_string($bd, $txtPseudo);

			$S = "SELECT	count(*)
					FROM	compte
					WHERE	nomCompte = '$txtPseudo'";

			$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);

			$D = mysqli_fetch_row($R);

			if ($D[0] > 0) {
				$erreurs[] = 'Le pseudo doit &ecirc;tre chang&eacute;';
			}
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

		// Vérification du nom
		$txtNom = trim($_POST['name']);
		if ($txtNom == '') {
			$erreurs[] = 'Le nom est obligatoire';
		}
		
		// Vérification du prénom
		$txtPrenom = trim($_POST['firstname']);
		if ($txtPrenom == '') {
			$erreurs[] = 'Le pr&eacute;nom est obligatoire';
		}
		

		// Vérification du mail
		$txtMail = trim($_POST['email']);
		if ($txtMail == '') {
			$erreurs[] = 'L\'adresse mail est obligatoire';
		} elseif (strpos($txtMail, '@') === FALSE
		|| strpos($txtMail, '.') === FALSE)
		{
			$erreurs[] = 'L\'adresse mail n\'est pas valide';
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
		
		//-----------------------------------------------------
		// Insertion d'un nouvel enregistrement dans la base de données
		//-----------------------------------------------------
		$dateInscription = date('Ymd');
		$txtPasse = mysqli_real_escape_string($bd, md5($txtPasse));
		$txtQuestion = mysqli_real_escape_string($bd, $txtQuestion);
		$txtReponse = mysqli_real_escape_string($bd, $txtReponse);
		$txtNom = mysqli_real_escape_string($bd, $txtNom);
		$txtPrenom = mysqli_real_escape_string($bd, $txtPrenom);
		$txtMail = mysqli_real_escape_string($bd, $txtMail);
		$txttelephone = mysqli_real_escape_string($bd, $txttelephone);
		$txtAdresse = mysqli_real_escape_string($bd, $txtAdresse);
		$txtCp = mysqli_real_escape_string($bd, $txtCp);
		$txtVille = mysqli_real_escape_string($bd, $txtVille);
		$txtPays = mysqli_real_escape_string($bd, $txtPays);

		$S = "INSERT INTO coordonnees SET
				nomCoordonnees = '$txtNom',
				prenomCoordonnees = '$txtPrenom',
				emailCoordonnees = '$txtMail',
				telephoneCoordonnees = '$txttelephone',
				adresseCoordonnees = '$txtAdresse',
				codePostalCoordonnees = '$txtCp',
				villeCoordonnees = '$txtVille',
				paysCoordonnees = '$txtPays'";
		
		mysqli_query($bd, $S) or bd_erreur($bd, $S);
				
		$S2 = "SELECT idCoordonnees
				FROM coordonnees
				WHERE nomCoordonnees = '$txtNom'
				AND prenomCoordonnees = '$txtPrenom'
				AND emailCoordonnees = '$txtMail'";
				
		$R2 = mysqli_query($bd, $S2) or bd_erreur($bd, $S2);

		$D2 = mysqli_fetch_row($R2);
		$idCoordonnees = $D2[0];
				
		$S3 = "INSERT INTO compte SET
				inscriptionCompte = $dateInscription,
				nomCompte = '$txtPseudo',
				mdpCompte = '$txtPasse',
				questionCompte = '$txtQuestion',
				reponseCompte = '$txtReponse',
				typeCompte = 2,
				coordonneesCompte = '$idCoordonnees'";

		mysqli_query($bd, $S3) or bd_erreur($bd, $S3);

		//-----------------------------------------------------
		// Ouverture de la session et redirection vers la page protegée
		//-----------------------------------------------------
		session_start();
		$_SESSION['idCompte'] = mysqli_insert_id($bd);
		$_SESSION['nomCompte'] = $txtPseudo;
		header ('location: accueil.php');

		exit();			// EXIT : le script est terminé
	}
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Permet d'inscrire une entreprise si aucun problème n'est détecté.
	*
	* fonction qui vérifie que les informations de l'entreprise sont correctes
	* et les ajoute à la base de donnée.
	* Si aucune erreur n'est détecté on connecte l'entreprise et on le redirige
	* vers la page accueil.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function inscrire_entreprise() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------
		$erreurs2 = array();

		// Vérification du pseudo
		$txtPseudo = trim($_POST['pseudo']);
		$long = strlen($txtPseudo);
		if ($long < 4
		|| $long > 30)
		{
			$erreurs2[] = 'Le pseudo doit avoir de 4 &agrave; 30 caract&egrave;res';
		} else {
			// Vérification que le pseudo n'existe pas dans la BD
			$bd = bd_connexion();

			$txtPseudo = mysqli_real_escape_string($bd, $txtPseudo);

			$S = "SELECT	count(*)
					FROM	compte
					WHERE	nomCompte = '$txtPseudo'";

			$R = mysqli_query($bd, $S) or bd_erreur($bd, $S);

			$D = mysqli_fetch_row($R);

			if ($D[0] > 0) {
				$erreurs2[] = 'Le pseudo doit &ecirc;tre chang&eacute;';
			}
		}

		// Vérification du mot de passe
		$txtPasse = trim($_POST['password1']);
		if ($txtPasse == '') {
			$erreurs2[] = 'Le mot de passe est obligatoire';
		}

		$txtVerif = trim($_POST['password2']);
		if ($txtPasse != $txtVerif) {
			$erreurs2[] = 'Le mot de passe est diff&eacute;rent dans les 2 zones';
		}

		// Vérification du nom
		$txtNom = trim($_POST['compagnyName']);
		if ($txtNom == '') {
			$erreurs2[] = 'Le nom est obligatoire';
		}
		
		// Vérification du prénom
		$txtPrenom = trim($_POST['firstname']);
		if ($txtPrenom == '') {
			$erreurs2[] = 'Le pr&eacute;nom est obligatoire';
		}
		

		// Vérification du mail
		$txtMail = trim($_POST['email']);
		if ($txtMail == '') {
			$erreurs2[] = 'L\'adresse mail est obligatoire';
		} elseif (strpos($txtMail, '@') === FALSE
		|| strpos($txtMail, '.') === FALSE)
		{
			$erreurs2[] = 'L\'adresse mail n\'est pas valide';
		}

		// Vérification de la question
		$txtQuestion = trim($_POST['question']);
		if ($txtQuestion == '') {
			$erreurs2[] = 'La question est obligatoire';
		}
		
		// Vérification de la réponse
		$txtReponse = trim($_POST['answer']);
		if ($txtReponse == '') {
			$erreurs2[] = 'La r&eacute;ponse est obligatoire';
		}
		
		// Vérification du téléphone
		$txttelephone = trim($_POST['phone']);
		if ($txttelephone == '') {
			$erreurs2[] = 'Le t&eacute;l&eacute;phone est obligatoire';
		}
		$long2 = strlen($txttelephone);
		if ($long2 != 10)
		{
			$erreurs2[] = 'Le t&eacute;l&eacute;phone doit avoir 10 chiffres';
		}
		
		// Vérification de l'adresse
		$txtAdresse = trim($_POST['address']);
		if ($txtAdresse == '') {
			$erreurs2[] = 'L\'adresse est obligatoire';
		}
		
		// Vérification du code postal
		$txtCp = trim($_POST['cp']);
		if ($txtCp == '') {
			$erreurs2[] = 'Le code postal est obligatoire';
		}
		$long3 = strlen($txtCp);
		if ($long3 != 5)
		{
			$erreurs2[] = 'Le code postal doit avoir 5 chiffres';
		}
		
		// Vérification de la ville
		$txtVille = trim($_POST['city']);
		if ($txtVille == '') {
			$erreurs2[] = 'La ville est obligatoire';
		}

		// Vérification du pays
		$txtPays = trim($_POST['country']);
		if ($txtPays == '') {
			$erreurs2[] = 'Le pays est obligatoire';
		}

		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs2) > 0) {
			return $erreurs2;		// RETURN : des erreurs ont été détectées
		}
		
		//-----------------------------------------------------
		// Insertion d'un nouvel enregistrement dans la base de données
		//-----------------------------------------------------
		$dateInscription = date('Ymd');
		$txtPasse = mysqli_real_escape_string($bd, md5($txtPasse));
		$txtQuestion = mysqli_real_escape_string($bd, $txtQuestion);
		$txtReponse = mysqli_real_escape_string($bd, $txtReponse);
		$txtNom = mysqli_real_escape_string($bd, $txtNom);
		$txtPrenom = mysqli_real_escape_string($bd, $txtPrenom);
		$txtMail = mysqli_real_escape_string($bd, $txtMail);
		$txttelephone = mysqli_real_escape_string($bd, $txttelephone);
		$txtAdresse = mysqli_real_escape_string($bd, $txtAdresse);
		$txtCp = mysqli_real_escape_string($bd, $txtCp);
		$txtVille = mysqli_real_escape_string($bd, $txtVille);
		$txtPays = mysqli_real_escape_string($bd, $txtPays);
				
		$S = "INSERT INTO coordonnees SET
				nomCoordonnees = '$txtNom',
				prenomCoordonnees = '$txtPrenom',
				emailCoordonnees = '$txtMail',
				telephoneCoordonnees = '$txttelephone',
				adresseCoordonnees = '$txtAdresse',
				codePostalCoordonnees = '$txtCp',
				villeCoordonnees = '$txtVille',
				paysCoordonnees = '$txtPays'";
		
		mysqli_query($bd, $S) or bd_erreur($bd, $S);
				
		$S2 = "SELECT idCoordonnees
				FROM coordonnees
				WHERE nomCoordonnees = '$txtNom'
				AND prenomCoordonnees = '$txtPrenom'
				AND emailCoordonnees = '$txtMail'";
				
		$R2 = mysqli_query($bd, $S2) or bd_erreur($bd, $S2);

		$D2 = mysqli_fetch_row($R2);
		$idCoordonnees = $D2[0];
				
		$S3 = "INSERT INTO compte SET
				inscriptionCompte = $dateInscription,
				nomCompte = '$txtPseudo',
				mdpCompte = '$txtPasse',
				questionCompte = '$txtQuestion',
				reponseCompte = '$txtReponse',
				typeCompte = 1,
				coordonneesCompte = '$idCoordonnees'";

		mysqli_query($bd, $S3) or bd_erreur($bd, $S3);

		//-----------------------------------------------------
		// Ouverture de la session et redirection vers la page protegée
		//-----------------------------------------------------
		session_start();
		$_SESSION['idCompte'] = mysqli_insert_id($bd);
		$_SESSION['nomCompte'] = $txtPseudo;
		header ('location: accueil.php');

		exit();			// EXIT : le script est terminé
	}
?>