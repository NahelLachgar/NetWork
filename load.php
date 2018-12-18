<?php
session_start();
var_dump($_SESSION);
try
{
    $db = new PDO('mysql:host=localhost;dbname=NetWork', 'root', 'root');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$messageId = (int) $_POST['messageId']; // on s'assure que c'est un nombre entier

// on récupère les messages ayant un id plus grand que celui donné
$requete = $db->prepare('SELECT * FROM privateMessages WHERE id > messageId ORDER BY id DESC');
$requete->execute(array('messageId' => $messageId));

$messages = null;

// on inscrit tous les nouveaux messages dans une variable
while($donnees = $requete->fetch()){
    $messages .= '<li class="<?=$class?><p>"' . $donnees['content'] . '</p></li>';
    echo $donnees['content'].'<br>';
}
echo $messages; // enfin, on retourne les messages à notre script JS

?>