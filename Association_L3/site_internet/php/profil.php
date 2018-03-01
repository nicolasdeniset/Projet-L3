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
    echo '<h1 class="page-header">Profil de l\'entreprise ',ucfirst(htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8')),'</h1>';
    break;
  case '2':
    echo '<h1 class="page-header">Profil de l\'étudiant ',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h1>';
    break;
  case '3':
    echo '<h1 class="page-header">Profil du bénévole ',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h1>';
    break;
  default:
    header('location:'.APP_PAGE_ACCUEIL);
    break;
}
echo  '<div class="item">',
      '<div class="row">',
      '<div class="col-md-6 col-sm-12">';
switch (getTypeCompte($_POST['id_Membre'])) {
  case '1':
    echo  '<h3>',ucfirst(htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8')),' <small>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</small></h3>';
    break;
  case '2':
    echo  '<h3>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h3>';
    break;
  case '3':
    echo '<h3>',ucfirst(htmlentities($tab['nomCoordonnees'], ENT_QUOTES, 'UTF-8')),' ',ucfirst(htmlentities($tab['prenomCoordonnees'], ENT_QUOTES, 'UTF-8')),'</h3>';
    break;
  default:
    # code...
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
    echo 'les stat';
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
echo  '</tbody>',
      '</table>',
      '</div>',
      '</div>';
if(isset($_POST['idCandidature']) && getTypeCompte($_SESSION["idCompte"]) == 0){
  echo  '<div class="row">',
        '<div class="col-md-12">',
        '<button class="btn btn-info btn-block"><span class="fa fa-eye" aria-hidden="true"></span>Acceder à la lettre de motivation</button>',
        '</div>',
        '</div>';
}

switch (getTypeCompte($_POST['id_Membre'])) {
  case '1':
    echo  '<div class="row">',
            (getTypeCompte($_SESSION["idCompte"]) != 0) ? '<div class="col-md-12">' : '<div class="col-md-6">',
                '<button onclick="javascript:openGestion([\'stagePropose\']);" class="btn btn-inline btn-success btn-block" onclick="javascript:openGestion([\'gestionStages\', \'gestionStatistiques\']); return false;"><span class="fa fa-book" aria-hidden="true"></span>Stages proposés</button>',
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
