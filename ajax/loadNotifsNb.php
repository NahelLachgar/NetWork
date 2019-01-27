<?php

$db = dbConnect();
$req = $db->prepare('SELECT COUNT(*) AS nbNotifs FROM notifications WHERE user = ? AND `type` NOT LIKE "message" AND `type` NOT LIKE "groupMessage"');
$req->execute(array($_SESSION['id']));
$nbNotifs = $req->fetch();
echo $nbNotifs['nbNotifs'];
?>