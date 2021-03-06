<?php

/*******************************************************************************
*
* Projet Licence 3 :
*     CONCEPTION D'UN SITE INTERNET POUR UNE ASSOCIATION D'AIDE
*               A LUTTER CONTRE LA FRACTURE NUMERIQUE
* DENISET Nicolas - IDATTE Camille - PIU Pierre-Alexandre
*
*******************************************************************************/
//___________________________________________________________________

/*******************************************************************************
 *  Definition des constantes de l'application
*******************************************************************************/
define('APP_TEST', TRUE);

// Gestion des infos base de données
define('APP_BD_URL', 'localhost');
define('APP_BD_USER', 'root');
define('APP_BD_PASS', 'association_l3');
define('APP_BD_NOM', 'association_l3');

define('APP_NOM_APPLICATION','association_l3');

// Gestion des pages de l'application
define('APP_PAGE_STATISTIQUE', 'statistique.php');
define('APP_PAGE_FORMATION', 'formation.php');
define('APP_PAGE_STAGE', 'stage.php');
define('APP_PAGE_COMPTE', 'gestionCompte.php');
define('APP_PAGE_MEMBRE', 'listeMembre.php');
define('APP_PAGE_ETUDIANT', 'listeEtudiant.php');
define('APP_PAGE_ENTREPRISE', 'listeEntreprise.php');
define('APP_PAGE_BENEVOLE', 'listeBenevole.php');
define('APP_PAGE_POLE', 'poleFormation.php');
define('APP_PAGE_ACTUALITE', 'actualite.php');
define('APP_PAGE_GESTIONSITE', 'gestionSite.php');
define('APP_PAGE_CANDIDATURE', 'candidature.php');
define('APP_PAGE_PROFIL', 'profil.php');
define('APP_PAGE_ACCUEIL', 'accueil.php');
define('APP_PAGE_CONNEXION', 'login.php');

//___________________________________________________________________
/*******************************************************************************
 *  Fonctions structure pages
*******************************************************************************/

/*******************************************************************************
 * Génère le code HTML du début des pages.
 *
 * @param string	$titre		Titre de la page
 * @param string	$css		url de la feuille de styles liée
 ******************************************************************************/
function html_head($titre) {
	echo '<!DOCTYPE HTML>',
		'<html>',
			'<head>',
				'<meta charset="UTF-8">',
				'<title>', $titre,'</title>',
				'<link rel="stylesheet" href="../css/reboot.css">',
				'<link rel="stylesheet" href="../css/bootstrap-theme.css">',
				'<link rel="stylesheet" href="../css/bootstrap.css">',
				'<link rel="stylesheet" href="../css/font-awesome.min.css">',
				'<link rel="stylesheet" href="../css/style.css">',
				'<script src="../jq/jquery-2.1.1.min.js"></script>',
				'<script src="../js/bootstrap.min.js"></script>',
				'<script src="../js/fonction4php.js"></script>',
			'</head>';
}
/*******************************************************************************
 * Génère le code HTML du pied des pages.
*******************************************************************************/
function html_pied($little = "") {
	if($little != "") {
		echo '<footer class="little-footer">';
	}
	else{
		echo '<footer>';
	}
	echo '<div class="container">',
				'<div class="row justify-content-center">',
					'<h3>NumAfrique</h3>',
						'<p>Une association pour lutter contre la fracture numérique.</p>',
					'</div>',
				'<div class="row navFooter">',
					'<ul class="social list-unstyled list-inline text-center">',
						'<li><a href="#">Politique de confidentialité</a></li>',
						'<li><a href="#">Condition d\'utilisation</a></li>',
						'<li><a href="#">FAQ</a></li>',
						'<li><a href="#">Plan du site</a></li>',
					'</ul>',
				'</div>',
				'<div class="row justify-content-center">',
					'<p class="copyright"> © 2017-2018 Projet-L3 Copyright: Flaticon, font-awesome</p>',
				'</div>',
			'</div>',
			'</footer></body></html>';
}

