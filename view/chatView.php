<?php 
$title = "Messages";
ob_start();
?>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
			
				<img id="profile-img" src="./img/profile/<?= $userProfile['photo'] ?>" class="online rounded-circle" width="45" alt="" />
				<p><?= $userProfile['name'] . ' ' . $userProfile['lastName'] ?></p>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts">
			<ul>
            <?php for ($i = 0; $i < count($contactProfile); $i++) : ?>
			<form>
			<input type="hidden" id="idContact" name="contactId" value="<?= $contactProfile[$i]['id'] ?>">

				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img class="rounded-circle" width="45"src="./img/profile/<?= $contactProfile[$i]['photo'] ?>" alt="" />
						<div class="meta">
						<p class="name"><?= $contactProfile[$i]['name'] . ' ' . $contactProfile[$i]['lastName'] ?></p>
			</form>
						</div>
					</div>
				</li>
			
				
                <?php endfor ?>
			</ul>
		</div>
		
	</div>
	<div class="content">
		<div class="contact-profile">
		<img class="rounded-circle" width="45"src="./img/profile/<?= $reiceverProfile['photo'] ?>" alt="" />
			<p><?= $reiceverProfile['name'] . ' ' . $reiceverProfile['lastName'] ?></p>
        </div>
        
		<div class="messages">
			<ul id="messages">
			 <?php 
			while ($messagesFetch = $messages->fetch()) :
				if ($messagesFetch['reicever'] == $_SESSION['id']) {
				$class = "sent";
			} else {
				$class = "replies";
			}
			?>
				<li id="<?= $messagesFetch['id'] ?>" class=<?= $class ?>>
					<p><?= $messagesFetch['content'] ?></p>
				</li>
                    <?php endwhile ?>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<form>
				<input type="text" name="content" id="content" placeholder="Écrivez votre message" />
				<input type="hidden" name="contactId" id="contactId" value="<?= $_POST['contactId'] ?>">
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i> 
				<button type="button" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</form>
			</div>
		</div>    
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$(window).on('keydown', function(e) {
		if (e.which == 13) {
			return false;
		}
	});
	function load() {
				setInterval(function(){
				var lastId = $('#messages li:last').attr('id');
				$.ajax({
					url : "view/load.php",
					type : "POST",
					data : "messageId=" + lastId,
					dataType:"html",
					success : function(html){
						$('.messages ul').append(html);
					}
				});
			},1000)
	}
			load();

	$('#send').click(function(e){
			var content = $('#content').val();
			var contactId = $('#contactId').val();
			if ($.trim(content) != "") {			
				$.ajax({
				url : "view/send.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "content=" + contactId + "&contactId=" + content // et on envoie nos données
				});
			}
		$('#content').val("");
	});
	
});
</script>
 <?php 
$content = ob_get_clean();
require('./view/template.php');
?>
