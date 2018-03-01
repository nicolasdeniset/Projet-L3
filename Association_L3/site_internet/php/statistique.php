<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');

	// Connexion a la base de donnée.
	ob_start();
  	bd_connexion();

	// Démarage d'une session et récupération de notre identifiant.
	verifie_session();
	$id = $_SESSION["idCompte"];
	if(getTypeCompte($_SESSION["idCompte"]) !=0) {
        header('location: acceuil.php');
        exit();            // EXIT : le script est terminé
    }
	
	
	//-----------------------------------------------------
	// Affichage de la page
	//-----------------------------------------------------
	html_head("Formations");
	html_header($id);
	html_aside_main_debut(APP_PAGE_STATISTIQUE);
	
	echo '<h1 class="page-header">Nos statistiques</h1>';

	echo '<div class="row">';

	    // Nouvel item
          $S1 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 1';
          $R1 =  mysqli_query($GLOBALS['bd'], $S1) or bd_erreur($S1);
          $nbEntrep = mysqli_fetch_assoc($R1);

          item_stat($nbEntrep['total'], 'partenaires', '../images/001-network.svg', 'Les partenaires correspondent bien aux entreprises inscrites ?');
          
	    // Nouvel item
          $S2 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 3';
          $R2 =  mysqli_query($GLOBALS['bd'], $S2) or bd_erreur($S2);
          $nbBene = mysqli_fetch_assoc($R2);
          item_stat($nbBene['total'], 'bénévoles', '../images/benevole.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
	    // Nouvel item
          $S3 = 'SELECT COUNT(idPoleFormation) as total
                 FROM poleformation';
          $R3 =  mysqli_query($GLOBALS['bd'], $S3) or bd_erreur($S3);
          $nbPoles = mysqli_fetch_assoc($R3);
          item_stat($nbPoles['total'], 'pôles en Afrique', '../images/005-maps-and-flags.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
    	// Nouvel item
          $S4 = 'SELECT COUNT(idCompte) as total
                 FROM compte 
                 WHERE typeCompte = 2';
          $R4 =  mysqli_query($GLOBALS['bd'], $S4) or bd_erreur($S4);
          $nbEtu = mysqli_fetch_assoc($R4);
          item_stat($nbEtu['total'], 'étudiants', '../images/studentgirl.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');

          // Nouvel item
          $S5 = 'SELECT COUNT(DISTINCT etudiantAsuivi) as total
                 FROM asuivi 
                 WHERE certificationAsuivi = 1';
          $R5 =  mysqli_query($GLOBALS['bd'], $S5) or bd_erreur($S5);
          $nbCertif = mysqli_fetch_assoc($R5);
          item_stat($nbCertif['total'], 'certifiés', '../images/chapeauEtudiant.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
	    // Nouvel item
          $S6 = 'SELECT COUNT(idFormation) as total
                 FROM formation';
          $R6 =  mysqli_query($GLOBALS['bd'], $S6) or bd_erreur($S6);
          $nbForm = mysqli_fetch_assoc($R6);
          item_stat($nbForm['total'], 'formations', '../images/formation.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
          // Nouvel item
          $S7 = 'SELECT COUNT(DISTINCT etudiantAeffectue) as total
                 FROM aeffectue';
          $R7 =  mysqli_query($GLOBALS['bd'], $S7) or bd_erreur($S7);
          $nbSta = mysqli_fetch_assoc($R7);
          item_stat($nbSta['total'], 'stagiaires', '../images/networking.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');

          // Nouvel item
          $S8 = 'SELECT COUNT(DISTINCT etudiantAeffectue) as total
                 FROM aeffectue
                 WHERE embaucheAeffectue = 1';
          $R8 =  mysqli_query($GLOBALS['bd'], $S8) or bd_erreur($S8);
          $nbEmploi = mysqli_fetch_assoc($R8);
          item_stat($nbEmploi['total'], 'créations d\'emploi', '../images/job.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
	    // Nouvel item
          $S9 = 'SELECT COUNT(idStage) as total
                 FROM stage';
          $R9 =  mysqli_query($GLOBALS['bd'], $S9) or bd_erreur($S9);
          $nbStages = mysqli_fetch_assoc($R9);
          item_stat($nbStages['total'], 'stages proposés', '../images/studentman.svg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
          
    echo '</div>';
		
	html_aside_main_fin();
	echo '</body></html>';
	
	ob_end_flush();
?>