<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');
	
	$nbErr = 0;
	$nbErr2 = 0;
	$nbErr3 = 0;
	$erreurs = array();
	$erreurs2 = array();
	$erreurs3 = array();
	
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
		$_POST['country'] = $_POST['motivation'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs = inscrire_user("2");
		$nbErr = count($erreurs);
	}
	if (! isset($_POST['btnValider2'])) {
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr2 = 0;
		$_POST['pseudo2'] = $_POST['name2'] = '';
		$_POST['firstname2'] = $_POST['email2'] = '';
		$_POST['password12'] = $_POST['password22'] = '';
		$_POST['question2'] = $_POST['answer2'] = '';
		$_POST['phone2'] = $_POST['address2'] = '';
		$_POST['cp2'] = $_POST['city2'] = '';
		$_POST['country2'] = $_POST['motivation2'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs2 = inscrire_user("3");
		$nbErr2 = count($erreurs2);
	}
	
	if (! isset($_POST['btnValider3'])) {
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr3 = 0;
		$_POST['pseudo3'] = $_POST['name3'] = '';
		$_POST['firstname3'] = $_POST['email3'] = '';
		$_POST['password13'] = $_POST['password23'] = '';
		$_POST['question3'] = $_POST['answer3'] = '';
		$_POST['phone3'] = $_POST['address3'] = '';
		$_POST['cp3'] = $_POST['city3'] = '';
		$_POST['country3'] = $_POST['motivation3'] = '';
		$_POST['compagnyName3'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs3 = inscrire_user("1");
		$nbErr3 = count($erreurs3);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Inscription");
	html_header();
	
	 echo '<div class="container">',
      '<div class="row">',

        '<main>',
        '<section>',
        '<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 col-sm-12 col-xs-12">',
          '<div class="account-holder">',
            '<h2 id="titleRegister" class="text-center">JE M\'INSCRIS EN TANT QU\'ETUDIANT</h2>';
			
			// Si il y a des erreurs on les affiche
				if ($nbErr > 0) {
					echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
					for ($i = 0; $i < $nbErr; $i++) {
						echo '<br>', $erreurs[$i];
					}
				}
			
				if ($nbErr2 > 0) {
					echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
					for ($i = 0; $i < $nbErr2; $i++) {
						echo '<br>', $erreurs2[$i];
					}
				}

				if ($nbErr3 > 0) {
					echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
					for ($i = 0; $i < $nbErr3; $i++) {
						echo '<br>', $erreurs3[$i];
					}
				}


            echo '<div class="row">',
              "<div id=\"studentChoice\" class=\"text col-md-4 col-sm-12\" onclick=\"javascript:openGestion(['student', 'company', 'volunteer']); javascript:enTantQue('EN TANT QU\'ETUDIANT'); return false;\">",
                '<button href="#" class="btn btn-success btn-block">En tant qu\'étudiant</button>',
              '</div>',
              '<div id="voluteerChoice" class="text col-md-4 col-sm-12" onclick="javascript:openGestion([\'volunteer\', \'company\', \'student\']); javascript:enTantQue(\'EN TANT QUE BENEVOLE\'); return false;">',
                '<button href="#" class="btn btn-success btn-block">En tant que bénévole</button>',
              '</div>',
              "<div id=\"companyChoice\" class=\"text col-md-4 col-sm-12\" onclick=\"javascript:openGestion(['company', 'student', 'volunteer']); javascript:enTantQue('EN TANT QU\'ENTREPRISE'); return false;\">",
                '<button href="#" class="btn btn-success btn-block">En tant qu\'entreprise</button>',
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
				  
				  '<div class="form-group">',
                    '<label class="control-label required" for="country">Qu\'est ce qui vous motive à rejoindre l\'association ?<sup style="color:red">*</sup></label>',
                    '<textarea id="motivation" name="motivation" class="form-control" placeholder="Entrez vos motivations"></textarea>',
                  '</div>',
                
                  '<button type="submit" class="btn btn-block btn-success" name="btnValider1">S\'inscrire</button>',
                
              '</form>',
			  
			   '<form id="volunteer" method="POST">',
                
                  '<div class="form-group">',
                    '<label class="control-label required" for="pseudo">Nom de compte<sup style="color:red">*</sup></label>',
                    '<input id="pseudo" name="pseudo2" type="text" class="form-control" placeholder="Entrez votre nom de compte">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du bénévole<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name2" type="text" class="form-control" placeholder="Entrez votre nom">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du bénévole<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname2" type="text" class="form-control" placeholder="Entrez votre prénom">',
                  '</div>',
                                  
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email2" type="text" class="form-control" placeholder="Entrez votre adresse mail">',
                  '</div>',
                                    
                  '<div class="form-group">',
                    '<label class="control-label required" for="password">Mot de passe<sup style="color:red">*</sup></label>',
                    '<input id="password" name="password12" type="password" class="form-control" placeholder="mot de passe">',
                  '</div>',
                                    
                  '<div class="form-group">',
                    '<label class="control-label required" for="password">Confirmer le mot de passe<sup style="color:red">*</sup></label>',
                    '<input id="password" name="password22" type="password" class="form-control" placeholder="mot de passe">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="question">Question secrète (en cas de perte de mot de passe)<sup style="color:red">*</sup></label>',
                    '<input id="question" name="question2" type="text" class="form-control" placeholder="Entrez votre question secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="answer">Réponse secrète<sup style="color:red">*</sup></label>',
                    '<input id="answer" name="answer2" type="text" class="form-control" placeholder="Entrez votre réponse secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone2" type="text" class="form-control" placeholder="Entrez votre numéro de téléphone">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address2" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp2" type="text" class="form-control" placeholder="Entrez votre code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city2" type="text" class="form-control" placeholder="Entrez votre ville">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country2" type="text" class="form-control" placeholder="Entrez votre pays">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Qu\'est ce qui vous motive à rejoindre l\'association ?<sup style="color:red">*</sup></label>',
                    '<textarea id="motivation" name="motivation2" class="form-control" placeholder="Entrez vos motivations"></textarea>',
                  '</div>',

                
                  '<button type="submit" class="btn btn-block btn-success" name="btnValider2">S\'inscrire</button>',
                
              '</form>',

               '<form id="company" method="POST">',
               
                  '<div class="form-group">',
                    '<label class="control-label required" for="pseudo">Nom de compte<sup style="color:red">*</sup></label>',
                    '<input id="pseudo" name="pseudo3" type="text" class="form-control" placeholder="Entrez votre nom de compte">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="compagnyName">Nom de l\'entreprise<sup style="color:red">*</sup></label>',
                    '<input id="compagnyName" name="compagnyName" type="text" class="form-control" placeholder="Entrez le nom de votre entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du gérant<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name3" type="text" class="form-control" placeholder="Entrez le nom du gérant de l\'entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du gérant<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname3" type="text" class="form-control" placeholder="Entrez le prénom du gérant de l\'entreprise">',
                  '</div>',
                                  
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email3" type="text" class="form-control" placeholder="Entrez l\'adresse mail de l\'entreprise">',
                  '</div>',
                                    
                  '<div class="form-group">',
                    '<label class="control-label required" for="password">Mot de passe<sup style="color:red">*</sup></label>',
                    '<input id="password" name="password13" type="password" class="form-control" placeholder="mot de passe">',
                  '</div>',
                                    
                  '<div class="form-group">',
                    '<label class="control-label required" for="password">Confirmer le mot de passe<sup style="color:red">*</sup></label>',
                    '<input id="password" name="password23" type="password" class="form-control" placeholder="mot de passe">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="question">Question secrète (en cas de perte de mot de passe)<sup style="color:red">*</sup></label>',
                    '<input id="question" name="question3" type="text" class="form-control" placeholder="Entrez votre question secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="answer">Réponse secrète<sup style="color:red">*</sup></label>',
                    '<input id="answer" name="answer3" type="text" class="form-control" placeholder="Entrez votre réponse secrète">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone3" type="text" class="form-control" placeholder="Entrez le numéro de téléphone de l\'entreprise">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address3" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp3" type="text" class="form-control" placeholder="Entrez le code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city3" type="text" class="form-control" placeholder="Entrez la ville">',
                  '</div>',

                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country3" type="text" class="form-control" placeholder="Entrez le pays">',
                  '</div>',
				  
				  '<div class="form-group">',
                    '<label class="control-label required" for="country">Qu\'est ce qui vous motive à rejoindre l\'association ?<sup style="color:red">*</sup></label>',
                    '<textarea id="motivation" name="motivation3" class="form-control" placeholder="Entrez vos motivations"></textarea>',
                  '</div>',
                                
                  '<button type="submit" class="btn btn-block btn-success" name="btnValider3">S\'inscrire</button>',
                
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
	function inscrire_user($type) {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------
		$erreurs = array();

		if ($type == 2) {
			$txtPseudo = trim(utf8_encode($_POST['pseudo']));
			$txtPasse = trim(utf8_encode($_POST['password1']));
			$txtVerif = trim(utf8_encode($_POST['password2']));
			$txtNom = trim(utf8_encode($_POST['name']));
			$txtPrenom = trim(utf8_encode($_POST['firstname']));
			$txtMail = trim(utf8_encode($_POST['email']));
			$txtQuestion = trim(utf8_encode($_POST['question']));
			$txtReponse = trim(utf8_encode($_POST['answer']));
			$txttelephone = trim(utf8_encode($_POST['phone']));
			$txtAdresse = trim(utf8_encode($_POST['address']));
			$txtCp = trim(utf8_encode($_POST['cp']));
			$txtVille = trim(utf8_encode($_POST['city']));
			$txtPays = trim(utf8_encode($_POST['country']));
			$txtMotivation = trim(utf8_encode($_POST['motivation']));			
		}
		else {
			if($type == 3) {
				$txtPseudo = trim(utf8_encode($_POST['pseudo2']));
				$txtPasse = trim(utf8_encode($_POST['password12']));
				$txtVerif = trim(utf8_encode($_POST['password22']));
				$txtNom = trim(utf8_encode($_POST['name2']));
				$txtPrenom = trim(utf8_encode($_POST['firstname2']));
				$txtMail = trim(utf8_encode($_POST['email2']));
				$txtQuestion = trim(utf8_encode($_POST['question2']));
				$txtReponse = trim(utf8_encode($_POST['answer2']));
				$txttelephone = trim(utf8_encode($_POST['phone2']));
				$txtAdresse = trim(utf8_encode($_POST['address2']));
				$txtCp = trim(utf8_encode($_POST['cp2']));
				$txtVille = trim(utf8_encode($_POST['city2']));
				$txtPays = trim(utf8_encode($_POST['country2']));
				$txtMotivation = trim(utf8_encode($_POST['motivation2']));	
			}
			else {
				$txtPseudo = trim(utf8_encode($_POST['pseudo3']));
				$txtPasse = trim(utf8_encode($_POST['password13']));
				$txtVerif = trim(utf8_encode($_POST['password23']));
				$txtNom = trim(utf8_encode($_POST['name3']));
				$txtPrenom = trim(utf8_encode($_POST['firstname3']));
				$txtMail = trim(utf8_encode($_POST['email3']));
				$txtQuestion = trim(utf8_encode($_POST['question3']));
				$txtReponse = trim(utf8_encode($_POST['answer3']));
				$txttelephone = trim(utf8_encode($_POST['phone3']));
				$txtAdresse = trim(utf8_encode($_POST['address3']));
				$txtCp = trim(utf8_encode($_POST['cp3']));
				$txtVille = trim(utf8_encode($_POST['city3']));
				$txtPays = trim(utf8_encode($_POST['country3']));
				$txtMotivation = trim(utf8_encode($_POST['motivation3']));	
			}
		}
		// Vérification du pseudo
		$long = strlen($txtPseudo);
		if ($long < 4
		|| $long > 30)
		{
			$erreurs[] = 'Le pseudo doit avoir de 4 &agrave; 30 caract&egrave;res';
		} else {
			// Vérification que le pseudo n'existe pas dans la BD
			ob_start();
			bd_connexion();

			$txtPseudo = mysqli_real_escape_string($GLOBALS['bd'], $txtPseudo);

			$S = "SELECT	count(*)
					FROM	compte
					WHERE	nomCompte = '$txtPseudo'";

			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

			$D = mysqli_fetch_row($R);

			if ($D[0] > 0) {
				$erreurs[] = 'Le pseudo doit &ecirc;tre chang&eacute;';
			}
		}
		
		if($type == "1") {
			$txtCompanyName = trim(utf8_encode($_POST['compagnyName']));
			if ($txtCompanyName == '') {
				$erreurs[] = 'Le nom de l\'entreprise est obligatoire';
			}
		}

		// Vérification du mot de passe
		if ($txtPasse == '') {
			$erreurs[] = 'Le mot de passe est obligatoire';
		}

		if ($txtPasse != $txtVerif) {
			$erreurs[] = 'Le mot de passe est diff&eacute;rent dans les 2 zones';
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

		// Vérification de la question
		if ($txtQuestion == '') {
			$erreurs[] = 'La question est obligatoire';
		}
		
		// Vérification de la réponse
		if ($txtReponse == '') {
			$erreurs[] = 'La r&eacute;ponse est obligatoire';
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
		
		// Vérification du texte de motivation
		if ($txtMotivation == '') {
			$erreurs[] = 'Le texte de motivation est obligatoire';
		}

		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		//-----------------------------------------------------
		// Insertion d'un nouvel enregistrement dans la base de données
		//-----------------------------------------------------
		$dateInscription = date('Ymd');
		$txtPasse = mysqli_real_escape_string($GLOBALS['bd'], md5($txtPasse));
		$txtQuestion = mysqli_real_escape_string($GLOBALS['bd'], $txtQuestion);
		$txtReponse = mysqli_real_escape_string($GLOBALS['bd'], $txtReponse);
		$txtNom = mysqli_real_escape_string($GLOBALS['bd'], $txtNom);
		$txtPrenom = mysqli_real_escape_string($GLOBALS['bd'], $txtPrenom);
		$txtMail = mysqli_real_escape_string($GLOBALS['bd'], $txtMail);
		$txttelephone = mysqli_real_escape_string($GLOBALS['bd'], $txttelephone);
		$txtAdresse = mysqli_real_escape_string($GLOBALS['bd'], $txtAdresse);
		$txtCp = mysqli_real_escape_string($GLOBALS['bd'], $txtCp);
		$txtVille = mysqli_real_escape_string($GLOBALS['bd'], $txtVille);
		$txtPays = mysqli_real_escape_string($GLOBALS['bd'], $txtPays);
		$txtMotivation = mysqli_real_escape_string($GLOBALS['bd'], $txtMotivation);
		if($type == "1") {
			$txtCompanyName = mysqli_real_escape_string($GLOBALS['bd'], $txtCompanyName);
		}

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
		
		if($type == "1") {
			$S3 = "INSERT INTO compte SET
					inscriptionCompte = $dateInscription,
					nomCompte = '$txtPseudo',
					mdpCompte = '$txtPasse',
					lettreMotivCompte = '$txtMotivation',
					questionCompte = '$txtQuestion',
					reponseCompte = '$txtReponse',
					nomEntrepriseCompte = '$txtCompanyName',
					typeCompte = '$type',
					actifCompte = '0',
					coordonneesCompte = '$idCoordonnees'";

			mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		}
		else {
			$S3 = "INSERT INTO compte SET
					inscriptionCompte = $dateInscription,
					nomCompte = '$txtPseudo',
					mdpCompte = '$txtPasse',
					lettreMotivCompte = '$txtMotivation',
					questionCompte = '$txtQuestion',
					reponseCompte = '$txtReponse',
					typeCompte = '$type',
					actifCompte = '0',
					coordonneesCompte = '$idCoordonnees'";

			mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		}

		//-----------------------------------------------------
		// Ouverture de la session et redirection vers la page protegée
		//-----------------------------------------------------
		session_start();
		$_SESSION['idCompte'] = mysqli_insert_id($GLOBALS['bd']);
		$idSession = $_SESSION['idCompte'];
		$_SESSION['nomCompte'] = $txtPseudo;
		$_SESSION['actifCompte'] = "0";
		
				// On crée la candidature associé a l'inscription du compte
		$S4 = "INSERT INTO candidature SET
					compteCandidature = '$idSession',
					typeCandidature = '0',
					lettreMotivCandidature = '$txtMotivation',
					traiteeCandidature = '0',
					accepteeCandidature = '0'";

		mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
		
		header ('location: accueil.php');

		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>