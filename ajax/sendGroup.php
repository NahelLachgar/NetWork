<?php
$db = dbConnect();
        $message = $_POST['message'];
        $groupId = $_POST['groupId'];
        $sendMessage = $db->prepare('INSERT into groupAdd (`message`,`addDate`,`user`,`status`,`group`)
                                VALUES (:message,NOW(),:user,"message",:group)');
    $sendMessage->execute(array(
        "message"=>$message,
        "user"=>$_SESSION['id'],
        "group"=>$groupId
    ));

    $profile = getProfile($_SESSION['id']);
    if ($userProfile['status']== "employee") {
    $group = getGroupsName($groupId);
    $content = $profile['name'].' '.$profile['lastName'].' a envoyé un message dans le groupe '.$group['title'].'.';
    $url = 'index.php?action=showMessagesGroup&groupId='.$groupId;
    $icon = $profile['photo'];
    $type = "groupMessage";
    $members = selectContactGroup($groupId);
    for ($i=0;$i>count($members);$i++) {
        $userProfile = getProfile($members[$i]);
        $contactId = $userProfile;
        $notif = addNotif($contactId,$content,$url,$icon,$type);
    }
}
    if ($sendMessage) {
        echo "Success";
    } else {
        echo "Failed";
    }
?>