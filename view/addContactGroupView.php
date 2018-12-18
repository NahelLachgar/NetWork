<?php 
$title = "Groupe";
ob_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <SCRIPT LANGUAGE="JavaScript" SRC="js/group.js"></SCRIPT>       

<div class="add">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">X</div>
            <form  action="index.php?action=add" method="post">
            <div class="form-label-group">
                <label for=""> Ajouter des contacts</label><br>
                <?php foreach ($contacts as $add): ?>
                    <input type="checkbox" name="addContacts[]" value="<?= $add['id'] ?>"><?= $add['id'] ?>
                <?php endforeach; ?>
                <input type="submit" value="Ajouter" name="ajouter">
            </form>
            </div>
    </div>
    
 
</div>
   
<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>