<?php
session_start();
$userId = $_SESSION['id'];
function dbConnect() {
    $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
    return $db;
}
$db = dbConnect();

$req = $db->prepare('SELECT COUNT(*) FROM notifications 
WHERE contact = :userId');
$req->execute(array(
    'userId' => $userId
));
echo $notification; // on retourne les messages à notre script JS
?>