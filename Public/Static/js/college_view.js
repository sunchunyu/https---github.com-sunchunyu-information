$(function () {
    $(".collegeName").on("blur", function () {
        processSpelChar($(this));
    });

    $(".btn-save").on("click", function () {
        var name = $.trim($(".collegeName").val());
        var college = $.trim($(".college").val());
        if (name.length == 0) {
            bootMessage("warning", "亲，院或系名不能为空~~~");
            return;
        }

        $.post($("#form").attr("action"), {
            "id": $(".id").val(),
            "name": name,
            "p_id": college
        }, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
                if (college == 0)
                    $(".college").append("<option value=" + d.result + ">" + name + "</option>");
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});