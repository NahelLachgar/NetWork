<?php
require('model/model.php');

function home($userId) {
$contactPosts = getContactPosts($userId);
$suggests = getSuggests($userId);
$profile = getProfile($userId);
$companySuggests = getCompanySuggests($userId);
$employeeSuggests = getEmployeeSuggests($userId);
$contactsCount = getContactsCount($userId);
$followedCompaniesCount = getFollowedCompaniesCount($userId);
require('view/homeView.php');
}
?>