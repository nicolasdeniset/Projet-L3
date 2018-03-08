<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	$idPole = $_GET["id"];
	$listeFormationDejaPropose = array();
	$listeFormation = array();
	
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
	$S3 = "SELECT	coordonneesPoleFormation, nbBenevolesPoleFormation
							FROM	poleformation
							WHERE	idPoleFormation = '$idPole'";
	$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
	$D3 = mysqli_fetch_row($R3);
	$coordonneesPoleFormation = $D3[0];
	$nbBenevolesPoleFormation = $D3[1];
	$S4 = "SELECT	nomCoordonnees, prenomCoordonnees, emailCoordonnees, telephoneCoordonnees, adresseCoordonnees, villeCoordonnees, codePostalCoordonnees, paysCoordonnees, gpsLongitudeCoordonnes, gpsLatitudeCoordonnees 
							FROM	coordonnees
							WHERE	idCoordonnees = '$coordonneesPoleFormation'";
	$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
	$D4 = mysqli_fetch_row($R4);
	$nomCoordonnees = $D4[0];
	$prenomCoordonnees = $D4[1];
	$emailCoordonnees = $D4[2];
	$telephoneCoordonnees = $D4[3];
	$adresseCoordonnees = $D4[4];
	$villeCoordonnees = $D4[5];
	$codePostalCoordonnees = $D4[6];
	$paysCoordonnees = $D4[7];
	$gpsLongitudeCoordonnes = $D4[8];
	$gpsLatitudeCoordonnees = $D4[9];
	$stat = statistique_pole($idPole);
	
	if (isset($_POST['btnValider'])) { 
		ajouter_formationsPropose($idPole);
	}
	if (! isset($_POST['btnValider2'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script gestionPole.
		$erreurs = modifier_pole($idPole,$coordonneesPoleFormation);
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Gestion de Pole de Formation");
	html_header($id);
	html_aside_main_debut(APP_PAGE_POLE);
	
	echo '<a href="poleFormation.php" class="btn btn-retour">Retour</a>',
			'<h1 class="page-header">Gestion du Pôle de ',$villeCoordonnees,'</h1>',
			'<div class="item">',
					'<div class="row">',
						'<div class="col-md-6 col-sm-12">',
						'<h3>Pole de ', $villeCoordonnees ,'</h3>',
						  '<p class="small">Gérant : ',$prenomCoordonnees,' ',$nomCoordonnees,'</p>',
						  '<p class="small">Adresse : ',$adresseCoordonnees,'</p>',
						  '<p class="small">Email : ',$emailCoordonnees,'</p>',
						  '<p class="small">Téléphone : ',$telephoneCoordonnees,'</p>',
						'</div>',
						'<div class="col-md-6 col-sm-12">',
						'<h3>STATISTIQUES</h3>',
							'<table class="table table-striped">',
								'<tbody>',
									'<tr>',
										'<th>Nombre de formations proposées</th>',
										'<td>',$stat[0],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre étudiants</th>',
										'<td>',$stat[1],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre étudiants diplomé</th>',
										'<td>',$stat[2],'</td>',
									'</tr>',
									'<tr>',
										'<th>Nombre de bénévoles</th>',
										'<td>',$nbBenevolesPoleFormation,'</td>',
									'</tr>',
								'</tbody>',
							'</table>',
						'</div>',
					'</div>',
					'<div class="row">',
						'<div class="col-md-12">',
							'<div class="col-md-6">',
							  "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionDesFormations', 'gestionPole']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer les formations du pôle</button>",
							'</div>',
							'<div class="col-md-6">',
							  "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionPole', 'gestionDesFormations']); return false;\"><span class=\"fa fa-cogs\" aria-hidden=\"true\"></span>Modifier les informations du pôle</button>",
							'</div>',
						'</div>',
					'</div>',
					
					'<div id="gestionDesFormations" class="gestion row">',
						'<div class="row">',
						'<form method="POST" action="gestionPoleFormation.php?id=',$idPole,'" accept-charset="iso-8859-1" enctype="multipart/form-data">',
							'<div class="form-group">',
							'<p> Liste des formations disponibles dans ce pôle : <br/>';
							$S = "SELECT	idFormation
									FROM	formation, propose
									WHERE	idFormation = formationPropose
									AND		polePropose = '$idPole'";
							$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
							while ($D = mysqli_fetch_assoc($R)) {
								$listeFormationDejaPropose[] = $D["idFormation"];
							}
							$S2 = "SELECT	idFormation, titreFormation
									FROM	formation";
							$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
							$i = 0;
							while ($D2 = mysqli_fetch_assoc($R2)) {
								if(in_array($D2["idFormation"], $listeFormationDejaPropose)) {
									echo '<input type="checkbox" id="formation',$i,'" name="formation[]" value="',$D2["idFormation"],'" checked/>',
											'<label style="margin: 5px" for="formation',$i,'">  ',$D2["titreFormation"],' </label> ';
								}
								else {
									echo '<input type="checkbox" id="formation',$i,'" name="formation[]" value="',$D2["idFormation"],'"/>',
											'<label style="margin: 5px" for="formation',$i,'">  ',$D2["titreFormation"],' </label> ';
								}
								echo '<br/>';
								$i++;
							}
							echo '</p>',
							'</div>',
							'<div class="col-md-12">',
								'<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Ajouter des formations au pôle</button>',
							'</div>',
						'</form>',
						'</div>',
					'</div>',
		
					'<div id="gestionPole" class="gestion row">';
					// Si il y a des erreurs on les affiche
					if ($nbErr > 0) {
						echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
						for ($i = 0; $i < $nbErr; $i++) {
							echo '<br>', $erreurs[$i];
						}
					}
					echo '<form method="POST" action="gestionPoleFormation.php?id=',$idPole,'" accept-charset="iso-8859-1" >',
						   '<div class="form-group">',
							'<label class="control-label required" for="name">Nom du responsable<sup style="color:red">*</sup></label>',
							'<input id="name" name="name" type="text" class="form-control" placeholder="Entrer son nom" value="',$nomCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="firstname">Prénom du responsable<sup style="color:red">*</sup></label>',
							'<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrer son prénom" value="',$prenomCoordonnees,'">',
						  '</div>',                   
						  '<div class="form-group">',
							'<label class="control-label required" for="email">Email du responsable<sup style="color:red">*</sup></label>',
							'<input id="email" name="email" type="text" class="form-control" placeholder="Entrer son adresse mail" value="',$emailCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="phone">Téléphone du responsable<sup style="color:red">*</sup></label>',
							'<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer son numéro de téléphone" value="',$telephoneCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="address">Adresse<sup style="color:red">*</sup></label>',
							'<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue" value="',$adresseCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="cp">Code postal<sup style="color:red">*</sup></label>',
							'<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrer son code postal" value="',$codePostalCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="city">Ville<sup style="color:red">*</sup></label>',
							'<input id="city" name="city" type="text" class="form-control" placeholder="Entrer sa ville" value="',$villeCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="country">Pays<sup style="color:red">*</sup></label>',
							'<input id="country" name="country" type="text" class="form-control" placeholder="Entrer son pays" value="',$paysCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="gpsLatitude">Coordonnées GPS Latitude<sup style="color:red">*</sup></label>',
							'<input id="gpsLatitude" name="gpsLatitude" type="text" class="form-control" placeholder="Entrer latitude" value="',$gpsLatitudeCoordonnees,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="gpsLongitude">Coordonnées GPS Longitude<sup style="color:red">*</sup></label>',
							'<input id="gpsLongitude" name="gpsLongitude" type="text" class="form-control" placeholder="Entrer longitude" value="',$gpsLongitudeCoordonnes,'">',
						  '</div>',
						  '<div class="form-group">',
							'<label class="control-label required" for="name">Nombre de bénévole<sup style="color:red">*</sup></label>',
							'<input id="nbBenevole" name="nbBenevole" type="number" class="form-control" placeholder="Entrez le nombre de bénévoles" value="',$nbBenevolesPoleFormation,'">',
						  '</div>',
						  '<div class="col-md-12">',
							'<div class="col-md-6">',
								'<button type="reset" class="btn btn-inline btn-info btn-block">Annuler changement</button>',
							'</div>',
							'<div class="col-md-6">',
								'<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider2"><span class="fa fa-check" aria-hidden="true"></span>Sauvegarder les changements du pôle</button>',
							'</div>',
						  '</div>',
						'</form>',
					'</div>',
			'</div>';
					
	
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________	
	function ajouter_formationsPropose($idPole) {
		$listeFormation = array();
		$S = "SELECT formationPropose
				FROM propose
				WHERE	polePropose = '$idPole'";	
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		while ($D = mysqli_fetch_assoc($R)) {
			if(!in_array($D["formationPropose"], $_POST['formation'])) {
				$formationProposeSupprime = $D["formationPropose"];
				$S2 = "DELETE FROM propose
						WHERE	polePropose = '$idPole'
						AND		formationPropose = '$formationProposeSupprime'";	
				mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
			}
		}
		
		$S = "SELECT formationPropose
				FROM propose
				WHERE	polePropose = '$idPole'";	
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		while ($D = mysqli_fetch_assoc($R)) {
			$listeFormation[] = $D["formationPropose"];
		}
		foreach($_POST['formation'] as $formation){
			if(!in_array($formation, $listeFormation)) {
				$formation = mysqli_real_escape_string($GLOBALS['bd'], $formation);
				$S2 = "INSERT INTO propose SET
						formationPropose = '$formation',
						polePropose = '$idPole'";	
				mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
			}
		}
		header("location: gestionPoleFormation.php?id=$idPole");
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
	
	function modifier_pole($idPole,$coordonneesPoleFormation) {
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
		
		if(strpos($txtLatitude, '.') === FALSE) {
			$erreurs[] = 'La latitude est incorrecte';
		}
		
		if(strpos($txtLongitude, '.') === FALSE) {
			$erreurs[] = "La longitude est incorrecte";
		}
		
		if(ctype_digit($txtNbBenevole) != true) {
			$erreurs[] = 'Le nombre de bénévoles entré n\'est pas un numéro';
		}
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		$txtNom = mysqli_real_escape_string($GLOBALS['bd'], $txtNom);
		$txtPrenom = mysqli_real_escape_string($GLOBALS['bd'], $txtPrenom);
		$txtMail = mysqli_real_escape_string($GLOBALS['bd'], $txtMail);
		$txttelephone = mysqli_real_escape_string($GLOBALS['bd'], $txttelephone);
		$txtAdresse = mysqli_real_escape_string($GLOBALS['bd'], $txtAdresse);
		$txtCp = mysqli_real_escape_string($GLOBALS['bd'], $txtCp);
		$txtVille = mysqli_real_escape_string($GLOBALS['bd'], $txtVille);
		$txtPays = mysqli_real_escape_string($GLOBALS['bd'], $txtPays);
		$txtLatitude = mysqli_real_escape_string($GLOBALS['bd'], $txtLatitude);
		$txtLongitude = mysqli_real_escape_string($GLOBALS['bd'], $txtLongitude);
		$txtNbBenevole = mysqli_real_escape_string($GLOBALS['bd'], $txtNbBenevole);
		
		$S = "UPDATE poleformation SET
				nbBenevolesPoleFormation  = '$txtNbBenevole'
				WHERE	idPoleFormation = '$idPole'";
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S = "UPDATE coordonnees SET
				nomCoordonnees = '$txtNom',
				prenomCoordonnees = '$txtPrenom',
				emailCoordonnees = '$txtMail',
				telephoneCoordonnees = '$txttelephone',
				adresseCoordonnees = '$txtAdresse',
				codePostalCoordonnees = '$txtCp',
				villeCoordonnees = '$txtVille',
				paysCoordonnees = '$txtPays',
				gpsLongitudeCoordonnes = '$txtLongitude',
				gpsLatitudeCoordonnees = '$txtLatitude'
				WHERE idCoordonnees = '$coordonneesPoleFormation'";
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		header("location: gestionPoleFormation.php?id=$idPole");
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>