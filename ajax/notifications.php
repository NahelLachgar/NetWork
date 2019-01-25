<?php
session_start();
$userId = $_SESSION['id'];
function dbConnect() {
    $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
    return $db;
}
$db = dbConnect();
/*$req = $db->prepare('SELECT DISTINCT * FROM notifications 
WHERE contact = :userId');*/
$req = $db->prepare('SELECT COUNT(*) FROM notifications 
WHERE contact = :userId');
$req->execute(array(
    'userId' => $userId
));

/*function getProfile($userId)
{
    $db = dbConnect();
    $profile = $db->prepare('SELECT * FROM users WHERE id =?');
    $profile->execute(array($userId));
    $profileFetch = $profile->fetch();
    return $profileFetch;
}
$notification = null;

// on inscrit tous les nouveaux messages dans une variable
while($data = $req->fetch())
{
    /*$profile = getProfile($data['user']);
    $notif .= '<li id="'.$data["id"].'" class="'.$class.'">
    <img src="./img/profile/'.$profile["photo"].'" alt="">

    <p>' . $data['content'] . '</p></li>';*
}*/
echo $notification; // on retourne les messages à notre script JS
?>