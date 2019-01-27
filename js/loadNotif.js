function loadNotif() {
    setInterval(function(){
    $.ajax({
        url : "index.php?action=loadNotif",
        type : "POST",
        dataType:"html",
        success : function(html){
            var notif = JSON.parse(html);
            var content = notif.content;
            var url = notif.url;
            var icon = notif.icon;
            $.notify({
                // options
                //icon: icon,
              //  message: content
              message : '<div>'+
              '<img width=50 src="'+icon+'">&nbsp&nbsp'+content+
              '</div>',
                url: url,
                target: "_self"
            },{
                // settings
                type: 'info',
                url_target: 'self',
                icon_type: 'image',
                animate: {
                    enter: 'animated rollIn',
                    exit: 'animated rollOut'
                },
                template: '<div style="color:#2c3e50;background-color:#ecf0f1;border:none" data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
		'<span data-notify="icon"></span> ' +
		'<span data-notify="title">{1}</span> ' +
		'<span data-notify="message">{2}</span>' +
		'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
		'</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
    '</div>'
            });  
        }
    });
},100)
}
loadNotif();

function loadNotifNb() {
    setInterval(function(){
    $.ajax({
        url : "index.php?action=loadNotifNb",
        type : "POST",
        dataType:"html",
        success : function(html){
            console.log(html);
            $("#nbNotifs").text(html);
              }
    });
},100)
}
loadNotifNb();