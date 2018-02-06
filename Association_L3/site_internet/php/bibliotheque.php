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
define('APP_BD_PASS', '');
define('APP_BD_NOM', 'association_l3');

define('APP_NOM_APPLICATION','');

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
				'<title>', $titre, '</title>',
				'<link rel="stylesheet" href="../css/reboot.css">',
				'<link rel="stylesheet" href="../css/bootstrap-theme.css">',
				'<link rel="stylesheet" href="../css/bootstrap.css">',
				'<link rel="stylesheet" href="../css/font-awesome.min.css">',
				'<link rel="stylesheet" href="../css/style.css">',
				'<script src="../jq/jquery-2.1.1.min.js"></script>',
				'<script src="../js/bootstrap.min.js"></script>',
				'<script src="../js/fonction.js"></script>',
			'</head>';
}

/*******************************************************************************
 * Génère le code HTML du pied des pages.
*******************************************************************************/
function html_pied($little = "") {
	if($little != "") {
		echo '<footer class="little-footer">',
		'<div class="container">',
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
    '</footer>';
	}
	else {
		echo '<footer>',
		'<div class="container">',
			'<div class="row justify-content-center">',
				'<h1>NOM ASSOCIATION</h1>',
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
}

/*******************************************************************************
 * Génère le code HTML du header des pages.
*******************************************************************************/
function html_header($session = "") {
	if($session != "") {
		echo '<body id="signIn">',
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
						'<li><a href="#Contacter">Nous contacter</a></li>',
						'<li><a href="#Connexion" class="navConnexion">Connexion</a> </li>',
						'<li><a href="#Candidater" class="navInscription">S\'inscrire</a></li>',
					  '</ul>',
					'</div>',
					'<div id="navigationResponsive" class="overlay">',
					  '<button type="button" class="close" aria-label="Close" onclick="closeNav()"><span aria-hidden="true">&times;</span></button>',
					  '<a class="closebtn" onclick="closeNav()">&times;</a>',
					  '<ul class="overlay-content">',
						'<li><a href="http://google.Com" onclick="closeNav()">Actualités</a></li>',
						'<li><a href="#Statitistique" onclick="closeNav()">Statistiques</a></li>',
						'<li><a href="#Partenaire" onclick="closeNav()">Partenaires</a></li>',
						'<li><a href="#Donation" onclick="closeNav()">Donation</a></li>',
						'<li><a href="#Contacter" onclick="closeNav()">Nous Contacter</a></li>',
						'<li><a href="#Connexion" onclick="closeNav()">Connexion</a> </li>',
						'<li><a href="#Candidater" onclick="closeNav()">S\'inscrire</a></li>',
					  '</ul>',
					'</div>',
					'<span class="btn pull-right hidden-lg hidden-md" onclick="openNav()">MENU</span>',
				  '</div>',
				'</nav>',
			  '</header>';
	}
	else {
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
					'<li><a href="#Contacter">Nous contacter</a></li>',
					'<li><a href="#Administration" class="navActive">Tableau d\'administration</a></li>',
				  '</ul>',
				'</div>',
				'<div id="navigationResponsive" class="overlay">',
				  '<button type="button" class="close" aria-label="Close" onclick="closeNav()"><span aria-hidden="true">&times;</span></button>',
				  '<a class="closebtn" onclick="closeNav()">&times;</a>',
				  '<ul class="overlay-content">',
					'<li><a href="http://google.Com" onclick="closeNav()">Actualités</a></li>',
					'<li><a href="#Statitistique" onclick="closeNav()">Statistiques</a></li>',
					'<li><a href="#Partenaire" onclick="closeNav()">Partenaires</a></li>',
					'<li><a href="#Donation" onclick="closeNav()">Donation</a></li>',
					'<li><a href="#Contacter" onclick="closeNav()">Nous Contacter</a></li>',
					'<li><a href="#Connexion" class="navActive" onclick="closeNav()">Tableau d\'administration</a></li>',
				  '</ul>',
				'</div>',
				'<span class="btn pull-right hidden-lg hidden-md" onclick="openNav()">MENU</span>',
			  '</div>',
			'</nav>',
		  '</header>';
	}
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
function bd_connexion() {
  $bd = mysqli_connect("localhost","root","","association_l3");

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
function bd_erreur($sql) {
	$errNum = mysqli_errno($GLOBALS['bd']);
	$errTxt = mysqli_error($GLOBALS['bd']);

	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de requ&ecirc;te</h4>'
			."<pre><b>Erreur mysql :</b> $errNum"
			."<br> $errTxt"
			."<br><br><b>Requ&ecirc;te :</b><br> $sql"
			.'<br><br><b>Pile des appels de fonction</b>';

	// Récupération de la pile des appels de fonction
	$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
			.'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
			.'<td>Fichier</td></tr>';

	// http://www.php.net/manual/fr/function.debug-backtrace.php
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
	ob_end_clean();		// Supression de tout ce qui a pu être déja généré

	// Si on est en phase de développement, on affiche le message
	if (APP_TEST) {
		echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>',
				'Erreur base de données</title></head><body>',
				$msg,
				'</body></html>';
		exit();
	}

	// Si on est en phase de production on stocke les
	// informations de débuggage dans un fichier d'erreurs
	// et on affiche un message sibyllin.
	$buffer = date('d/m/Y H:i:s')."\n$msg\n";
	error_log($buffer, 3, 'erreurs_bd.txt');

	// Génération d'une page spéciale erreur
	html_head('24sur7');

	echo '<h1>24sur7 est overbook&eacute;</h1>',
			'<div id="bcDescription">',
				'<h3 class="gauche">Merci de r&eacute;essayez dans un moment</h3>',
			'</div>';

	html_pied();

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