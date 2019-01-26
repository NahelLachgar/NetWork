function load() {
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
                icon: icon,
                message: content,
                url: url,
            },{
                // settings
                type: 'info',
                url_target: '_self',
                icon_type: 'image'
            });  
        }
    });
},100)
}
load();