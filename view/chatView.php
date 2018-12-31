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
			<input type="hidden" name="contactId" value="<?= $contactProfile[$i]['id'] ?>">

				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img class="rounded-circle" width="45"src="./img/profile/<?= $contactProfile[$i]['photo'] ?>" alt="" />
						<div class="meta">
						<button type="submit" class="btn btn-link">

							<p class="name"><?= $contactProfile[$i]['name'] . ' ' . $contactProfile[$i]['lastName'] ?></p>
							</button>

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
				<button type="submit" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</form>
			</div>
		</div>    
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
console.log('a');
	function load(){
				setTimeout( function(){
				var fisrtId = $('#messages li:first').attr('id');
				$.ajax({
					url : "load.php",
					type : "POST",
					data : "messageId=" + firstId,
					dataType:'html',
					success : function(html){
					$('#messages').prepend(html);
					}
				})
			},5000);
			load();

	$('#send').click(function(e){
		e.preventDefault();
		var content = $('#content').val();
		var contactId = $('#contactId').val();
		if ($.trim(content) != "") {
			$.post(
				'index.php?action=send',
				{
					content: $('#content').val(),
					contactId: $('#contactId').val()
				},
				function (data) {
					if (data == "Success") {	
						$('#messages').append('<li id="'+Number($('#messages li:last').attr('id'))+1+'" class="sent"><p>' + content + '</p></li>');
					} else {
						echo ("Erreur lors de l'envoi");
					}
				}
			'html'
			);
		}
	});

});

</script>
 <?php 
$content = ob_get_clean();
require('./view/template.php');
?>
