<?php
  require('bibliotheque.php');
  ob_start();
  bd_connexion();
  verifie_session();
  html_head('Nos partenaires');
  html_header();
  html_aside_main_debut("","","","","class=\"active\"","","","","","");

  $S= ' SELECT *
        FROM compte, coordonnees
        WHERE idCompte ='. $_POST['id_Entreprise'];

  $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);

  $tab=mysqli_fetch_assoc($R);
  $patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/','/^\s*{(\w+)}\s*=/');
  $replace = array ('\3/\4/\1\2', '$\1 =');
  echo  '<a href="./listeEntreprise.php" class="btn btn-retour">Retour</a>',
        '<h1 class="page-header">Profil de l\'entreprise ',strtoupper($tab['nomEntrepriseCompte']),'</h1>',
        '<div class="item">',
        '<div class="row">',
        '<div class="col-md-6 col-sm-12">',
        '<h3>',strtoupper($tab['nomEntrepriseCompte']),/*'<small>',$tab['idCompte'],'</small>*/'</h3>',
        '<ul>',
          '<li>Compte actif: A GERER AVEC LA NOUVELLE BD</li>',
          '<li>Date inscription : ', preg_replace($patterns, $replace, $tab['inscriptionCompte']),'</li>',
          '<li>Coordonnées postales: ',$tab['adresseCoordonnees'],' ',strtoupper($tab['villeCoordonnees']),' ',$tab['codePostalCoordonnees'],' ', strtoupper($tab['paysCoordonnees']),'</li>',
          '<li>Adresse email: ',$tab['emailCoordonnees'],'</li>',
          '<li>Numéro de téléphone: ',$tab['telephoneCoordonnees'],'</li>',
        '</ul>',
        '</div>',
        '<div class="col-md-6 col-sm-12">',
          '<h3>STATISTIQUES</h3>',
          '<table class="table table-striped">',
            '<tbody>',
              '<tr>',
                '<th>AJOUTER STAT</th>',
                '<td>AJOUTER STAT</td>',
              '</tr>',
              '<tr>',
                '<th>AJOUTER STAT</th>',
                '<td>AJOUTER STAT</td>',
              '</tr>',
            '</tbody>',
          '</table>',
        '</div>',
      '</div>',
      '<div class="row">',
        '<div class="col-md-12">',
          '<div class="col-md-4">',
            '<button class="btn btn-inline btn-success btn-block" onclick="javascript:openGestion(["gestionStages", "gestionEmbauche"]); return false;"><span class="fa fa-book" aria-hidden="true"></span>Stages proposés</button>',
          '</div>',
          '<div class="col-md-4">',
            '<button class="btn btn-inline btn-success btn-block" onclick="javascript:openGestion(["gestionEmbauche", "gestionStages"]); return false;"><span class="fa fa-bar-chart" aria-hidden="true"></span>Etudiants embauchés</button>',
          '</div>',
          '<div class="col-md-4">',
            '<form><button type="submit" value="supprimer" class="btn btn-inline btn-danger btn-block"><span class="fa fa-trash-o" aria-hidden="true"></span>Supprimer entreprise</button></form>',
          '</div>',
        '</div>',
      '</div>',
    '</div>',
    '<div id="gestionEmbauche" class="gestion row">',
      '<table class="table table-striped">',
        '<tbody>',
          '<tr>',
            '<th>Nombre stages proposés</th>',
            '<td>6</td>',
          '</tr>',
          '<tr>',
            '<th>Nombre demande de stage accepté</th>',
            '<td>6</td>',
          '</tr>',
          '<tr>',
            '<th>Nombre étudiants embauchés</th>',
            '<td>6</td>',
          '</tr>',
        '</tbody>',
      '</table>',
    '</div>';
  html_aside_main_fin();
  ob_end_flush();
  ?>
