$(document).ready(function () {
    if ($('#st_hiden').val() == 1) {
        showToast("提交成功");
    } else if ($('#st_hiden').val() == 2) {
        showToast("提交失败");
    }

    $("#sex").val($("#my_sex").val());
    $("#category").val($("#my_category").val());
    $("#speciality").val($("#my_speciality").val());
    if ($("#my_id").val() == "0") {
        $(".gamma-search-layer").fadeIn();
    } else {
        $(".gamma-search-layer").hide();

    }
    $('.dropify').dropify();

});

function setData() {
    $("#speciality").val($.trim($("#gamma-zy option:selected").text()));
    $("#college_id").val($("#gamma-yx").val());
    $("#specialty_id").val($("#gamma-zy").val());
    $("#class_id").val($("#gamma-bj").val());
    $("#xy_id").val($("#gamma-xy").val());
}


$(function () {
    $('.save-btn').click(function () {
        var _this = $(this);
        var data = _this.attr('data');
        if (data == 3 || data == 1) {
            if ($(this).attr('data-type') == 0) {
                //表示的确认
                showLoading("提交中...");
                $.post($('#status').attr('data'), {}, function (msg) {
                    if (msg) {
                        showToast("确认成功");
                        $('.save-btn').html("已确认");
                        _this.prev().hide();
                        _this.attr("disabled", true);
                        _this.attr("data", 2);
                        var form = document.forms[0];
                        for (var i = 0; i < form.length; i++) {
                            var element = form.elements[i];
                            element.disabled = "true";
                        }
                    } else {
                        showToast("确认失败");
                    }
                });

            } else {
                showLoading("提交中...");
                //提交或修改
                var name = $('#name').val();
                var wheremidd = $('#wheremidd').val();
                var ticketnumber = $('#ticketnumber').val();
                var phone = $('#phone').val();
                var addr = $('#addr').val();
                var totalscore = $('#totalscore').val();
                var remark = $('#remark').val();
                var idcard = $('#idcard').val();
                //手机号正则
                var tel_zz = /^1\d{10}$/;
                //判断上传文件类型
                var icon = $('#photo').val();
                var re = /(\\+)/g;
                var filename = icon.replace(re, "#");
                var one = filename.split("#");
                var two = one[one.length - 1];
                //再对文件名进行截取，以取得后缀名
                var three = two.split(".");
                //获取截取的最后一个字符串，即为后缀名
                var last = three[three.length - 1];
                //添加需要判断的后缀名类型
                var tp = "jpg,gif,JPG,GIF,png,jpeg";
                //返回符合条件的后缀名在字符串中的位置
                var rs = tp.indexOf(last);
                if ($.trim(name) == '') {
                    showToast("姓名不能为空");
                } else if ($.trim(idcard) == '') {
                    showToast("身份证号码不能为空");
                } else if (idcard.length > 18 || !(/^\d+$/.test(idcard))) {
                    showToast("身份证号码输入不合法");
                } else if ($.trim(wheremidd) == '') {
                    showToast("中招考试所在地不能为空");
                } else if ($.trim(ticketnumber) == '') {
                    showToast("准考证号不能为空");
                } else if ($.trim(addr) == '') {
                    showToast("家庭住址不能为空");
                } else if ($.trim(totalscore) == '') {
                    showToast("考试总分不能为空");
                } else if (phone == "") {
                    showToast("手机号不能为空");
                } else if (phone.length > 11 || !(/^\d+$/.test(phone))) {
                    showToast("手机号输入不合法");
                } else if (rs < 0) {
                    showToast("上传类型错误");
                } else {
                    $('#img_status').val($('.dropify-render img').attr('src'));
                    $('form[name="category_form"]').submit();
                }
            }

        }
    });
});
window.onload = function () {
    $('.dropify-clear').text("移除");
    $('.dropify-infos-message').text('拖文件至此处或者点击此处');
    if ($('#status').val() == 2 || $('#status').val() == 0) {
        //已确认，或审核中不可编辑
        var form = document.forms[0];
        for (var i = 0; i < form.length; i++) {
            var element = form.elements[i];
            element.disabled = "true";
        }
        $('.save-btn,#txt-bj,#txt-xy,#txt-yx,#txt-zy').attr('disabled', true);
    }
}