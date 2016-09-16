$(function () {
    $(".className").on("blur",function(){
        processSpelChar($(this));
    });

    $(".btn-save").on("click", function () {
        var name = $.trim($(".className").val());
        var specialty = $.trim($(".specialty").val());
        if (name.length == 0) {
            bootMessage("warning", "亲，班级名称不能为空~~~");
            return;
        }
        if (specialty == 0) {
            bootMessage("warning", "亲，班级应所属于某个专业~~~");
            return;
        }
        $.post($("#form").attr("action"), {
            "id": $(".id").val(),
            "name": name,
            "specialty_id":specialty
        }, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});