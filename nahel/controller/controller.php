<?php
require('model/model.php');

function home($userId) {
$contactPosts = getContactPosts($userId);
$profile = getProfile($userId);
$companySuggests = getCompanySuggests($userId);
$employeeSuggests = getEmployeeSuggests($userId);
$contactsNb = getContactsCount($userId);
$followedCompaniesNb = getFollowedCompaniesCount($userId);
require('view/homeView.php');
}