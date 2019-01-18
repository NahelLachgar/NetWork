<?php
require_once('model/dbConnect.php');
require_once('model/insertModel.php');
require_once('model/deleteModel.php');
require_once('model/updateModel.php');

//UNFOLLOW UN CONTACT
function unfollow($contactId, $idUser)
{
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM contacts WHERE contact = ? AND user = ? OR contact = ? AND user = ?');
    $req->execute(array($contactId, $idUser,$idUser,$contactId));
    return $req;
}


// SUPPRIMER DANS LA TABLE groupAdd
function deleteGroupAdd($groupId){
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM groupAdd WHERE groupAdd.group = ?");
    $req->execute(array($groupId));
}

// SUPPRIMER DANS LA TABLE groups
function deleteGroups($groupId){
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM groups WHERE id = ?");
    $req->execute(array($groupId));	
}

function removeFromGroup($contactId, $groupId) {
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM groupAdd WHERE groupAdd.user = ? AND groupAdd.group = ?");
    $req->execute(array($contactId, $groupId));
    return $req;
}





//SUPPRIMER LES COMMENTAIRES
function deleteAllComs($ID)
{
    $bdd=dbConnect();
    //RECHERCHER LES COMMENTAIRES DE L'UTILISATEUR
    $reponse=$bdd->prepare('SELECT com
                            FROM coms, comment
                            WHERE user=:ID AND com=coms.id');
    $reponse->execute(['ID'=>$ID]);
    $e=array();
    $m=0;
    while($data=$reponse->fetch())
    {
        $e[$m]=$data['com'];
        $m++;
    }
    //SUPPRIMER LES COMMENTAIRES DE L'UTILISATEUR
    for($m=0;$m<sizeof($e);$m++)
    {
        $reponse=$bdd->prepare('DELETE FROM comment
                                WHERE com=:id');
        $reponse->execute(['id'=>$e[$m]]);
    }
    $reponse=$bdd->prepare('DELETE FROM coms
                            WHERE user=:ID');
    $reponse->execute(['ID'=>$ID]);
}
 //SUPPRIMER LES PUBLICATIONS
 function deleteAllPubli($ID)
 {
     $bdd=dbConnect();
     //RECHERCHER LES PUBLICATIONS DE L'UTILISATEUR
     $reponse=$bdd->prepare('SELECT publication
                             FROM post, publications
                             WHERE user=:ID AND publication=publications.id');
     $reponse->execute(['ID'=>$ID]);
     $f=array();
     $n=0;
     while($data=$reponse->fetch())
     {
         $f[$n]=$data['publication'];
         $n++;
     }
     //RECHERCHER LES COMMENTAIRES SUR LES PUBLICATIONS DE L'UTILISATEUR
     $g=array();
     $o=0;
     for($n=0;$n<sizeof($f);$n++)
     { 
         $reponse=$bdd->prepare('SELECT com
                                 FROM coms, comment, post
                                 WHERE post.publication=:id AND comment.publication=post.publication AND com=coms.id');
         $reponse->execute(['id'=>$f[$n]]);
         while($data=$reponse->fetch())
         {
             $g[$o]=$data['com'];
             $o++;
         }
     }
     //SUPPRIMER LES COMMENTAIRES SUR LES PUBLICATIONS DE L'UTILISATEUR
     for($o=0;$o<sizeof($g);$o++)
     {
         $reponse=$bdd->prepare('DELETE FROM comment
                                 WHERE com=:id');
         $reponse->execute(['id'=>$g[$o]]);
         $reponse=$bdd->prepare('DELETE FROM coms
                             WHERE id=:id');
         $reponse->execute(['id'=>$g[$o]]);
     }
     //SUPPRIMER LES PUBLICATIONS DE L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM post
                             WHERE user=:ID');
     $reponse->execute(['ID'=>$ID]);
     for($n=0;$n<sizeof($f);$n++)
     {
         $reponse=$bdd->prepare('DELETE FROM publications
                                 WHERE id=:id');
         $reponse->execute(['id'=>$f[$n]]);
     }
 }

 //SUPPRIMER LES MESSAGES
 function deleteAllMessages($ID)
 {
     $bdd=dbConnect();
     //SUPPRIMER LES MESSAGES ENVOYES PAR L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM privateMessages
                             WHERE sender=:ID');
     $reponse->execute(['ID'=>$ID]);
     //SUPPRIMER LES MESSAGE RECU PAR L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM privateMessages
                             WHERE receiver=:ID');
     $reponse->execute(['ID'=>$ID]);
 }

 //SUPPRIMER EVENEMENTS / LES PARTICIPATIONS DANS LES EVENEMENTS
 function deleteAllEvents($ID)
 {
    $bdd=dbConnect();
    //RECHERCHER LES EVENEMENTS OU L'UTILISATEUR EST L'ADMINISTRATEUR
    $reponse=$bdd->prepare('SELECT id
                            FROM events
                            WHERE admin=:ID');
    $reponse->execute(['ID'=>$ID]);
    $b=array();
    $j=0;
    while($data=$reponse->fetch()) {
        $b[$j]=$data['id'];
        $j++;
    }
    //SUPPRIMER LES EVENEMENTS OU L'UTILISATEUR EST L'ADMINISTRATEUR
    for($i=0;$i<$j;$i++) {
        $reponse=$bdd->prepare('DELETE FROM participate
                                 WHERE event=:id');
        $reponse->execute(['id'=>$b[$i]]);
        $reponse=$bdd->prepare('DELETE FROM events
                                 WHERE id=:id');
        $reponse->execute(['id'=>$b[$i]]);
    }
    //SUPPRIMER LES PARTICIPATIONS DE L'UTILISATEUR
    $reponse=$bdd->prepare('DELETE FROM participate
                            WHERE user=:ID');
    $reponse->execute(['ID'=>$ID]);
 }

 //SUPPRIMER UTILISATEUR DES GROUPES / SUPPRIMER LES GROUPES / CHANGER L'ADMINISTRATEUR DANS LES GROUPES
 function deleteAllGroups($ID)
 {
    $bdd=dbConnect();
    //RECHERCHER LES GROUPES OU L'UTILISATEUR EST L'ADMINISTRATEUR
    $reponse=$bdd->prepare('SELECT id
                            FROM groups
                            WHERE admin=:ID');
    $reponse->execute(['ID'=>$ID]);
    $a=array(array());
    $i=0;
    while($data=$reponse->fetch()) {
        $a[$i][0]=$data['id'];
        $a[$i][1]=false;
        $i++;
    }
    //RECHERCHER LE MEMBRE LE PLUS ANCIEN DU GROUPE HORMIS L'ADMINISTRATEUR
    for($j=0;$j<$i;$j++) {
        $reponse=$bdd->query('SELECT user, groupAdd.group AS idGroup
                                FROM groupAdd
                                ORDER BY id ASC');
        $find=false;
        while($data=$reponse->fetch()) {
            if($find==false) {
                if($data['user']==$ID && $data['idGroup']==$a[$j][0]) {
                    $find=true;
                }
            }
            else {
                if($data['idGroup']==$a[$j][0]) {
                    $a[$j][1]=true;
                    $a[$j][2]=$data['user'];
                    break;
                }
            }
        }
    }
    //SUPPRIMER L'UTILISATEUR DE SES GROUPES
    for($j=0;$j<$i;$j++) {
        if($a[$j][1]==true) {
            //CHANGER L'ADMINISTRATEUR AVEC UN AUTRE MEMBRE
            $reponse=$bdd->prepare('UPDATE groups
                                    SET admin=:id
                                    WHERE id=:group');
            $reponse->execute(['id'=>$a[$j][2],
                                'group'=>$a[$j][0]]);
        }
        else {
            //SUPPRIMER LES GROUPES DE L'UTILISATEUR OU IL N'Y A AUCUN MEMBRE
            $reponse=$bdd->prepare('DELETE FROM groups
                                    WHERE admin=:group');
            $reponse->execute(['group'=>$a[$j][0]]);
        }
    }
    //SUPPRIMER L'UTILISATEUR DES GROUPES EN TANT QUE MEMBRE
    $reponse=$bdd->prepare('DELETE FROM groupAdd
                            WHERE user=:ID');
    $reponse->execute(['ID'=>$ID]);
 }

 //SUPPRIMER LES CONTACTS
 function deleteAllContacts($ID)
 {
     $bdd=dbConnect();
     //SUPPRIMER LES CONTACTS DE L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM contacts
                             WHERE user=:ID OR contact=:ID');
     $reponse->execute(['ID'=>$ID]);
 }

 //SUPPRIMER L'UTILISATEUR
 function deleteUser($ID)
 {
     $bdd=dbConnect();
     //SUPPRIMER LE COMPTE DE L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM users
                             WHERE id=:ID');
     $reponse->execute(['ID'=>$ID]);
 }

 //QUITTER EVENEMENT
 function deleteParticipate($ID, $id)
 {
     $bdd=dbConnect();
     //SUPPRIMER LA PARTICIPATION DE L'UTILISATEUR DANS CET EVENEMENT
     $reponse=$bdd->prepare('DELETE FROM participate
                             WHERE user=:ID AND event=:id');
     $reponse->execute(['ID'=>$ID,
                         'id'=>$id]);
 }

 //SUPPRIMER EVENEMENT
 function deleteEvent($ID)
 {
     $bdd=dbConnect();
     //SUPPRIMER LA PARTICIPATION DES PARTICIPANTS DE CET EVENEMENT
     $reponse=$bdd->prepare('DELETE FROM participate
                             WHERE event=:ID');
     $reponse->execute(['ID'=>$ID]);
     //SUPPRIMER L'EVENEMENT
     $reponse=$bdd->prepare('DELETE FROM events
                             WHERE id=:ID');
     $reponse->execute(['ID'=>$ID]);
 }

?>