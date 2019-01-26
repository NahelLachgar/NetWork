<?php
if( isset($_POST['content']) && isset($_POST['contactId']) ){
        $content = $_POST['content'];
        $contactId = $_POST['contactId'];
        $db = dbConnect();
        $sendMessage = $db->prepare('INSERT into privateMessages (content,receiver,sendDate,sender)
                                VALUES (:content,:receiver,NOW(),:sender)');
    $sendMessage->execute(array(
        "content"=>$content,
        "receiver"=>$contactId,
        "sender"=>$_SESSION['id']
    ));

    $profile = getProfile($_SESSION['id']);
    $userProfile = getProfile($contactId);
    if ($userProfile['status']== "employee") {

    $content = $profile['name'].' '.$profile['lastName'].' vous a envoyé un message.';
    $url = 'index.php?action=showMessages&contactId='.$profile['id'];
    $icon = $profile['photo'];
    
    $notif = addNotif($contactId,$content,$url,$icon);
    }
    
    if ($sendMessage) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
?>