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
                    <div class="card-body">
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $profile['photo'] ?>" alt="" />
						<?= $profile['name'] ?></div>
                        <div class="h6">
                            <ul class="list-group list-group-flush">
                                <li>
                                    <?= $profile['company'] ?>
                                </li>
                                <li>
                                    <?= $profile['town'] ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h6 text-muted"><a href="index.php?action=contactList">Contacts</a></div>
                            <div class="h5"><?= $contactsNb ?></div>
        
                        </li>
                        <li class="list-group-item">
                            <div class="h6 text-muted"><a href="index.php?action=updateProfile">Modifier le profil</a></div>
                        </li>
                        <li class="list-group-item">
                            <div class="h6 text-muted"><a href="index.php?action=disconnect">Déconnexion</a></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 gedf-main">
            <!------------------->

                <!--- PUBLICATION-->
                <div class="card gedf-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                    a publication</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">Post</label>
                                    <form action="index.php?action=post" method="POST">
                                    <textarea name="content" class="form-control" id="message" rows="3" placeholder="Que souhaitez-vous publier ?" require_onced></textarea>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Upload image</label>
                                    </div>
                                </div>
                                <div class="py-4"></div>
                            </div>
                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group">
                                <input type="hidden" name="type" value="text">
                                <button type="submit" class="btn btn-primary">Publier</button>
                                </form>
                            </div>
                            <div class="btn-group">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------->

          
               

                <!--- ---------FIL D'ACTUALITÉ--------- -->
                <div>
                    <?php 
                    if ($contactsPosts) :
                    for ($i = 0; $i < count($contactsPosts); $i++) :
                    ?>
                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                    <img class="rounded-circle" width="45"src="./img/profile/<?= $contactsPosts[$i]['photo'] ?>" alt="" />
                                    </div>
                                    <div class="ml-2"> 
                                        <?php if ($contactsPosts[$i]['contactId'] !== $_SESSION['id']): ?>
                                        <form action="index.php?action=profilePage" method="POST">
                                            <div class="h5 m-0"><button type="submit" class="btn btn-link"><?= $contactsPosts[$i]['name'] . ' ' . $contactsPosts[$i]['lastName'] ?></button></div>
                                            <input type="hidden" name="contactId" value="<?= $contactsPosts[$i]['id']?>">
                                        </form>
                                        <?php else : ?>
                                        <div class="h5 m-0"><?= $contactsPosts[$i]['name'] . ' ' . $contactsPosts[$i]['lastName'] ?></div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?= strftime("Le %d %b à %R",strtotime($contactsPosts[$i]['postDate'])) ?></div>
                            <div class="card-text">
                                <?php if ($contactsPosts[$i]['type'] == "text"): ?>
                                    <?= $contactsPosts[$i]['content'] ?>
                                <?php else : ?>
                                    <div class="row justify-content-center">
                                        <div>
                                            <div class="col-md-12">
                                                <img  width="600" src="./img/posts/<?= $contactsPosts[$i]['content'] ?>" alt="photo de profil">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div> <!-- CARD BODY -->
                        <div class="card-footer">
                        <form action="index.php?action=comment" method="post">
                            <div class="input-group">
                                <input type="text" name="comment" placeholder="Écrivez un commentaire" class="form-control"  aria-describedby="button-addon2">
                                <input type="hidden" name="postId" value="<?=$contactsPosts[$i]['id']?>">
                                
                            <input type="hidden" name="company" value=" ">
                                <button class="btn btn-outline-primary" type="submit"  id="button-addon2">
                                    <i class="fa fa-comment"></i>
                                </button>
                        </form>
                        
                </div>
                </div>
                        </div>
                    </div>
                    <?php 
                    endfor;
                 else :
                    echo("Vous n'avez aucune publication a afficher");
                 endif;
                    ?>
                </div>
            </div>
                <!--------------------------------->
    </div>
    <?php 
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>