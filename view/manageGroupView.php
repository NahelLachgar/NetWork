<?php 
$title = "Groupe";
ob_start();
?>

<?php foreach( $res as $member) :?>
        <?= $member['name']." ".$member['lastName'] ?> 
        <form action="index.php?action=removeToGroups" method="POST">
             <input type="hidden" name="contactId" value="<?=$member['id']?>">
             <input type="hidden" name="groupId" value="<?= $idGroup ?>">
             <button type="submit" class="btn btn-link">retirer du groupe</button>
        </form><br>
<?php endforeach; ?>

<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>