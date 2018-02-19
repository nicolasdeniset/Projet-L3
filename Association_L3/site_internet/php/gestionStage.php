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
		header('location: formation.php');
		exit();			// EXIT : le script est terminé
	}
	
	$S2 = "SELECT	titreStage, descriptionStage, dureeStage, dispoStage, entrepriseStage, coordonneesStage
			FROM	stage
			WHERE	idStage = '$idStage'";
			
	$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
	$D2 = mysqli_fetch_row($R2);	
	$titreStage = $D2[0];
	$descriptionStage = $D2[1];
	$dureeStage = $D2[2];
	$dispoStage = $D2[3];
	$idEntrepriseStage = $D2[4];
	$idCoordonneesStage = $D2[5];
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
		$_POST['titre'] = $_POST['name'] = "";
		$_POST['firstname'] = $_POST['email'] = "";
		$_POST['phone'] = $_POST['address'] = "";
		$_POST['cp'] = $_POST['city'] = "";
		$_POST['country'] = $_POST['description'] = "";
		$_POST['duree'] = $_POST['compagnyName'] = "";
		
	} else {
		// On est dans la phase de soumission du formulaire on en
		// fait la vérification. Si aucune erreur n'est détectée,
		// cette fonction redirige la page sur le script gestionStage.
		$erreurs = modifier_stage();
		$nbErr = count($erreurs);
	}
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Gestion de Stage");
	html_header($id);
	html_aside_main_debut("","","","class=\"active\"","","","","","","");
	
	echo '<a href="stage.php" class="btn btn-retour">Retour</a>',
       '<h1 class="page-header">Gestion du stage "',$titreStage,'"</h1>',
        '<div class="item">',
          '<div class="row">',
            '<div class="col-md-6 col-sm-12">',
              '<h3>',$titreStage,'<small>#',$idStage,'</small></h3>',
              '<p class="small">Durée de formation : ',$dureeStage,' semaines</p>',
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
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionCandidatures', 'gestionStages', 'gestionStatistiques', 'gestionEtudiants']); return false;\"><span class=\"fa fa-id-card-o\" aria-hidden=\"true\"></span>Gérer candidatures</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionStages', 'gestionCandidatures', 'gestionStatistiques', 'gestionEtudiants']); return false;\"><span class=\"fa fa-cogs\" aria-hidden=\"true\"></span>Modifier formation</button>",
            '</div>',
            '<div class="col-md-4">',
              "<button class=\"btn btn-inline btn-success btn-block\" onclick=\"javascript:openGestion(['gestionEtudiants', 'gestionStages', 'gestionCandidatures', 'gestionStatistiques']); return false;\"><span class=\"fa fa-graduation-cap\" aria-hidden=\"true\"></span>Etudiants</button>",
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
				ORDER BY idCompte";
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
					'<td>',$idCompteCandidat,'</td>',
					'<td>',$prenomCandidat,' ',$nomCandidat,'</td>',
					'<td>',$dateDebut,' - ',$dateFin,'</td>',
					'<td>',
					'<form method="POST" action="gestionStage.php?id=',$idStage,'">',
						'<button type="submit" class="btn btn-inline" name="accepter',$i,'"><span class="text-success fa fa-check" aria-hidden="true"></span></button>',
						'<a href="#" class="text-info"><span class="fa fa-eye" aria-hidden="true"></span></a>',
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
		
		'<div id="gestionStages" class="gestion row">',
		'<form method="POST" action="ajoutStage.php" accept-charset="iso-8859-1" >',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Titre du stage<sup style="color:red">*</sup></label>',
                '<input id="titre" name="titre" type="text" class="form-control" placeholder="Entrez le titre du stage">',
              '</div>',
				   '<div class="form-group">',
				   '<label class="control-label required" for="compagnyName">Sélectionner le nom de l\'entreprise proposant le stage<sup style="color:red">*</sup></label><br>';
				    $S2 = "SELECT nomEntrepriseCompte, idCompte 
							FROM compte 
							WHERE nomEntrepriseCompte != ''";
					$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
					$D2 = mysqli_fetch_row($R2);
					echo '<select name="compagnyName">',
						'<option value="',$D2[1],'">',$D2[0],'</option>';
					while ($D2 = mysqli_fetch_assoc($R2)) {
						echo '<option value="',$D2['idCompte'],'">',$D2['nomEntrepriseCompte'],'</option>';
					}
				    echo '</select>',
                  '</div>',
				   '<div class="form-group">',
				   '<label class="control-label required" for="formationName">Sélectionner la formation nécessaire pour obtenir ce stage<sup style="color:red">*</sup></label><br>';
				    $S3 = "SELECT titreFormation, idFormation 
							FROM formation";
					$R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($GLOBALS['bd'], $S3);
					$D3 = mysqli_fetch_row($R3);
					echo '<select name="formationName">',
						'<option value="',$D3[1],'">',$D3[0],'</option>';
					while ($D3 = mysqli_fetch_assoc($R3)) {
						echo '<option value="',$D3['idFormation'],'">',$D3['titreFormation'],'</option>';
					}
				    echo '</select>',
                  '</div>',
				   '<div class="form-group">',
                    '<label class="control-label required" for="name">Nom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="name" name="name" type="text" class="form-control" placeholder="Entrer son nom">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="firstname">Prénom du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="firstname" name="firstname" type="text" class="form-control" placeholder="Entrer son prénom">',
                  '</div>',                   
                  '<div class="form-group">',
                    '<label class="control-label required" for="email">Email du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="email" name="email" type="text" class="form-control" placeholder="Entrer son adresse mail">',
                  '</div>',
				  '<div class="form-group">',
                    '<label class="control-label required" for="phone">Téléphone du responsable de stage<sup style="color:red">*</sup></label>',
                    '<input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer son numéro de téléphone">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="address">Adresse du stage<sup style="color:red">*</sup></label>',
                    '<input id="address" name="address" type="text" class="form-control" placeholder="numéro et nom de rue">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="cp">Code postal du stage<sup style="color:red">*</sup></label>',
                    '<input id="cp" name="cp" type="text" class="form-control" placeholder="Entrer son code postal">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="city">Ville du stage<sup style="color:red">*</sup></label>',
                    '<input id="city" name="city" type="text" class="form-control" placeholder="Entrer sa ville">',
                  '</div>',
                  '<div class="form-group">',
                    '<label class="control-label required" for="country">Pays du stage<sup style="color:red">*</sup></label>',
                    '<input id="country" name="country" type="text" class="form-control" placeholder="Entrer son pays">',
                  '</div>',
			  '<div class="form-group">',
                '<label class="control-label required" for="name">Description du stage<sup style="color:red">*</sup></label>',
                '<textarea id="description" name="description" type="text" class="form-control" placeholder="Entrez la description du stage"></textarea>',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="name">Durée du stage<sup style="color:red">*</sup></label>',
                '<input id="duree" name="duree" type="number" class="form-control" placeholder="Entrez la durée de la formation" value="5">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required">Disponniblité du stage<sup style="color:red">*</sup></label><br>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="1" checked>Public</label>',
                '<label class="radio-inline"><input type="radio" name="optradio" value="0">Privée</label>',
              '</div>',
              '<div class="col-md-12">',
                '<button type="submit" value="enregistrer" class="btn btn-inline btn-success btn-block" name="btnValider"><span class="fa fa-check" aria-hidden="true"></span>Créer le nouveau stage</button>',
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
	
?>