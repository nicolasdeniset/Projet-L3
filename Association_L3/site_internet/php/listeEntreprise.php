<?php
  require('bibliotheque.php');
  ob_start();
  bd_connexion();
  // Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];

  if (isset($_POST['supprimer'])) {
    supprimer_user_admin($_POST['id_Entreprise'],$_POST['$id_Coordonnees']);
  }
  else{
    $_POST['id_Entreprise']='';
    $_POST['$id_Coordonnees']='';
  }

  html_head('Nos partenaires');
  html_header($id);
  html_aside_main_debut("","","","","class=\"active\"","","","","","");
  echo '<h1 class="page-header">Nos entreprises partenaires</h1>';

  if(!isset($_POST['rechercher'])){
    $S= ' SELECT DISTINCT *
          FROM compte, coordonnees
          WHERE coordonneesCompte = idCoordonnees
          AND typeCompte = "1"';

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);

    $tab=mysqli_fetch_assoc($R);
    afficheEntreprise($R, $tab);
  }
  else {
    if ($_POST['nomEntreprise'] != ''){
      rechercheEntreprise($_POST['nomEntreprise']);
    }
    else{
      header('location: ./listeEntreprise.php');
    }
  }

  /*AFFICHAGE*/
  html_aside_main_fin();
  ob_end_flush();

  //=================== FIN DU SCRIPT =============================

  //_______________________________________________________________
  //
  //		FONCTIONS LOCALES
  //_______________________________________________________________

  function afficheEntreprise($R, $tab){
    $id = $_SESSION["idCompte"];
    if($tab['idCompte'] == NULL){
      $_POST['nomEntreprise']='';
      if(isset($_POST['rechercher'])){
        $_POST['nomEntreprise']='';
        echo '<form class="form-inline" action="listeEntreprise.php" method="POST">',
              '<div class="form-group">',
                '<input type="text" name="nomEntreprise" class="form-control" placeholder="Nom de l\'entreprise">',
              '</div>',
              '<button type="submit" class="btn btn-inline" name="rechercher"><span class="fa fa-search"></span>Rechercher</button>',
            '</form>';
      }
      echo '<h3>Aucune entreprise n\'a été trouvée. </h3>',
            (true) ? '<a href=\'./listeEntreprise\'>Retour à la liste complète</a>' : '<a href=\'./listeEntreprise\'>Retour à la liste complète</a>',
           '</section></main></div>';
    }
    else {
      $_POST['nomEntreprise']='';
      echo '<form class="form-inline" action="listeEntreprise.php" method="POST">',
            '<div class="form-group">',
              '<input type="text" name="nomEntreprise" class="form-control" placeholder="Nom de l\'entreprise">',
            '</div>',
            '<button type="submit" class="btn btn-inline" name="rechercher"><span class="fa fa-search"></span>Rechercher</button>',
          '</form>',
          '<div class="table-responsive">',
            '<table class="table table-striped">',
              '<thead>',
                '<tr>',
                  '<th>Nom Entreprise</th>',
                  '<th>Date d\'inscription</th>',
                  '<th>Nombre stages proposés</th>',
                  '<th>Nombre étudiants pris en stage</th>',
                  '<th>Nombre étudiants embauchés</th>',
                  '<th>Gestion</th>',
                '</tr>',
              '</thead>',
              '<tbody>';
              do{
                echo  '<tr>',
                        '<td>',htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',stat_nbStagePropose($tab['idCompte']),'</td>',
                        '<td>',stat_nbEtudiantStagiaire($tab['idCompte']),'</td>',
                        '<td>',stat_nbEtudiantEmbauche($tab['idCompte']),'</td>',
                        '<td>',
                          '<form class="form_inline" method="POST" action="profilEntreprise.php">',
                            '<input type="hidden" name="id_Entreprise" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                            '<button class="btn-link" name="view"><span class="text-info fa fa-eye" aria-hidden="true"></span></button>',
                          '</form>';
                          if(getTypeCompte($id) == 0){
                            echo '<form class="form_inline" method="POST" action="listeEntreprise.php" accept-charset="iso-8859-1">',
                                  '<input type="hidden" name="id_Entreprise" value="',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'" />',
                                  '<input type="hidden" name="$id_Coordonnees" value="',htmlentities($tab['idCoordonnees'], ENT_QUOTES, 'UTF-8'),'" />',
                                  '<button class="btn-link" name="supprimer" onClick="return(confirm(\'Êtes-vous sur de vouloir supprimer votre compte ?\'))" value="supprimer"><span class="text-danger fa fa-times" aria-hidden="true"></span></span></button>',
                                '</form>';
                          }
                        echo '</td>',
                        '</tr>';
              }while($tab=mysqli_fetch_assoc($R));
              echo '</tbody></table></div></section></main></div>';
            }
  }

  function rechercheEntreprise($recherche){
    $nom = trim($recherche); // on recupère la chaine a qui nous sert de recherche
		$nom = mysqli_real_escape_string($GLOBALS['bd'], $nom);
    if($nom != ''){ // on verifie que cette chaine n'est pas nulle avant d'effectuer des recherches.
      $S= " SELECT DISTINCT *
            FROM compte, coordonnees
            WHERE coordonneesCompte = idCoordonnees
            AND nomEntrepriseCompte LIKE '%$nom%'
            AND typeCompte = '1'";

      $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

      $tab=mysqli_fetch_assoc($R);

      afficheEntreprise($R, $tab);
    }
  }
/*  function supprimer_user_admin ($id_Entreprise, $id_Coordonnees) {
    echo $id_Entreprise ,'ET',$id_Coordonnees;
    $S = "DELETE FROM compte
					WHERE	idCompte = '$id_Entreprise'";
		$R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

		$S2 = "DELETE FROM coordonnees
					WHERE	idCoordonnees = '$id_Coordonnees'";
		$R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'], $S2);
  }*/

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
    $S= " SELECT COUNT(etudiantAeffectue) as total
          FROM aeffectue, stage
          WHERE entrepriseStage = $id
          AND stageAeffectue = idStage
          GROUP BY etudiantAeffectue";

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);

    $tab=mysqli_fetch_assoc($R);

    return $tab['total'];
  }
 ?>
