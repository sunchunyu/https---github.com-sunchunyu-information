/*
 * 操作提示方法
 * type:success成功，info信息，danger错误，warning警告
 * message:提示信息
 * */

$(function () {
    if (navigator.userAgent.indexOf("MSIE") > 0) {
        $(".caret").remove();
    }
    $(".loading-container").hide();
    $("#logout").on("click", function () {
        var e = this;
        bootConfirm("确定要退出系统吗？", function () {
            window.location.href = $(e).attr("data");
        });
    });
});
function bootMessage(type, message) {
    $("#mdl-" + type).remove();
    var html = $('<div id="mdl-' + type + '" class="modal modal-message modal-' + type + ' animated fadeInDown" style="display: block;opacity:1">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<i class="glyphicon glyphicon-check"></i>' +
        '</div>' +
        '<div class="modal-title"></div>' +
        '<div class="modal-body">' + message + '</div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-' + type + '" data-dismiss="modal">确定</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>');

    html.find(".btn-" + type).on("click", function () {
        $("#mdl-" + type).addClass("fadeOutUp").on("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
            $(this).remove();
        });
    });
    $("body").append(html);
    setTimeout(function () {
        $("#mdl-" + type + " .btn-" + type).click();
        $("#mdl-" + type).remove();
    }, 2000)
}
/*
 * 确认提示方法
 * message:提示信息
 * fun:回调函数
 * */
function bootConfirm(message, fun) {
    bootbox.confirm({
        message: message,
        buttons: {
            confirm: {
                label: "确认",
                className: "btn-success"
            },
            cancel: {
                label: "取消"
            }
        },
        callback: function (result) {
            if (result) {
                fun();
            }
        }
    });
}

//验证邮件格式
function isMail(str) {
    var reg = /[a-zA-Z0-9]{1,10}@[a-zA-Z0-9]{1,5}\.[a-zA-Z0-9]{1,5}/;
    return reg.test(str);
}
//电话号码验证
function isPhone(str) {
    var reg = /^[1][3578][0-9]{9}/;
    return reg.test(str);
}

/*
 *   不允许特殊字符
 *   替换输入框内的值
 *   obj:输入框对象
 */
function processSpelChar(obj) {
    var text = $(obj).val().replace(/[ ]/g, ""); //去除空格

    var checkNum = /[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g;
    if (checkNum.test(text)) {
        text = text.replace(checkNum, "");   //替换字符
        bootMessage("warning", "只允许输入汉字、字母、数字");
    }

    $(obj).val(text);
}
