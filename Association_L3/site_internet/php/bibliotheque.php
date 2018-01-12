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
define('APP_BD_URL', '');
define('APP_BD_USER', '');
define('APP_BD_PASS', '');
define('APP_BD_NOM', '');

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
	if ($css == '-') {
		$css = '';
	} else {
		$css = "<link rel='stylesheet' href='$css'>";
	}

	echo '<!DOCTYPE HTML>',
		'<html lang="fr">',
			'<head>',
				'<meta charset="UTF-8">',
				'<title>', $titre, '</title>',
				$css,
				'<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
				'<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">',
			'</head>',
			'<body><section>';
}

/*******************************************************************************
 * Génère le code HTML du pied des pages.
*******************************************************************************/
function html_pied() {
	echo 	'</section><footer>',

				'</footer></body></html>';
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
?>
