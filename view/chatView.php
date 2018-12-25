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
				<li class=<?= $class ?>>
					<p><?= $messagesFetch['content'] ?></p>
				</li>
                    <?php endwhile ?>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<form action="index.php?action=sendMessage" method="POST">
				<input type="text" name="content" id="content" placeholder="Écrivez votre message" />
				<input type="hidden" name="contactId" id="contactId" value="<?= $_POST['contactId'] ?>">
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i> 
				<button type="submit" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</form>
			</div>
		</div>
	</div>
</div>
<script src='https://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script >
$(document).ready(function(){
	$("#messages").animate({ scrollTop: $(document).height() }, "fast");
	//BARRE DE SCROLL EN BAS 
	$(window).on('keydown', function(e) {
	if (e.which == 13) {
		return false;
	}

	$('#envoi').click(function(e)){
		e.preventDefault();
		var content = $('#content').val();
		var contactId = $('#contactId').val();

		if (content != "" && trim(content) != "") {
			$.ajax({
				url : "send.php",
				type : "POST",
				data : "content=" + content + "&contactId=" + idContact,
				dataType:'html'
			});
			$('#messages').appendTo("<li class=<?= $class ?>><p>" + content + "</p></ul>");
		}
	}
	});
function load(){
				setTimeout( function(){
				var fisrtId = $('#messages p:first').attr('id');
				$.ajax({
					url : "load.php",
					type : "POST",
					data : "messageId=" + firstId,
					dataType:'html',
					success : function(html){
					$('#messages').prepend(html);
					}
				})
			});
			load();
	},5000);
	load();
)};
</script>
 <?php 
$content = ob_get_clean();
require('./view/template.php');
?>
