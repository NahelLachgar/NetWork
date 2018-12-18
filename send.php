<?php 
session_start();
var_dump($_SESSION);
echo($_POST['contactId']);

try
{
    $db = new PDO('mysql:host=localhost;dbname=NetWork', 'root', 'root');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

    $content =  htmlspecialchars($_POST['content']);
    $contactId =  htmlspecialchars($_POST['contactId']);
    $userId = $_SESSION['id'];

    $sendMessage = $db->prepare('INSERT into privateMessages (content,reicever,sendDate,sender)
    VALUES (:content,:reicever,NOW(),:sender)');
    $sendMessage->execute(array(
    "content"=>$content,
    "reicever"=>$contactId,
    "sender"=>$userId
));
    
?>