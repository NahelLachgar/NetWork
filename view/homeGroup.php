<?php 
$title = "Groupe";
ob_start();
?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <SCRIPT LANGUAGE="JavaScript" SRC="js/group.js"></SCRIPT>       
<?php
if($state=='activated') {
?>
<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5">
                    <img class="rounded-circle" width="45" src="./img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                    <?= $profile['name'] . ' ' . $profile['lastName'] ?></div>
                    <div class="h7">
                        <?= $profile['job'] . ' chez ' . $profile['company'] ?>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=companyList">Entreprises</a></div>
                        <div class="h5"><?= $followedCompaniesNb ?></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=contactList">Contacts</a></div>
                        <div class="h5"><?= $contactsNb ?></div>
    
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=updateProfile">Modifier le profil</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=deleteView">Supprimer le compte</a></div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a href="index.php?action=disconnect">Déconnexion</a></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 gedf-main">
            <br><h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Vos groupes</span></h4>
            
            <?php 
            if($adminGroup):
                if ($adminGroup['0']['admin'] == $_SESSION['id']) : ?>

                <?php foreach ($adminGroup as $groupAdmin) : ?>
                <form method="POST" action="index.php?action=groupsManage">
                    <input type="hidden" name="groupId" value="<?= $groupAdmin['id'] ?>" >
                    <input type="hidden" name="adminGroup" value="<?= $groupAdmin['admin'] ?>" >
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
            endif;  ?>
            <?php
                if(!$adminGroup):
                    
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
                        echo "Vous n'appartenez à aucun groupe.";
                    }
                ?>
        </div>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title=" Creer votre cercle restreint ! Creer votre groupe ;-) !">
            <a class="trigger_popup_fricc"><button class="btn btn-primary btn-lg btn-block" style="pointer-events: none;" type="button" disabled>Créer un groupe</button></a>
            </span>

            <div class="hover_bkgr_fricc">
                <span class="helper"></span>
                <div>
                    <div class="popupCloseButton">X</div>
                    <form name="form" enctype="multipart/form-data" action="index.php?action=createGroup" method="POST">
                        
                        <div class="mb-3">
                            <label for="name">Nom du groupe</label>
                                <input type="text" class="form-control" id="name" name="nameG" placeholder="" require_onced>
                            <div class="invalid-feedback">                            
                            </div>
                            <span id="aideName"></span>
                        </div>
                        <div class="mb-3">
                            <label for="photo">Photo du groupe</label>
                                <input type="file" class="form-control" id="photo" name="photo" placeholder="" require_onced>
                        </div>
                    <a class="creer"><button class="btn btn-primary btn-lg btn-block" name="creer" type="submit">Créer</button></a></form>
                </div>
                
            
            </div>
    </div>
</div>
<?php
}
else {
    echo "<br/><center>Votre compte est désactivé. Vous devez le réactiver pour pouvoir accéder à cette fonctionnalité.</center>";
}
$content = ob_get_clean();
require_once('view/template.php');
?>