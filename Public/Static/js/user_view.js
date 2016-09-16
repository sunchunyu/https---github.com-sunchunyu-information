$(function () {

    $(".btn-save").on("click", function () {
        var name = $.trim($(".userName").val());
        var code = $.trim($(".userCode").val());
        var phone = $.trim($(".userPhone").val());
        var email = $.trim($(".userEmail").val());
        if (name.length == 0) {
            bootMessage("info", "亲，用户名称不能为空~~~");
            return;
        }
        if (code.length == 0) {
            bootMessage("info", "亲，用户帐号不能为空~~~");
            return;
        }
        if (!isPhone(phone) && phone != "") {
            bootMessage("info", "亲，请填写正确的手机号~~~");
            return;
        }
        if (!isMail(email) && email != "") {
            bootMessage("info", "亲，请填写正确的邮箱~~~");
            return;
        }
        $.post($("#form").attr("action"), {
            "id": $(".userId").val(),
            "name": name,
            "code": code,
            "phone": phone,
            "email": email
        }, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});