/*******************************************************************************
 * Génère le code HTML du aside + du main pour les pages tableaux de bords
*******************************************************************************/
function html_aside_main_debut($page=''){
	echo 	'<div class="container-fluid">',
				'<div class="col-sm-3 col-md-2 sidebar">';
	if($page == APP_PAGE_ENTREPRISE || $page == APP_PAGE_FORMATION || $page == APP_PAGE_STAGE || $page == APP_PAGE_ENTREPRISE || $page == APP_PAGE_ETUDIANT || $page == APP_PAGE_BENEVOLE || $page == APP_PAGE_POLE || $page == APP_PAGE_ACTUALITE || $page == APP_PAGE_CANDIDATURE || $page == APP_PAGE_GESTIONSITE || $page == APP_PAGE_STATISTIQUE || $page == APP_PAGE_COMPTE || $page == APP_PAGE_MEMBRE || $page == APP_PAGE_PROFIL) {
/*		if (getTypeCompte($_SESSION['idCompte']) != 0){
			echo		'<ul class="nav nav-sidebar">',
	  					($page == APP_PAGE_PROFIL) ?'<li class="active"><a href="./profil.php"><span class="fa fa-home" aria-hidden="true"></span>Profil</a></li>' :'<li><a href="./profil.php"><span class="fa fa-home" aria-hidden="true"></span>Profil</a></li>',
	      			'</ul>';
		}*/
	  echo 	'<ul class="nav nav-sidebar">',
	      		($page == APP_PAGE_FORMATION) ?'<li class="active"><a href="'.APP_PAGE_FORMATION.'"><span class="fa fa-book" aria-hidden="true"></span>Formations</a></li>' : '<li><a href="'.APP_PAGE_FORMATION.'"><span class="fa fa-book" aria-hidden="true"></span>Formations</a></li>',
	      		($page == APP_PAGE_STAGE) ? '<li class="active"><a href="'.APP_PAGE_STAGE.'"><span class="fa fa-briefcase" aria-hidden="true"></span>Stages</a></li>' :  '<li><a href="'.APP_PAGE_STAGE.'"><span class="fa fa-briefcase" aria-hidden="true"></span>Stages</a></li>',
						($page == APP_PAGE_MEMBRE || $page == APP_PAGE_PROFIL) ?  '<li class="active"><a href="'.APP_PAGE_MEMBRE.'"><span class="fa fa-users" aria-hidden="true"></span>Membres</a></li>': '<li><a href="'.APP_PAGE_MEMBRE.'"><span class="fa fa-users" aria-hidden="true"></span>Membres</a></li>',
						($page == APP_PAGE_POLE) ? '<li class="active"><a href="'.APP_PAGE_POLE.'"><span class="fa fa-university" aria-hidden="true"></span>Pôles de formations</a></li>' : '<li><a href="'.APP_PAGE_POLE.'"><span class="fa fa-university" aria-hidden="true"></span>Pôles de formation</a></li>',
						($page == APP_PAGE_ACTUALITE) ? '<li class="active"><a href="'.APP_PAGE_ACTUALITE.'"><span class="fa fa-file-text-o" aria-hidden="true"></span>Actualités</a></li>' : '<li><a href="'.APP_PAGE_ACTUALITE.'"><span class="fa fa-file-text-o" aria-hidden="true"></span>Actualités</a></li>',

					'</ul>';
					if (getTypeCompte($_SESSION['idCompte']) == 0){
						echo 	'<ul class="nav nav-sidebar">',
										($page == APP_PAGE_CANDIDATURE) ? '<li class="active"><a href="'.APP_PAGE_CANDIDATURE.'"><span class="fa fa-cogs" aria-hidden="true"></span>Candidatures</a></li>' : '<li><a href="'.APP_PAGE_CANDIDATURE.'"><span class="fa fa-cogs" aria-hidden="true"></span>Candidatures</a></li>',
										($page == APP_PAGE_GESTIONSITE) ? '<li class="active"><a href="'.APP_PAGE_GESTIONSITE.'"><span class="fa fa-cogs" aria-hidden="true"></span>Site Internet</a></li>' : '<li><a href="'.APP_PAGE_GESTIONSITE.'"><span class="fa fa-cogs" aria-hidden="true"></span>Site Internet</a></li>',
										($page == APP_PAGE_STATISTIQUE) ? '<li class="active"><a href="'.APP_PAGE_STATISTIQUE.'"><span class="fa fa-bar-chart" aria-hidden="true"></span>Statistiques</a></li>' : '<li><a href="'.APP_PAGE_STATISTIQUE.'"><span class="fa fa-bar-chart" aria-hidden="true"></span>Statistiques</a></li>',
									'</ul>';
					}
					if(isset($_SESSION['idCompte'])){
						echo '<ul class="nav nav-sidebar">';
						echo 	($page == APP_PAGE_COMPTE) ? '<li class="active"><a href="'.APP_PAGE_COMPTE.'"><span class="fa fa-user" aria-hidden="true"></span>Paramètres compte</a></li>' : '<li><a href="'.APP_PAGE_COMPTE.'"><span class="fa fa-user" aria-hidden="true"></span>Paramètres compte</a></li>',
									'<li><a href="deconnexion.php"><span class="fa fa-sign-out" aria-hidden="true"></span>Déconnexion</a></li>',
								'</ul>';
					}
		}
	echo  '</div>',
				'<main class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">',
				'<section>';
}

