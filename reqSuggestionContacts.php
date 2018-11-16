<?php
//RÉCUPÉRATION DES ID DES CONTACTS DU USER
$contactsId = $db->prepare('SELECT user AS id FROM contacts WHERE contact LIKE :id 
            UNION
            SELECT contact AS id FROM contacts WHERE user LIKE :id');
$contactsId >execute(array(
    "id"=>$contactsId['id']
));
$contactsIdFetch = $contactsId->fetch();



//RÉCUPÉRATION DES EMPLOYÉS À SUGGÉRER
$employeeSuggests = $db->prepare('SELECT u.lastName AS lastName, u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "employee"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "employee"');

$employeeSuggests->execute(array("id"=>$contactsId['id']));

while ($employeeSuggestsFetch = $employeeSuggests->fetch()) {
    //AFFICHE DES SUGGESTIONS D'EMPLOYÉS
}
$employeeSuggests->closeCursor();

//RÉCUPÉRATION DES ENTREPRIES À SUGGÉRER
$companySuggests = $db->prepare('SELECT u.name AS name FROM contacts c
        JOIN users u ON u.id = c.user
        WHERE c.contact LIKE :id AND u.status LIKE "company"
        UNION 
        JOIN users u ON u.id = c.user
        WHERE c.user LIKE :id AND u.status LIKE "company"');

$companySuggests->execute(array( "id"=>$contactsId['id']));

while ($companySuggestsFetch = $companySuggests->fetch()) {
    //AFFICHE DES SUGGESTIONS D'ENTREPRISE
}
$companySuggests->closeCursor();
?>