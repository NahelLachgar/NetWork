<?php
if(isset($_POST['messageId']) && isset($_POST['contactId'])){ 
$contactId = (int) $_POST['contactId'];
$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier
// on récupère les messages ayant un id plus grand que celui donné

$db = dbConnect();
$req = $db->prepare('SELECT DISTINCT * FROM privateMessages 
WHERE sender = :userId AND receiver = :contactId
AND id > :id
UNION
SELECT DISTINCT * FROM privateMessages 
WHERE sender = :contactId AND receiver = :userId
AND id > :id
ORDER BY id ASC');
$req->execute(array(
    'id' => $messageId,
    'contactId' => $contactId,
    'userId' => $_SESSION['id']
));


$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($data = $req->fetch())
{
    $profile = getProfile($data['sender']);
    if ($data['sender'] == $_SESSION['id']) {
        $class="sent";
    } else {
        $class="replies";
    }
    $messages .= '<li id="'.$data["id"].'" class="'.$class.'">
    <img src="./img/profile/'.$profile["photo"].'" alt="">

    <p>' . $data['content'] . '</p></li>';
}
echo $messages; // on retourne les messages à notre script JS
}
?>