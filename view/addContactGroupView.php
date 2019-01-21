<?php 
$title = "Groupe";
ob_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/group.css" />
        <script src="https://www.google.com/jsapi"></script>
        <SCRIPT SRC="js/group.js"></SCRIPT>       

<!-- Arriere plan -->
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

        </div>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title=" Creer votre cercle plus personnel ! Creer votre groupe ;-) !">
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
                <?php if($res != FALSE):
                foreach ($res as $add): ?>
                    <input type="checkbox" id="<?= $add['id'] ?>" name="addContacts[]" value="<?= $add['id'] ?>">
                    <label for="<?= $add['id'] ?>"><?= $add['lastName'] ?> <?= $add['name'] ?></label><br>
                <?php endforeach; ?>
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="ajouter" value="Ajouter">
                <?php else:
                echo "Vous n'avez aucun contact! ";
                endif;?>
                </div>
            </form>
        </div>
    </div>
    
 
</div>
   
<?php 
    $content = ob_get_clean();
    require_once('view/template.php');
?>