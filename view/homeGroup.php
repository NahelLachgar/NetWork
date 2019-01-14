<?php 
$title = "Groupe";
ob_start();
?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <SCRIPT LANGUAGE="JavaScript" SRC="js/group.js"></SCRIPT>       

<div class="container">
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <br><h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Vos groupes</span></h4>
            
            <?php
            if($adminGroup):
                if ($adminGroup['0']['admin'] == $_SESSION['id']) : ?>

                <?php foreach ($adminGroup as $groupAdmin) : ?>
                <form method="POST" action="index.php?action=groupsManage">
                    <input type="hidden" name="groupId" value="<?= $groupAdmin['id'] ?>" >
                    <input type="submit" class="btn btn-link" value="<?= $groupAdmin['title'] ?>" >
                </form><br>
                <?php endforeach; ?>

                <?php endif; ?>
            <?php 
            foreach ($groups as $group) : ?>
                <form method="POST" action="index.php?action=getGroupId">
                    <input type="hidden" name="groupId" value="<?= $group['group'] ?>" >
                    <input type="submit" class="btn btn-link" value="<?= $group['title'] ?>" >
                </form><br>
            <?php endforeach; 
            else:
            echo "";
            endif; ?>
            <?php
                if($groups):
                    
                foreach ($groups as $group) : ?>
                    <form method="POST" action="index.php?action=getGroupId">
                        <input type="hidden" name="groupId" value="<?= $group['group'] ?>" >
                        <input type="submit" class="btn btn-link" value="<?= $group['title'] ?>" >
                    </form><br>
                <?php endforeach; 
                else:
                echo "";
                endif; ?>
                <?php 
                    if(empty($groups) && empty($adminGroup)){
                        echo "Vous n'avez aucun groupe";
                    }
                ?>
        </div>
        <div class="col-md-8 order-md-1">
            <a class="trigger_popup_fricc"><button class="btn btn-link">Créer un groupe</button></a>

            <div class="hover_bkgr_fricc">
                <span class="helper"></span>
                <div>
                    <div class="popupCloseButton">X</div>
                    <form name="form" enctype="multipart/form-data" action="index.php?action=createGroup" method="POST">
                        
                        <div class="mb-3">
                            <label for="name">Nom du groupe</label>
                                <input type="text" class="form-control" id="name" name="nameG" placeholder="" include_onced>
                            <div class="invalid-feedback">                            
                            </div>
                            <span id="aideName"></span>
                        </div>
                        <div class="mb-3">
                            <label for="photo">Photo du groupe</label>
                                <input type="file" class="form-control" id="photo" name="photo" placeholder="" include_onced>
                        </div>
                    <a class="creer"><button class="btn btn-primary btn-lg btn-block" name="creer" type="submit">Créer</button></a></form>
                </div>
                
            
            </div>
        </div>
    </div>
</div>
   
<?php 
$content = ob_get_clean();
include_once('view/template.php');
?>