<?php
if(isset($_POST['messageId']) && isset($_POST['groupId'])){ 
$groupId = (int) $_POST['groupId'];
$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier
// on récupère les messages ayant un id plus grand que celui donné

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


$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($data = $req->fetch())
{
    $profile = getProfile($data['user']);
    if ($data['user'] == $_SESSION['id']) {
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