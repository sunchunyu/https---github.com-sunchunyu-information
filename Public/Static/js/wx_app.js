function showToast(message) {
    $(".toast").remove();
    var html = '<div class="toast">' + message + '</div>';
    $("body").append(html);
    setTimeout(function () {
        $(".toast").remove();
    }, 2000);
}
function showLoading(message) {
    $(".load").remove();
    var html = '<div class="toast load">' + message + '</div>';
    $("body").append(html);
}

function selected(e, id) {
    var selectedValue = $(e).val();
    $("#gamma-" + id).html("<option data='0' value='0'>请选择</option>");
    if (id == "yx") {
        $.each(arr_yx, function (i, item) {
            if (selectedValue == "0") {
                $("#gamma-yx").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
                return;
            }
            if (item.pid == selectedValue) {
                $("#gamma-yx").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
            }
        });
    }
    if (id == "zy") {
        $.each(arr_zy, function (i, item) {
            if (selectedValue == "0") {
                $("#gamma-zy").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
                return;
            }
            if (item.pid == selectedValue) {
                $("#gamma-zy").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
            }
        });
    }
    if (id == "bj") {
        $.each(arr_bj, function (i, item) {
            if (selectedValue == "0") {
                $("#gamma-bj").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
                return;
            }
            if (item.pid == selectedValue) {
                $("#gamma-bj").append("<option data='" + item.pid + "' value='" + item.value + "'>" + item.name + "</option>")
            }
        });
    }
}

var arr_yx = new Array();
var arr_zy = new Array();
var arr_bj = new Array();
$(function () {
    $("#gamma-xy").bind("change", function () {
        selected(this, "yx");
    });

    $("#gamma-yx").bind("change", function () {
        selected(this, "zy");
    })

    $("#gamma-zy").bind("change", function () {
        selected(this, "bj");
    })
    $("#gamma-yx>option").each(function () {
        if ($(this).attr("data") == "0") {
            $("#gamma-yx").html("<option data='0' value='0'>请选择院系</option>")
            return;
        }
        if (parseInt($("#gm-xy").val()) == parseInt($(this).attr("data"))) {
            $("#gamma-yx").append("<option data='" + $(this).attr("data") + "' value='" + $(this).attr("value") + "'>" + $(this).text() + "</option>")
        }
        arr_yx.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).attr("data")})
    });
    $("#gamma-zy>option").each(function () {
        if ($(this).attr("data") == "0") {
            $("#gamma-zy").html("<option data='0' value='0'>请选择专业</option>")
            return;
        }
        if ($("#gm-yx").val() == $(this).attr("data")) {
            $("#gamma-zy").append("<option data='" + $(this).attr("data") + "' value='" + $(this).attr("value") + "'>" + $(this).text() + "</option>")
        }
        arr_zy.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).attr("data")})
    });
    $("#gamma-bj>option").each(function () {
        if ($(this).attr("data") == "0") {
            $("#gamma-bj").html("<option data='0' value='0'>请选择班级</option>")
            return;
        }
        if ($("#gm-zy").val() == $(this).attr("data")) {
            $("#gamma-bj").append("<option data='" + $(this).attr("data") + "' value='" + $(this).attr("value") + "'>" + $(this).text() + "</option>")
        }
        arr_bj.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).attr("data")})
    });
    $(".gamma-refresh").on("click", function () {
        window.location.reload();
    });


    $("#txt-xy,#txt-yx,#txt-zy,#txt-bj").on("click", function () {
        $("#gamma-xy").val($("#gm-xy").val());
        $("#gamma-yx").val($("#gm-yx").val());
        $("#gamma-zy").val($("#gm-zy").val());
        $("#gamma-bj").val($("#gm-bj").val());
        $(".gamma-search-layer").fadeIn("normal", function () {

        });
    });
    $(".search-btn").on("click", function () {
        if ($("#gamma-xy").val() == 0) {
            showToast("请选择学院");
            return;
        }
        if ($("#gamma-yx").val() == 0) {
            showToast("请选择院系");
            return;
        }
        if ($("#gamma-zy").val() == 0) {
            showToast("请选择专业");
            return;
        }
        if ($("#gamma-bj").val() == 0) {
            showToast("请选择班级");
            return;
        }
        $("#gm-xy").val($("#gamma-xy").val());
        $("#gm-yx").val($("#gamma-yx").val());
        $("#gm-zy").val($("#gamma-zy").val());
        $("#gm-bj").val($("#gamma-bj").val());
        $("#txt-xy").val($.trim($("#gamma-xy option:selected").text()));
        $("#txt-yx").val($.trim($("#gamma-yx option:selected").text()));
        $("#txt-zy").val($.trim($("#gamma-zy option:selected").text()));
        $("#txt-bj").val($.trim($("#gamma-bj option:selected").text()));
        $(".gamma-search-layer").fadeOut("normal", function () {
            $("#gamma-xy").val(0)
            $("#gamma-yx").val(0)
            $("#gamma-zy").val(0)
            $("#gamma-bj").val(0)
        });
        setData();
    });
});
function setData() {

}

var browser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return { //移动终端浏览器版本信息
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1 //是否iPad
        };
    }()
}
