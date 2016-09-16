$(function () {
    GetData();
    $(".btn-add").on("click", function () {
        window.location.href = $(this).attr("data");
    });
    $(".btn-edit").on("click", function () {
        var id = $(".tr-selected").attr("data");
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要编辑的数据~~~")
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });


    $(".btn-del").on("click", function () {
        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除的数据~~~")
        } else {
            bootConfirm("亲，您是否要删除这条数据吗？", function () {
                var arr = [];
                $.each(ids, function (i, id) {
                    arr.push($(id).attr("data"));
                });
                deleteRow(arr.join(","));
            });
        }
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
    /*$("#college").on("change", function () {
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
        //
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
        //
        $("#class option").each(function (index) {
            //console.log($(this).data('parent'));
            if (id != 0) {
                if ($(this).data('parent') == id) {
                    $(this).show();
                } else {
                    $(this).hide();
                    *//*$(".class option").each(function (index) {
                     $(this).show();
                     });*//*
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

    if (resultDataTable) {
        resultDataTable.fnClearTable();
        $searchResult.dataTable().fnDestroy();
        $("#simpledatatable tbody").empty();
        $('ul.toggle-table-columns').empty();
    } else {
        $searchResult.show();
    }
    resultDataTable = $searchResult.dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
        "bAutoWidth": false,
        "bStateSave": true,
        "sAjaxSource": $(".btn-query").attr("data"),
        "language": {
            "sZeroRecords": "没有您要搜索的内容",
            "sInfo": "从 _START_ 到 _END_ 条记录，总记录数为 _TOTAL_ 条",
            "sInfoEmpty": "总记录数为 0 条",
            "sInfoFiltered": "(全部记录数 _MAX_  条)",
            "sSearch": "",
            "sLengthMenu": "_MENU_",
            "oPaginate": {
                "sPrevious": "上一页",
                "sNext": "下一页"
            }
        },
        "columns": [
            {"data": "update_time","bVisible": false},
            {"data": "name"},
            {"data": "code"},
            {"data": "college_id"},
            {"data": "department_id"},
            {"data": "specialty_id"},
            {"data": "class_id"},
            {"data": "url","bSortable": false},
            {"data": "status", "bSortable": false},
            {"data": "Id", "bSortable": false, "bSearchable": false}
        ],
        "aaSorting": [
            [0, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = {
                "college_id": $("#college").find("option:selected").val(),
                "specialty_id": $("#specialty").find("option:selected").val(),
                "class_id": $("#class").find("option:selected").val(),
                "status": $("#status").find("option:selected").val(),
                'code': $("#code").find("option:selected").text(),
                'deparment': $("#deparment").find("option:selected").val(),
                'student_name': $("#student_name").val()
            };
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
                    var clipboard = new Clipboard('.btn-copy', {
                        text: function (e) {
                            var data = $(e).attr("data");
                            return data;
                        }
                    });

                    clipboard.on('success', function (e) {
                        Notify("复制成功," + e.text, 'top-right', "3000", 'success', 'fa-list', false);
                        return false;
                    });

                    clipboard.on('error', function (e) {
                        bootMessage("danger", "复制失败！");
                    });

                }
            });

        },
        "fnInitComplete": function () {
            $("input[type=search]").attr("placeholder", "全文筛选");
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

            $(nRow).find("td:eq(6)").html("<button  class='btn btn-primary btn-copy' style='font-size: 11px;padding: 2px 7px;' data='" + aData.url + "'  ><i class='glyphicon glyphicon-list-alt'></i>复制</button>");

            if (aData.status == 0) {

                $(nRow).find("td:eq(7)").html("<a class='btn btn-danger btn-xs' data='" + aData.Id + "," + aData.status + "' onclick='change(this,event)'><i class='glyphicon glyphicon-remove'></i> 关闭 </a>");
            } else if (aData.status == 1) {
                $(nRow).find("td:eq(7)").html("<a class='btn btn-info btn-xs' data='" + aData.Id + "," + aData.status + "' onclick='change(this,event)'><i class='glyphicon glyphicon-ok'></i> 开启 </a>");

            }

            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='eidt(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='del(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>");
            return nRow;
        }
    });
}

function change(e,event) {//由开启状态到关闭状态
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
        bootConfirm("亲，您确定要开启这条数据信息吗？", function () {
            change_close(id, status);
        });
    } else if (status == 1) {
        bootConfirm("亲，您确定要关闭这条数据信息吗？", function () {
            change_close(id, status);
        });
    }

}

function change_close(id, status) {
    $.post($(".btn-status").attr("data"), {id: id, status: status}, function (d) {
        if (d.code == 0) { //开启数据成功
            window.location.reload();
            bootMessage("success", d.message);
        } else if (d.code == 1) {
            bootMessage("danger", d.message);
        } else if (d.code == 2) {
            window.location.reload();
            bootMessage("success", d.message);
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}

/*function copy(e){
 event.stopPropagation();
 var data = $(e).attr("data").split(",");
 var nums = [];//用来存放id
 var path_url=[];//用来存放URL路径
 for (var i=0; i<data.length; i++)
 {
 if(i==0){
 nums.push(parseInt(data[i]));
 }else{
 path_url.push(data[i]);
 }
 }
 var id = nums;
 var url =path_url;


 }*/


function eidt(e,event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    window.location.href = $(".btn-edit").attr("data") + "?id=" + $(e).attr("data");
}

/*
 function del(e) {//删除行
 event.stopPropagation();
 var ids = $(e).attr("data");
 bootConfirm("亲，您确定要删除这条记录吗？", function () {
 deleteRow(ids);
 });
 }
 function deleteRow(ids) {
 $.post($(".btn-del").attr("data"), {id: ids}, function (d) {
 if (d.code == 0) {
 bootMessage("success", d.message);
 var arr = [];
 $.each(ids, function (i, id) {
 arr.push($(id).attr("data"));
 });
 deleteRow(arr.join(","));
 } else {
 bootMessage("danger", d.message);
 }
 }, "json");
 }*/

function del(e,event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    bootConfirm("亲，您是否要删除这条数据？", function () {
        deleteRow(id);
    });
}
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {id: ids}, function (d) {
        if (d.code == 0) {
            if (ids.split(",").length > 1) {
                window.location.reload();
                bootMessage("success", d.message);
            } else {
                window.location.reload();
                bootMessage("success", d.message);
            }
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
