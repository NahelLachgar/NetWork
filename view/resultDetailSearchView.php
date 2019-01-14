<?php 
$title = "Recherche";
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
        

    </form>
    <br><br>
        <?php
           if(!empty($res)):
            foreach ($res as $result) : 
                    if(in_array($result['contactId'],$contact)):
                        if($result['status'] == 'employee') :
            ?>
            <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $result['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                        <form action="index.php?action=profilePage" method="POST">
                            <input type="hidden" name="contactId" value="<?= $result['contactId'] ?>"> 
                            <input type="hidden" name="token" value="0">
                            <input type="submit" class="btn btn-link" value="<?= $result['name'] . ' ' . $result['lastName'] ?>"> 
                        </form></h5>
                        <p class="card-text"><?= $result['job'] . ' chez ' . $result['company'] ?></p>
                        <form action="index.php?action=removeContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$result['contactId']?>">
                            <button type="submit" class="btn btn-link"><img src="./img/icon/unfriend.png"></button> 
                        </form>
                    </div>
            </div>
            </a> <br>
            <?php else: ?>
            <div class="card gedf-card">
                    <div class="card-body">       
                        <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $result['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                        <form action="index.php?action=profilePage" method="POST">
                            <input type="hidden" name="contactId" value="<?= $result['contactId'] ?>"><input type="hidden" name="token" value="0"> 
                            <input type="submit" class="btn btn-link" value="<?= $result['name'] . ' ' . $result['lastName'] ?>"> </form></h5>
                        </form>
                        <form action="index.php?action=removeContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$result['contactId']?>">
                            <button type="submit" class="btn btn-link">Ne plus suivre</button>
                        </form>
                    </div>
            </div></a> <br>
                <?php endif; 
                    else:  
                    if($result['status'] == 'employee') :
                        ?>
                <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $result['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                        <form action="index.php?action=profilePage" method="POST">
                            <input type="hidden" name="contactId" value="<?= $result['contactId'] ?>">
                            <input type="hidden" name="token" value="1"> 
                            <input type="submit" class="btn btn-link" value="<?= $result['name'] . ' ' . $result['lastName'] ?>"> </form></h5>
                        <p class="card-text"><?= $result['job'] . ' chez ' . $result['company'] ?></p>
                        <form action="index.php?action=addContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$result['contactId']?>">
                            <button type="submit" class="btn btn-link"><img src="./img/icon/users.png"></button>
                        </form>
                    </div>
            </div>
            </a> <br>
            <?php else: ?>

            <div class="card gedf-card">
                    <div class="card-body">     
                    <form action="index.php?action=profilePage" method="POST">

                        <h5 class="card-title"><img class="rounded-circle" width="45" src="./img/profile/<?= $result['photo'] ?>" alt="Photo de profil">&nbsp&nbsp&nbsp
                            <input type="hidden" name="contactId" value="<?= $result['contactId'] ?>">
                            <input type="hidden" name="token" value="1">
                            <input type="submit" class="btn btn-link" value="<?= $result['name'] . ' ' . $result['lastName'] ?>"> 
                        </form></h5>
                        <form action="index.php?action=addContact" method="POST">
                            <input type="hidden" name="contactId" value="<?=$result['contactId']?>">
                            <button type="submit" class="btn btn-link">Suivre</button>
                        </form>
                    </div>
            </div></a> <br>
            <?php endif;
            endif;
            endforeach;
        else: ?>
        <center><div class="card gedf-card">
            <div class="card-body">       
           <b> Aucun resultat trouvé </b>
            </div></center>
<?php
endif;
$content = ob_get_clean();
require_once('view/template.php');
?>