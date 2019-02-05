<?php

$db = dbConnect();
$req = $db->prepare('SELECT * FROM notifications WHERE user = ? AND status LIKE "unseen"');
$req->execute(array($_SESSION['id']));

$url = null;
$content = null;
$icon = null;
// on inscrit tous les nouveaux messages dans une variable
while($data = $req->fetch())
{
    $url = $data['url'];
    $content = $data['content'];
    $icon = "../img/profile/".$data['icon'];
$seen = $db->prepare('UPDATE notifications SET `status` = "seen" WHERE id = ?');
$seen->execute(array($data['id']));
echo(json_encode(array("url"=>$url,"content"=>$content,"icon"=>$icon)));
}

?>