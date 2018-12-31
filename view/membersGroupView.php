<?php 
$title = "Groupe";
ob_start();
?>

<?php if($admin['id'] == $_SESSION['id']): ?>
    <?= $admin['name']." ".$admin['lastName'] ?>
    <a href="#">Ajouter des contacts</a>
    <a href="#">Modifier le groupe</a>  
    <h4 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">Administrateur</span></h4>
<?php else: ?>
    <?= $admin['name']." ".$admin['lastName'] ?> 
    <h4 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">Administrateur</span></h4>
<?php endif; ?>

<?php foreach( $res as $member) :?>
    <?php if ( ($member['id'] != $admin['id']) && ($member['id'] == $_SESSION['id']) ): ?>
        <?= $member['name']." ".$member['lastName'] ?> <a href="#">quitter le groupe</a><br>
    <?php else: ?>
        <?= $member['name']." ".$member['lastName'] ?><br>
    <?php endif; ?>
<?php endforeach; ?>

<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>