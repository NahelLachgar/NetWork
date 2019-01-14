<?php 
$title = "Accueil";
ob_start();
?>

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
        
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>


<!-- PROFIL-->
    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body"></div>
                        <div class="h5"><img class="rounded-circle" width="45" src="./img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
						<?= $profile['name'] . ' ' . $profile['lastName'] ?></div>
                        <div class="h7">
                            <?= $profile['job'] . ' chez ' . $profile['company'] ?>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h6 text-muted">Entreprises</div>
                            <div class="h5"><?= $followedCompaniesNb ?></div>
                        </li>
                        <li class="list-group-item">
                            <form action="index.php?action=contactContacts" method="POST">
                            <input type="hidden" name="id" value="<?=$profile['id']?>">
                            <button type="submit" class="btn btn-link">Contacts</button>
                            </form>
                            <div class="h5"><?= $contactsNb ?></div>
                        </li>
                        <li class="list-group-item">
                           <?php if($pass == 0 || $pass == 2): ?>

                         <form action="index.php?action=removeContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$profile['id']?>">
                            <button type="submit" class="btn btn-link" ><img src="./img/icon/unfriend.png"></button>
                         </form>
                            <?php elseif($pass == 1): ?>
                        <form action="index.php?action=addContact" method="POST" >
                            <input type="hidden" name="contactId" value="<?=$profile['id']?>">
                            <button type="submit" class="btn btn-link" ><img src="./img/icon/users.png"></button>
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
                                    <img class="rounded-circle" width="45" src="./img/profile/<?= $postsFetch['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
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
                            <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?= $postsFetch['postDate'] ?></div>
                            <p class="card-text">
                                <?= $postsFetch['content'] ?>
                            </p>
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