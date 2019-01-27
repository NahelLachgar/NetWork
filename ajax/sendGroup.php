<?php
session_start();
        $content = $_POST['content'];
        $groupId = $_POST['groupId'];
        $db = new PDO('mysql:host=localhost;dbname=NetWork;charset=utf8', 'root', 'root'); 
        $sendMessage = $db->prepare('INSERT into groupAdd (`message`,`addDate`,`user`,`status`,`group`)
                                VALUES (:message,NOW(),:user,"message",:group)');
    $sendMessage->execute(array(
        "message"=>$messsage,
        "user"=>$_SESSION['id'],
        "group"=>$groupId
    ));

    $profile = getProfile($_SESSION['id']);
    $userProfile = getProfile($contactId);
    if ($userProfile['status']== "employee") {

    $content = $profile['name'].' '.$profile['lastName'].' vous a envoyé un message.';
    $url = 'index.php?action=showMessagesGroup&groupId='.$groupId;
    $icon = $profile['photo'];
    $type = "message";
    $members = selectContactGroup($groupId);
    for ($i=0;$i>count($members);$i++) {
        $profile = getProfile($member);
        $contactId = $profile['id'];
        $notif = addNotif($contactId,$content,$url,$icon,$type);
    }
    if ($sendMessage) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
?>