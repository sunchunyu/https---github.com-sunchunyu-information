$(function () {
    $(".btn-back").on("click", function () {
        window.location.href = $(this).attr("data");
    });

    var arr_yx = new Array(); //系别
    var arr_zy = new Array(); //专业
    var arr_bj = new Array(); //班级

    $(".department>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_yx.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });
    $(".specialty>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_zy.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });
    $(".class>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_bj.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });

    $(".college").bind("change", function () {
        selected(this, "yx");
    });

    $(".department").bind("change", function () {
        selected(this, "zy");
    });

    $(".specialty").bind("change", function () {
        selected(this, "bj");
    });

    function selected(e, id) {
        var selectedValue = $(e).val();
        /* $("#gamma-" + id).html("<option value='0'>全部</option>");*/
        if (id == "yx") {
            $.each(arr_yx, function (i, item) {
                if (selectedValue == "0") {
                    $(".department").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $(".department option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $(".department").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
        if (id == "zy") {
            $.each(arr_zy, function (i, item) {
                if (selectedValue == "0") {
                    $(".specialty").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $(".specialty option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $(".specialty").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
        if (id == "bj") {
            $.each(arr_bj, function (i, item) {
                if (selectedValue == "0") {
                    $(".class").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $(".class option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $(".class").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
    }

    /*
     级联更新下拉列表
     */
    /*$(".college").on("change", function () {
        //console.log("college  change");
        var id = $(this).val();

        $(".department option").each(function (index) {
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
            }
        });
        $(".college option").each(function (index) {
            $(this).show();
        });

        $(".department").val("0");
        $(".specialty").val("0");
        $(".class").val("0");
        $(".college option").each(function (index) {
            $(this).show();
        });
    });

    $(".department").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $(".college option").each(function (index) {
            $(this).show();
        });

        $(".specialty option").each(function (index){
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $(".college").change();
            }
        });

        $(".college").val(parent);
        $(".college").change();
        $(".specialty").val("0");
        $(".class").val("0");
        $(this).val(id);
       *//* $(".department option").each(function (index) {
            $(this).show();
        });*//*
    });

    $(".specialty").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $(".department option").each(function (index) {
            $(this).show();
        });

        $(".class option").each(function (index) {
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $(".college").change();
                $(".department").change();
            }
        });

        $(".department").val(parent);
        $(".department").change();
        $(".class").val("0");
        $(this).val(id);
        *//*$(".specialty option").each(function (index) {
            $(this).show();
        });*//*
    });


    $(".class").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $(".specialty option").each(function (index) {
            if (id != 0){
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $(".department").change();
                $(".college").change();
            }
        });

        $(".specialty").val(parent);
        $(".specialty").change();
        $(this).val(id);    //重置选项
        *//*$(".class option").each(function (index) {
            $(this).show();
        });*//*
    });*/


    $(".btn-save").on("click",function(){

        var getdata   = $(".getdata").find("option:selected").text();
        var college   = $(".college").find("option:selected").val();
        var type   = $(".getdata").find("option:selected").val();
        var specialty = $(".specialty").find("option:selected").val();
        var sclass = $(".class").find("option:selected").val();
        var department=$(".department").find("option:selected").val();
        var dataname=$(".dataname").val();
        if(dataname==''){
            bootMessage("danger","数据采集名称不能为空");
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:$('#form').attr('action'),
                data:{
                    'name': dataname,
                    'code': getdata,
                    'college_id':college,
                    'specialty_id': specialty,
                    'department':department,
                    'class_id':sclass,
                    'type':type
                },
                success:function(data) {
                   if(data==0){
                       bootMessage("success","数据信息添加成功！");
                       window.location.href = $(".btn-back").attr("data");
                   }else{
                       bootMessage("danger","数据信息添加失败！");
                   }
                }
            });
        }
        return false;

    });
});

