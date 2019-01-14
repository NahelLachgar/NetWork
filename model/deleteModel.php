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
    while($donnees=$reponse->fetch())
    {
        $e[$m]=$donnees['com'];
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
     while($donnees=$reponse->fetch())
     {
         $f[$n]=$donnees['publication'];
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
         while($donnees=$reponse->fetch())
         {
             $g[$o]=$donnees['com'];
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
     //RECHERCHER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
     /*$reponse=$bdd->prepare('SELECT events
                             FROM participate, events
                             WHERE admin=:ID AND event=events.id');
     $reponse->execute(['ID'=>$ID]);
     $b=array();
     $j=0;
     while($donnees=$reponse->fetch())
     {
         $b[$j]=$donnees['event'];
         $j++;
     }*/
     //SUPPRIMER LES PARTICIPATIONS DE L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM participate
                             WHERE user=:ID');
     $reponse->execute(['ID'=>$ID]);
     //SUPPRIMER LES EVENEMENTS OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
     /*for($j=0;$j<sizeof($b);$j++)
     { 
         $reponse=$bdd->prepare('DELETE FROM events
                                 WHERE id=:id');
         $reponse->execute(['id'=>$b[$j]]);
     }*/
 }

 //SUPPRIMER LES GROUPES / LES PARTICIPATIONS DANS LES GROUPES
 function deleteAllGroups($ID)
 {
     $bdd=dbConnect();
     //RECHERCHER LES GROUPES OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
     /*$reponse=$bdd->prepare('SELECT group
                             FROM groupAdd, groups
                             WHERE admin=:ID AND group=groups.id');
     $reponse->execute(['ID'=>$ID]);
     $a=array();
     $i=0;
     while($donnees=$reponse->fetch())
     {
         $a[$i]=$donnees['group'];
         $i++;
     }*/
     //SUPPRIMER LES PARTICIPATIONS DE L'UTILISATEUR
     $reponse=$bdd->prepare('DELETE FROM groupAdd
                             WHERE user=:ID');
     $reponse->execute(['ID'=>$ID]);
     //SUPPRIMER LES GROUPES OU L'UTILISATEUR EN EST L'ADMINISTRATEUR
     /*for($i=0;$i<sizeof($a);$i++)
     { 
         $reponse=$bdd->prepare('DELETE FROM groups
                                 WHERE id=:id');
         $reponse->execute(['id'=>$a[$i]]);
     }*/
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