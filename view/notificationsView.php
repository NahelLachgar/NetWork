<?php 
$title = "Notifications";
ob_start();
?>

<?php 
    $content = ob_get_clean();
    require_once('view/template.php');
?>