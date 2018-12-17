// Contrôle du courriel en fin de saisie
//CONTROLE MAIL
document.getElementById("email").addEventListener("input", function (e) {
    var validiteCourriel = "";
    var regex =  /[@.]/g;
    var couleurMsg = "red";
    var textSansEspace = $('#email').val().replace(/ /g,"");
    
   if ((e.target.value.indexOf("@") === -1 ) || (e.target.value.indexOf(".") === -1 )) {
       if(e.target.value.indexOf(".") === -1) {
            // Le courriel saisi ne contient pas le caractère @
            validiteCourriel = "Adresse invalide";
       }
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

  //CONTROLE NOM
  document.getElementById("firstName").addEventListener("input", function (e) {
    var validiteName = "";
    var couleurMsg = "red";

        if((document.getElementById('firstName').value==' ') || (document.getElementById('firstName').value=='')){
            validiteName = "Prénom invalide";
        } else {
            validiteName = "Prénom valide";
            couleurMsg = "green";
        }
    var aideNameElt = document.getElementById("aideName");
    document.getElementById("aideName").textContent = validiteName;
    aideNameElt.style.color = couleurMsg;
}); 

//CONTROLE PRENOM
document.getElementById("lastName").addEventListener("input", function (e) {
    var validiteName = "";
    var couleurMsg = "red";

        if((document.getElementById('lastName').value==' ') || (document.getElementById('lastName').value=='')){
            validiteName = "Nom invalide";
        } else {
            validiteName = "Nom valide";
            couleurMsg = "green";
        }
    var aideLnameElt = document.getElementById("aideLname");
    document.getElementById("aideLname").textContent = validiteName;
    aideLnameElt.style.color = couleurMsg;
}); 