<?php 
$title = "Accueil";
ob_start();
?>
<!-- PROFIL-->
<div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="h5"><img class="rounded-circle" width="45" src="../img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
						<?= $profile['name'] . ' ' . $profile['lastName'] ?></div>
                        <div class="h7">
                            <?= $profile['job'] . ' chez ' . $profile['company'] ?>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h6">Entreprises</div>
                            <div class="h5"><?= $followedCompaniesNb ?></div>
                        </li>
                        <li class="list-group-item">
                        <div class="h6">Contacts</div>                            <div class="h5"><?= $contactsNb ?></div>
                        </li>
                        <li class="list-group-item">
                           <?php if($pass == 0 || $pass == 2): ?>

                         <form action="index.php?action=removeContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$profile['id']?>">
                            <button type="submit" class="btn btn-link" ><img src="../img/icon/unfriend.png"></button>
                         </form>
                            <?php elseif($pass == 1): ?>
                        <form action="index.php?action=addContact" method="POST" >
                            <input type="hidden" name="contactId" value="<?=$profile['id']?>">
                            <button type="submit" class="btn btn-link" ><img src="../img/icon/users.png"></button>
                        </form>
                        <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 gedf-main">
            <!------------------->

                
               

                <!--- ---------FIL D'ACTUALITÉ--------- -->
                <div class="text-center">
                    <?php 
                    if ($contactPosts) :
                    while($postsFetch = $contactPosts->fetch()) :
                    ?>
                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="../img/profile/<?= $postsFetch['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0"><?= $postsFetch['name'] . ' ' . $postsFetch['lastName'] ?></div>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                                    <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?= strftime("Le %d %b à %R", strtotime($postsFetch['postDate'])) ?></div>
                                    <div class="card-text">
                                        <?php if ($postsFetch['type'] == "text") : ?>
                                            <?= $postsFetch['content'] ?>
                                        <?php else : ?>
                                            <div class="row justify-content-center">
                                                <div>
                                                    <div class="col-md-12">
                                                    <img  width="100%" src="../img/posts/<?= $postsFetch['content'] ?>" alt="photo">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div> 
                        <div class="card-footer">
                        <form action="index.php?action=comment" method="post">
                            <div class="input-group">
                                <input type="text" name="comment" placeholder="Écrivez un commentaire" class="form-control"  aria-describedby="button-addon2">
                                <input type="hidden" name="postId" value="<?=$postsFetch['id']?>">
                                <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit"  id="button-addon2">
                                    <i class="fa fa-comment"></i>
                                </button>
                         </form>
                </div>
                </div>
                        </div>
                    </div>
                    <?php 
                    endwhile;
                 else :
                    echo $profile['name'].' n\'a rien publié.';
                 endif;
                    ?>
                </div>
            </div>
    </div>
    <?php 
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>