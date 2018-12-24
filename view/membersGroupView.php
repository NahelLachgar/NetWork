<?php 
$title = "Groupe";
ob_start();
?>

<?php foreach( $res as $member) :?>
<?= $member['lastName']." ".$member['name'] ?><br>
<?php endforeach; ?>

<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>