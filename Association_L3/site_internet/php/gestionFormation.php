<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	$idFormation = $_GET["id"];
	
	// Requête qui va récuperer les informations nous concernant (typeCompte).
	$S = "SELECT	typeCompte
			FROM	compte
			WHERE	idCompte = '$id'";

	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
	$D = mysqli_fetch_row($R);
	
	$estAdmin = $D[0];
	// On vérifie que l'utilisateur est un admin et qu'il a le droit d'ajouter des formations.
	if($estAdmin != 0) {
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
	}
	
	$S2 = "SELECT	titreFormation, descriptionFormation, dureeFormation, dispoFormation
			FROM	formation
			WHERE	idFormation = '$idFormation'";
			
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	$D2 = mysqli_fetch_row($R2);
	
	$titreFormation = $D2[0];
	$descriptionFormation = $D2[1];
	$dureeFormation = $D2[2];
	$dispoFormation = $D2[3];
	$stat = statistique_formation($idFormation);
	
	if($dispoFormation == "1") {
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
		$_POST['titre'] = "$titreFormation";
		$_POST['description'] = "$descriptionFormation";
		$_POST['duree'] = "$dureeFormation";
		$_POST['formation'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script gestionFormation.
		$erreurs = modifier_formation($idFormation);
		$nbErr = count($erreurs);
	}
	
	if (isset($_POST['btnValider2'])) {
		supprimer_formation($idFormation);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Gestion de Formation");
	html_header($id);
	html_aside_main_debut("","","class=\"active\"","","","","","","","");
	
	echo '<a href="formation.php" class="btn btn-retour">Retour</a>',
        '<h1 class="page-header">Gestion de la formation "',$titreFormation,'"</h1>',
        '<div class="item">',
          '<div class="row">',
            '<div class="col-md-6 col-sm-12">',
              '<h3>',$titreFormation,'<small>#',$idFormation,'</small></h3>',
              '<p class="small">Durée de formation : ',$dureeFormation,' semaines</p>',
              '<p>',$descriptionFormation,'</p>',
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
                    '<th>Nombre étudiants diplomé</th>',
                    '<td>',$stat[2],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre étudiants en formation</th>',
                    '<td>',$stat[3],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre stages proposés</th>',
                    '<td>',$stat[4],'</td>',
                  '</tr>',
                  '<tr>',
                    '<th>Nombre pôles de formation</th>',
                    '<td>',$stat[5],'</td>',
                  '</tr>',
                '</tbody>',
              '</table>',
            '</div>',
          '</div>',
        '</div>',
        '<div class="row">',
          '<div class="col-md-12">',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidatures', 'gestionFormations', 'gestionStatistiques', 'gestionEtudiants']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionFormations', 'gestionCandidatures', 'gestionStatistiques', 'gestionEtudiants']); return false;\"><span class=\"fa fa-cogs\" aria-hidden=\"true\"></span>Modifier formation</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionEtudiants', 'gestionFormations', 'gestionCandidatures', 'gestionStatistiques']); return false;\"><span class=\"fa fa-graduation-cap\" aria-hidden=\"true\"></span>Etudiants</button>",
            '</div>',
          '</div>',
        '</div>',

        '<div id="gestionCandidatures" class="gestion row">',
          '<table class="table table-striped">',
            '<thead>',
              '<tr>',
                '<th>ID</th>',
                '<th>Nom candidat</th>',
                '<th>Pôle de formation</th>',
                '<th>Date demandée</th>',
                '<th>Gestion</th>',
              '</tr>',
            '</thead>',
            '<tbody>',
              '<tr>',
                '<td>1</td>',
                '<td>Martin Dupont</td>',
                '<td>ville formation & code postale & pays</td>',
                '<td>01/01/2018 - 01/03/2018</td>',
                '<td><a href="#" class="text-success"><span class="fa fa-check" aria-hidden="true"></span></a><a href="#" class="text-info"><span class="fa fa-eye" aria-hidden="true"></span></a><a href="#" class="text-danger"><span class="fa fa-times" aria-hidden="true"></span></a></td>',
              '</tr>',
            '</tbody>',
          '</table>',
        '</div>',
        '<div id="gestionFormations" class="gestion row"  accept-charset="iso-8859-1" enctype="multipart/form-data">';
		// Si il y a des erreurs on les affiche
		if ($nbErr > 0) {
			echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
			for ($i = 0; $i < $nbErr; $i++) {
				echo '<br>', $erreurs[$i];
			}
		}
         echo '<form method="POST" action="gestionFormation.php?id=',$idFormation,'" accept-charset="iso-8859-1" enctype="multipart/form-data">',
            '<div class="form-group">',
              '<label class="control-label required" for="name">Titre de la formation<sup style="color:red">*</sup></label>',
              '<input id="titre" name="titre" type="text" class="form-control" placeholder="Entrez le titre de la formation" value="',$titreFormation,'">',
            '</div>',
            '<div class="form-group">',
              '<label class="control-label required" for="name">Description de la formation<sup style="color:red">*</sup></label>',
              '<textarea id="description" name="description" type="text" class="form-control" placeholder="Entrez la description de la formation">',$descriptionFormation,'</textarea>',
            '</div>',
            '<div class="form-group">',
              '<label class="control-label required" for="name">Durée de la formation<sup style="color:red">*</sup></label>',
              '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="',$dureeFormation,'">',
            '</div>',
            '<div class="form-group">',
              '<label class="control-label required" for="name">Fichier de la formation<sup style="color:red">*</sup></label>',
              '<input id="fichier" name="formation" type="file" placeholder="Entrez le fichier de la formation">',
            '</div>',
            '<div class="form-group">',
              '<label class="control-label required">Disponniblité de la formation<sup style="color:red">*</sup></label><br>',
              '<label class="radio-inline"><input type="radio" name="optradio"  value="1" ',$checked,'>Public</label>',
              '<label class="radio-inline"><input type="radio" name="optradio"  value="0" ',$checked2,'>Privée</label>',
            '</div>',
            '<div class="col-md-12">',
              '<div class="col-md-4">',
                '<button type="submit"  onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer cette formation ?\'))" value="supprimer" class="btn btn-inline btn-danger btn-block" name="btnValider2"><span class="fa fa-trash-o" aria-hidden="true"></span>Supprimer formation</button>',
              '</div>',
              '<div class="col-md-4">',
                '<button type="reset" class="btn btn-inline btn-info btn-block">Annuler changement</button>',
              '</div>',
              '<div class="col-md-4">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Sauvegarder formation</button>',
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
                '<th>Pôle de formation</th>',
                '<th>Date formation</th>',
                '<th>Certifié</th>',
              '</tr>',
            '</thead>',
            '<tbody>';
			$S3 = "SELECT	etudiantAsuivi, villeCoordonnees, codePostalCoordonnees, paysCoordonnees, dateDebutAsuivi, dateFinAsuivi, certificationAsuivi
					FROM	asuivi, propose, coordonnees, poleFormation
					WHERE	formationAsuivi = idPropose
					AND	polePropose = idPoleFormation
					AND	coordonneesPoleFormation  = idCoordonnees
					AND	formationPropose= '$idFormation'
					ORDER BY etudiantAsuivi, dateDebutAsuivi";		
			$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
			while ($D3 = mysqli_fetch_assoc($R3)) {
				$etudiantAsuivi = $D3['etudiantAsuivi'];
				$villeCoordonnees = $D3['villeCoordonnees'];
				$codePostalCoordonnees = $D3['codePostalCoordonnees'];
				$paysCoordonnees = $D3['paysCoordonnees'];
				$dateDebutAsuivi = $D3['dateDebutAsuivi'];
				$dateFinAsuivi = $D3['dateFinAsuivi'];
				$certificationAsuivi = $D3['certificationAsuivi'];
				if($certificationAsuivi == 1) {
					$certificationAsuivi = "text-success fa fa-check";
				} else {
					$certificationAsuivi = "text-danger fa fa-times";
				}
				
				$S4 = "SELECT	nomCoordonnees
						FROM compte, coordonnees
						WHERE	coordonneesCompte = idCoordonnees
						AND	idCompte = '$etudiantAsuivi'";		
				$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
				$D4 = mysqli_fetch_row($R4);
				$nomCoordonnees = $D4[0];
             echo '<tr>',
                '<td>',$etudiantAsuivi,'</td>',
                '<td>',$nomCoordonnees,'</td>',
                '<td>',$villeCoordonnees,' ',$codePostalCoordonnees,' ',$paysCoordonnees,'</td>',
                '<td>',$dateDebutAsuivi,' - ',$dateFinAsuivi,'</td>',
                '<td><span class="',$certificationAsuivi,'" aria-hidden="true"></span></td>',
              '</tr>';
			}
           echo '</tbody>',
          '</table>',
        '</div>';
	
	html_aside_main_fin();
	echo '</body></html>';
	
		//_______________________________________________________________
	//
	//		FONCTIONS LOCALES
	//_______________________________________________________________

	/**
	* Fonction qui permet d'ajouter les informations reliées à une nouvelle
	* formation et qui vérifie que les changements sont correctes et peuvent
	* être ajouté à la base de donnée.
	* Si aucune erreur n'est détecté on change ses informations et on le redirige
	* vers la page gestionFormation.
	*
	* @return array $erreurs		Tableau des erreurs détectées.
	*/
	function modifier_formation($idFormation) {
		//-----------------------------------------------------
		// Vérification des zones
		//-----------------------------------------------------	
		$erreurs = array();
		
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
		
		// Vérification du fichier
		$dossier = "../upload/";
		$fichier = basename($_FILES['formation']['name']);
		$taille = filesize($_FILES['formation']['tmp_name']);
		$extension = strrchr($_FILES['formation']['name'], '.');
		
		if($extension != ".pdf") {
			$erreurs[] = 'Votre fichier n\'est pas au format PDF ';
		}
		
		//renomage du fichier
		//rename("$fichier", "file" .time(). "1");
		
		if(!move_uploaded_file($_FILES['formation']['tmp_name'], $dossier . $fichier)) {
			$erreurs[] = "Erreur interne de transfert";
		}
		
		// Si il y a des erreurs, la fonction renvoie le tableau d'erreurs
		if (count($erreurs) > 0) {
			return $erreurs;		// RETURN : des erreurs ont été détectées
		}
		
		// Ajout des informations.
		$txtTitre = mysqli_real_escape_string($GLOBALS['bd'], $txtTitre);
		$txtDescription = mysqli_real_escape_string($GLOBALS['bd'], $txtDescription);
		$txtDuree = mysqli_real_escape_string($GLOBALS['bd'], $txtDuree);
		$fichier = mysqli_real_escape_string($GLOBALS['bd'], $fichier);
		$taille = mysqli_real_escape_string($GLOBALS['bd'], $taille);
		$formationDispo = mysqli_real_escape_string($GLOBALS['bd'], $_POST['optradio']);
		
		$S = "UPDATE formation SET
				titreFormation = '$txtTitre',
				descriptionFormation = '$txtDescription',
				documentFormation = '$fichier',
				tailleDocumentFormation = '$taille',
				dureeFormation = '$txtDuree',
				dispoFormation = '$formationDispo'
				WHERE	idFormation = '$idFormation'";
		
		mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		header("location: gestionFormation.php?id=$idFormation");
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
	
	/**
	* Permet de connecter un utilisateur si aucun problème n'est détecté.
	*
	* fonction qui permet de supprimer une formation.
	*
	*/
	function supprimer_formation($idFormation) {
		
		$S = "DELETE FROM formation
					WHERE	idFormation = '$idFormation'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
		
		$S2 = "DELETE FROM propose
					WHERE	formationPropose = '$idFormation'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
		
		$S3 = "DELETE FROM enseignement
					WHERE	formationEnseignement = '$idFormation'";
		$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
		
		$S4 = "DELETE FROM certifiactionrequise
					WHERE	formationCertificationRequise = '$idFormation'";
		$R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($GLOBALS['bd'], $S4);
		
		$S5 = "DELETE FROM candidature
					WHERE	experienceCandidature = '$idFormation'
					AND		typeCandidature = '1'";
		$R5 = mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($GLOBALS['bd'], $S5);
		
		header ('location: formation.php');
		exit();			// EXIT : le script est terminé
		ob_end_flush();
	}
?>