$(document).ready(function () {
    if ($("#id").val() == "0") {
        $(".gamma-search-layer").fadeIn();
    } else {
        $(".gamma-search-layer").hide();

    }
    $('.dropify').dropify();
    $('.dropify-fr').dropify({
        messages: {
            'default': '点击或拖拽文件到这里',
            'replace': '点击或拖拽文件到这里来替换文件',
            'remove': '移除文件',
            'error': '对不起，你上传的文件太大了'
        }
    });
    var status = $("#id").attr("data");
    if (status == 0 || status == 2) {
        $(".col-sm-12 input").each(function () {
            $(this).attr("disabled", "disabled");
        });
        $(".col-sm-12 select").each(function () {
            $(this).attr("disabled", "disabled");
        });
        $(".dropify-clear,.dropify-infos").remove();
    }
    $(".affirm-btn").on("click", function () {
        var url = $(this).attr("url");
        showLoading("提交中...");
        $.post(url, {id: $("#id").val()}, function (d) {
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
    $("#class").val($("#gm-bj").val());
}

$(function () {
    /**
     *  单击保存按钮执行的函数
     */
    $('.save-btn').click(function () {
        var data_obj = new Array();       //这个用于存储文本框和下拉列表里面选择的值
        //文本框数据处理代码
        var input_group = $(".col-sm-12>.form-group>span>input");       //获取全部的input标签
        //循环获取input标签中的值
        for (var i = 0; i < input_group.length; i++) {
            if ($.trim($(input_group[i]).val()) == "") {
                showToast($(input_group[i]).parent().parent().children("label").text() + "不能为空");
                return;
            }
            var item = $(input_group[i]).attr("id") + "#=#" + $.trim($(input_group[i]).val());
            data_obj.push(item);
        }

        //下拉列表数据处理代码
        var select_group = $(".col-sm-12>span>select");
        for (var i = 0; i < select_group.length; i++) {
            if ($(select_group[i]).attr("id") == "allowances" || $(select_group[i]).attr("id") == "parent1_guardian" || $(select_group[i]).attr("id") == "parent2_guardian" || $(select_group[i]).attr("id") == "sex" || $(select_group[i]).attr("id") == "polity" || $(select_group[i]).attr("id") == "accounttype") {
                data_obj.push($(select_group[i]).attr("id") + "#=#" + $(select_group[i]).val());
            } else {
                if (parseInt($(select_group[i]).val()) == 0) {
                    showToast("请选择" + $(select_group[i]).parent().children("label").text());
                    return;
                } else {
                    data_obj.push($(select_group[i]).attr("id") + "#=#" + $(select_group[i]).val());
                }
            }
        }
        if ($(".dropify-render>img").attr("src") == undefined || $(".dropify-render>img").attr("src") == "") {
            showToast("请上传相片")
            return;
        }
        data_obj.push("id#=#" + $("#id").val());
        data_obj.push("collection_id#=#" + $("#collection_id").val());
        data_obj.push("college_id#=#" + $("#gm-yx").val());
        data_obj.push("specialty_id#=#" + $("#gm-zy").val());
        data_obj.push("class_id#=#" + $("#gm-bj").val());
        data_obj.push("photo#=#" + $(".dropify-render>img").attr("src"));
        var url = $('#save-url').attr('data');
        showLoading("提交中...");
        $.post(url, {data: data_obj}, function (data) {
            showToast(data.message);
            if (data.code == 0) {
                setTimeout(function () {
                    location.reload();
                }, 1000)
            }
        }, "json");
    });
});