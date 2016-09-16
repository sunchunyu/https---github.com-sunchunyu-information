$(function () {
    $(".btn-save").on("click", function () {
        var old_pass = $.trim($(".old_pass").val());
        var new_pass = $(".new_pass").val();
        var res_pass = $(".txt_pass").val();
        if (old_pass.length == 0 || new_pass.length == 0 || res_pass.length == 0) {
            bootMessage("warning", "亲，请将信息填写完整~~~");
            return;
        }
        if (new_pass != res_pass) {
            bootMessage("warning", "亲，两次新密码输入不一致~~~");
            return;
        }
        if (new_pass == old_pass) {
            bootMessage("warning", "亲，新密码和原密码不能一样~~~");
            return;
        }
        if (new_pass.length < 6) {
            bootMessage("warning", "亲，密码长度至少6位~~~");
            return;
        }
        $.post($("#form").attr("action"), {o: old_pass, n: new_pass, r: res_pass}, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});
