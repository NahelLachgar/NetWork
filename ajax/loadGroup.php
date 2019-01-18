<?php
session_start();
if(isset($_POST['messageId']) && isset($_POST['groupId'])){ 
$groupId = (int) $_POST['groupId'];
$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier
// on récupère les messages ayant un id plus grand que celui donné
function dbConnect() {
    $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
    return $db;
}
$db = dbConnect();
$req = $db->prepare('SELECT DISTINCT * FROM groupAdd 
WHERE  group = :groupId AND status = "message"
AND id > :id
ORDER BY id ASC');
$req->execute(array(
    'id' => $messageId,
    'group' => $groupId,
    'userId' => $_SESSION['id']
));

function getProfile($userId)
{
    $db = dbConnect();
    $profile = $db->prepare('SELECT * FROM users WHERE id =?');
    $profile->execute(array($userId));
    $profileFetch = $profile->fetch();
    return $profileFetch;
}
$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($donnees = $req->fetch())
{
    $profile = getProfile($donnees['user']);
    if ($donnees['user'] == $_SESSION['id']) {
        $class="sent";
    } else {
        $class="replies";
    }
    $messages .= '<li id="'.$donnees["id"].'" class="'.$class.'">
    <img src="./img/profile/'.$profile["photo"].'" alt="">

    <p>' . $donnees['content'] . '</p></li>';
}
echo $messages; // on retourne les messages à notre script JS
}
?>