function html_aside_main_fin(){
	echo 	'</section></main></div>';
}
/*******************************************************************************
 * Génère le code HTML du header des pages.
*******************************************************************************/
function html_header($session = '') {
		echo '<body>',
				 	'<header>',
				 		'<nav class="navbar navbar-default navbar-fixed-top">',
				 			'<div class="container">',
				 				'<a id="logo" href="./accueil.php" class="navbar-brand">NumAfrique</a>',
				 					'<div id="navigation" class="navbar-right">',
				 						'<ul class="nav navbar-nav hidden-sm hidden-xs">',
				 							'<li><a href="./accueil.php#actualite">Actualités</a></li>',
				 							'<li><a href="./accueil.php#formation">Formations</a></li>',
				 							'<li><a href="./accueil.php#partenaire">Partenaires</a></li>',
				 							'<li><a href="./accueil.php#donation">Donations</a></li>',
				 							'<li><a href="./accueil.php#contacter">Nous contacter</a></li>';
		if($session != ""){
			echo 						'<li><a href="',APP_PAGE_PROFIL,'" class="navActive">Tableau d\'administration</a></li>';
		}
		else {
			echo 						'<li><a href="login.php" class="navConnexion">Connexion</a> </li>',
											'<li><a href="inscription.php" class="navInscription">S\'inscrire</a></li>';
		}
		echo 						'</ul>',
									'</div>',
									'<div id="navigationResponsive" class="overlay">',
										'<button type="button" class="close" aria-label="Close" onclick="closeNav()"><span aria-hidden="true">&times;</span></button>',
										'<a class="closebtn" onclick="closeNav()">&times;</a>',
										'<ul class="overlay-content">',
											'<li><a href="./accueil.php#actualite" onclick="closeNav()">Actualités</a></li>',
											'<li><a href="./accueil.php#formation" onclick="closeNav()">Formations</a></li>',
											'<li><a href="./accueil.php#partenaire" onclick="closeNav()">Partenaires</a></li>',
											'<li><a href="./accueil.php#donation" onclick="closeNav()">Donations</a></li>',
											'<li><a href="./accueil.php#contacter" onclick="closeNav()">Nous Contacter</a></li>';
		if($session != ""){
			echo 						'<li><a href="',APP_PAGE_PROFIL,'" class="navActive" onclick="closeNav()">Tableau d\'administration</a></li>';
		}
		else {
			echo 						'<li><a href="login.php" onclick="closeNav()">Connexion</a> </li>',
											'<li><a href="inscription.php" onclick="closeNav()">S\'inscrire</a></li>';
		}
		echo						'</ul>',
									'</div>',
									'<span class="btn pull-right hidden-lg hidden-md" onclick="openNav()">MENU</span>',
								'</div>',
							'</nav>',
						'</header>';
}



