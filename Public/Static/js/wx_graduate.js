$(function () {
    if ($("#id").val() == "0") {
        $(".gamma-search-layer").fadeIn();
    } else {
        $(".gamma-search-layer").hide();

    }

    //判断状态，设置页面是否可用
    var status = $("#id").data("status");
    if (status == 0 || status == 2) {
        $("input[type=text]").each(function () {
            $(this).attr("disabled", "disabled");
        });
        $("select").each(function () {
            $(this).attr("disabled", "disabled");
        });
    }

    //文本框获取焦点全选事件
    $("input[type=text]").each(function () {
        $(this).on("focus", function () {
            $(this).select();
        })
    });

    $(".save-btn").on("click", function () {
        var url = $(this).attr("url");

        var name = $.trim($("#name").val());
        var idcard = $.trim($("#idcard").val());
        var nation = $.trim($("#nation").val());
        var sex = $.trim($("#sex").val());
        var phone = $.trim($("#phone").val());
        var homeaddr = $.trim($("#homeaddr").val());
        var speciality = $.trim($("#speciality").val());
        var qq = $.trim($("#qq").val());
        var email = $.trim($("#email").val());
        var company = $.trim($("#company").val());
        var companycode = $.trim($("#companycode").val());
        var addr = $.trim($("#addr").val());
        var addrnow = $.trim($("#addrnow").val());
        var postcode = $.trim($("#postcode").val());
        var contacts = $.trim($("#contacts").val());
        var contactphone = $.trim($("#contactphone").val());
        //基本信息
        var college_id = $.trim($("#gm-yx").val());
        var specialty_id = $.trim($("#gm-zy").val());
        var class_id = $.trim($("#gm-bj").val());

        var isAction = true;    //是否提交表单
        $("input[type=text]").each(function () {
            if ($(this).val().length == 0) {
                isAction = false;
                errorMessage($(this));
                return false;
            }
        });
        //判断是否可以正常提交
        if (!isAction) {      //存在错误，不可提交
            return;
        } else {
            $(this).attr("disabled", true);     //不存在错误则进行提交并将命令按钮置为不可用
        }

        if (isAction) {
            var data = {
                "name": name,
                "idcard": idcard,
                "nation": nation,
                "sex": sex,
                "phone": phone,
                "homeaddr": homeaddr,
                "speciality": speciality,
                "qq": qq,
                "email": email,
                "company": company,
                "companycode": companycode,
                "addr": addr,
                "addrnow": addrnow,
                "postcode": postcode,
                "contacts": contacts,
                "contactphone": contactphone,
                "status": status,
                "college_id": college_id,
                "specialty_id": specialty_id,
                "class_id": class_id,
                "collection_id": $("#id").data("collection")
            };
            showLoading("提交中...");
            $.post(url, {
                "id": $("#id").val(),
                "data": data
            }, function (d) {
                showToast(d.message);
                if (d.code == 0) {
                    setTimeout(function () {
                        location.reload();
                    }, 2000)
                } else {
                    $(this).attr("disabled", false);
                }

            }, "json");
        }

    });

    $(".affirm-btn").on("click", function () {
        var url = $(this).attr("url");
        showLoading("提交中...");
        $.post(url, {
            "id": $("#id").val()
        }, function (d) {
            showToast(d.message);
            if (d.code == 0) {
                setTimeout(function () {
                    location.reload();
                }, 1000)
            }
        }, "json");
    });

});
function setData() {
    $("#speciality").val($.trim($("#gamma-zy option:selected").text()));

}

/*
 错误产生对象
 错误提示消息

 */
function errorMessage(obj, message) {

    $("label[class=danger]").each(function () {
        $(this).remove();
    });

    var message = $(obj).parent().parent().find("label").text();
    message = "<label class='danger'>请输入" + message + "!!!</label>";
    $(obj).after(message);
    $(obj).focus();
    $(obj).addClass("has-error");
    console.log("错误提示：" + message);
}