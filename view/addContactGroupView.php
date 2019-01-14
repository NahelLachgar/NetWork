<?php 
$title = "Groupe";
ob_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script src="https://www.google.com/jsapi"></script>
        <SCRIPT SRC="js/group.js"></SCRIPT>       

<!-- Arriere plan -->
<div class="container">
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <br><h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Vos groupes</span></h4>
        </div>
        <div class="col-md-8 order-md-1">
            <a class="trigger_popup_fricc"><button class="btn btn-link">Créer un groupe</button></a>

            <div class="hover_bkgr_fricc">
                <span class="helper"></span>
                <div>
                    <div class="popupCloseButton">X</div>
                    <form name="form" action="index.php?action=createGroup" method="POST">
                        
                        <div class="mb-3">
                            <label for="name">Nom du groupe</label>
                            <input type="text" class="form-control" id="name" name="nameG" placeholder="" include_onced>
                            <div class="invalid-feedback">
                            
                            </div>
                            <span id="aideName"></span>
                        </div>
                    
                    <a class="creer"><button class="btn btn-primary btn-lg btn-block" name="creer" type="submit">Créer</button></a></form>
                </div>
                
            
            </div>
        </div>
    </div>
</div>
<!-- popup AJOUT DES CONTACTS-->
<div class="add">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">X</div>
            <form method="POST" action="index.php?action=addContactsToGroups" >
            <input type="hidden" name="groupId" value="<?= $create ?>">
            <input type="hidden" name="statut" value="2">
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
    include_once('view/template.php');
?>