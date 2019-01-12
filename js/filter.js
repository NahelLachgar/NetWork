function filter() {

    // ON DÉCLARE LES VARIABLES
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById('contactSearch');
      filter = input.value.toUpperCase();
      ul = document.getElementById("contactList");
      li = ul.getElementsByTagName('li');
    
    // ON PARCOURE LE TABLEAU EN MASQUANT CEUX QUI NE CORRESPONDENT PAS À LA RECHERCHE
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("p")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    }