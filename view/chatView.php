<?php 
$title = "Messages";
ob_start();
?>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="https://picsum.photos/50/50" class="online" alt="" />
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
			<form action="index.php?action=showMessages" method="POST">
			<input type="hidden" name="contactId" value="<?= $contactProfile[$i]['id'] ?>">

				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="https://picsum.photos/50/50" alt="" />
						<div class="meta">
						<button type="submit" class="btn btn-link">

							<p class="name"><?= $contactProfile[$i]['name'] . ' ' . $contactProfile[$i]['lastName'] ?></p>
							</button>

							<p class="preview"><?= "Dernier message" ?></p>

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
			<img src="https://picsum.photos/50/50" alt="" />
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
			<form action="send.php" method="POST">
				<input type="text" name="content" id="content" placeholder="Écrivez votre message" />
				<input type="hidden" name="contactId" id="contactId" value="<?= $reiceverProfile['id'] ?>">
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i> 
				<button type="submit" name="send" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</form>
			</div>
		</div>
	</div>
</div>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script >$("#messages").animate({ scrollTop: $(document).height() }, "fast");
//BARRE DE SCROLL EN BAS 
	$(window).on('keydown', function(e) {
	if (e.which == 13) {
		return false;
	}

	$('#send').click(function(e)){
		e.preventDefault();
		var content = $('#content').val();
		var contactId = $('#contactId').val();

		if (trim(content) != "") {
			$.ajax({
				url : "send.php",
				type : "POST",
				data : "content=" + content + "&contactId=" + idContact
			});
			$('#messages').append("<li class=<?= $class ?>><p>" + content + "</p></ul>");
		}
	}
	});
function load(){
		setTimeout( function(){
			var fisrtId = $('#messages p:first').attr('id');
			$.ajax({
				url : "load.php",
				type : GET,
				data : "messageId=" + firstId,
				success : function(html){
					$('#messages').prepend(html);
				}
			})load();
		}),5);		
	};
load();

</script>
 <?php 
$content = ob_get_clean();
require('./view/template.php');
?>
