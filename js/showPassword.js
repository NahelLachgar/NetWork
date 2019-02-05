var checkbox = $("#showPass");
        var password = $("#inputPassword");
        checkbox.click(function() {
            if(checkbox.prop("checked")) {
                password.prop("type", "text");
            } else {
                password.prop("type", "password");
            }
        });