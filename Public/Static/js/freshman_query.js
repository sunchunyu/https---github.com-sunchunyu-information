$(function () {
    GetData();
    $(".btn-get").on("click", function () {
        window.location.href = $(this).attr("data");
    });

    var arr_yx = new Array(); //系别
    var arr_zy = new Array(); //专业
    var arr_bj = new Array(); //班级

    $("#deparment>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_yx.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });
    $("#specialty>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_zy.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });
    $("#class>option").each(function () {
        if ($(this).data("parent") == "0") {
            return;
        }
        arr_bj.push({name: $(this).text(), value: $(this).attr("value"), pid: $(this).data("parent")})
    });

    $("#college").bind("change", function () {
        selected(this, "yx");
    });

    $("#deparment").bind("change", function () {
        selected(this, "zy");
    });

    $("#specialty").bind("change", function () {
        selected(this, "bj");
    });

    function selected(e, id) {
        var selectedValue = $(e).val();
        /* $("#gamma-" + id).html("<option value='0'>全部</option>");*/
        if (id == "yx") {
            $.each(arr_yx, function (i, item) {
                if (selectedValue == "0") {
                    $("#deparment").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $("#deparment option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $("#deparment").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
        if (id == "zy") {
            $.each(arr_zy, function (i, item) {
                if (selectedValue == "0") {
                    $("#specialty").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $("#specialty option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $("#specialty").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
        if (id == "bj") {
            $.each(arr_bj, function (i, item) {
                if (selectedValue == "0") {
                    $("#class").append("<option value='" + item.value + "'>" + item.name + "</option>")
                    return;
                }
                $("#class option[value='" + item.value + "']").remove();
                if (item.pid == selectedValue) {
                    $("#class").append("<option value='" + item.value + "'>" + item.name + "</option>")
                }
            });
        }
    }
    /*
     级联更新下拉列表
     */
   /* $("#college").on("change", function () {
        //console.log("college  change");
        var id = $(this).val();

        $("#deparment option").each(function (index) {
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
        $("#college option").each(function (index) {
            $(this).show();
        });

        $("#deparment").val("0");
        $("#specialty").val("0");
        $("#class").val("0");
        $("#college option").each(function (index) {
            $(this).show();
        });
    });

    $("#deparment").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $("#college option").each(function (index) {
            $(this).show();
        });

        $("#specialty option").each(function (index) {
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $("#college").change();
            }
        });

        $("#college").val(parent);
        $("#college").change();
        $("#specialty").val("0");
        $("#class").val("0");
        $(this).val(id);
        $("#deparment option").each(function (index) {
            $(this).show();
        });
    });

    $("#specialty").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $("#deparment option").each(function (index) {
            $(this).show();
        });

        $("#class option").each(function (index) {
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $("#college").change();
                $("#department").change();
            }
        });

        $("#deparment").val(parent);
        $("#deparment").change();
        $("#class").val("0");
        $(this).val(id);
        $("#specialty option").each(function (index) {
            $(this).show();
        });
    });


    $("#class").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $("#specialty option").each(function (index) {
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                $(this).show();
                $("#deparment").change();
                $("#college").change();
            }
        });

        $("#specialty").val(parent);
        $("#specialty").change();
        $(this).val(id);    //重置选项
        $("#class option").each(function (index) {
            $(this).show();
        });
    });*/

});
var resultDataTable = null;
var Id = "";
function GetData() {
    $(".loading-container").show();
    var $searchResult = $("#simpledatatable");
    $searchResult.dataTable().fnDestroy();
    resultDataTable = $searchResult.dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
        "searching": false,
        "bFilter": false,
        "bAutoWidth": false,
        "bStateSave": true,
        "bProcessing": true, //开启读取服务器数据时显示正在加载中……特别是大数据量的时候，开启此功能比较好
        "bServerSide": true,//开启服务器模式，使用服务器端处理配置datatable。注意：sAjaxSource参数也必须被给予为了给datatable源代码来获取所需的数据对于每个画。 这个翻译有点别扭。开启此模式后，你对datatables的每个操作 每页显示多少条记录、下一页、上一页、排序（表头）、搜索，这些都会传给服务器相应的值。
        "sAjaxSource": $(".btn-query").attr("data"),
        "language": {
            "sZeroRecords": "没有您要搜索的内容",
            "sInfo": "从 _START_ 到 _END_ 条记录，总记录数为 _TOTAL_ 条",
            "sInfoEmpty": "总记录数为 0 条",
            "sInfoFiltered": "(全部记录数 _MAX_  条)",
            "sSearch": false,
            "sLengthMenu": "_MENU_",
            "sProcessing": "正在加载数据...",
            "oPaginate": {
                "sPrevious": "上一页",
                "sNext": "下一页"
            }
        },
        "columns": [
            {"data": "name", "sName": "name"},
            {"data": "sex", "sName": "sex"},
            {"data": "collection_id", "sName": "collection_id"},
            {"data": "phone", "sName": "phone"},
            {"data": "college_id", "sName": "college_id"},
            {"data": "specialty_id", "sName": "specialty_id"},
            {"data": "class_id", "sName": "class_id"},
            {"data": "status", "sName": "status"},
            {"data": "Id", "sName": "Id", "bSortable": false}
        ],
        "aaSorting": [
            [8, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData["college_id"] = $("#college").find("option:selected").val();
            aoData["deparment"] = $("#deparment").find("option:selected").val();
            aoData["specialty_id"] = $("#specialty").find("option:selected").val();
            aoData["class_id"] = $("#class").find("option:selected").val();
            aoData["status"] = $("#status").find("option:selected").val();
            aoData["collection_id"] = $("#collection_status").find("option:selected").val();
            aoData["student_name"] = $("#student_name").val();
            $.ajax({
                "type": 'post',
                "url": sSource,
                "dataType": "json",
                "data": {
                    aoData: aoData
                },
                "success": function (resp) {
                    fnCallback(resp);
                    $(".loading-container").hide();
                }
            });

        },
        "fnInitComplete": function () {
            /* $("input[type=search]").attr("placeholder", "名称筛选");*/
        },

        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).on("click", function () {
                if ($(this).hasClass("tr-selected")) {
                    $(this).removeClass("tr-selected");
                } else {
                    $(this).addClass("tr-selected");
                }
            });
            $(nRow).attr("data", aData.Id);
            $(nRow).attr("id", "tr_" + aData.Id);
            if (aData.status == 0) {
                $(nRow).find("td:eq(7)").html("<a class='btn btn-danger btn-xs' data='" + aData.Id + "," + aData.status + "' onclick='change(this,event)'><i class='glyphicon glyphicon-remove'></i> 未审核 </a>");
            } else if (aData.status == 1) {
                $(nRow).find("td:eq(7)").html("<a class='btn btn-info btn-xs' data='" + aData.Id + "," + aData.status + "' onclick='change(this,event)'><i class='glyphicon glyphicon-ok'></i>已审核</a>");
            } else {
                $(nRow).find("td:eq(7)").html("<a class='btn btn-success btn-xs' data='" + aData.Id + "," + aData.status + "' onclick='waring(event)'><i class='glyphicon glyphicon-ok'></i>已确认</a>");
            }

            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='Look(this,event)'><i class='fa fa-search'></i> 查看</a> ");
            return nRow;
        }
    });
}


function change(e, event) {//由开启状态到关闭状态
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var data = $(e).attr("data").split(",");
    var nums = [];
    for (var i = 0; i < data.length; i++) {
        nums.push(parseInt(data[i]));
    }
    var id = nums[0];
    var status = nums[1];
    if (status == 0) {
        bootConfirm("亲，您确定要审核这条数据信息吗？", function () {
            change_status(id, status);
        });
    } else if (status == 1) {
        bootConfirm("亲，您要确认这条数据信息吗？", function () {
            change_status(id, status);
        });
    }

}

function waring(event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    bootMessage("warning", "该条数据已经确认过了");
}

function change_status(id, status) {
    $.post($(".btn-status").attr("data"), {id: id, status: status}, function (d) {
        if (d.code == 0) { //开启数据成功
            window.location.reload();
            bootMessage("success", d.message);//已审核
        } else if (d.code == 1) {
            window.location.reload();
            bootMessage("danger", d.message);
        } else if (d.code == 2) { //已确认
            window.location.reload();
            bootMessage("success", d.message);
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}


function Look(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    $.ajax({
        type: 'POST',
        url: $('.btn-look').attr('data'),
        data: {
            'id': id
        },
        success: function (data) {
            $("#name").val(data[0]['name']);
            $("#sex").val(data[0]['sex']);
            $("#idcard").val(data[0]['idcard']);
            $("#wheremidd").val(data[0]['wheremidd']);
            $("#ticketnumber").val(data[0]['ticketnumber']);
            $("#phone").val(data[0]['phone']);
            $("#addr").val(data[0]['addr']);
            $("#speciality").val(data[0]['speciality']);
            $("#category").val(data[0]['category']);
            $("#totalscore").val(data[0]['totalscore']);
            $("#remark").val(data[0]['remark']);
            $("#create_time").val(data[0]['create_time']);
            $("#creator").val(data[0]['creator']);
            $("#update_time").val(data[0]['update_time']);
            $("#updator").val(data[0]['updator']);
            $("#collection_id").val(data[0]['collection_id']);
            $("#college_id").val(data[0]['college_id']);
            $("#specialty_id").val(data[0]['specialty_id']);
            $("#class_id").val(data[0]['class_id']);
            $("#openid").val(data[0]['openid']);
            $("#photo").attr('src', data[0]['photo']);
            $("#look_detail").trigger("click");
        }
    });
}

