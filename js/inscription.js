// Contrôle du courriel en fin de saisie
//CONTROLE MAIL
document.getElementById("email").addEventListener("input", function (e) {
    var validiteCourriel = "";
    var couleurMsg = "red";
    if (e.target.value.indexOf("@" && ".") === -1) {
        // Le courriel saisi ne contient pas le caractère @
        validiteCourriel = "Adresse invalide";
    } else {
      validiteCourriel = "Adresse valide";
      var couleurMsg = "green"; 
    }
    var aideCourrielElt = document.getElementById("aideCourriel");
    document.getElementById("aideCourriel").textContent = validiteCourriel;
    aideCourrielElt.style.color = couleurMsg;
});
  //CONTROLE NUMERO DE TELEPHONE
  document.getElementById("phone").addEventListener("input", function (e) {
    var validitePhone = "";
    var phone = e.target.value;
    var couleurMsg = "red";
    var regex =  /[a-zA-Z_ ]/g;

    if (phone.length != 10) {
        // la taille du numero de telephone est different de 10
        validitePhone = "Numero de telephone invalide";
    } else if(phone.length = 10) {
        if(phone.match(regex)){
            validitePhone = "Numero de telephone invalide";
        } else {
            validitePhone = "Numero de telephone valide";
            couleurMsg = "green";
        }
    }
    var aidePhoneElt = document.getElementById("aidePhone");
    document.getElementById("aidePhone").textContent = validitePhone;
    aidePhoneElt.style.color = couleurMsg;
}); 