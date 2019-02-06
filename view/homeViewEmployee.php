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
                    <?php	
 if($_SESSION['state']=='activated') {	
    echo "<div class='h5'>";	
}	
else {	
    echo "<div class='h5' style='color:#798081;'>";	
}	
?>
                        <img class="rounded-circle" width="45" src="../img/profile/<?= $profile['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
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
                            <div class="h6 text-muted"><a href="index.php?action=deleteView">Gérer le compte</a></div>
                        </li>
                        <li class="list-group-item">
                            <div class="h6 text-muted"><a href="index.php?action=disconnect">Déconnexion</a></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 gedf-main">
            <?php	
            if($_SESSION['state']=='activated') {	
            ?>
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
                            <div id="<?=$contactsPosts[$i]['id']?>" class="card gedf-card">
                                <div class="card-header">
                                <?php if ($contactsPosts[$i]['contactId'] == $_SESSION['id']):?>
                                    <input type="hidden" class="postId" name="comId" value="<?= $contactsPosts[$i]['id']?>">

                                        <button type="submit" class="deletePost btn btn-link">
                                            <span><img width=15 src="../img/icon/cross.svg"></span>
                                        </button>
                                   <?php endif?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <?php if ($contactsPosts[$i]['contactId'] !== $_SESSION['id']) : ?>
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="45px" src="../img/profile/<?= $contactsPosts[$i]['photo'] ?>" alt="Photo de profil">
                                                </div>
                                            <?php else : ?>
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="45px" src="../img/profile/<?= $profile['photo'] ?>" alt="photo de profil">
                                                </div>
                                            <?php endif ?>
                                            <div class="ml-2"> 
                                            <?php if ($contactsPosts[$i]['contactId'] !== $_SESSION['id']) : ?>
                                                <form action="index.php?action=profilePage" method="POST">
                                            <input type="hidden" name="contactId" value="<?= $contactsPosts[$i]['id'] ?>">
                                                    <input type="hidden" name="token" value="0">
                                                    <div class="h5 m-0">
                                                        <button style="color:black;font-size:1.1em;text-decoration:none" type="submit" class="btn btn-link">
                                                            <?= $contactsPosts[$i]['name'] . ' ' . $contactsPosts[$i]['lastName'] ?>
                                                        </button>
                                                    </div>
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
                                                    <img  width="100%" src="../img/posts/<?= $contactsPosts[$i]['content'] ?>" alt="photo">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div> <!-- CARD BODY -->
                                <!-- commentaires-->
                                <div class="card-footer">
                               <?php for($j=0;$j<count($comments);$j++) :
                                        if ($comments[$j]['postId'] == $contactsPosts[$i]['id']):?>
                                <p>
                                    <ul style="display:inline" class="list-group list-group-flush">
                                    <?php if ($comments[$j]['user'] == $_SESSION['id']|| $contactsPosts[$i]['contactId'] == $_SESSION['id']):?>
                                    <input type="hidden" class="comId" name="comId" value="<?= $comments[$j]['id']?>">

                                        <button type="submit" class="deleteCom btn btn-link">
                                            <span><img width=15 src="../img/icon/cross.svg"></span>
                                        </button>
                                  <?php endif?>
                                        <li style="list-style:none"> 
                                            <img class="rounded-circle" width="45px" src="../img/profile/<?=$comments[$j]['photo'] ?>" alt="photo de profil">&nbsp 
                                            <a href=""><?=$comments[$j]['name']. ' '.$comments[$j]['lastName']?></a>
                                         <span class="coms"><?= $comments[$j]['content'] ?></span>
                                        </li>                      
                                </ul>
                                </p>
                                <?php 
                                    endif;
                                    endfor;
                                ?>
                                </div>
                                <!-- -->
                                    <div class="input-group">
                                        <input type="text" name="comment" placeholder="Écrivez un commentaire" class="comment form-control"  aria-describedby="button-addon2">
                                        <input type="hidden" name="postId" value="<?= $contactsPosts[$i]['id'] ?>">
                                        <input type="hidden" name="contactPostId" value="<?= $contactsPosts[$i]['contactId'] ?>">
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-primary" id="sendComment">
                                            <i class="fa fa-comment"></i>
                                        </button>
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
<?php	
 }	
else {	
    echo "<br/><center>Votre compte est désactivé. Vous devez le réactiver pour pouvoir accéder à cette fonctionnalité.</center>";	
}	
?>

    </div>
    <script type="text/javascript" src="https://unpkg.com/onscreen/dist/on-screen.umd.min.js"></script>
    <script type="text/javascript">
        var os = new OnScreen();
    </script>
    <script>
    $(document).ready(function(){
        $(".deleteCom").click(function(e){
            e.preventDefault();
            comId = $(this).siblings('.comId').val();
            console.log(comId);
            
          $(this).parents('.card-footer').hide();
         $.ajax({
				url : "index.php?action=deleteCom", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "comId=" + comId // et on envoie nos données
				});
        });

    $(".deletePost").click(function(e){
                e.preventDefault();
                postId = $(this).parents('.card').attr('id');
                $(this).parents('.card').hide();
                $.ajax({
                    url : "index.php?action=deletePost", // on donne l'URL du fichier de traitement
                    type : "POST", // la requête est de type POST
                    data : "postId=" + postId // et on envoie nos données
                    }); 
    });

    $("#sendComment").click(function(e){
            e.preventDefault();
            comment = $(this).parents('div').siblings('.comment').val();
            postId = $(this).parents().eq(2).attr('id');
			if ($.trim(comment) != "") {			
                $.ajax({
                    url : "index.php?action=comment", // on donne l'URL du fichier de traitement
                    type : "POST", // la requête est de type POST
                    data : "postId=" + postId + "&comment=" + comment, // et on envoie nos données
                    dataType : "html",
                    success : function(html){
                        $("#51 .card-footer").append(html);
                    }
                    });
                    $(this).parents('div').siblings('.comment').val("");
                }



    });
});
    </script>
    <?php 
    $content = ob_get_clean();
    require_once('view/template.php');
    ?>