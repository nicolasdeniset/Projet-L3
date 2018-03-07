<?php
  require('bibliotheque.php');
  ob_start();
  bd_connexion();
  verifie_session();
  html_head('Nos partenaires');
  html_header($_SESSION["idCompte"]);
  html_aside_main_debut(APP_PAGE_PROFIL);

  if (isset($_POST['supprimer'])) {
    $id_Membre=$_POST['id_Compte'];
    $id_Coordonnees=$_POST['id_Coordonnees'];
    supprimer_user_admin ($id_Compte, $id_Coordonnees);
        header('location:'.APP_PAGE_MEMBRE);
  }

  if(!isset($_POST['id_Membre'])){
    $_POST['id_Membre']=$_SESSION["idCompte"];
  }

  $S= " SELECT *
        FROM compte, coordonnees
        WHERE coordonneesCompte = idCoordonnees
        AND idCompte =". $_POST['id_Membre'];

$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);

$tab=mysqli_fetch_assoc($R);

switch (getTypeCompte($_POST['id_Membre'])) {
  case '0':
    header('location:'.APP_PAGE_STATISTIQUE);
    break;
  case '1':
    echo '<h1 class="page-header">Profil de l\'entreprise ',ucfirst(htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8')),'</h1>',
		'<div class="item">',
		'<div class="row">',
		'<div class="col-md-6 col-sm-12">',
		'<h3>',ucfirst(htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8')),' <small>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</small></h3>';
    break;
  case '2':
    echo '<h1 class="page-header">Profil de l\'étudiant ',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h1>',
		'<div class="item">',
		'<div class="row">',
		'<div class="col-md-6 col-sm-12">',
		'<h3>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h3>';
    break;
  case '3':
    echo '<h1 class="page-header">Profil du bénévole ',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h1>',
		'<div class="item">',
		'<div class="row">',
		'<div class="col-md-6 col-sm-12">',
		'<h3>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h3>';
    break;
  default:
    header('location:'.APP_PAGE_ACCUEIL);
    break;
}

echo  '<ul>',
        '<li>Compte actif : ',($tab['actifCompte'])  ? 'oui' :'non', '</li>',
        '<li>Date inscription : ',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</li>',
        '<li>Coordonnées postales : ',htmlentities($tab['adresseCoordonnees'], ENT_QUOTES, 'UTF-8'),' ',ucfirst(htmlentities($tab['villeCoordonnees'], ENT_QUOTES, 'UTF-8')),' (',htmlentities($tab['codePostalCoordonnees'], ENT_QUOTES, 'UTF-8'),') ',ucfirst(htmlentities($tab['paysCoordonnees'], ENT_QUOTES, 'UTF-8')),'</li>',
        '<li>Adresse mail : ',htmlentities($tab['emailCoordonnees'], ENT_QUOTES, 'UTF-8'),'</li>',
        '<li>Numéro de téléphone : ',htmlentities($tab['telephoneCoordonnees'], ENT_QUOTES, 'UTF-8'),'</li>',
      '</ul>',
      '</div>',
      '<div class="col-md-6 col-sm-12">',
        '<h3>STATISTIQUES</h3>',
        '<table class="table table-striped">',
          '<tbody>';

switch (getTypeCompte($_POST['id_Membre'])) {
  case '1':
    $stat = statistique_entreprise($_POST['id_Membre']);
    echo '<tr>',
      '<th>Nombre stages proposés</th>',
      '<td>',$stat[0],'</td>',
    '</tr>',
    '<tr>',
      '<th>Nombre étudiants ayant effectué un stage dans cette entreprise</th>',
      '<td>',$stat[1],'</td>',
    '</tr>',
    '<tr>',
      '<th>Nombre étudiants embauchés</th>',
      '<td>',$stat[2],'</td>',
    '</tr>';
    break;
  case '2':
    $stat = statistique_etudiant($_POST['id_Membre']);
    echo '<tr>',
  	  '<th>Nombre candidatures pour formations</th>',
  	  '<td>',$stat[0],'</td>',
    '</tr>',
    '<tr>',
  	  '<th>Nombre candidatures pour stages</th>',
  	  '<td>',$stat[1],'</td>',
    '</tr>',
    '<tr>',
  	  '<th>Nombre formations suivies</th>',
  	  '<td>',$stat[2],'</td>',
    '</tr>',
    '<tr>',
  	  '<th>Nombre stages effectués</th>',
  	  '<td>',$stat[3],'</td>',
    '</tr>';
    break;
  case '3':
    $stat = statistique_benevole($_POST['id_Membre']);
    echo '<tr>',
      '<th>Nombre formations enseignées</th>',
      '<td>',$stat[0],'</td>',
    '</tr>';
    break;
}
echo  '</tbody>',
      '</table>',
      '</div>',
      '</div>';

if(isset($_POST['idCandidature']) && getTypeCompte($_SESSION["idCompte"]) == 0){
	$idCandidature = $_POST['idCandidature'];
	$S = "SELECT	lettreMotivCandidature, typeCandidature
			FROM	candidature
			WHERE	idCandidature = '$idCandidature'";
	$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
	$D = mysqli_fetch_row($R);
	$lettreMotivCandidature = $D[0];
	$typeCandidature = $D[1];
	if($typeCandidature == 0) {
		$question = 'Qu\'est ce qui vous motive à rejoindre l\'association ?';
	}
	if($typeCandidature == 1) {
		$question = 'Qu\'est ce qui vous motive à faire cette formation ?';
	}
	if($typeCandidature == 2) {
		$question = 'Qu\'est ce qui vous motive à faire ce stage ?';
	}
	
	echo  '<div class="row">',
        '<div class="col-md-12">',
			"<div onclick=\"javascript:openGestion(['MotivationBis']);\">",
				'<button class="btn btn-info btn-block"><span class="fa fa-eye" aria-hidden="true"></span>Acceder à la lettre de motivation</button>',
			'</div>',
			'<form class="gestion" id="MotivationBis" method="POST" action="profil.php">';
			if($typeCandidature == 0) {
				echo '<input type="hidden" name="id_Membre" value="',$_POST['id_Membre'],'" />',
				'<input type="hidden" name="idCandidature" value="',$_POST['idCandidature'],'" />',
				'<input type="hidden" name="pageDeRetour" value="candidature.php" />';
			}
			if($typeCandidature == 1) {
				echo '<input type="hidden" name="id_Membre" value="',$_POST['id_Membre'],'" />',
				'<input type="hidden" name="idCandidature" value="',$_POST['idCandidature'],'" />',
				'<input type="hidden" name="pageDeRetour" value="',$_POST['pageDeRetour'],'" />',
				'<input type="hidden" name="idFormation" value="',$_POST['idFormation'],'" />',
				'<input type="hidden" name="dateDebut" value="',$_POST['dateDebut'],'" />',
				'<input type="hidden" name="dateFin" value="',$_POST['dateFin'],'" />';
			}
			if($typeCandidature == 2) {
				echo '<input type="hidden" name="id_Membre" value="',$_POST['id_Membre'],'" />',
				'<input type="hidden" name="idCandidature" value="',$_POST['idCandidature'],'" />',
				'<input type="hidden" name="pageDeRetour" value="',$_POST['pageDeRetour'],'" />',
				'<input type="hidden" name="idStage" value="',$_POST['idStage'],'" />',
				'<input type="hidden" name="dateDebut" value="',$_POST['dateDebut'],'" />',
				'<input type="hidden" name="dateFin" value="',$_POST['dateFin'],'" />';
			}
			echo '<div class="form-group">',
					'<br>',
					'<label class="control-label required">',$question,'</label>',
					'<p>',$lettreMotivCandidature,'</p>',
				'</div>';
				if($typeCandidature == 1) {
					$idFormation = $_POST['idFormation'];
					$S2 = "SELECT idPropose, villeCoordonnees, polePropose
							FROM propose, poleformation, coordonnees 
							WHERE polePropose = idPoleFormation
							AND	coordonneesPoleFormation = idCoordonnees
							AND  formationPropose = '$idFormation'
							ORDER BY polePropose";
					$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
					$D2 = mysqli_fetch_row($R2);
					echo  '<label class="control-label">Dans quel pole(s) aura lieu cette formation ? <sup style="color:red">*</sup></label><br>',
					'<select name="PoleName">',
						'<option value="',$D2[0],'">Pole de ',$D2[1],'</option>';
						while ($D2 = mysqli_fetch_assoc($R2)) {
							echo '<option value="',$D2['idPropose'],'">Pole de ',$D2['villeCoordonnees'],'</option>';
						}
				    echo '</select>';
				}
				echo '<div class="col-md-12">',
					'<div class="col-md-6">',
						'<button type="submit" class="btn btn-block btn-success" name="btnValider1">Accepter la Candidature</button>',
					'</div>',
					'<div class="col-md-6">',
						'<button type="submit" class="btn btn-block btn-success" name="btnValider2">Refuser la Candidature</button>',
					'</div>',
				'</div>',
			'</form>',
        '</div>',
        '</div>';
	if($typeCandidature == 0) {
		$retour = $_POST['pageDeRetour'];
		$idCompte = $_POST['id_Membre'];
		if (isset($_POST["btnValider2"])) {
			$S = "SELECT	coordonneesCompte
					FROM	compte
					WHERE	idCompte = '$idCompte'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$D = mysqli_fetch_row($R);
			$coordonneesCompte = $D[0];
			
			$S = "DELETE FROM compte
					WHERE	idCompte = '$idCompte'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$S = "DELETE FROM coordonnees
					WHERE	idCoordonnees = '$coordonneesCompte'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$S = "DELETE FROM candidature
					WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
		if (isset($_POST["btnValider1"])) {
			$S = "UPDATE	candidature
				SET	traiteeCandidature = '1', accepteeCandidature = '1'
				WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$S = "UPDATE	compte
				SET	actifCompte = '1'
				WHERE	idCompte = '$idCompte'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
	}
	if($typeCandidature == 1) {
		$retour = $_POST['pageDeRetour'];
		$idEtudiant = $_POST['id_Membre'];
		$idFormation = $_POST['idFormation'];
		$dateDebut = $_POST['dateDebut'];
		$dateFin = $_POST['dateFin'];
		if (isset($_POST["btnValider2"])) {
			$S = "UPDATE	candidature
				SET	traiteeCandidature = '1', accepteeCandidature = '0'
				WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
		if (isset($_POST["btnValider1"])) {
			$idPole = $_POST["PoleName"];
			$S = "UPDATE	candidature
				SET	traiteeCandidature = '1', accepteeCandidature = '1'
				WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$S = "INSERT INTO asuivi SET
					etudiantAsuivi = '$idEtudiant',
					formationAsuivi = '$idPole',
					dateDebutAsuivi  = '$dateDebut',
					dateFinAsuivi  = '$dateFin',
					certificationAsuivi = '0'";
			mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
	}
	if($typeCandidature == 2) {
		$retour = $_POST['pageDeRetour'];
		if (isset($_POST["btnValider2"])) {
			$S = "UPDATE	candidature
					SET	traiteeCandidature = '1', accepteeCandidature = '0'
				WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
		if (isset($_POST["btnValider1"])) {
			$idEtudiant = $_POST['id_Membre'];
			$idStage = $_POST['idStage'];
			$dateDebut = $_POST['dateDebut'];
			$dateFin = $_POST['dateFin'];
			$S = "UPDATE	candidature
					SET	traiteeCandidature = '1', accepteeCandidature = '1'
				WHERE	idCandidature = '$idCandidature'";
			$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			$S = "INSERT INTO aeffectue SET
				etudiantAeffectue = '$idEtudiant',
				stageAeffectue = '$idStage',
				tuteurAeffectue = 'Voir table stage',
				dateDebutAeffectue  = '$dateDebut',
				dateFinAeffectue  = '$dateFin',
				embaucheAeffectue = '0'";
			mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
			header("location: $retour");
			exit();			// EXIT : le script est terminé
			ob_end_flush();
		}
	}
}

switch (getTypeCompte($_POST['id_Membre'])) {
  case '1':
    echo  '<div class="row">',
            (getTypeCompte($_SESSION["idCompte"]) != 0) ? '<div class="col-md-12">' : '<div class="col-md-6">',
                '<button onclick="javascript:openGestion([\'stagePropose\']);" class="btn btn-inline btn-success btn-block" onclick="javascript:openGestion([\'gestionStages\', \'gestionStatistiques\']); return false;"><span class="fa fa-briefcase" aria-hidden="true"></span>Stages proposés</button>',
              '</div>';
    if(getTypeCompte($_SESSION["idCompte"]) == 0){
      echo  '<div class="col-md-6">',
            '<form class="form_inline" method="POST" action="listeMembre.php" accept-charset="iso-8859-1">',
            '<input type="hidden" name="id_Compte" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
            '<input type="hidden" name="id_Coordonnees" value="',htmlentities($tab['idCoordonnees'], ENT_QUOTES, 'UTF-8'),'" />',
            '<button type="submit" name="supprimer" value="supprimer"  onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer le compte ?\'))" class="btn btn-inline btn-danger btn-block"><span class="fa fa-trash-o" aria-hidden="true"></span>Supprimer entreprise</button>',
            '</form>',
            '</div>';
    }
    echo  '<div id=\'stagePropose\' class=\'gestion\'>',
          'aaa',
          '</div>';
    echo  '</div>',
          '</div>',
          '</div>';
    break;
  case '2':
    # code...
    break;
  case '3':
    # code...
    break;
  default:
    # code...
    break;
}
?>