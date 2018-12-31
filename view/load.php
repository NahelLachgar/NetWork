<?php
if(!empty($_POST['messageId'])){ // on vérifie que l'id est bien présent et pas vide

$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier

// on récupère les messages ayant un id plus grand que celui donné
$req = $bdd->prepare('SELECT * FROM privateMessages WHERE id > :id ORDER BY id DESC');
$requete->execute(array('id' => $messageId));

$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($donnees = $req->fetch()){
    if ($donnees['sender']==$_SESSION['id']) {
        $class="sent";
    } else {
        $class="replies";
    }
    $messages .= '<li id="'.$donnes["id"].'" class="<?=$class?><p>"' . $donnees['content'] . '</p></li>';
}
echo $messages; // enfin, on retourne les messages à notre script JS
}
?>