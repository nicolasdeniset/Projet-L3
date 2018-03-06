<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	$idStage = $_GET["id"];
	
	// Requête qui va récuperer les informations nous concernant (typeCompte).
	$S = "SELECT	typeCompte
			FROM	compte
			WHERE	idCompte = '$id'";
	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
	$D = mysqli_fetch_row($R);
	
	$estAdmin = $D[0];
	// On vérifie que l'utilisateur est un admin et qu'il a le droit d'ajouter des formations.
	if($estAdmin != 0) {
		header('location: stage.php');
		exit();			// EXIT : le script est terminé
	}
	
	$S2 = "SELECT	titreStage, descriptionStage, dureeStage, dispoStage, entrepriseStage, coordonneesStage
			FROM	stage
			WHERE	idStage = '$idStage'";
			
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	$D2 = mysqli_fetch_row($R2);	
	$titreStage = $D2[0];
	$descriptionStage = $D2[1];
	$dureeStage1 = $D2[2];
	$dispoStage = $D2[3];
	$idEntrepriseStage = $D2[4];
	$idCoordonneesStage = $D2[5];
	$S2 = "SELECT	nomEntrepriseCompte
			FROM	compte
			WHERE	idCompte = '$idEntrepriseStage'";
			
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	$D2 = mysqli_fetch_row($R2);
	$compagnyName = $D2[0];
	$S2 = "SELECT	nomCoordonnees, prenomCoordonnees, emailCoordonnees, telephoneCoordonnees, adresseCoordonnees, codePostalCoordonnees, villeCoordonnees, paysCoordonnees
			FROM	coordonnees
			WHERE	idCoordonnees = '$idCoordonneesStage'";
			
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	$D2 = mysqli_fetch_row($R2);
	$nomCoordonnees = $D2[0];
	$prenomCoordonnees = $D2[1];
	$emailCoordonnees = $D2[2];
	$telephoneCoordonnees = $D2[3];
	$adresseCoordonnees = $D2[4];
	$codePostalCoordonnees = $D2[5];
	$villeCoordonnees = $D2[6];
	$paysCoordonnees = $D2[7];
	$stat = statistique_stage($idStage);
	
	if($dispoStage == "1") {
		$checked = "checked";
		$checked2 = "";
	}
	else {
		$checked = "";
		$checked2 = "checked";
	}
	
	//-----------------------------------------------------
	// Détermination de la phase de traitement : 1er affichage
	// ou soumission du formulaire
	//-----------------------------------------------------
	if (! isset($_POST['btnValider'])) { // premier formulaire
		// On n'est dans un premier affichage de la page. On
		// intialise les zones de saisie.
		$nbErr = 0;
		$_POST['titre'] = $titreStage;
		$_POST['name'] = $nomCoordonnees;
		$_POST['firstname'] = $prenomCoordonnees;
		$_POST['email'] = $emailCoordonnees;
		$_POST['phone'] = $telephoneCoordonnees;
		$_POST['address'] = $adresseCoordonnees;
		$_POST['cp'] = $codePostalCoordonnees;
		$_POST['city'] = $villeCoordonnees;
		$_POST['country'] = $paysCoordonnees;
		$_POST['description'] = $descriptionStage;
		$_POST['duree'] = $dureeStage1;
		$_POST['compagnyName'] = $compagnyName;
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script gestionStage.
		$erreurs = modifier_stage($idStage,$idCoordonneesStage);
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Gestion de Stage");
	html_header($id);
	html_aside_main_debut(APP_PAGE_STAGE);
	
	echo '<a href="stage.php" class="btn btn-retour">Retour</a>',
       '<h1 class="page-header">Gestion du stage "',$titreStage,'"</h1>',
        '<div class="item">',
          '<div class="row">',
            '<div class="col-md-6 col-sm-12">',
              '<h3>',$titreStage,'</h3>',
              '<p class="small">Durée de formation : ',$dureeStage1,' semaines</p>',
              '<p>',$descriptionStage,'</p>',
            '</div>',
            '<div class="col-md-6 col-sm-12">',
              '<h3>STATISTIQUES</h3>',
              '<table class="table table-striped">',
                '<tbody>',
                  '<tr>',
                    '<th>Nombre candidatures</th>',
                    '<td>',$stat[0],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre étudiants acceptés</th>',
                    '<td>',$stat[1],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre étudiants embauchés</th>',
                    '<td>',$stat[2],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre étudiants en stage</th>',
                    '<td>',$stat[3],'</td>',
                  '</tr>',
                '</tbody>',
              '</table>',
            '</div>',
        '</div>',
		'<div class="row">',
          '<div class="col-md-12">',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidatures', 'gestionStages', 'gestionEtudiants']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionStages', 'gestionCandidatures', 'gestionEtudiants']); return false;\"><span class=\"fa fa-cogs\" aria-hidden=\"true\"></span>Modifier stage</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionEtudiants', 'gestionStages', 'gestionCandidatures']); return false;\"><span class=\"fa fa-graduation-cap\" aria-hidden=\"true\"></span>Etudiants</button>",
            '</div>',
          '</div>',
        '</div>',
		
		'<div id="gestionCandidatures" class="gestion row">',
          '<table class="table table-striped">',
            '<thead>',
              '<tr>',
                '<th>ID</th>',
                '<th>Nom candidat</th>',
                '<th>Date demandée</th>',
                '<th>Gestion</th>',
              '</tr>',
            '</thead>',
            '<tbody>';
			$date = date('Ymd');
			$dateDebut = date('Y-m-d',strtotime('+1 month',strtotime($date)));
			$S = "SELECT idCandidature, nomCoordonnees, prenomCoordonnees, dureeStage, idCompte
				FROM candidature, compte, coordonnees, stage
				WHERE compteCandidature = idCompte
				AND coordonneesCompte = idCoordonnees
				AND typeCandidature = '2'
				AND traiteeCandidature = '0'
				AND experienceCandidature = idStage
				AND experienceCandidature = '$idStage'
				ORDER BY idCandidature";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$i = 0;
			while ($D = mysqli_fetch_assoc($R)) {
				$idCandidat = $D['idCandidature'];
				$nomCandidat = $D['nomCoordonnees'];
				$prenomCandidat = $D['prenomCoordonnees'];
				$dureeStage = 7 * $D['dureeStage'];
				$idCompteCandidat = $D['idCompte'];
				$dateFin = date('Y-m-d',strtotime("+$dureeStage day",strtotime($dateDebut)));
				echo '<tr>',
					'<td>',$idCandidat,'</td>',
					'<td>',$prenomCandidat,' ',$nomCandidat,'</td>',
					'<td>',$dateDebut,' - ',$dateFin,'</td>',
					'<td>',
					'<form method="POST" action="profil.php">',
							'<input type="hidden" name="id_Membre" value="',$idCompteCandidat,'" />',
							'<input type="hidden" name="idCandidature" value="',$idCandidat,'" />',
							'<input type="hidden" name="pageDeRetour" value="gestionStage.php?id=',$idStage,'" />',
							'<input type="hidden" name="idStage" value="',$idStage,'" />',
							'<input type="hidden" name="dateDebut" value="',$dateDebut,'" />',
							'<input type="hidden" name="dateFin" value="',$dateFin,'" />',
							'<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
					'</form>',
					'<form method="POST" action="gestionStage.php?id=',$idStage,'">',
						'<button type="submit" class="btn btn-inline" name="accepter',$i,'"><span class="text-success fa fa-check" aria-hidden="true"></span></button>',
						'<button type="submit" class="btn btn-inline" name="refuser',$i,'"><span class="text-danger fa fa-times" aria-hidden="true"></span></button>',
					'</form>',
					'</td>',
				  '</tr>';
					if (isset($_POST["refuser$i"])) {
						$S = "UPDATE	candidature
								SET	traiteeCandidature = '1', accepteeCandidature = '0'
								WHERE	idCandidature = '$idCandidat'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						header("location: gestionStage.php?id=$idStage");
						exit();			// EXIT : le script est terminé
						ob_end_flush();
					}
					if (isset($_POST["accepter$i"])) {
						$S = "UPDATE	candidature
								SET	traiteeCandidature = '1', accepteeCandidature = '1'
								WHERE	idCandidature = '$idCandidat'";
						$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						$S = "INSERT INTO aeffectue SET
								etudiantAeffectue = '$idCompteCandidat',
								stageAeffectue = '$idStage',
								tuteurAeffectue = 'Voir table stage',
								dateDebutAeffectue  = '$dateDebut',
								dateFinAeffectue  = '$dateFin',
								embaucheAeffectue = '0'";
						mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
						header("location: gestionStage.php?id=$idStage");
						exit();			// EXIT : le script est terminé
						ob_end_flush();
					}
				  $i++;
			}
            echo '</tbody>',
          '</table>',
        '</div>',
		
		'<div id="gestionStages" class="gestion row">';
		// Si il y a des erreurs on les affiche
		if ($nbErr > 0) {
			echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
			for ($i = 0; $i < $nbErr; $i++) {
				echo '<br>', $erreurs[$i];
			}
		}
		echo '<form method="POST" action="gestionStage.php?id=',$idStage,'" accept-charset="iso-8859-1" >',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Titre du stage<sup style="color:red">*</sup></label>',
                '<input id="titre" name="titre" type="text" class="form-control" placeholder="Entrez le titre du stage" value="',$titreStage,'">',
              '</div>',
				   '<div class="form-group">',
				   '<label class="control-label required" for="compagnyName">Sélectionner le nom de l\'entreprise proposant le stage<sup style="color:red">*</sup></label><br>';
					$S = "SELECT	entrepriseStage, nomEntrepriseCompte
							FROM	stage, compte
							WHERE	idStage = '$idStage'
							AND		idCompte = entrepriseStage";
					$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
					$D = mysqli_fetch_row($R);
					$selected = $D[0];
				   $S2 = "SELECT nomEntrepriseCompte, idCompte 
							FROM compte 
							WHERE nomEntrepriseCompte != ''
							AND	idCompte != '$selected'";
					$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
					echo '<select name="compagnyName">',
						'<option value="',$D[0],'">',$D[1],'</option>';
					while ($D2 = mysqli_fetch_assoc($R2)) {
						echo '<option value="',$D2['idCompte'],'">',$D2['nomEntrepriseCompte'],'</option>';
					}
				    echo '</select>',
                  '</div>',
				   '<div class="form-group">',
				   '<label class="control-label required" for="formationName">Sélectionner la formation nécessaire pour obtenir ce stage<sup style="color:red">*</sup></label><br>';
					$S = "SELECT	titreFormation, idFormation
							FROM	formation, certificationrequise
							WHERE	stageCertificationRequise = '$idStage'
							AND		idFormation = formationCertificationRequise";
					$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
					$D = mysqli_fetch_row($R);
					$selected = $D[1];
				   $S3 = "SELECT titreFormation, idFormation 
							FROM formation
							WHERE idFormation != '$selected'";
					$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
					echo '<select name="formationName">',
						'<option value="',$D[1],'">',$D[0],'</option>';
					while ($D3 = mysqli_fetch_assoc($R3)) {
						echo '<option value="',$D3['idFormation'],'">',$D3['titreFormation'],'</option>';
					}
				    echo '</select>',
                  '</div>',
				   '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrer son nom" value="',$nomCoordonnees,'">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrer son prénom" value="',$prenomCoordonnees,'">',
                  '</div>',                   
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrer son adresse mail" value="',$emailCoordonnees,'">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer son numéro de téléphone" value="',$telephoneCoordonnees,'">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse du stage<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue" value="',$adresseCoordonnees,'">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal du stage<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrer son code postal" value="',$codePostalCoordonnees,'">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville du stage<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrer sa ville" value="',$villeCoordonnees,'">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays du stage<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrer son pays" value="',$paysCoordonnees,'">',
                  '</div>',
			  '<div class="form-group">',
                '<label class="control-label required" for="name">Description du stage<sup style="color:red">*</sup></label>',
                '<textarea id="description" name="description" type="text" class="form-control" placeholder="Entrez la description du stage">',$descriptionStage,'</textarea>',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Durée du stage<sup style="color:red">*</sup></label>',
                '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="',$dureeStage1,'">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required">Disponniblité du stage<sup style="color:red">*</sup></label><br>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="1" ',$checked,'>Public</label>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="0" ',$checked2,'>Privée</label>',
              '</div>',
              '<div class="col-md-12">',
                '<div class="col-md-6">',
					'<button type="reset" class="btn btn-inline btn-info btn-block">Annuler changement</button>',
				'</div>',
				'<div class="col-md-6">',
					'<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Sauvegarder stage</button>',
				'</div>',
              '</div>',
            '</form>',
		'</div>',
		
		'<div id="gestionEtudiants" class="gestion row">',
          '<table class="table table-striped">',
            '<thead>',
              '<tr>',
                '<th>ID</th>',
                '<th>Nom étudiant</th>',
                '<th>Date stage</th>',
                '<th>Embauché</th>',
              '</tr>',
            '</thead>',
            '<tbody>';
			$S3 = "SELECT	etudiantAeffectue, nomCoordonnees, prenomCoordonnees, dateDebutAeffectue, dateFinAeffectue, embaucheAeffectue
					FROM	aeffectue, compte, coordonnees
					WHERE idCompte = etudiantAeffectue
					AND	coordonneesCompte  = idCoordonnees
					AND	stageAeffectue= '$idStage'
					ORDER BY etudiantAeffectue, dateDebutAeffectue";		
			$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
			while ($D3 = mysqli_fetch_assoc($R3)) {
				$etudiantAeffectue = $D3['etudiantAeffectue'];
				$nomCoordonnees = $D3['nomCoordonnees'];
				$prenomCoordonnees = $D3['prenomCoordonnees'];
				$dateDebutAeffectue = $D3['dateDebutAeffectue'];
				$dateFinAeffectue = $D3['dateFinAeffectue'];
				$embaucheAeffectue = $D3['embaucheAeffectue'];
				if($embaucheAeffectue == 1) {
					$embaucheAeffectue = "text-success fa fa-check";
				} else {
					$embaucheAeffectue = "text-danger fa fa-times";
				}
             echo '<tr>',
                '<td>',$etudiantAeffectue,'</td>',
                '<td>',$prenomCoordonnees,' ',$nomCoordonnees,'</td>',
                '<td>',$dateDebutAeffectue,' - ',$dateFinAeffectue,'</td>',
                '<td><span class="',$embaucheAeffectue,'" aria-hidden="true"></span></td>',
              '</tr>';
			}
           echo '</tbody>',
          '</table>',
        '</div>';
	
	html_aside_main_fin();
	echo '</body></html>';
	ob_end_flush();
	
	//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________
	
	function modifier_stage($idStage,$idCoordonneesStage) {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		
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
		
		// Vérification du titre
		$txtTitre = trim(utf8_encode($_POST['titre']));
		if ($txtTitre == '') {
			$erreurs[] = 'Vous avez oublié le titre !';
		}
		
		// Vérification de la description
		$txtDescription = trim(utf8_encode($_POST['description']));
		if ($txtDescription == '') {
			$erreurs[] = 'Vous avez oublié la description !';
		}
		
		// Vérification de la durée
		$txtDuree = trim($_POST['duree']);
		if ($txtDuree == '') {
			$erreurs[] = 'Vous avez mis une durée incorrecte !';
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
		
		$S = "UPDATE stage SET
				titreStage = '$txtTitre',
				entrepriseStage = '$idCompteEntreprise',
				descriptionStage = '$txtDescription',
				dureeStage = '$txtDuree',
				dispoStage = '$stageDispo'
				WHERE	idStage = '$idStage'";
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S = "UPDATE coordonnees SET
				nomCoordonnees = '$txtNom',
				prenomCoordonnees = '$txtPrenom',
				emailCoordonnees = '$txtMail',
				telephoneCoordonnees = '$txttelephone',
				adresseCoordonnees = '$txtAdresse',
				codePostalCoordonnees = '$txtCp',
				villeCoordonnees = '$txtVille',
				paysCoordonnees = '$txtPays'
				WHERE idCoordonnees = '$idCoordonneesStage'";
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S = "UPDATE certificationrequise SET
				formationCertificationRequise = '$idFormation'
				WHERE stageCertificationRequise  = '$idStage'";
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		header("location: gestionStage.php?id=$idStage");
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
	
?>