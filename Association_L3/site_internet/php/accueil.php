<?php
	// Inclusion de la bibliothèque.
	require('bibliotheque.php');
	
echo '<!DOCTYPE html>',
'<html>',
  '<head>',
    '<meta charset="utf-8">',
    '<title>TEST CSS & DESIGN</title>',
    '<!-- Feuille(s) CSS -->',
    '<link rel="stylesheet" href="../css/reboot.css">',
    '<link rel="stylesheet" href="../css/bootstrap-theme.css">',
    '<link rel="stylesheet" href="../css/bootstrap.css">',
    '<link rel="stylesheet" href="../css/font-awesome.min.css">',
    '<link rel="stylesheet" href="../css/style.css">',
    '<!-- Feuille(s) JS -->',
    '<script src="../jq/jquery-2.1.1.min.js"></script>',
    '<script src="../js/bootstrap.min.js"></script>',

    '<script>',
      'function openNav() {',
          'document.getElementById("navigationResponsive").style.width = "100%";',
      '}',
      'function closeNav() {',
          'document.getElementById("navigationResponsive").style.width = "0%";',
      '}',
      'function initSectionCandidater(){',
        'if(window.innerWidth>1000) {',
         ' var div1=$("#candidaterEtudiant").height();',
          'var div2=$("#candidaterPartenariat").height();',
          'if (div1>div2) {$("#candidaterPartenariat").height(div1);}',
          'else if (div2>div1) {$("#candidaterEtudiant").height(div2);}',
        '}',
      '}',
      'function initSectionArticle(){',
        'if(window.innerWidth>1000) {',
          'var div1=$("#article1").height();',
          'var div2=$("#article2").height();',
          'var div3=$("#article3").height();',
          'if(div1>div2 & div1>div3){', //div1 la plus grande
            '$("#article2").height(div1);',
            '$("#article3").height(div1);',
          '}',
          'else if (div2>div1 & div2>div3) {', //div2 la plus grande
            '$("#article1").height(div2);',
            '$("#article3").height(div2);',
          '}',
          'else if (div3>div1 & div3>div2) {',//div3 la plus grande
            '$("#article1").height(div3);',
            '$("#article2").height(div3);',
          '}',
        '}',
      '}',

      'function initSectionFormation(){',
        'if(window.innerWidth>1000) {',
          'var div1=$("#formation1").height();',
          'var div2=$("#formation2").height();',
          'var div3=$("#formation3").height();',
          'if(div1>div2 & div1>div3){', //div1 la plus grande
            '$("#formation2").height(div1);',
            '$("#formation3").height(div1);',
          '}',
          'else if (div2>div1 & div2>div3) { ',//div2 la plus grande
            '$("#formation1").height(div2);',
            '$("#formation3").height(div2);',
          '}',
          'else if (div3>div1 & div3>div2) {',//div3 la plus grande
            '$("#formation1").height(div3);',
            '$("#formation2").height(div3);',
          '}',
        '}',
      '}',

      '$(window).scroll(function() {',
        'if ($(document).scrollTop() > 50) {',
          '$(\'nav\').removeClass(\'transparent\');',
        '} else {',
          '$(\'nav\').addClass(\'transparent\');',
        '}',
      '});',

      'function onloadFonction() {',
          '$(\'nav\').addClass(\'transparent\');',
          'initSectionCandidater();',
          'initSectionArticle();',
          'initSectionFormation();',
      '}',

      'window.onload = onloadFonction;',

    '</script>',
    '<!-- Autre(s) -->',
    '<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">',
    '<meta name="viewport" content="width=device-width, initial-scale=1">',
    '<meta charset="UTF-8">',
  '</head>',
  '<!-- Début corps de la page-->',
  '<body id="onepage">',
    '<!-- Début header -->',
    '<header>',
      '<nav class="navbar navbar-default navbar-fixed-top">',
        '<div class="container">',
          '<a id ="logo" href="index.html" class="navbar-brand">(logo) - NOM ASSO</a>',
          '<div id="navigation" class="navbar-right">',
            '<ul class="nav navbar-nav hidden-sm hidden-xs">',
              '<li><a href="#Actualité">Actualité</a></li>',
              '<li><a href="#Formation">Formation</a></li>',
              '<li><a href="#Partenaire">Partenaire</a></li>',
              '<li><a href="#Donation">Donation</a></li>',
              '<li><a href="#Contacter">Nous contacter</a></li>',
              '<li><a href="login.php" class="navConnexion">Connexion</a> </li>',
              '<li><a href="inscription.php" class="navInscription">S\'inscrire</a></li>',
            '</ul>',
          '</div>',
          '<div id="navigationResponsive" class="overlay">',
            '<button type="button" class="close" aria-label="Close" onclick="closeNav()"><span aria-hidden="true">&times;</span></button>',
            '<a class="closebtn" onclick="closeNav()">&times;</a>',
            '<ul class="overlay-content">',
              '<li><a href="http://google.Com" onclick="closeNav()">Actualités</a></li>',
              '<li><a href="#Statitistique" onclick="closeNav()">Statistiques</a></li>',
              '<li><a href="#Partenaire" onclick="closeNav()">Partenaires</a></li>',
              '<li><a href="#Donation" onclick="closeNav()">Donation</a></li>',
              '<li><a href="#Contacter" onclick="closeNav()">Nous Contacter</a></li>',
              '<li><a href="#Connexion" onclick="closeNav()">Connexion</a> </li>',
              '<li><a href="#Candidater" onclick="closeNav()">S\'inscrire</a></li>',
            '</ul>',
          '</div>',
          '<span class= "btn pull-right hidden-lg hidden-md" onclick="openNav()">MENU</span>',
        '</div>',
      '</nav>',
    '</header>',
    '<!-- Fin header -->',
    '<!-- Début section -->',
    '<section>',
      '<div class="jumbotron">',
        '<div class="container">',
          '<div class="row">',
            '<h1>NOM ASSOCIATION</h1>',
            '<h3>Un slogan plutôt sympa ! patatipatata patatapatati</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
          '</div>',
          '<div class="row">',
            '<div class="text col-md-6 col-sm-12">',
              '<a href="#about" class="btn btn-info btn-block">Découvrire</a>',
            '</div>',
            '<div class="text col-md-6 col-sm-12">',
              '<a href="#about" class="btn btn-success btn-block">Candidater</a>',
            '</div>',
          '</div>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section a propos-->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">A PROPOS</h2>',
          '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section statistiques-->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">STATISTIQUES</h2>',
          '<h3 class="text-center">L\'association en quelques chiffres clés</h3>',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/001-network.svg" alt="Une image" height="100px" width="100px"/>',
            '<h3 class="text-center">75 Partenaires</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/benevole.svg" alt="Une image" height="100px" width="100px"/>',
            '<h3 class="text-center">75 bénévoles</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/studentgirl.svg" alt="Une image" height="100px" width="100px" />',
            '<h3 class="text-center">75 étudiants</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/studentman.svg" alt="Une image" height="100px" width="100px" />',
            '<h3 class="text-center">75 Stages proposés</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/formation.svg" alt="Une image" height="100px" width="100px" />',
            '<h3 class="text-center">75 Formations</h3>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4 col-sm-6">',
            '<img class="img-responsive center-block" src="../images/005-maps-and-flags.svg" alt="Une image" height="100px" width="100px" />',
            '<h3 class="text-center">75 Pôles en Afrique</h3>',
            '<p>loremLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>',
          '</div>',
          '<!-- End Item-->',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section témoignage -->',
    '<section>',
      '<div class="container">',
        '<h2 class="text-center">TEMOIGNAGES</h2>',
        '<div id="myCarousel" class="carousel slide" data-ride="carousel">',

          '<!-- Indicators -->',
          '<ol class="carousel-indicators">',
            '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>',
            '<li data-target="#myCarousel" data-slide-to="1"></li>',
            '<li data-target="#myCarousel" data-slide-to="2"></li>',
          '</ol>',

          '<!-- Wrapper for slides -->',
          '<div class="carousel-inner">',
            '<div class="item active ">',
              '<div class="item col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-3">',
                '<img class="img-responsive center-block" src="../images/quotation-mark.svg" alt="Quote" height="100px" width="100px">',
              '</div>',
              '<p class="item col-md-8 col-sm-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
              '<!--<div class="carousel-caption">',
                '<h4>Témoignage par : Inconnu</h4>',
              '</div>-->',
            '</div>',

            '<div class="item">',
              '<div class="item col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-3">',
                '<img class="img-responsive center-block" src="../images/quotation-mark.svg" alt="Quote" height="100px" width="100px">',
              '</div>',
              '<p class="item col-md-8 col-sm-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
              '<!--<div class="carousel-caption">',
                '<h4>Témoignage par : Inconnu</h4>',
              '</div>-->',
            '</div>',

            '<div class="item">',
              '<div class="item col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-3">',
                '<img class="img-responsive center-block" src="../images/quotation-mark.svg" alt="Quote" height="100px" width="100px">',
              '</div>',
              '<p class="item col-md-8 col-sm-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
              '<!--<div class="carousel-caption">',
                '<h4>Témoignage par : Inconnu</h4>',
              '</div>-->',
            '</div>',
          '</div>',

          '<!-- Left and right controls -->',
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
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section formation -->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">FORMATIONS</h2>',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="formation1">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h3>Titre de la formation</h3>',
              '<p class="small">Durée formation : 2mois</p>',
              '<p>Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Acceder à la formation</a>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="formation2">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h3>Titre de la formation</h3>',
              '<p class="small">Durée formation : 2mois</p>',
              '<p>Rapide description</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Acceder à la formation</a>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="formation3">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h3>Titre de la formation</h3>',
              '<p class="small">Durée formation : 2mois</p>',
              '<p>Rapide description</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Acceder à la formation</a>',
          '</div>',
          '<!-- End Item-->',
        '</div>',
        '<div class="row">',
          '<a href="#about" class="btn btn-info btn-block">Acceder à nos autres formations</a>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section partenaire-->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">PARTENAIRES</h2>',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-2 col-sm-4">',
            '<img class="img-responsive center-block logoPartenaire" src="../images/help.svg" alt="Une image" height="75px" width="75px"/>',

          '</div>',
          '<!-- End Item-->',

        '</div>',
        '<div class="row">',
          '<div class="text col-md-6 col-sm-12">',
            '<a href="#about" class="btn btn-info btn-block">Découvrire nos autres partenaires</a>',
          '</div>',
          '<div class="text col-md-6 col-sm-12">',
            '<a href="#about" class="btn btn-success btn-block">Candidater pour devenir partenaire</a>',
          '</div>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section candidater -->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">CANDIDATER</h2>',
          '<h3 class="text-center">Vous souhaitez devenir membre de l\'associaition ?</h3>',
          '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
        '</div>',
        '<div class="row">',
          '<!-- Item-->',
          '<div class="item  col-md-6">',
            '<div id="candidaterPartenariat">',
              '<img class="img-responsive center-block" src="../images/partenaire.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4 class="text-center">Devenir partenaire</h4>',
              '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Candidature partenariat</a>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-6">',
            '<div id="candidaterEtudiant">',
              '<img class="img-responsive center-block" src="../images/chapeauEtudiant.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4 class="text-center">Devenir étudiant</h4>',
              '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Candidature étudiante</a>',
          '</div>',
          '<!-- End Item-->',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section article -->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">ARTICLES</h2>',
          '<h3 class="text-center">Nos dernières actualités</h3>',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="article1">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4>Titre de l\'article</h4>',
              '<p class="small">Publié le 01/01/2018</p>',
              '<p>Rapide description</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Lire l\'article</a>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="article2">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4>Titre de l\'article</h4>',
              '<p class="small">Publié le 01/01/2018</p>',
              '<p>Rapide description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Lire l\'article</a>',
          '</div>',
          '<!-- End Item-->',
          '<!-- Item-->',
          '<div class="item col-md-4">',
            '<div id="article3">',
              '<img class="img-responsive center-block" src="../images/help.svg" alt="Une image" height="100px" width="100px"/>',
              '<h4>Titre de l\'article</h4>',
              '<p class="small">Publié le 01/01/2018</p>',
              '<p>Rapide description</p>',
            '</div>',
            '<a href="#about" class="btn btn-success btn-block">Lire l\'article</a>',
          '</div>',
          '<!-- End Item-->',
        '</div>',
        '<div class="row">',
          '<a href="#about" class="btn btn-info btn-block">Acceder à nos autres articles</a>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section -->',
    '<!-- Début section newletter -->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">NEWSLETTER</h2>',
          '<h3 class="text-center">Souscrivez à notre newsletter pour rester informé</h3>',
          '<div class="item col-md-6">',
            '<p>Chaque mois recevez un mail pour vous tenir au courant de nos activités et actualités Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip est laborum.</p>',
          '</div>',
          '<div class="item col-md-6 col-sm-12">',
            '<form>',
              '<div class="form-group">',
                '<input type="email" class="form-control" id="email" placeholder="Votre e-mail" required>',
              '</div>',
              '<button type="submit" class="btn btn-success btn-block">Souscrire à la newsletter</button>',
            '</form>',
          '</div>',
        '</div>',
      '</div>',
    '</section>',
    '<!-- Fin section-->',
    '<!-- Début section contacter -->',
    '<section>',
      '<div class="container">',
        '<div class="row">',
          '<h2 class="text-center">NOUS CONTACTER</h2>',
          '<h3 class="text-center">Une question ? Une remarque ? Un petit mot ? Notre équipe se fera une joie de vous répondre !</h3>',
          '<div class="item col-md-6">',
            '<h4>ASSOCIATION L3</h4>',
            '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
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
    '</section>',
    '<!-- Fin section -->',
    '<!-- Footer -->';

	html_pied();

?>