//___________________________________________________________________
/*******************************************************************************
 *  Fonctions gestion erreurs
*******************************************************************************/

/**
 * Connexion à la base de données.
 * Le connecteur obtenu par la connexion est stocké dans une
 * variable global : $GLOBALS['bd']
 * Le connecteur sera ainsi accessible partout.
 */
/*function bd_connexion() {
  return mysqli_connect("localhost","root","","association_l3");
}*/
function bd_connexion() {
$bd = mysqli_connect(APP_BD_URL, APP_BD_USER, APP_BD_PASS, APP_BD_NOM);

  if ($bd !== FALSE) {
    mysqli_set_charset($bd, 'utf8') or bd_erreurExit('<h4>Erreur lors du chargement du jeu de caractères utf8</h4>');
    $GLOBALS['bd'] = $bd;
    return;			// Sortie connexion OK
  }

  // Erreur de connexion
  // Collecte des informations facilitant le debugage
  $msg = '<h4>Erreur de connexion base MySQL</h4>'
          .'<div style="margin: 20px auto; width: 350px;">'
              .'APP_BD_URL : '.APP_BD_URL
              .'<br>APP_BD_USER : '.APP_BD_USER
              .'<br>APP_BD_PASS : '.APP_BD_PASS
              .'<br>APP_BD_NOM : '.APP_BD_NOM
              .'<p>Erreur MySQL num&eacute;ro : '.mysqli_connect_errno($bd)
              .'<br>'.mysqli_connect_error($bd)
          .'</div>';

  bd_erreurExit($msg);
}
/**
 * Traitement erreur mysql, affichage et exit.
 *
 * @param string		$sql	Requête SQL ou message
 */
function bd_erreur($bd, $sql) {
	$errNum = mysqli_errno($bd);
	$errTxt = mysqli_error($bd);

	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de requête</h4>'
			."<pre><b>Erreur mysql :</b> $errNum"
			."<br> $errTxt"
			."<br><br><b>Requête :</b><br> $sql"
			.'<br><br><b>Pile des appels de fonction</b>';

	// Récupération de la pile des appels de fonction
	$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
			.'<tr><td>Fonction</td><td>Appelée ligne</td>'
			.'<td>Fichier</td></tr>';

	$appels = debug_backtrace();
	for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
		$msg .= '<tr align="center"><td>'
				.$appels[$i]['function'].'</td><td>'
				.$appels[$i]['line'].'</td><td>'
				.$appels[$i]['file'].'</td></tr>';
	}

	$msg .= '</table></pre>';

	bd_erreurExit($msg);
}

//___________________________________________________________________
/**
 * Arrêt du script si erreur base de données.
 * Affichage d'un message d'erreur si on est en phase de
 * développement, sinon stockage dans un fichier log.
 *
 * @param string	$msg	Message affiché ou stocké.
 */
function bd_erreurExit($msg) {
	ob_end_clean();		// Supression de tout ce qui
					// a pu être déja généré

	echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
			'Erreur base de données</title></head><body>',
			$msg,
			'</body></html>';
	exit();
	}

