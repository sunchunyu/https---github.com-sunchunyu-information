/**
 * Created by liuwanqiu on 2016/4/11.
 */
var ue = UE.getEditor('myEditor');
$(function () {
    var arr_p = new Array();
    var arr_c = new Array();
    var arr_q = new Array();
    $("#province>option").each(function () {
        if ($(this).attr("data-id") == "0") {
            return;
        }
        arr_p.push({id: $(this).attr("data-id"), name: $.trim($(this).text()), value: $.trim($(this).attr("value")), pid: $(this).attr("data-pid")})
    });
    $("#province").val($.trim($("#p").val()));
    $("#county_child>option").each(function () {
        if ($(this).attr("data-pid") == "0") {
            $("#county_child").html("<option data-id='0' data-pid='0' value='0'>请选择</option>");
            return;
        }
        if ($.trim($(this).attr("data-pid")) == $.trim($("#province>option:selected").attr("data-id"))) {
            $("#county_child").append("<option data-pid='" + $(this).attr("data-pid") + "' data-id='" + $(this).attr("data-id") + "' value='" + $.trim($(this).attr("value")) + "'>" + $.trim($(this).text()) + "</option>")
        }
        arr_c.push({id: $(this).attr("data-id"), name: $.trim($(this).text()), value: $.trim($(this).attr("value")), pid: $(this).attr("data-pid")})
    });
    $("#county_child").val($.trim($("#c").val()));
    $("#city_child>option").each(function () {
        if ($(this).attr("data-pid") == "0") {
            $("#city_child").html("<option data-id='0' data-pid='0' value='0'>请选择</option>");
            return;
        }
        if ($.trim($(this).attr("data-pid")) == $.trim($("#county_child>option:selected").attr("data-id"))) {
            $("#city_child").append("<option data-pid='" + $(this).attr("data-pid") + "' data-id='" + $(this).attr("data-id") + "' value='" + $.trim($(this).attr("value")) + "'>" + $.trim($(this).text()) + "</option>")
        }
        arr_q.push({id: $(this).attr("data-id"), name: $.trim($(this).text()), value: $.trim($(this).attr("value")), pid: $(this).attr("data-pid")})
    });
    $("#city_child").val($.trim($("#t").val()));

    $("#province").on("change", function () {
        $("#county_child").html("<option data-id='0' data-pid='0' value='0'>请选择</option>");
        var selectedValue = $(this).find("option:selected").attr("data-id");
        $.each(arr_c, function (i, item) {
            if (item.pid == selectedValue) {
                $("#county_child").append("<option data-pid='" + item.pid + "' data-id='" + item.id + "' value='" + item.name + "'>" + item.name + "</option>")
            }
        });
    })
    $("#county_child").on("change", function () {
        $("#city_child").html("<option data-id='0' data-pid='0' value='0'>请选择</option>");
        var selectedValue = $(this).find("option:selected").attr("data-id");
        $.each(arr_q, function (i, item) {
            if (item.pid == selectedValue) {
                $("#city_child").append("<option data-pid='" + item.pid + "' data-id='" + item.id + "' value='" + item.name + "'>" + item.name + "</option>")
            }
        });
    })

    //设置默认值
    if ($('#salary_hide').val() != '') {
        $("#salary").val($('#salary_hide').val());
    }
    if ($('#education_hide').val() != '') {
        $("#education").val($('#education_hide').val());
    }
    if ($('#category_hide').val() != '') {
        $("#category").val($('#category_hide').val());
    }
    if ($('#worklife_hide').val() != '') {
        $("#worklife").val($('#worklife_hide').val());
    }


    $('.offer_add_save').click(function () {
        var url = $('.offer_add_save').attr('data');
        var offer_title = $('#offer_title').val();
        var addr = '';
        if ($("#province").val() == 0) {
            bootMessage("info", "亲，请选择工作地省份~~~");
            return;
        }
        if ($("#county_child").val() == 0) {
            bootMessage("info", "亲，请选择工作地城市~~~");
            return;
        }
        if ($("#city_child").val() == 0) {
            bootMessage("info", "亲，请选择工作地区县~~~");
            return;
        }
        addr = $("#province").val() + "-" + $("#county_child").val() + "-" + $("#city_child").val();
        var len = $('.label-info').length;
        if (len > 0) {
            for (var i = 0; i < len; i++) {
                if ($($('.label-info')[i]).text().length > 10) {
                    bootMessage("info", "亲，标签输入长度不合法~~~");
                    return;
                }
            }
        }
        offer_addr = addr;
        var salary = $("#salary option:selected").val();
        var number = $('#offer_number').val();
        var education = $("#education option:selected").val();
        var worklife = $("#worklife option:selected").val();
        var category = $("#category option:selected").val();
        var welfare = $('#welfare').val();
        var ue_html = UE.getEditor('myEditor').getContent();
        if (!$.trim(offer_title)) {
            bootMessage("info", "亲，请输入岗位名称~~~");
        } else if (!$.trim(offer_addr)) {
            bootMessage("info", "亲，请选择工作地点~~~");
        } else if (!$.trim(number)) {
            bootMessage("info", "亲，请输入招聘人数~~~");
        } else if($.trim(number)<=0) {
            bootMessage("info", "亲，请输入招聘人数的正确格式~~~");
        }else if (!$.trim(ue_html)) {
            bootMessage("info", "亲，请输入内容~~~");
        } else {
            $.post(url, {
                _offer_title: offer_title,
                _offer_addr: offer_addr,
                _salary: salary,
                _number: number,
                _education: education,
                _worklife: worklife,
                _welfare: welfare,
                _category: category,
                _ue_html: ue_html,
            }, function (msg) {
                if (msg) {
                    window.location.href = $('.offer_list').attr('href');
                } else {
                    bootMessage("warning", "操作失败！！！");
                }
            });
        }
    });
});