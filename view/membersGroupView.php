<?php 
$title = "Groupe";
ob_start();
?>


<div class="container">
      <div class="py-12 text-center">
        <h2>Groupe</h2>
        <p class="lead"></p>
      </div>
        <br>
      <div class="row">
        <div class="col-md-12">
        
              <div class="row justify-content-center">
                  <div class="col-md-12-center">
                      <img class="rounded-circle" width="150" src="./img/groups/<?= $group['photo'] ?>" alt="Photo du groupe">
                  </div>
              </div>   
          </div>      
  </div>
  <div class="row justify-content-center">
              <div class="col-md-3 mb-3">
                <label for="lastName">Nom du groupe</label>
                <input type="text" class="form-control" id="groupName" name="groupName" value="<?= $group['title'] ?>" READONLY>
              </div>
              <div class="col-md-3 mb-3">
                <label for="admin">Administrateur</label><br>
                <input type="text" class="form-control" id="groupName" name="groupName" value="<?= $admin['name']." ".$admin['lastName'] ?>" READONLY>
              </div>
            </div>
          
          <div class="row justify-content-center">
                     
          <div class="col-md-2">
                <form action="index.php?action=leaveTheGroups" method="POST">
                    <input type="hidden" name="contactId" value="<?=$_SESSION['id']?>">
                    <input type="hidden" name="groupId" value="<?= $group['group'] ?>">
                  <button class="btn btn-danger btn-lg btn-block" name="delete" type="submit">Quitter</button>
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
        <h4>Membre(s) du groupe</h4>
      </div>
              <?php if(!empty($res)) : ?>

            <div class="row">
                <?php foreach( $res as $member) :?>
                    <div class="col-md-2 mb-3">
                        <?= $member['name']." ".$member['lastName'] ?>
                    </div>
                <?php endforeach; ?>
            </div> 

            <?php 
                endif;
            ?>

            <hr>

          </div>
        </div>
      </div>

    </div>
          </div>



<?php 
    $content = ob_get_clean();
    require_once('view/template.php');
?>