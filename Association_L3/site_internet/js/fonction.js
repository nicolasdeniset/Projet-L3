function openNav() {
    document.getElementById("navigationResponsive").style.width = "100%";
}
function closeNav() {
    document.getElementById("navigationResponsive").style.width = "0%";
}
/* On passe en paramètre un tableau contenant les ID des objets concernés, le premier étant l'item à sélectionner*/
function openGestion(tabThingsId) {
    if (document.getElementById(tabThingsId[0]).style.display == "") {
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
  $('#gestionFormations').hide();
  $('#gestionStages').hide();
  $('#gestionEtudiant').hide();
});
