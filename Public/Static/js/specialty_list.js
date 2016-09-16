$(function () {
    GetData();
    //新增，编辑和删除按钮
    $(".btn-add").on("click", function () {
        window.location.href = $(this).attr("data");
    });
    $(".btn-edit").on("click", function () {
        var id = $(".tr-selected").attr("data")
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要编辑的用户~~~")
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });

    $(".btn-del").on("click", function () {
        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除的记录~~~")
        } else {
            bootConfirm("亲，您确定要删除这个专业吗？警告：执行操作将解除与对应班级关系！！", function () {
                var arr = [];
                $.each(ids, function (i, id) {
                    arr.push($(id).attr("data"));
                });
                deleteRow(arr.join(","));
            });
        }
    });

    $(".btn-primary").on("click", function () {
        $(".loading-container").removeClass("loading-inactive")
        $(".loading-container").show();
        GetData();      //执行查询
    });

    /*
     级联更新下拉列表
     */
    $("#college_0").on("change", function () {
        //console.log("college_0  change");
        var id = $(this).val();

        $("#college_1 option").each(function (index) {
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

        $("#college_1").val("0");
        $("#specialty").val("0");
        $("#college_0 option").each(function (index) {
            $(this).show();
        });
    })

    $("#college_1").on("change", function () {
        var id = $(this).val();
        var parent = $(this).children("option[value=" + id + "]").data('parent');   //获取选择值的父id
        //设置上级选项
        $("#college_0 option").each(function (index) {
            $(this).show();
        });

        $("#college_0").val(parent);
    })
});
var resultDataTable = null;
var Id = "";
function GetData() {
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
        "sAjaxSource": $("#url").val(),
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
            {"data": "name"},
            {"data": "college_id.name"},
            {"data": "college_id.college"},
            {"data": "Id", "bSortable": false, "bSearchable": false}
        ],
        "aaSorting": [
            [3, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = {
                "p_id": $("#college_0").val(),
                "college_id": $("#college_1").val()
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
                }
            });

        },
        "fnInitComplete": function () {
            $("input[type=search]").attr("placeholder", "全文筛选");
            $(".loading-container").hide();
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

            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='eidt(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='del(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>");
            return nRow;
        }
    });
}


function power(e,event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    window.location.href = $(".btn-power").attr("data") + "?id=" + $(e).attr("data");
}
function eidt(e,event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    window.location.href = $(".btn-edit").attr("data") + "?id=" + $(e).attr("data");
}
function del(e,event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    bootConfirm("亲，您确定要删除这个专业吗？警告：执行操作将解除与对应班级关系！！", function () {
        deleteRow(id);
    });
}
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {id: ids}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            var table = $("#simpledatatable").DataTable();
            table.ajax.reload();
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}