<?php
require('model/model.php');

function home($userId) {
$posts = getPosts($userId);
$suggests = getSuggests($userId);
$profile = getProfile($userId);
}
?>