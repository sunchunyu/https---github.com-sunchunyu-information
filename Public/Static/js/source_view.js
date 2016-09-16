$(function () {

    $(".sourceName").on("blur",function(){
        processSpelChar($(this));
    });

    $(".btn-save").on("click", function () {
        var name = $.trim($(".sourceName").val());
        if (name.length == 0) {
            bootMessage("warning", "亲，用户名称不能为空~~~");
            return;
        }
        $.post($("#form").attr("action"), {
            "id": $(".id").val(),
            "name": name,
        }, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});