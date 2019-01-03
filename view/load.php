<?php
session_start();
if(isset($_POST['messageId']) && isset($_POST['contactId'])){ 
$contactId = (int) $_POST['contactId'];
$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier

// on récupère les messages ayant un id plus grand que celui donné
$db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
$req = $db->prepare('SELECT DISTINCT * FROM privateMessages 
WHERE id > :id 
AND sender = :userId AND receiver = :contactId
OR sender = :contactId AND receiver = :userId 
ORDER BY id ASC');
$req->execute(array(
    'id' => $messageId,
    'contactId' => $contactId,
    'userId' => $_SESSION['id']
));

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
echo $messages; // on retourne les messages à notre script JS
}
?>