function verifie_session(){
	session_start();
	if(!isset($_SESSION['idCompte'])){
		session_unset();
		session_destroy();
		$cookieParams = session_get_cookie_params();
		setcookie(session_name(),
			'',
			time() - 86400,
         	$cookieParams['path'],
         	$cookieParams['domain'],
         	$cookieParams['secure'],
         	$cookieParams['httponly']
    	);
		header('location:'.APP_PAGE_CONNEXION); 
		exit();
	}
	$S = 'SELECT actifCompte
				FROM compte
				WHERE idCompte ='.$_SESSION['idCompte'];
	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);
	$tab=mysqli_fetch_assoc($R);
	if($tab['actifCompte'] == 0){
		header('location:'.APP_PAGE_CONNEXION);
	}
}

function getTypeCompte($id=''){
    // Requête qui va récuperer les informations nous concernant (typeCompte).
    $S = "SELECT    typeCompte
            FROM    compte
            WHERE    idCompte = '$id'";
    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
    $D = mysqli_fetch_row($R);

    return $D[0];
}

/**
 * Génère le code HTML d'un item de statistiques.
 *
 * @param integer $nb      Nombre de [...] pour cet item
 * @param string  $item    Nom de l'item
 * @param string  $image   Chemin vers l'image souhaitée
 * @param string  $details Détails supplémentaires
 */
function item_stat($nb, $item, $image, $details) {
  echo '<div class="item col-md-4 col-sm-6">',
          '<img class="img-responsive center-block" src="',$image,'" alt="Une image" height="100px" width="100px"/>',
          '<h3 class="text-center">',$nb,' ',$item,'</h3>',
          '<p>',$details,'</p>',
        '</div>';
}


