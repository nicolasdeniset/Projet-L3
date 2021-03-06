<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	ob_start();
  	bd_connexion();

	//-----------------------------------------------------
	// Détermination de la phase de traitement : 1er affichage
	// ou soumission du formulaire
	//-----------------------------------------------------
	if (! isset($_POST['btnValider'])) {
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['txtPseudo'] = $_POST['txtPasse'] = '';

	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script cuiteur.
		$erreurs = connect_user();
		$nbErr = count($erreurs);
	}

	$id = '';
	 session_start();
	if(isset($_SESSION['idCompte'])){
		$id = $_SESSION["idCompte"];
	}

	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Connexion");
	html_header($id);

	echo '<div class="container">',
      '<div class="row">',
        '<main>',

          '<section class="col-lg-6 col-md-6 col-sm-12 col-xs-12">',
            '<div id="register">',
              '<h2 class="text-center">PAS ENCORE INSCRIT ?</h2>',
              '<p>L\'association a pour objectif d’affaiblir les inégalités et de lutter efficacement contre la fracture numérique à travers la mise en place de cours en Informatique en lien avec les besoins des entreprises locales dans différents pays. Les apprenants doivent maîtriser les outils numériques afin de faciliter leur insertion et de participer à l’éclosion de l’économie locale.</p>',

                '<li><span class="fa fa-check text-success"></span>Accédez à une communauté d\'entraide</li>',
                '<li><span class="fa fa-check text-success"></span>Réalisez des formations et entrez dans le monde du travail</li>',
              '</ul>',
            '</div>',
            '<a href="./inscription.php" class="btn btn-success btn-block">S\'inscrire</a>',
          '</section>',

          '<section  id="login" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">',
            '<h2 class="text-center">JE ME CONNECTE</h2>',
            '<div class="row">';

			// Si il y a des erreurs on les affiche
			if ($nbErr > 0) {
				echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
				for ($i = 0; $i < $nbErr; $i++) {
					echo '<br>', $erreurs[$i];
				}
			}


              echo '<form method="POST" action="login.php" accept-charset="iso-8859-1">',
                '<div class="form-group">',
                  '<label class="control-label required" for="pseudo">Nom de compte<sup style="color:red">*</sup></label>',
                  '<input id="pseudo" name="txtPseudo" type="text" class="form-control" placeholder="Entrez votre nom de compte">',
                '</div>',
                '<div class="form-group">',
                  '<label class="control-label required" for="password">Mot de passe<sup style="color:red">*</sup></label>',
                  '<input id="password" name="txtPasse" type="password" class="form-control" placeholder="mot de passe">',
                '</div>',
                '<a href="#" class="forgot-password">Mot de passe oublié ?</a>',
                '<div class="form-group">',
                  '<input type="checkbox" id="condition" name="condition" value="condition">',
                  '<label class="checkCondition" for="condition"> Se souvenir de moi</label>',
                '</div>',
                '<button class="btn btn-block btn-success" name="btnValider">Se connecter</button>',
              '</form>',


            '</div>',
          '</section>',
        '</main>',
        '</div>',
      '</div>';

	html_pied("little");

	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Permet de connecter un utilisateur si aucun problème n'est détecté.
	*
	* fonction qui vérifie que le pseudo de l'utilisateur existe bien dans
	* la base de donnée et qui vérifie que le mot de passe correspond bien
	* au même que celui qui se trouve dans la base de donnée.
	* Si aucune erreur n'est détecté on connecte l'utilisateur et on le redirige
	* vers la page acceuil.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function connect_user() {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------
		$erreurs = array();

		// Vérification que le pseudo existe dans la BD
		$txtPseudo = trim($_POST['txtPseudo']);
		$txtPseudo = mysqli_real_escape_string($GLOBALS['bd'], $txtPseudo);

		$S = "SELECT	count(*)
				FROM	compte
				WHERE	nomCompte = '$txtPseudo'";

		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

		$D = mysqli_fetch_row($R);

		if ($D[0] == 0) {
			$erreurs[] = 'Le pseudo n\'existe pas !';
		}

		// Vérification du mot de passe
		$txtPasse = trim($_POST['txtPasse']);
		$txtPasse = md5($txtPasse);
		$S2 = "SELECT	mdpCompte
				FROM	compte
				WHERE	nomCompte = '$txtPseudo'
				AND	mdpCompte = '$txtPasse'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);

		$D2 = mysqli_fetch_row($R2);
		if (($D2[0] == 0)||($D2[0] < 0)) {
			$erreurs[] = 'Le mot de passe est incorrecte !';
		}

		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}

		//-----------------------------------------------------
		// Ouverture de la session et redirection vers la page cuiteur
		//-----------------------------------------------------
		session_start();
		$_SESSION['nomCompte'] = $txtPseudo;
		$S3 = "SELECT	idCompte
				FROM	compte
				WHERE	nomCompte = '$txtPseudo'";
		$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);

		$D3 = mysqli_fetch_row($R3);
		$_SESSION['idCompte'] = $D3[0];
		header ('location: accueil.php');

		exit();			// EXIT : le script est terminé

		ob_end_flush();
}
?>
