// Contrôle du courriel en fin de saisie
//CONTROLE MAIL
document.getElementById("email").addEventListener("input", function (e) {
    var validiteCourriel = "";
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

  //CONTROLE PRENOM
  document.getElementById("firstName").addEventListener("input", function (e) {
    var validiteName = "";
    var couleurMsg = "red";

        if((document.getElementById('firstName').value==' ') || (document.getElementById('firstName').value=='')){
            validiteName = "Prenom invalide";
        } else {
            validiteName = "Prenom valide";
            couleurMsg = "green";
        }
    var aideNameElt = document.getElementById("aideName");
    document.getElementById("aideName").textContent = validiteName;
    aideNameElt.style.color = couleurMsg;
}); 

//CONTROLE NOM
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
//CONTROLE JOB
document.getElementById("job").addEventListener("input", function (e) {
    var validiteJob = "";
    var couleurMsg = "red";

        if((document.getElementById('job').value==' ') || (document.getElementById('job').value=='')){
            validiteJob = "Emploi invalide";
        } else {
            validiteJob = "Emploi valide";
            couleurMsg = "green";
        }
    var aideJobElt = document.getElementById("aideJob");
    document.getElementById("aideJob").textContent = validiteJob;
    aideJobElt.style.color = couleurMsg;
}); 

//CONTROLE COMPANY
document.getElementById("company").addEventListener("input", function (e) {
    var validiteCompany = "";
    var couleurMsg = "red";

        if((document.getElementById('company').value==' ') || (document.getElementById('company').value=='')){
            validiteCompany = "Entreprise invalide";
        } else {
            validiteCompany = "Entreprise valide";
            couleurMsg = "green";
        }
    var aideCompanyElt = document.getElementById("aideCompany");
    document.getElementById("aideCompany").textContent = validiteCompany;
    aideCompanyElt.style.color = couleurMsg;
}); 

//CONTROLE VILLE
document.getElementById("town").addEventListener("input", function (e) {
    var validiteTown = "";
    var couleurMsg = "red";

        if((document.getElementById('town').value==' ') || (document.getElementById('town').value=='')){
            validiteTown = "Ville invalide";
        } else {
            validiteTown = "Ville valide";
            couleurMsg = "green";
        }
    var aideTownElt = document.getElementById("aideTown");
    document.getElementById("aideTown").textContent = validiteTown;
    aideTownElt.style.color = couleurMsg;
}); 
//CONTROLE MOT DE PASSE
function password() {
    var mdp = document.getElementById("mdp").value;
    var confirm = document.getElementById("mdp2").value;
    var validitePass = "";
    var couleurMsg = "red";

    if (mdp == confirm) {
        validitePass = "Mot de passe valide";
        couleurMsg = "green";
    } else {
        validitePass = "Mot de passe invalide";
    }
    var aidePass = document.getElementById("aidePass");
    document.getElementById("aidePass").textContent = validitePass;
    aidePassElt.style.color = couleurMsg;
}