function supprimer_user_admin ($id_Entreprise, $id_Coordonnees) {
    $S = "DELETE FROM compte
                    WHERE    idCompte = '$id_Entreprise'";
        $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

        $S2 = "DELETE FROM coordonnees
                    WHERE    idCoordonnees = '$id_Coordonnees'";
        $R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);

}
	
	/**
	* Fonction qui permet de faire les statistique concernant une
	* formation à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_formation($idFormation) {
		$stat = array();
		
		$S = "SELECT count(idCandidature)
			FROM candidature
			WHERE experienceCandidature = '$idFormation'
			AND	typeCandidature = '1'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		$S = "SELECT count(accepteeCandidature)
			FROM candidature
			WHERE experienceCandidature = '$idFormation'
			AND	typeCandidature = '1'
			AND accepteeCandidature = '1'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[1] = $D[0];
		
		$S2 = "SELECT count(certificationAsuivi)
			FROM propose, asuivi
			WHERE formationAsuivi = idPropose
			AND	formationPropose = '$idFormation'
			AND certificationAsuivi = '1'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		$D2 = mysqli_fetch_row($R2);
		$stat[2] = $D2[0];
		
		$currentDate = date('Ymd');
		$S3 = "SELECT count(idAsuivi)
			FROM propose, asuivi
			WHERE formationAsuivi = idPropose
			AND	formationPropose = '$idFormation'
			AND dateDebutAsuivi <= '$currentDate'
			AND	dateFinAsuivi > '$currentDate'";
		$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		$D3 = mysqli_fetch_row($R3);
		$stat[3] = $D3[0];
		
		$S4 = "SELECT count(stageCertificationRequise)
			FROM certificationrequise
			WHERE formationCertificationRequise = '$idFormation'";
		$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
		$D4 = mysqli_fetch_row($R4);
		$stat[4] = $D4[0];
		
		$S5 = "SELECT count(polePropose)
			FROM propose
			WHERE formationPropose = '$idFormation'";
		$R5 = mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($GLOBALS['bd'], $S5);
		$D5 = mysqli_fetch_row($R5);
		$stat[5] = $D5[0];
		
		return $stat;
	}
	
	/**
	* Fonction qui permet de faire les statistique concernant un
	* stage à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_stage($idStage) {
		$stat = array();
		
		$S = "SELECT count(idCandidature)
			FROM candidature
			WHERE experienceCandidature = '$idStage'
			AND	typeCandidature = '2'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		$S = "SELECT count(accepteeCandidature)
			FROM candidature
			WHERE experienceCandidature = '$idStage'
			AND	typeCandidature = '2'
			AND accepteeCandidature = '1'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[1] = $D[0];
		
		$S2 = "SELECT count(embaucheAeffectue)
			FROM aeffectue
			WHERE stageAeffectue = '$idStage'
			AND	embaucheAeffectue = '1'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		$D2 = mysqli_fetch_row($R2);
		$stat[2] = $D2[0];
		
		$currentDate = date('Ymd');
		$S3 = "SELECT count(idAeffectue)
			FROM aeffectue
			WHERE stageAeffectue = '$idStage'
			AND dateDebutAeffectue <= '$currentDate'
			AND	dateFinAeffectue > '$currentDate'";
		$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		$D3 = mysqli_fetch_row($R3);
		$stat[3] = $D3[0];
		
		return $stat;
	}
	
	/**
	* Fonction qui permet de faire les statistique concernant un
	* stage à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_pole($idPole) {
		$stat = array();
		
		$S = "SELECT count(formationPropose)
			FROM propose
			WHERE polePropose = '$idPole'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		$S = "SELECT DISTINCT count(etudiantAsuivi)
			FROM propose, asuivi
			WHERE polePropose = '$idPole'
			AND	formationPropose = 'formationAsuivi'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[1] = $D[0];
		
		$S2 = "SELECT DISTINCT count(etudiantAsuivi)
			FROM propose, asuivi
			WHERE polePropose = '$idPole'
			AND	formationPropose = 'formationAsuivi'
			AND certificationAsuivi = '1'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		$D2 = mysqli_fetch_row($R2);
		$stat[2] = $D2[0];
		
		return $stat;
	}
	
		/**
	* Fonction qui permet de faire les statistique concernant un
	* étudiant à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_etudiant($idEtudiant) {
		$stat = array();
		
		$S = "SELECT count(idCandidature)
			FROM candidature
			WHERE compteCandidature = '$idEtudiant'
			AND	typeCandidature = '1'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		$S = "SELECT count(idCandidature)
			FROM candidature
			WHERE compteCandidature = '$idEtudiant'
			AND	typeCandidature = '2'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[1] = $D[0];
		
		$S = "SELECT count(idAsuivi)
			FROM asuivi
			WHERE etudiantAsuivi = '$idEtudiant'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[2] = $D[0];

		$S = "SELECT count(idAeffectue)
			FROM aeffectue
			WHERE etudiantAeffectue = '$idEtudiant'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[3] = $D[0];
		
		return $stat;
	}

	/**
	* Fonction qui permet de faire les statistique concernant une
	* entreprise à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_entreprise($idEntreprise) {
		$stat = array();
		
		$S = "SELECT count(idStage)
			FROM stage
			WHERE entrepriseStage = '$idEntreprise'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		$S = "SELECT count(idAeffectue)
			FROM aeffectue, stage
			WHERE stageAeffectue = idStage
			AND entrepriseStage = '$idEntreprise'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[1] = $D[0];
		
		$S = "SELECT count(idAeffectue)
			FROM aeffectue, stage
			WHERE stageAeffectue = idStage
			AND entrepriseStage = '$idEntreprise'
			AND embaucheAeffectue = 1";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[2] = $D[0];
		
		return $stat;
	}

	/**
	* Fonction qui permet de faire les statistique concernant un
	* bénévole à partir de son identifiant.
	*
	* @return array $stat		Tableau des statistiques détectées.
	*/
	function statistique_benevole($idBenevole) {
		$stat = array();
		
		$S = "SELECT count(idEnseignement)
			FROM enseignement
			WHERE benevoleEnseignement = '$idBenevole'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		$D = mysqli_fetch_row($R);
		$stat[0] = $D[0];
		
		return $stat;
	}
?>
