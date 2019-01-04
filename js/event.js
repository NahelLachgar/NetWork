// Contrôle du courriel en fin de saisie
//CONTROLE NOM DE L'EVENEMENT
document.getElementById("title").addEventListener("input", function (e) {
    var validiteTitle="";
    var couleurMsg="red";

        if((document.getElementById('title').value==' ') || (document.getElementById('title').value=='')) {
            validiteTitle="Nom invalide";
        }
        else if(title.length<4) {
            validiteTitle="Nom invalide";
        }
        else {
            validiteTitle="Nom valide";
            couleurMsg="green";
        }
    var aideLtitleElt=document.getElementById("aideLtitle");
    document.getElementById("aideLtitle").textContent=validiteTitle;
    aideLtitleElt.style.color=couleurMsg;
});  

//CONTROLE LIEU
document.getElementById("place").addEventListener("input", function (e) {
    var validitePlace="";
    var couleurMsg="red";

    if(place.length<4) {
        validitePlace="Lieu invalide";
    }
    else {
        validitePlace="Lieu valide";
        couleurMsg="green";
    }
    var aidePlaceElt=document.getElementById("aidePlace");
    document.getElementById("aidePlace").textContent=validitePlace;
    aidePlaceElt.style.color=couleurMsg;
});

//CONTROLE DATE DE L'EVENEMENT
document.getElementById("eventDate").addEventListener("input", function (e) {
    var sdate1=document.getElementById('eventDate').value;
    var date1=new Date();
    date1.setFullYear(sdate1.substr(0,4));
    date1.setMonth(sdate1.substr(5,2));
    date1.setDate(sdate1.substr(8,2));
    date1.setHours(sdate1.substr(14,2));
    date1.setMinutes(sdate1.substr(13,2));
    date1.setSeconds(sdate1.substr(17,2));
    date1.setMilliseconds(0);
    var d1=date1.getTime();
    
    var d2=new Date();

    if(d1<d2) {
        validiteEventDate="Date invalide";
    }
    else {
        validiteEventDate="Date valide";
        couleurMsg="green";
    }
    var aideEventDateElt=document.getElementById("aideEventDate");
    document.getElementById("aideEventDate").textContent=validiteEventDate;
    aideEventDateElt.style.color=couleurMsg;
});