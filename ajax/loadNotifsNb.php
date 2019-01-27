<?php

$db = dbConnect();
$req = $db->prepare('SELECT COUNT(*) AS nbNotifs FROM notifications WHERE user = ?');
$req->execute(array($_SESSION['id']));
$nbNotifs = $req->fetch();
echo $nbNotifs['nbNotifs'];
?>