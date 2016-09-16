$(function () {
    $(".specialtyName").on("blur",function(){
        processSpelChar($(this));
    });

    $(".btn-save").on("click", function () {
        var name = $.trim($(".specialtyName").val());
        var college = $.trim($(".college").val());
        if (name.length == 0) {
            bootMessage("warning", "亲，专业名称不能为空~~~");
            return;
        }
        if (college == 0) {
            bootMessage("warning", "亲，专业应所属于某个院系~~~");
            return;
        }
        $.post($("#form").attr("action"), {
            "id": $(".id").val(),
            "name": name,
            "college_id":college
        }, function (d) {
            if (d.code == 0) {
                bootMessage("success", d.message);
            } else {
                bootMessage("danger", d.message);
            }
        }, "json");
    });
});
