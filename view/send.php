<?php
session_start();
if( isset($_POST['content']) && isset($_POST['contactId']) ){
        $content = $_POST['content'];
        $content = $_POST['contactId'];

        $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
        $sendMessage = $db->prepare('INSERT into privateMessages (content,reicever,sendDate,sender)
                                VALUES (:content,:reicever,NOW(),:sender)');
    $sendMessage->execute(array(
        "content"=>$content,
        "reicever"=>$contactId,
        "sender"=>$_SESSION['id']
    ));
    if ($sendMessage) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
?>