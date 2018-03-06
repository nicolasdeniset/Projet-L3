function openNav() {
  document.getElementById("navigationResponsive").style.width = "100%";
}
function closeNav() {
  document.getElementById("navigationResponsive").style.width = "0%";
}
/* On passe en paramètre un tableau contenant les ID des objets concernés, le premier étant l'item à sélectionner*/
function openGestion(tabThingsId) {
  if ((document.getElementById(tabThingsId[0]).style.display == "") && (window.location.href.match('inscription.php') == null)) {
    document.getElementById(tabThingsId[0]).style.display = "none";
  }
  else {
    document.getElementById(tabThingsId[0]).style.display = "";
  }
  for (var i = 1; i < tabThingsId.length; i++) {
    document.getElementById(tabThingsId[i]).style.display = "none" ;
  }
}

$(document).ready(function(){
  $('.gestion').hide();
});

/*Variables et fonctions utilisées pour créer la map*/

var tabNames = [];
var tabLat = [];
var tabLng = [];

function mapAddPlace(name, lat, lng) {
  tabNames[tabNames.length] = name;
  tabLat[tabLat.length] = lat;
  tabLng[tabLng.length] = lng;
}


function mapCreate() {
  var carte = document.getElementById("carte");
  var map = new google.maps.Map(carte, { 
    center: new google.maps.LatLng(2,18),
    zoom: 3
  });

  for (var i = 0; i < tabNames.length; i++) {
    var pin = new google.maps.Marker({
      position: new google.maps.LatLng(tabLat[i],tabLng[i]),
      animation: google.maps.Animation.DROP
    });
    pin.infoWindow = new google.maps.InfoWindow({
      content: "Pôle de " + tabNames[i]
    });
    pin.setMap(map);
    google.maps.event.addListener(pin, 'click', function(e) {
      // this est le Marker qui a reçu l'événement 
      this.infoWindow.open(map, this);
    });
  }
}

/* Fonctions spécifiques à la one page */

function initSectionCandidater(){
  if(window.innerWidth>1000) {
    var div1=$("#candidaterEtudiant").height();
    var div2=$("#candidaterPartenariat").height();
    var div3=$("#candidaterBenevolat").height();
    if (div1>=div2 && div1>=div3) {
      $("#candidaterPartenariat").height(div1);
      $("#candidaterBenevolat").height(div1);
    }
    else if (div2>=div1 && div2>=div3) {
      $("#candidaterEtudiant").height(div2);
      $("#candidaterBenevolat").height(div2);
    }
    else if (div3>=div1 && div3>=div2) {
      $("#candidaterEtudiant").height(div3);
      $("#candidaterPartenariat").height(div3);
    }
  }
}

function initSectionArticle(){
  if(window.innerWidth>1000) {
    var div1=$("#article1").height();
    var div2=$("#article2").height();
    var div3=$("#article3").height();
    if(div1>div2 & div1>div3){ //div1 la plus grande
      $("#article2").height(div1);
      $("#article3").height(div1);
    }
    else if (div2>div1 & div2>div3) { //div2 la plus grande
      $("#article1").height(div2);
      $("#article3").height(div2);
    }
    else if (div3>div1 & div3>div2) {//div3 la plus grande
      $("#article1").height(div3);
      $("#article2").height(div3);
    }
  }
}

function initSectionFormation(){
  if(window.innerWidth>1000) {
    var div1=$("#formation1").height();
    var div2=$("#formation2").height();
    var div3=$("#formation3").height();
    if(div1>div2 & div1>div3){ //div1 la plus grande
      $("#formation2").height(div1);
      $("#formation3").height(div1);
    }
    else if (div2>div1 & div2>div3) { //div2 la plus grande
      $("#formation1").height(div2);
      $("#formation3").height(div2);
    }
    else if (div3>div1 & div3>div2) {//div3 la plus grande
      $("#formation1").height(div3);
      $("#formation2").height(div3);
    }
  }
}

function onloadFonction() {
    $('nav').addClass('transparent');
    initSectionCandidater();
    initSectionArticle();
    initSectionFormation();
    //$('html, body').animate({scrollTop:0}, 'fast');
}

if (window.location.href.match('accueil.php') != null) {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 50) {
      $('nav').removeClass('transparent');
    } else {
      $('nav').addClass('transparent');
    }
  });

  window.onload = onloadFonction;
}

/* Fonction spécifique à la page de connexion */

function initConnexion(){
  if(window.innerWidth>1000) {
    var divReg=$("#register").height();
    var divLog=$("#login").height();
    if (divReg>divLog) {$("#login").height(divReg);}
    else {$("#register").height(divLog-94);}
  }
}

if (window.location.href.match('login.php') != null) {
  window.onload = initConnexion;
}

/* Fonction et initialisation spécifique à la page d'inscription */

function enTantQue(who) {
  document.getElementById("titleRegister").innerHTML = "JE M'INSCRIS " + who;
}

if (window.location.href.match('inscription.php') != null) {
  $(document).ready(function(){
    $('#company').hide();
    $('#volunteer').hide();
  });
}