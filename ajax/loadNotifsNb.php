<?php

$db = dbConnect();
$req = $db->prepare('SELECT COUNT(*) AS nbNotifs FROM notifications WHERE user = ? `type` NOT LIKE "message" `type` NOT LIKE "groupeMessage"');
$req->execute(array($_SESSION['id']));
$nbNotifs = $req->fetch();
echo $nbNotifs['nbNotifs'];
?>