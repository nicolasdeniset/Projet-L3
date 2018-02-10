<?php
  require('bibliotheque.php');
  ob_start();
  bd_connexion();
  session_start();
  html_head('Nos partenaires');
  html_header();
  html_aside_main_debut("","","","","class=\"active\"","","","","","");
  echo '<h1 class="page-header">Nos entreprises partenaires</h1>';
  rechercheEntreprise();
  html_aside_main_fin();
  ob_end_flush();

  //=================== FIN DU SCRIPT =============================

  //_______________________________________________________________
  //
  //		FONCTIONS LOCALES
  //_______________________________________________________________

  function rechercheEntreprise(){
    $S= ' SELECT *
          FROM compte, coordonnees
          WHERE coordonneesCompte = idCoordonnees
          AND typeCompte = "3"';

    $R = mysqli_query($GLOBALS['bd'], $S) or bd_erreur($S);

    $tab=mysqli_fetch_assoc($R);

    if($tab['idCompte'] == NULL){
      echo '<p>Aucune entrerpise trouvée</p>';
    }
    else {

      echo '<form class="form-inline">',
            '<div class="form-group">',
              '<input type="text" class="form-control" placeholder="Nom de l\'entreprise">',
            '</div>',
            '<button type="submit" class="btn btn-inline"><span class="fa fa-search"></span>Rechercher</button>',
          '</form>',
          '<div class="table-responsive">',
            '<table class="table table-striped">',
              '<thead>',
                '<tr>',
                  '<th>ID</th>',
                  '<th>Nom Entrerpise</th>',
                  '<th>Date d\'inscription</th>',
                  '<th>Nombre stages proposés</th>',
                  '<th>Nombre étudiants embauchés</th>',
                  '<th>Gestion</th>',
                '</tr>',
              '</thead>',
              '<tbody>';
              do {
                echo  '<tr>',
                        '<td>',htmlentities($tab['idCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',htmlentities($tab['nomEntrepriseCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',htmlentities($tab['inscriptionCompte'], ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',htmlentities("5", ENT_QUOTES, 'UTF-8'),'</td>',
                        '<td>',htmlentities("0", ENT_QUOTES, 'UTF-8'),'</td>',
                        '</tr>';
              }while($tab=mysqli_fetch_assoc($R));
              echo '</tbody></table></div></section></main></div>';


    }
  }

 ?>



 echo '<ul>';
 				$i=0;
 				do{
 					$i++;
 					if($i % 2 == 0){echo '<li class="paire">';}
 					else{echo '<li class="impaire">';}
 					echo '',htmlentities($tab['utiNom'], ENT_QUOTES, 'UTF-8'), ' - ',htmlentities($tab['utiMail'], ENT_QUOTES, 'UTF-8'),'';
 					if($tab['utiID']!=$_SESSION['utiID']){
 						while($tab2['utiID']!=NULL){
 							if($tab2['utiID']==$tab['utiID']){
 								echo ' [Abonné à votre agenda]';
 								break;
 							}
 							else{
 								$tab2=mysqli_fetch_assoc($R2);
 							}
 						}
 					}
 					$R2 = mysqli_query($GLOBALS['bd'], $S2) or papci_bd_erreur($S2);

 					$tab2=mysqli_fetch_assoc($R2);
 					echo 	'<form method="POST" action="abonnements.php?id=',$tab['utiID'],'">',
 		             papci_form_input(APP_Z_SUBMIT, 'btnDesabonnement', 'Se Désabonner'),
 		            '</form></li>';
 			}while($tab=mysqli_fetch_assoc($R));
 			echo '</ul>';
 		}

 //		$R2 = mysqli_query($GLOBALS['bd'], $S2) or papci_bd_erreur($S2);
 //  	$tab2=mysqli_fetch_assoc($R2);
 		echo '<h4>Mes abonnés</h4>';
 		if($tab2['utiNom'] == NULL){
 			echo '<strong>Aucune correspondance</strong>';
 		}
 		else{
 			echo '<ul>';
 			$i=0;
 			do{
 				$i++;
 				if($i % 2 == 0){echo '<li class="paire">';}
 				else{echo '<li class="impaire">';}
 				echo '',htmlentities($tab2['utiNom'], ENT_QUOTES, 'UTF-8'), ' - ',htmlentities($tab2['utiMail'], ENT_QUOTES, 'UTF-8'),'';
 				$R2 = mysqli_query($GLOBALS['bd'], $S2) or papci_bd_erreur($S2);
 				$tab2=mysqli_fetch_assoc($R2);

 				while($tab['utiID']!=NULL){
 					if($tab2['utiID']==$tab['utiID']){
 						echo 	'<form method="POST" action="abonnements.php?id=',$tab2['utiID'],'">',
 									 papci_form_input(APP_Z_SUBMIT, 'btnAbonnement', 'S\'abonner'),
 									'</form></li>';
 						break;
 					}
 					else {
 						$tab=mysqli_fetch_assoc($R);
 					}
 				}

 		}while($tab=mysqli_fetch_assoc($R));
 	}
 	}
