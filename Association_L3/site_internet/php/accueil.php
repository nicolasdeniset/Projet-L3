<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');
  ob_start();
  bd_connexion();
  html_head('Accueil');

  $idPage = '';
  session_start();
  if(isset($_SESSION['idCompte'])){
    $idPage = $_SESSION["idCompte"];
  }
  html_header($idPage); 

  

  $S1 = 'SELECT *
        FROM association';
  $R1 = mysqli_query($GLOBALS['bd'], $S1) or bd_erreur($S1);
  while ($assoc = mysqli_fetch_assoc($R1)) {
    $nom = $assoc['nomAssociation'];
    $slogan = $assoc['sloganAssociation'];
    $description = $assoc['descriptionAssociation'];
  }
  
// Section jumbotron - présentation
echo  '<section>',
      '<div class="jumbotron">',
        '<div class="container">',
          '<div class="row">',
            '<h1>',$nom,'</h1>',
            '<h3>',$slogan,'</h3>',
            '<p>',$description,'</p>',
          '</div>',
          '<div class="row">',
            '<div class="text col-md-6 col-sm-12">',
              '<a href="#statistique" class="btn btn-info btn-block">Découvrir</a>',
            '</div>',
            '<div class="text col-md-6 col-sm-12">',
              '<a href="login.php" class="btn btn-success btn-block">Candidater</a>',
            '</div>',
          '</div>',
        '</div>',
      '</div>',
    '</section>';
  // Fin section

  // Début section statistiques
  echo '<section id="statistique">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">STATISTIQUES</h2>',
          '<h3 class="text-center">L\'association en quelques chiffres clés</h3>';

          // Nouvel item
          $S2 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 1';
          $R2 =  mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($S2);
          $nbEntrep = mysqli_fetch_assoc($R2);

          item_stat($nbEntrep['total'], 'partenaires', '../images/001-network.svg', 'Les entreprises partenaires proposent des stages pour aider les étudiants à s\'insérer dans la vie active.');

          // Nouvel item
          $S3 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 3';
          $R3 =  mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($S3);
          $nbBene = mysqli_fetch_assoc($R3);
          item_stat($nbBene['total'], 'bénévoles', '../images/benevole.svg', 'Les bénévoles enseignent les différentes formations aux étudiants.');

          // Nouvel item
          $S4 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 2';
          $R4 =  mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($S4);
          $nbEtu = mysqli_fetch_assoc($R4);
          item_stat($nbEtu['total'], 'étudiants', '../images/studentgirl.svg', 'Les étudiants peuvent réaliser des formations et des stages, leur permettant de se familiariser avec les nouvelles technologies.');

          // Nouvel item
          $S5 = 'SELECT COUNT(idStage) as total
                 FROM stage';
          $R5 =  mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($S5);
          $nbStages = mysqli_fetch_assoc($R5);
          item_stat($nbStages['total'], 'stages proposés', '../images/studentman.svg', 'Les stages permettent aux étudiants de mettre en pratique ce qu\'ils ont appris au cours des différentes formations qu\'ils ont suivies.');

          // Nouvel item
          $S6 = 'SELECT COUNT(idFormation) as total
                 FROM formation';
          $R6 =  mysqli_query($GLOBALS['bd'], $S6) or bd_erreur($S6);
          $nbForm = mysqli_fetch_assoc($R6);
          item_stat($nbForm['total'], 'formations', '../images/formation.svg', 'Les formations permettent aux étudiants d\acquérir des connaissances en rapport avec les nouvelles technologies.');

          // Nouvel item
          $S7 = 'SELECT COUNT(idPoleFormation) as total
                 FROM poleformation';
          $R7 =  mysqli_query($GLOBALS['bd'], $S7) or bd_erreur($S7);
          $nbPoles = mysqli_fetch_assoc($R7);
          item_stat($nbPoles['total'], 'pôles en Afrique', '../images/005-maps-and-flags.svg', 'Les pôles correspondent aux lieux où les étudiants peuvent suivre les différentes formations.');

      echo '</div>',
      '</div>',
    '</section>';
  // Fin section statistiques

  // Début section témoignages
  echo '<section>',
      '<div class="container">',
        '<h2 class="text-center">TEMOIGNAGES</h2>',
        '<div id="myCarousel" class="carousel slide" data-ride="carousel">',

          '<!-- Indicators -->',
          '<ol class="carousel-indicators">',
            '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>',
            '<li data-target="#myCarousel" data-slide-to="1"></li>',
            '<li data-target="#myCarousel" data-slide-to="2"></li>',
          '</ol>',

          // Wrapper for slides
          '<div class="carousel-inner">';

          // On compte le nombre de témoignages dans la base de données
          $S1 = 'SELECT COUNT(idTemoignages) as total
                FROM temoignages';
          $R1 = mysqli_query($GLOBALS['bd'], $S1) or bd_erreur($S1);
          $nbTem = mysqli_fetch_assoc($R1);

          $first = -1;
          $second = -1;
          $third = -1;

          // S'il y a plus de 3 témoignages, on en choisit 3 au hasard
          if ($nbTem['total'] > 3) {
            $first = rand(0, $nbTem['total']-1);
            do {
              $second = rand(0, $nbTem['total']-1);
            } while ($second == $first);
             do {
              $third = rand(0, $nbTem['total']-1);
            } while ($third == $first || $third == $second);
          }


          $S2 = 'SELECT compteTemoignages, texteTemoignages, anonymeTemoignages
                FROM temoignages';
          $R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($GLOBALS['bd'],$S2);
          $countLoop = 0; // Nombre de lignes de la requête parcourues
          $countItems = 0; // Nombre de témoignages affichés
          while ($tem = mysqli_fetch_assoc($R2)) {
            if ($countLoop == $first || $countLoop == $second || $countLoop == $third || $nbTem['total'] <= 3) {

              if ($tem['anonymeTemoignages'] == 1) {
                if ($countItems == 0) {
                  item_temoignage($tem['texteTemoignages'], 'Anonyme', 'active');
                }
                else {
                  item_temoignage($tem['texteTemoignages'], 'Anonyme');
                }
              }
              else {
                $S3 = 'SELECT typeCompte, nomEntrepriseCompte
                      FROM temoignages, compte
                      WHERE idCompte="'.$tem['compteTemoignages'].'"';
                $R3 = mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($S3);
                $compte = mysqli_fetch_assoc($R3);
                if ($compte['typeCompte'] == 1) {
                  if ($countItems == 0) {
                    item_temoignage($tem['texteTemoignages'], $compte['nomEntrepriseCompte'], 'active');
                  }
                  else {
                    item_temoignage($tem['texteTemoignages'], $compte['nomEntrepriseCompte']);
                  }
                }
                else {
                  $S4 = 'SELECT nomCoordonnees, prenomCoordonnees
                        FROM temoignages, compte, coordonnees
                        WHERE idCompte="'.$tem['compteTemoignages'].'"
                        AND coordonneesCompte = idCoordonnees';
                  $R4 = mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($S4);
                  $personne = mysqli_fetch_assoc($R4);
                  $nomTem = $personne['prenomCoordonnees'].' '.$personne['nomCoordonnees'];
                  if ($countItems == 0) {
                    item_temoignage($tem['texteTemoignages'], $nomTem, 'active');
                  }
                  else {
                    item_temoignage($tem['texteTemoignages'], $nomTem);
                  }
                }
              }

              $countItems++;
            }
            $countLoop++;
          }

      echo '</div>',

          // Left and right controls
          '<a class="carousel-control left" href="#myCarousel" data-slide="prev">',
            '<span class="glyphicon glyphicon-chevron-left"></span>',
            '<span class="sr-only">Previous</span>',
          '</a>',
          '<a class="carousel-control right" href="#myCarousel" data-slide="next">',
            '<span class="glyphicon glyphicon-chevron-right"></span>',
            '<span class="sr-only">Next</span>',
          '</a>',

        '</div>',
     '</div>',
    '</section>';
    // Fin section témoignages

    // Début section formations
  echo '<section id="formation">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">FORMATIONS</h2>';

          // On compte le nombre de formations disponibles dans la base de données
          $S1 = 'SELECT COUNT(idFormation) as total
                FROM formation
                WHERE dispoFormation = 1';
          $R1 = mysqli_query($GLOBALS['bd'], $S1) or bd_erreur($S1);
          $nbFormations = mysqli_fetch_assoc($R1);

          $first = -1;
          $second = -1;
          $third = -1;

          // S'il y a plus de 3 formations disponibles, on en choisit 3 au hasard
          if ($nbFormations['total'] > 3) {
            $first = rand(0, $nbFormations['total']-1);
            do {
              $second = rand(0, $nbFormations['total']-1);
            } while ($second == $first);
             do {
              $third = rand(0, $nbFormations['total']-1);
            } while ($third == $first || $third == $second);
          }

          $S2 = 'SELECT titreFormation, descriptionFormation, dureeFormation
                FROM formation
                WHERE dispoFormation = 1';
          $R2 = mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($S2);

          $count = 0; // Nombre de lignes de la requête parcourues
          $numID = 1; // ID de la prochaine formation
          while ($formations = mysqli_fetch_assoc($R2)) {
            if ($count == $first || $count == $second || $count == $third || $nbFormations['total'] <= 3) {
              item_formation('formation'.$numID, '../images/open-book.svg', $formations['titreFormation'], $formations['dureeFormation'], $formations['descriptionFormation']);
              $numID++;
            }
            $count++;
          }

    echo '</div>',
        '<div class="row">',
          '<a href="./formation.php" class="btn btn-info btn-block">Accéder à nos autres formations</a>',
        '</div>',
      '</div>',
    '</section>';
    // Fin section formations

    // Début section poles de formation
    echo '<section>
          <div class="container">
            <h2 class="text-center">POLES DE FORMATION</h2>
            <div class="col-md-12">
              <div id="carte" style="height: 70vh;">
              </div>
            </div>';

            $S = 'SELECT gpsLongitudeCoordonnes, gpsLatitudeCoordonnees, villeCoordonnees
                  FROM poleformation, coordonnees
                  WHERE idCoordonnees = coordonneesPoleFormation';
            $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'],$S);
            while ($poles = mysqli_fetch_assoc($R)) {
              echo "<script>javascript:mapAddPlace('",$poles['villeCoordonnees'],"',",$poles['gpsLatitudeCoordonnees'],",",$poles['gpsLongitudeCoordonnes'],");</script>";
            }

            echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd69t4YW9mL9RlqvcEOK3ymLn1INr9Ogc&callback=mapCreate"></script>
          </div>
        </section>';
        // Fin section

    // D&but section partenaires
    echo '<section id="partenaire">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">PARTENAIRES</h2>';

    $S = 'SELECT nomEntrepriseCompte
          FROM compte
          WHERE typeCompte = 1';
    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'],$S);
    while ($part = mysqli_fetch_assoc($R)) {
      item_partenaire($part['nomEntrepriseCompte'], '../images/help.svg');
    }   

    echo '</div>',
      '</div>',
    '</section>';
    // Fin section partenaires

    // Début section candidater
    echo '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">CANDIDATER</h2>',
          '<h3 class="text-center">Vous souhaitez devenir membre de l\'associaition ?</h3>',
          '<p>L\'association a pour objectif d’affaiblir ces inégalités et de lutter efficacement contre la fracture numérique à travers la mise en place de cours en Informatique en lien avec les besoins des entreprises locales dans différents pays. En devenant membre, vous participez activement à cet objectif, que ce soit en tant que bénévole, entreprise ou même étudiant.</p>',
        '</div>',
        '<div class="row">';

      echo '<div class="item  col-md-4">',
            '<div id="candidaterPartenariat">',
              '<img class="img-responsive center-block" src="../images/partenaire.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4 class="text-center">Devenir partenaire</h4>',
              '<p>Vous possédez une entreprise qui utilise les nouvelles technologies ? Vous souhaitez aidez à lutter contre la fracture numérique en Afrique ? En devenant partenaire de notre association, vous pourrez proposer à des jeunes des stages leur permettant de mettre en pratique les connaissances qu\'ils auront apprises et les préparant à la vie active.</p>',
            '</div>',
            '<a href="./inscription.php" class="btn btn-success btn-block">Candidature partenariat</a>',
          '</div>';

      echo '<div class="item col-md-4">',
            '<div id="candidaterBenevolat">',
              '<img class="img-responsive center-block" src="../images/benevole.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4 class="text-center">Devenir bénévole</h4>',
              '<p>Vous avez des connaissances concernant les nouvelles technologies et vous voulez les partager ? Vous souhaitez aidez à lutter contre la fracture numérique en Afrique ? N\'hésitez plus. En devenant bénévole, vous pourrez transmettre vos connaissances en formant des jeunes aux nouvelles technologies.</p>',
            '</div>',
            '<a href="./inscription.php" class="btn btn-success btn-block">Candidature bénévolat</a>',
          '</div>';

      echo '<div class="item col-md-4">',
            '<div id="candidaterEtudiant">',
              '<img class="img-responsive center-block" src="../images/chapeauEtudiant.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4 class="text-center">Devenir étudiant</h4>',
              '<p>Vous vous intéressez aux nouvelles technologies ? En rejoignant notre association en tant qu\'étudiant, vous pourrez acquérir ou approfondir vos connaissances concernant dans ce domaines, grâce aux différentes formations que nous proposons. Vous pourrez également appliquer ces connaissances au cours de stages proposés par nos entreprises partenaires.</p>',
            '</div>',
            '<a href="./inscription.php" class="btn btn-success btn-block">Candidature étudiante</a>',
          '</div>';

    echo '</div>',
      '</div>',
    '</section>';
    // Fin section candidater

    // Début section articles
    echo '<section id="actualite">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">ACTUALITES</h2>',
          '<h3 class="text-center">Nos dernières actualités</h3>';

          $S = 'SELECT titreActualites, dateActualites, texteActualites
                FROM actualites
                ORDER BY idActualites DESC
                LIMIT 3';
          $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'],$S);
          $count = 1;
          while ($actu = mysqli_fetch_assoc($R)) {
            item_article('article'.$count, $actu['titreActualites'], $actu['dateActualites'], $actu['texteActualites']);
            $count++;
          }

    echo '</div>',
        '<div class="row">',
          '<a href="#about" class="btn btn-info btn-block">Accéder à nos autres articles</a>',
        '</div>',
      '</div>',
    '</section>';
    // Fin section articles

    // Début section donations

    if (! isset($_POST['btnValiderDon'])) {
      // On est dans un premier affichage de la page.
      // => On intialise les zones de saisie.
      $nbErr = 0;
      $_POST['nom'] = '';
      $_POST['montant'] = '';

    } else {
      // On est dans la phase de soumission du formulaire
      $erreurs = add_donation();
      $nbErr = count($erreurs);
    }

  echo '<section id="donation">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">DONATIONS</h2>',
          '<h3 class="text-center">Aidez-nous à améliorer notre association en faisant un don !</h3>',
          '<div class="item col-md-6">',
            '<p>Grâce à votre soutien, notre association pourra améliorer ses services, permettant de lutter toujours plus efficacement contre la fracture numérique en Afrique Subsaharienne. Nos équipes ainsi que les étudiants formés par l\'association vous remercient d\'avance !</p>',
          '</div>',
          '<div class="item col-md-6 col-sm-12">';

          if ($nbErr > 0) {
            echo '<strong>Les erreurs suivantes ont &eacute;t&eacute; d&eacute;tect&eacute;es</strong>';
            for ($i = 0; $i < $nbErr; $i++) {
              echo '<br>', $erreurs[$i];
            }
          }
          else {
			if (isset($_POST['btnValiderDon'])) {
			  echo '<p style="color:#22DDAA;"><strong>Merci pour votre promesse de don !</strong></p>';
			}
          }

        echo '<form method="POST" action="./accueil.php#donation">',
              '<div class="form-group">',
                '<label class="control-label" for="nom">Votre nom</label>',
                '<input type="text" class="form-control" id="name" name="nom" placeholder="Ne remplissez pas ce champ si vous souhaitez faire un don anonyme">',
              '</div>',
              '<div class="form-group">',
                '<label class="control-label required" for="montant">Montant du don<sup style="color:red">*</sup></label>',
                '<input type="number" class="form-control" id="howmuch" name="montant" placeholder="Montant en €" required>',
              '</div>',
              '<button type="submit" class="btn btn-success btn-block" name="btnValiderDon">Faire une promesse de don</button>',
            '</form>',

          '</div>',
        '</div>',
      '</div>',
    '</section>';
    // Fin section newsletter

    // Début section nous contacter
  echo '<section id="contacter">',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">NOUS CONTACTER</h2>',
          '<h3 class="text-center">Une question ? Une remarque ? Un petit mot ? Notre équipe se fera une joie de vous répondre !</h3>',
          '<div class="item col-md-6">',
            '<h4>NumAfrique</h4>',
            '<p>Gérant : Hassan Mountassir</p>',
			'<p>Adresse : Route de Gray - Besançon (25000) FRANCE</p>',
			'<p>Email : Hmountas@femto-st.fr</p>',
			'<p>Téléphone : 0381666951</p>',
			'<p>Si vous avez des questions, vous pouvez simplement contacter le gérant de l\'association. Il vous répondra dans les plus brefs délais dans la mesure du possible.</p>',
            '<ul class="social list-unstyled list-inline text-center">',
              '<li><a href="#"><img class="img-responsive center-block" src="../images/twitter.svg" alt="Une image" height="40px" width="40px"/></a></li>',
              '<li><a href="#"><img class="img-responsive center-block" src="../images/facebook.svg" alt="Une image" height="40px" width="40px"/></a></li>',
              '<li><a href="#"><img class="img-responsive center-block" src="../images/instagram.svg" alt="Une image" height="40px" width="40px"/></a></li>',
              '<li><a href="mailto:#"><img class="img-responsive center-block" src="../images/mail.svg" alt="Une image" height="40px" width="40px"/></a></li>',
            '</ul>',
          '</div>',
          '<div class="item col-md-6 col-sm-12">',
            '<form>',
              '<div class="form-group">',
                '<input type="email" class="form-control" id="email" placeholder="Votre e-mail" required>',
              '</div>',
              '<div class="form-group">',
                '<input type="text" class="form-control" id="nom" placeholder="Votre nom" required>',
              '</div>',
              '<div class="form-group">',
                '<input type="text" class="form-control" id="objet" placeholder="Objet de votre message" required>',
              '</div>',
              '<div class="form-group">',
                '<textarea class="form-control" id="message" rows="3" placeholder="Votre message" required></textarea>',
              '</div>',
              '<div class="form-group">',
                '<input type="checkbox" id="condition" name="condition" value="condition" required>',
                '<label class="checkCondition" for="condition">J\'accepte les <a href="http://google.com">conditions générales d\'utilisation</a></label>',
              '</div>',
              '<button type="submit" class="btn btn-success btn-block">Envoyer</button>',
            '</form>',
          '</div>',
        '</div>',
      '</div>',
    '</section>';
    // Fin section nous contacter

	html_pied();

  //_______________________________________________________________
  //
  //    FONCTIONS LOCALES
  //_______________________________________________________________


  /**
   * Génère le code HTML d'un item de témoignage dans le carousel.
   *
   * @param string  $text    Texte du témoignage
   * @param string  $author  Auteur du témoignage ou "Anonyme"
   * @param string  $active  Indicateur qui indique si on est dans l'item actif
   */
  function item_temoignage($text, $author, $active='') {
    echo '<div class="item ',$active,' ">',
              '<div class="item col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-3">',
                '<img class="img-responsive center-block" src="../images/quotation-mark.svg" alt="Quote" height="100px" width="100px">',
              '</div>',
              '<h4>Témoignage par : ',$author,'</h4>',
              '<p class="item col-md-8 col-sm-7">',$text,'</p>',
            '</div>';
  }

  /**
   * Génère le code HTML d'un item de formation.
   *
   * @param int     $id           id de l'item
   * @param string  $image        Chemin vers l'image à utiliser
   * @param string  $title        Titre de la formation
   * @param int     $duration     Durée de la formation en semaines
   * @param string  $description  Description de la formation
   */
  function item_formation($id, $image, $title, $duration, $description) {
    echo '<div class="item col-md-4">',
            '<div id="',$id,'">',
              '<img class="img-responsive center-block" src="',$image,'" alt="Une image" height="100px" width="100px"/>',
              '<h3>',$title,'</h3>',
              '<p class="small">Durée formation : ',$duration,' semaines</p>',
              '<p>',$description,'</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Accéder à la formation</a>',
          '</div>';
  }

  /**
   * Génère le code HTML d'un item de partenaire.
   *
   * @param string  $text    Texte du témoignage
   * @param string  $author  Auteur du témoignage ou "Anonyme"
   */
  function item_partenaire($name, $image) {
    echo '<div class="item col-md-2 col-sm-4">',
          '<img class="img-responsive center-block logoPartenaire" src="',$image,'" alt="Une image" height="75px" width="75px"/>',
          '<h4 style="text-align:center;">',$name,'</h4>',
        '</div>';
  }

  /**
   * Génère le code HTML d'un item d'actualité.
   *
   * @param int     $id           id de l'item
   * @param string  $title        Titre de l'actualité
   * @param int     $duration     Date de publication de l'actualité
   * @param string  $text         Texte de l'actualité
   */
  function item_article($id, $titre, $date, $text) {
    echo '<div class="item col-md-4">',
          '<div id="',$id,'">',
            '<h4>',$titre,'</h4>',
            '<p class="small">Publié le ',$date,'</p>',
            '<p>';

            if (strlen($text) > 500) {
              echo substr($text, 0, 500), '...';
            }
            else {
              echo $text;
            }
            
        echo '</p>',
          '</div>',
          '<a href="#about" class="btn btn-success btn-block">Lire la suite de l\'actualité</a>',
        '</div>';
  }

  /**
  * Permet d'ajouter une promesse de dons si aucune erreur n'est détectée.
  *
  * @return array  $erreurs  Tableau des erreurs détectées.
  */
  function add_donation() {
    $erreurs = array();

    $txtNom = trim(utf8_encode($_POST['nom']));
    $txtMontant = trim(utf8_encode($_POST['montant']));

    if (ctype_digit($txtMontant) != true) {
      $erreurs[] = 'Veuillez entrer une somme valide';
    }

    if (count($erreurs) > 0) {
      return $erreurs;    // RETURN : des erreurs ont été détectées
    }

    //-----------------------------------------------------
    // Insertion d'un nouvel enregistrement dans la base de données
    //-----------------------------------------------------
    $txtNom = mysqli_real_escape_string($GLOBALS['bd'], $txtNom);
    if ($txtNom == '') {
      $txtNom = 'Anonyme';
    }
    $txtMontant = mysqli_real_escape_string($GLOBALS['bd'], $txtMontant);

    $S = "INSERT INTO donations SET
        nomDonateurDonations = '$txtNom',
        montantDonations = '$txtMontant'";
    
    mysqli_query($GLOBALS['bd'], $S) or bd_erreur($GLOBALS['bd'], $S);
  }
  ob_end_flush();

?>
