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
                        <div class="h5"><img class="rounded-circle" width="45" src="./img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp<!-- src="https://picsum.photos/50/50" -->
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
            <!------------------->
        <div style="overflow: scroll; height:1000px" class="posts">
                <!--- PUBLICATION-->
                <div class="card gedf-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Publication</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Image</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body"><?php if(!empty($errorExt)): echo "<i><h6 style='color:red;'>".$errorExt."</h6></i>"; endif ?>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">Publier</label>
                                    <form enctype="multipart/form-data" action="index.php?action=post" method="POST">
                                    <textarea name="content"  class="form-control" id="message" rows="3" placeholder="Que souhaitez-vous publier ?"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" name="photo" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Publiez une image</label>
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
                    if (isset($contactsPosts)) {
                        if ($contactsPosts > 1) {
                            for ($i = 0; $i < count($contactsPosts); $i++) :
                            ?>
                            <div class="card gedf-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <?php if ($contactsPosts[$i]['contactId'] !== $_SESSION['id']) : ?>
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="45px" src="./img/profile/<?= $contactsPosts[$i]['photo'] ?>" alt="photo de profil">
                                                </div>
                                            <?php else : ?>
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="45px" src="./img/profile/<?= $profile['photo'] ?>" alt="photo de profil">
                                                </div>
                                            <?php endif ?>
                                            <div class="ml-2"> 
                                            <?php if ($contactsPosts[$i]['contactId'] !== $_SESSION['id']) : ?>
                                                <form action="index.php?action=profilePage" method="POST">
                                                    <div class="h5 m-0"><button style="color:black;font-size:1.1em;text-decoration:none" type="submit" class="btn btn-link"><?= $contactsPosts[$i]['name'] . ' ' . $contactsPosts[$i]['lastName'] ?></button></div>
                                                    <input type="hidden" name="contactId" value="<?= $contactsPosts[$i]['id'] ?>">
                                                    <input type="hidden" name="token" value="0">
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
                                    <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?= strftime("Le %d %b à %R", strtotime($contactsPosts[$i]['postDate'])) ?></div>
                                    <div class="card-text">
                                        <?php if ($contactsPosts[$i]['type'] == "text") : ?>
                                            <?= $contactsPosts[$i]['content'] ?>
                                        <?php else : ?>
                                            <div class="row justify-content-center">
                                                <div>
                                                    <div class="col-md-12">
                                                    <img  width="100%" src="./img/posts/<?= $contactsPosts[$i]['content'] ?>" alt="photo de profil">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div> <!-- CARD BODY -->
                                <!-- commentaires-->
                                <div class="card-footer">
                                <p>
                                    <ul style="display:inline" class="list-group list-group-flush">
                                        <li style="list-style:none"> 
                                            <img class="rounded-circle" width="45px" src="./img/profile/<?= $profile['photo'] ?>" alt="photo de profil">
                                            <span class="h6 m-0">Prénom Nom</span>
                                            <li class="list-group-item">Commentaire</li>
                                        </li> 
                                </div>
                                <div class="card-footer">
                                    <li style="list-style:none"> 
                                        <img class="rounded-circle" width="45px" src="./img/profile/<?= $profile['photo'] ?>" alt="photo de profil">
                                        <span class="h6 m-0">Prénom Nom</span>
                                        <li class="list-group-item">Commentaire</li>
                                    </li> 
                                </ul>
                                </p>
                                <!-- -->
                                <form action="index.php?action=comment" method="post">
                                    <div class="input-group">
                                        <input type="text" name="comment" placeholder="Écrivez un commentaire" class="form-control"  aria-describedby="button-addon2">
                                        <input type="hidden" name="postId" value="<?= $contactsPosts[$i]['id'] ?>">
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
                            endfor;
                        } else {
                            echo "abcd";
                        }
                    } else {
                        echo ("Vous n'avez aucune publication a afficher");
                    }
                    ?>
                </div>
            </div>
                </div>
                <!--------------------------------->


               



<!--------- SUGGESTIONS DE CONTACTS----------->

