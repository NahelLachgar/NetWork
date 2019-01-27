$(document).ready(function(){
	
	function loadGroup() {
				setInterval(function(){
				var lastId = $('#messages li:last').attr('id');
				var groupId = $('#groupId').val();
				$.ajax({
					url : "index.php?action=loadGroup",
					type : "POST",
					data : "groupId=" + groupId + "&messageId=" + lastId,
					dataType:"html",
					success : function(html){
						console.log(html);
						$('.messages ul').append(html);
					}
				});
			},100)
	}
			loadGroup();

	$('#send').click(function(e){
			var message = $('#message').val();
			var groupId = $('#groupId').val();
			if ($.trim(message) != "") {			
				$.ajax({
				url : "index.php?action=sendGroup",
				type : "POST", // la requête est de type POST
				data : "message=" + message + "&groupId=" + groupId // et on envoie nos données
				});
			}
		$('#message').val("");
		$(".messages").animate({ scrollTop: $(document).height() }, "fast");

	});

	$('#message').keydown(function(e){
		if (e.which == 13) {
			e.preventDefault();
			var message = $('#message').val();
			var groupId = $('#groupId').val();
			if ($.trim(message) != "") {			
				$.ajax({
				url : "index.php?action=sendGroup",
				type : "POST", // la requête est de type POST
				data : "message=" + message + "&groupId=" + groupId // et on envoie nos données
				});
			}
			$('#message').val("");
			$(".messages").animate({ scrollTop: $(document).height() }, "fast");

		}
	});
});