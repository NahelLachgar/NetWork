<?php 
$title = "Messages";
ob_start();
?>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="https://picsum.photos/50/50" class="online" alt="" />
				<p>Nahel Lachgar</p>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts">
			<ul>
				<li class="contact">
					<div class="wrap">
						<span class="contact-status online"></span>
						<img src="https://picsum.photos/50/50" alt="" />
						<div class="meta">
							<p class="name">Morgan Mba</p>
							<p class="preview">Salut</p>
						</div>
					</div>
				</li>
			
				<li class="contact">
					<div class="wrap">
						<span class="contact-status"></span>
						<img src="https://picsum.photos/50/50" alt="" />
						<div class="meta">
							<p class="name">Kévin Barao Da Silva</p>
							<p class="preview">É c koman la</p>
						</div>
					</div>
				</li>
	
			</ul>
		</div>
		
	</div>
	<div class="content">
		<div class="contact-profile">
			<img src="https://picsum.photos/50/50" alt="" />
			<p>Morgan Mba</p>
		</div>
		<div class="messages">
			<ul>
				<li class="sent">
					<p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
				</li>
				<li class="replies">					
                    <p>When you're backed against the wall, break the god damn thing down.</p>
				</li>
				<li class="replies">
					<p>Excuses don't win championships.</p>
				</li>
				<li class="sent">
					<p>Oh yeah, did Michael Jordan tell you that?</p>
				</li>
				<li class="replies">
					<p>No, I told him that.</p>
				</li>
				<li class="replies">
					<p>What are your choices when someone puts a gun to your head?</p>
				</li>
				<li class="sent">
					<p>What are you talking about? You do what they say or they shoot you.</p>
				</li>
				<li class="replies">
					<p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
				</li>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Write your message..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");









});
//# sourceURL=pen.js
</script>
 <?php 
    $content = ob_get_clean();
    require('./view/template.php');
 ?>