<?php
if (isset($employeesSuggests)) :
    if (count($employeesSuggests) > 1) : ?>
            <div class="col-md-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
 <!-------> 
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
<!------->
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
  <div class="carousel-item active">
    <div class="card gedf-card">
                    
                    <div class="card-body">
                    <center>
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $employeesSuggests[0]['photo'] ?>" alt="" />
                    <h5 class="card-title"><?= $employeesSuggests[0]['name'] . ' ' . $employeesSuggests[0]['lastName'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $employeesSuggests[0]['job'] . ' chez ' . $employeesSuggests[0]['company'] ?></h6>
                    <a href="index.php?action=addcontacts&id=<?= $employeesSuggests[0]['id'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
</center>
                    </div>
                    </div>   

  <!------->

    <div class="carousel-item">
    <div class="card gedf-card">
                    <div class="card-body">
                    <center>
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $employeesSuggests[1]['photo'] ?>" alt="" />
                    <h5 class="card-title"><?= $employeesSuggests[1]['name'] . ' ' . $employeesSuggests[1]['lastName'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $employeesSuggests[1]['job'] . ' chez ' . $employeesSuggests[0]['company'] ?></h6>
                    <a href="index.php?action=addcontacts&id=<?= $employeesSuggests[1]['id'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
</center>
                    </div>
                    </div>   

                    <div class="carousel-item">
    <div class="card gedf-card">
                    
                    <div class="card-body">
                    <center>
                    <img class="rounded-circle" width="45"src="./img/profile/<?= $employeesSuggests[1]['photo'] ?>" alt="" />
                    <h5 class="card-title"><?= $employeesSuggests[1]['name'] . ' ' . $employeesSuggests[1]['lastName'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $employeesSuggests[1]['job'] . ' chez ' . $employeesSuggests[1]['company'] ?></h6>
                    <a href="index.php?action=addcontacts&id=<?= $employeesSuggests[1]['id'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
</center>
                    </div>
                    </div>   


</div>


<!------->  
   
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
                </div>    
                            <?php endif;
                            endif;
                            ?>


            <!--------------------------> 
<br>
            <!--------- SUGGESTIONS D'ENTREPRISE----------->
            <?php 
            if (isset($companiesSuggests)) :
                if (count($companiesSuggests) > 1) : ?>

            <div class="col-md-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <?php for ($i = 0; $i < count($companiesSuggests) - 1; $i++) : ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $companiesSuggests[$i]['name'] ?>"></li>
                <?php endfor ?>
            </ol>
            <div class="carousel-innitemer">
                <div class="carousel- active">
                <div class="card gedf-card">
                        <div class="card-body">
                            <center>
                        <img class="rounded-circle" width="45"src="./img/profile/<?= $companiesSuggests[$i]['photo'] ?>" alt="" />
                                    <h5 class="card-title"><?= $companiesSuggests[0]['name'] . ' ' . $companiesSuggests[0]['lastName'] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= $companiesSuggests[0]['job'] . ' chez ' . $companiesSuggests[0]['company'] ?></h6>
                                    <form action="index.php?action=addContact" method="POST">
                                    <input type="hidden" name="contactId" value="<?= $companiesSuggests[0]['id'] ?>">
                                        <button type="submit" class="btn btn-link" name="contactId" value="<?= $companiesSuggests[0]['id'] ?>"> <img src="./img/icon/users.png"></button>
                                    </form>
                            </center>
                        </div>
                    </div>
                </div>
                <?php 
                for ($i = 0; $i < count($companiesSuggests); $i++) : ?>
                <div class="carousel-item">
                <div class="card gedf-card">
                    
                                    <div class="card-body">
                                    <center>
                                    <img class="rounded-circle" width="45"src="./img/profile/<?= $companiesSuggests[$i]['photo'] ?>" alt="" />
                                    <h5 class="card-title"><?= $companiesSuggests[$i]['name'] . ' ' . $companiesSuggests[$i]['lastName'] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= $companiesSuggests[$i]['job'] . ' chez ' . $companiesSuggests[$i]['company'] ?></h6>
                                    <a href="index.php?action=addcontacts&id=<?= $companiesSuggests[$i]['id'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
            </center>
                                    </div>
                </div>    
                </div> 
                <?php endfor; ?>
                

                
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
                            <?php elseif (count($companiesSuggests) == 1) : ?>
                            <div class="card gedf-card">
                                    <div class="card-body">
                                    <center>
                                    <img class="rounded-circle" width="45"src="./img/profile/<?= $companiesSuggests[0]['photo'] ?>" alt="" />
                                    <h5 class="card-title"><?= $companiesSuggests[0]['name'] . ' ' . $companiesSuggests[0]['lastName'] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= $companiesSuggests[0]['job'] . ' chez ' . $companiesSuggests[0]['company'] ?></h6>
                                    <a href="index.php?action=addcontacts&id=<?= $companiesSuggests[0]['id'] ?>" class="card-link"> <img src="./img/icon/users.png"> </a>
            </center>

                                    </div>
                </div>    
                            <?php endif;
                            endif;
                            ?>
<!--------------------------> 

 
    </div>
    <?php 
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>