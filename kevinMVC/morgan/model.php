<?php

    // MODIFICATION DES CHAMPS DU PROFIL EXCEPTE LES CHAMPS password ET photo
    function updateProfiles($lastname,$name,$email,$phone,$job,$company,$town,$id)
    {
        $bdd =  dbConnect();
        $req = $bdd->prepare('UPDATE users SET users.lastname = ?, users.name = ?, users.email = ?, users.phone = ?,users.job = ?,users.company = ?,users.town = ?  WHERE users.id = ?');
        $req->execute(array($lastname,$name,$email,$phone,$job,$company,$town,$id));

        return $req;
    }

    // MODIFICATION DU CHAMPS password
    function updateProfilesPassword($pass,$id)
    {
        $bdd =  dbConnect();
        $req = $bdd->prepare('UPDATE users SET users.password = ? WHERE users.id = ?'); 
        $password = password_hash($pass, PASSWORD_BCRYPT);
        $req->execute(array($password,$id));

        return $req;
    }

    //RECHERCHE D'UN USER AVEC SON NOM OU SON PRENOM
    function getSearch($name)
    {
        $bdd =  dbConnect();
        $res  = "%".$name."%" ;
        $req =  $bdd->prepare('SELECT users.id as idContact,users.lastname,users.name,users.email,users.phone,users.job,users.company,users.town FROM users WHERE users.lastname LIKE ?  UNION SELECT users.id,users.lastname,users.name,users.email,users.phone,users.job,users.company,users.town WHERE users.name LIKE ? ');
        $req->execute(array($res,$res));

        return $req;
    }

    //AJOUT D"UN CONTACT
    function addContact($idContact,$idUser)
    {
        $bdd =  dbConnect();
        $req = $bdd->prepare('INSERT INTO contacts(contact,user) VALUES(?,?)');
        $req->execute(array($idContact,$idUser));

        return $req; 
    }

    function getContact($idContact)
    {
        $bdd =  dbConnect();
        $req = $bdd->prepare('SELECT ');
    }

    //SUPPRESSION D"UN CONTACT
    function deleteContacts($idContact,$idUser)
    {
        $bdd =  dbConnect();
        $req = $bdd->prepare('DELETE FROM contacts WHERE contacts.contact = ? AND contacts.user = ?');
        $req->execute(array($idContact,$idUser));

        return $req;
    } 
?>