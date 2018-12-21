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
            <form method="POST" action="index.php?action=addContactsToGroups" >
                Ajouter des contacts<br>
                <div>
                <?php foreach ($res as $add): ?>
                    <input type="checkbox" id="<?= $add['id'] ?>" name="addContacts[]" value="<?= $add['id'] ?>">
                    <label for="<?= $add['id'] ?>"><?= $add['lastName'] ?> <?= $add['name'] ?></label><br>
                <?php endforeach; ?>
                </div>
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="ajouter" value="Ajouter">
            </form>
        </div>
    </div>
    
 
</div>
   
<?php 
    $content = ob_get_clean();
    require('view/template.php');
?>