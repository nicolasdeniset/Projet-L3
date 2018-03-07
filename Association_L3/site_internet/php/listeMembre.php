<?php
  require('bibliotheque.php');
  ob_start();
  bd_connexion();
  // Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];

  if (isset($_POST['supprimer'])) {
      $id_Membre=$_POST['id_Membre'];
      $id_Coordonnees=$_POST['id_Coordonnees'];
      supprimer_user_admin ($id_Membre, $id_Coordonnees);
  }

  html_head('Nos membres');
  html_header($id);
  html_aside_main_debut(APP_PAGE_MEMBRE);
  echo '<h1 class="page-header">Nos membres</h1>',
        '<div class="col-md-12">',
          '<form class="form_inline" method="POST" action="listeMembre.php" accept-charset="iso-8859-1">',
            '<div class="col-md-4">',
              '<button class="btn btn-inline btn-success btn-block" name="typeMembre" onclick="javascript:openGestion([\'gestionStatistiques\', \'gestionStages\']); return false;" value="1"><span class="fa fa-industry" aria-hidden="true"></span>Entreprises</button>',
            '</div>',
            '<div class="col-md-4">',
              '<button class="btn btn-inline btn-success btn-block" name="typeMembre" onclick="javascript:openGestion([\'gestionStatistiques\', \'gestionStages\']); return false;" value="2"><span class="fa fa-graduation-cap" aria-hidden="true"></span>Etudiants</button>',
            '</div>',
            '<div class="col-md-4">',
              '<button class="btn btn-inline btn-success btn-block" name="typeMembre" onclick="javascript:openGestion([\'gestionStatistiques\', \'gestionStages\']); return false;" value="3"><span class="fa fa-users" aria-hidden="true"></span>Bénévoles</button>',
            '</div>',
          '</form>',
        '</div>';

        if (isset($_POST['tmp'])){
            $_POST['typeMembre']=$_POST['tmp'];
        }
        else {
          if (!isset($_POST['typeMembre'])) {
            if (isset($_POST['tmp'])){
                $_POST['typeMembre']=$_POST['tmp'];
            }
            else {
              $_POST['typeMembre']='-1';
              $_POST['tmp'] ='';
              $_POST['nomMembre']='';
              $_POST['id_Membre']='';
              $_POST['$id_Coordonnees']='';
            }
          }
        }

        afficheMembre($_POST['typeMembre']);
  html_aside_main_fin();
  ob_end_flush();

  //=================== FIN DU SCRIPT =============================

  //_______________________________________________________________
  //
  //		FONCTIONS LOCALES
  //_______________________________________________________________
  function stat_nbFormationEnseignee($id){
    $S= " SELECT COUNT(idEnseignement) as total
          FROM enseignement, formation
          WHERE formationEnseignement = idFormation
          AND benevoleEnseignement = $id";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
  function stat_nbStageRealise($id){
    $S= " SELECT COUNT(idAeffectue) as total
          FROM aeffectue, stage
          WHERE stageAeffectue = idStage
          AND etudiantAeffectue = $id";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
  function stat_nbFormationSuivie($id){
    $S= " SELECT COUNT(idAsuivi) as total
          FROM asuivi, formation
          WHERE formationAsuivi = idFormation
          AND etudiantAsuivi = $id";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
  function stat_nbStagePropose($id){
    $S= " SELECT COUNT(idAeffectue) as total
          FROM aeffectue, stage
          WHERE stageAeffectue = idStage
          AND entrepriseStage = $id";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
  function stat_nbEtudiantEmbauche($id){
    $S= " SELECT COUNT(idAeffectue) as total
          FROM aeffectue, stage
          WHERE stageAeffectue = idStage
          AND embaucheAeffectue = true
          AND entrepriseStage = $id";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
  function stat_nbEtudiantStagiaire($id){
    $S= "SELECT DISTINCT etudiantAeffectue
              FROM aeffectue, stage
              WHERE entrepriseStage = $id
              AND stageAeffectue = idStage";
    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'],$S);
    $nbEtudiants = 0;
    while ($etudiants = mysqli_fetch_assoc($R)) {
      $nbEtudiants++;
    }
    return $nbEtudiants;
  }
  function afficheContenuTabMembre($R) {
    $tab=mysqli_fetch_assoc($R);
    if ($tab['idCompte'] == null){
      echo 'Aucun membre ne correspond au critère de recherche';
    }else {
      switch ($_POST['typeMembre']) {
        case 1 :
          do{
            echo  '<tr>',
                    '<td>',ucfirst(htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8')),'</td>',
                    '<td>',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                    '<td>',stat_nbStagePropose($tab['idCompte']),'</td>',
                    '<td>',stat_nbEtudiantStagiaire($tab['idCompte']),'</td>',
                    '<td>',stat_nbEtudiantEmbauche($tab['idCompte']),'</td>',
                    '<td>',
                      '<form class="form_inline" method="POST" action="profil.php">',
                        '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                        '<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
                      '</form>';
            if(getTypeCompte($_SESSION["idCompte"]) == 0){
              echo  '<form class="form_inline" method="POST" action="listeMembre.php" accept-charset="iso-8859-1">',
                    '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                    '<input type="hidden" name="id_Coordonnees" value="',htmlentities($tab['idCoordonnees'], ENT_QUOTES, 'UTF-8'),'" />',
                    '<button class="btn-link" name="supprimer" onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer le compte ?\'))" value="supprimer"><span class="text-danger fa fa-times" aria-hidden="true"></span></button>',
                    '</form>';
            }
            echo  '</td>',
                  '</tr>';
          }while($tab=mysqli_fetch_assoc($R));
          break;
        case 2 :
          do {
            echo  '<tr>',
                    '<td>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</td>',
                    '<td>',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                    '<td>',stat_nbStageRealise($tab['idCompte']),'</td>',
                    '<td>',stat_nbFormationSuivie($tab['idCompte']),'</td>',
                    '<td>',
                      '<form class="form_inline" method="POST" action="profil.php">',
                        '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                        '<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
                      '</form>';
            if(getTypeCompte($_SESSION["idCompte"]) == 0){
              echo  '<form class="form_inline" method="POST" action="listeMembre.php" accept-charset="iso-8859-1">',
                    '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                    '<input type="hidden" name="id_Coordonnees" value="',htmlentities($tab['idCoordonnees'], ENT_QUOTES, 'UTF-8'),'" />',
                    '<button class="btn-link" name="supprimer" onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer votre compte ?\'))" value="supprimer"><span class="text-danger fa fa-times" aria-hidden="true"></span></button>',
                    '</form>';
            }
            echo  '</td>',
                  '</tr>';
          }while($tab=mysqli_fetch_assoc($R));
          break;
        case 3 :
          do {
            echo  '<tr>',
                    '<td>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</td>',
                    '<td>',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                    '<td>',stat_nbFormationEnseignee($tab['idCompte']),'</td>',
                    '<td>',
                      '<form class="form_inline" method="POST" action="profil.php">',
                        '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                        '<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
                      '</form>';
            if(getTypeCompte($_SESSION["idCompte"]) == 0){
              echo  '<form class="form_inline" method="POST" action="listeMembre.php" accept-charset="iso-8859-1">',
                      '<input type="hidden" name="id_Membre" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                      '<input type="hidden" name="id_Coordonnees" value="',htmlentities($tab['idCoordonnees'], ENT_QUOTES, 'UTF-8'),'" />',
                      '<button class="btn-link" name="supprimer" onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer votre compte ?\'))" value="supprimer"><span class="text-danger fa fa-times" aria-hidden="true"></span></button>',
                    '</form>';
              }
              echo  '</td>',
                    '</tr>';
            }while($tab=mysqli_fetch_assoc($R));
            break;
        }
    }
  }

  function rechercheMembre($recherche){
    $nom = trim($recherche); // on recupère la chaine a qui nous sert de recherche
    $nom = mysqli_real_escape_string($GLOBALS['bd'], $nom);
    if($nom != ''){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
      $S= " SELECT DISTINCT *
            FROM compte, coordonnees
            WHERE coordonneesCompte = idCoordonnees
            AND ((nomEntrepriseCompte LIKE '%$nom%') OR (nomCoordonnees LIKE '%$nom%') OR (prenomCoordonnees LIKE '%$nom%'))
            AND typeCompte =".$_POST['typeMembre'];
      $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
      afficheContenuTabMembre($R);
    }
  }

  function afficheMembre($type=''){
    if ($type ==-1){
      echo "<h3>Retrouvez sur cette page toutes nos entreprises partenaire, bénévoles et étudiants !</h3>";
    }else{
      switch ($type){
        case 1 :
          echo  '<h1 class="page-header">Nos Entreprises</h1>',
                '<form class="form-inline" action="listeMembre.php" method="POST">',
                     '<div class="form-group">',
                      '<input type="hidden" name="tmp" value="1"/>',
                      '<input type="text" name="nomMembre" class="form-control" placeholder="Nom de l\'entreprise">';
          break;
        case 2 :
          echo  '<h1 class="page-header">Nos Etudiants</h1>',
                '<form class="form-inline" action="listeMembre.php" method="POST">',
                     '<div class="form-group">',
                      '<input type="hidden" name="tmp" value="2"/>',
                       '<input type="text" name="nomMembre" class="form-control" placeholder="Nom de l\'étudiant">';
          break;
        case 3 :
          echo  '<h1 class="page-header">Nos Bénévoles</h1>',
                '<form class="form-inline" action="listeMembre.php" method="POST">',
                     '<div class="form-group">',
                       '<input type="hidden" name="tmp" value="3"/>',
                       '<input type="text" name="nomMembre" class="form-control" placeholder="Nom du bénévole">';
          break;
        default :
          header ('location: accueil.php');
      }
      echo  '</div>',
            '<button type="submit" class="btn btn-inline" name="rechercher"><span class="fa fa-search"></span>Rechercher</button>',
            '</form>',
            '<div class="table-responsive">',
            '<table class="table table-striped">',
            '<thead>',
            '<tr>';
            switch ($type){
              case 1 :
                echo  '<th>Nom Entreprise</th>',
                      '<th>Date d\'inscription</th>',
                      '<th>Nombre stages proposés</th>',
                      '<th>Nombre étudiants pris en stage</th>',
                      '<th>Nombre étudiants embauchés</th>',
                      '<th>Gestion</th>';
                break;
              case 2 :
                echo  '<th>Nom Etudiant</th>',
                      '<th>Date d\'inscription</th>',
                      '<th>Nombre stages réalisés</th>',
                      '<th>Nombre formations réalisés</th>',
                      '<th>Gestion</th>';
                break;
              case 3 :
                echo  '<th>Nom du bénévole</th>',
                      '<th>Date d\'inscription</th>',
                      '<th>Nombre formations enseignées</th>',
                      '<th>Gestion</th>';
                break;
              /*default :
                header ('location: accueil.php');*/
            }
      echo  '</tr>',
            '</thead>',
            '<tbody>';

            if(!isset($_POST['rechercher'])){
              $S= ' SELECT DISTINCT *
                    FROM compte, coordonnees
                    WHERE coordonneesCompte = idCoordonnees
                    AND typeCompte ='.$_POST['typeMembre'];
              $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);
              afficheContenuTabMembre($R);
            }
            else {
              if ($_POST['nomMembre'] != ''){
                rechercheMembre($_POST['nomMembre']);
              }
              else{
                header('location: '.APP_PAGE_MEMBRE);
              }
            }
    }



  }
 ?>
