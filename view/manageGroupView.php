<?php 
$title = "Groupe";
ob_start();
?>


<div class="container">
      <div class="py-12 text-center">
        <h2>Modification groupe</h2>
        <p class="lead"></p>
      </div>
        <br>
      <div class="row">
        <div class="col-md-12">
        
          <form enctype="multipart/form-data" action="index.php?action=updateGroup" method="POST">   
              <div class="row justify-content-center">
                  <div class="col-md-12-center">
                      <img class="rounded-circle border border-dark shadow bg-white rounded" width="150" src="./img/groups/<?= $group['photo'] ?>" alt="Photo du groupe" id="photoUpdate">
                        <input style="display:none" type="file" class="form-control-file" name="photo" id="photoUpdateFile"> 
                  </div>
              </div>   
          </div>      
          <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
                //jQuery(function($){
                //  $('#photoUpdateFile').click(function(e){
                //  });
                    
                    $('#photoUpdate').click(function(e){
                        $('#photoUpdateFile').click(); // équivalent de  $('#lien1').click();
                    });
                // });
            </script>
  </div>
  <div class="row justify-content-center">
              <div class="col-md-3 mb-3">
                <label for="lastName">Nom du groupe</label>
                <input type="text" class="form-control" id="groupName" name="groupName" value="<?= $group['title'] ?>">
              </div>
              <div class="col-md-3 mb-3">
                <label for="admin">Administrateur:</label><br>
                <select id="admin" class="form-control" name="newAdmin">
                    <option value="<?= $_SESSION['id'] ?>" selected>Vous</option>
                    <?php foreach( $res as $member) :?>
                        <option value="<?=$member['id']?>"><?= $member['name']." ".$member['lastName'] ?> </option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
          
            <input type="hidden" name="groupId" value="<?= $group['group'] ?>">
            <input type="hidden" name="lastAdmin" value="<?= $adminG ?>">

          <div class="row justify-content-center">
              <div class="col-md-2">
                  <button class="btn btn-primary btn-lg btn-block" name="update" type="submit">Modifier</button>
              </div>       
          </form>
    
          <div class="col-md-2">
                <form action="index.php?action=deleteGroup" method="POST">
                    <input type="hidden" name="groupId" value="<?= $group['group'] ?>">
                  <button class="btn btn-danger btn-lg btn-block" name="delete" type="submit">Supprimer</button>
                </form>
              </div>

              <div class="col-md-2">
                <form action="index.php?action=deleteGroup" method="POST">
                    <button class="btn btn-secondary btn-lg btn-block" name="update" type="submit">Retour</button>
                </form>
              </div>  
        </div>
              <hr>

            <div class="py-12 text-center">
                <h5>Membre(s) du groupe</h5>
                <p class="lead"></p>
            </div>

              <?php if(!empty($res)) : ?>

            <div class="row">
                <?php foreach( $res as $member) :?>
                    <div class="col-md-2 mb-3">
<?php
$stateSearch = checkActive($member['id']);
if($stateSearch=='activated') {
    echo "<div>".$member['name']." ".$member['lastName']."</div>";
}
else {
    echo "<div style='color:#798081'>".$member['name']." ".$member['lastName']."</div>";
}
?>
                        <form action="index.php?action=removeToGroups" method="POST">
                            <input type="hidden" name="contactId" value="<?=$member['id']?>">
                            <input type="hidden" name="groupId" value="<?= $idGroup ?>">
                            <input type="hidden" name="adminGroup" value="<?= $adminG ?>">
                            <button type="submit" class="btn btn-link">retirer du groupe</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div> 

            <?php else :
                echo "Aucun de vos contacts est dans ce groupe.";
                
                endif;
            ?>

            <hr>

            <div class="py-12 text-center">
                <h5>Suggestion de membre</h5>
                <p class="lead"></p>
            </div>

            <?php if(!empty($contactProfile)) : ?>
        
            <div class="row">
                <?php foreach ($contactProfile as $contact) :?>
                    <div class="col-md-2 mb-3">
<?php
$stateSearch = checkActive($contact['id']);
if($stateSearch=='activated') {
    echo "<div>".$contact['name']." ".$contact['lastName']."</div>";
}
else {
    echo "<div style='color:#798081'>".$contact['name']." ".$contact['lastName']."</div>";
}
?>
                        <form action="index.php?action=addToGroup" method="POST">
                            <input type="hidden" name="addContact" value="<?=$contact['id']?>">
                            <input type="hidden" name="statut" value="2">
                            <input type="hidden" name="groupId" value="<?= $idGroup ?>">
                            <input type="hidden" name="adminGroup" value="<?= $adminG ?>">
                            <button type="submit" class="btn btn-link">ajouter au groupe</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div> 

                <?php else :
                echo "Vous n'avez aucun ami à rajouter a ce groupe.";
                
                endif;
            ?>
          </div>
        </div>
      </div>

    </div>
          </div>



<?php 
    $content = ob_get_clean();
    require_once('view/template.php');
?>