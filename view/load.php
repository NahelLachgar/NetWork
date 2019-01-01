<?php
session_start();
if(!empty($_POST['messageId'])){ // on vérifie que l'id est bien présent et pas vide

$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier

// on récupère les messages ayant un id plus grand que celui donné
$db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
$req = $db->prepare('SELECT * FROM privateMessages WHERE id > :id ORDER BY id DESC');
$req->execute(array('id' => $messageId));

$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($donnees = $req->fetch()){
    if ($donnees['sender']== $_SESSION['id']) {
        $class="sent";
    } else {
        $class="replies";
    }
    $messages .= '<li id="'.$donnees["id"].'" class="'.$class.'"><p>' . $donnees['content'] . '</p></li>';
}
echo $messages; // enfin, on retourne les messages à notre script JS
}
?>