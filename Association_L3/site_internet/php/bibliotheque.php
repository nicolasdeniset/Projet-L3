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
define('APP_PAGE_ACCUEIL', 'accueil.php');

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
function html_head($titre, $css = '../css/style.css') {
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
					'<h3>NOM ASSOCIATION</h3>',
						'<p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
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
					'<p class="copyright"> © 2017 Copyright Blablabla</p>',
				'</div>',
			'</div>',
			'</footer></body></html>';
}

/*******************************************************************************
 * Génère le code HTML du aside + du main pour les pages tableaux de bords
*******************************************************************************/
function html_aside_main_debut($active1,$active2,$active3,$active4,$active5,$active6,$active7,$active8,$active9,$active10){
	echo '<div class="container-fluid">',
    		'<div class="col-sm-3 col-md-2 sidebar">',
      		'<ul class="nav nav-sidebar">',
        		'<li ', $active1,'><a href="#"><span class="fa fa-home" aria-hidden="true"></span>Accueil</a></li>',
		        '<li ', $active2,'><a href="./testStatistiqueAdmin.html"><span class="fa fa-bar-chart" aria-hidden="true"></span>Statistiques</a></li>',
      		'</ul>',
      		'<ul class="nav nav-sidebar">',
        		'<li ', $active3,'><a href="formation.php"><span class="fa fa-book" aria-hidden="true"></span>Formations</a></li>',
        		'<li ', $active4,'><a href="./testStageAdmin.html"><span class="fa fa-briefcase" aria-hidden="true"></span>Stages</a></li>',
      		'</ul>',
      		'<ul class="nav nav-sidebar">',
        		'<li ', $active5,'><a href="listeEntreprise.php"><span class="fa fa-industry" aria-hidden="true"></span>Entreprises</a></li>',
        		'<li ', $active6,'><a href="./testEtudiantAdmin.html"><span class="fa fa-graduation-cap" aria-hidden="true"></span>Etudiants</a></li>',
      		'</ul>',
		      '<ul class="nav nav-sidebar">',
        		'<li ', $active7,'><a href="./testPoleFormation.html"><span class="fa fa-university" aria-hidden="true"></span>Pôle de formation</a></li>',
        		'<li ', $active8,'><a href="./testActualiteAdmin.html"><span class="fa fa-file-text-o" aria-hidden="true"></span>Actualité</a></li>',
      		'</ul>',
      		'<ul class="nav nav-sidebar">',
        		'<li ', $active9,'><a href="#"><span class="fa fa-cogs" aria-hidden="true"></span>Site Internet</a></li>',
		        '<li ', $active10,'><a href="gestionCompte.php"><span class="fa fa-user" aria-hidden="true"></span>Paramètre compte</a></li>',
        		'<li><a href="deconnexion.php"><span class="fa fa-sign-out" aria-hidden="true"></span>Déconnexion</a></li>',
      		'</ul>',
    		'</div>',
				'<main class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">',
      		'<section>';
}

function html_aside_main_fin(){
	echo 	'</section></main></div>';
}
/*******************************************************************************
 * Génère le code HTML du header des pages.
*******************************************************************************/
function html_header($session = "") {
		echo '<body>',
				 	'<header>',
				 		'<nav class="navbar navbar-default navbar-fixed-top">',
				 			'<div class="container">',
				 				'<a id="logo" href="index.html" class="navbar-brand">(logo) - NOM ASSO</a>',
				 					'<div id="navigation" class="navbar-right">',
				 						'<ul class="nav navbar-nav hidden-sm hidden-xs">',
				 							'<li><a href="#Actualité">Actualité</a></li>',
				 							'<li><a href="#Formation">Formation</a></li>',
				 							'<li><a href="#Partenaire">Partenaire</a></li>',
				 							'<li><a href="#Donation">Donation</a></li>',
				 							'<li><a href="#Contacter">Nous contacter</a></li>';
		if($session != ""){
			echo 						'<li><a href="#Administration" class="navActive">Tableau d\'administration</a></li>';
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
											'<li><a href="http://google.Com" onclick="closeNav()">Actualités</a></li>',
											'<li><a href="#Statitistique" onclick="closeNav()">Statistiques</a></li>',
											'<li><a href="#Partenaire" onclick="closeNav()">Partenaires</a></li>',
											'<li><a href="#Donation" onclick="closeNav()">Donation</a></li>',
											'<li><a href="#Contacter" onclick="closeNav()">Nous Contacter</a></li>';
		if($session != ""){
			echo 						'<li><a href="#Connexion" class="navActive" onclick="closeNav()">Tableau d\'administration</a></li>';
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
		header('location: login.php');
		exit();
	}
	return false;
}
?>
