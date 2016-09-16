$(function () {
    $("#advanceSearch").on("click", function () {
        GetData();
    });
    GetData();
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
    $(".btn-power").on("click", function () {
        var id = $(".tr-selected").attr("data")
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要分配角色的用户~~~")
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });
    $(".btn-del").on("click", function () {
        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除的用户~~~")
        } else {
            bootConfirm("亲，您确定要删除这个用户吗？", function () {
                var arr = [];
                $.each(ids, function (i, id) {
                    arr.push($(id).attr("data"));
                });
                deleteRow(arr.join(","));
            });
        }
    });
    $(".btn-repass").on("click", function () {
        var id = $(".tr-selected").attr("data");
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要重置密码的用户~~~")
        } else {
            bootConfirm("亲，您确定要重置此用户密码吗？", function () {
                reSetPass(id);
            });
        }
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
        "sAjaxSource": $(".btn-query").attr("data"),
        "language": {
            "sZeroRecords": "没有您要搜索的内容",
            "sInfo": "从 _START_ 到 _END_ 条记录，总记录数为 _TOTAL_ 条",
            "sInfoEmpty": "总记录数为 0 条",
            "sInfoFiltered": "(全部记录数 _MAX_  条)",
            "sSearch": "",
            "sLengthMenu": "_MENU_",
            "sProcessing": "正在加载数据...",
            "oPaginate": {
                "sPrevious": "上一页",
                "sNext": "下一页"
            }
        },

        "columns": [
            {"data": "name"},
            {"data": "code" },
            {"data": "phone"},
            {"data": "email"},
            {"data": "role"},
            {"data": "Id", "bSearchable": false},
        ],
        "aaSorting": [
            [5, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = {
                n: $.trim($("#name").val()),
                c: $.trim($("#code").val()),
                p: $.trim($("#phone").val()),
                m: $.trim($("#mail").val())
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
            $(nRow).find("td:last").html("<a class='btn btn-info btn-xs' data='" + aData.Id + "' onclick='power(this,event)'><i class='glyphicon glyphicon-ok'></i> 角色 </a>&nbsp;<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='eidt(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='del(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>&nbsp;<a class='btn btn-darkorange btn-xs' data='" + aData.Id + "' onclick='repass(this,event)'><i class='glyphicon glyphicon-asterisk'></i> 密码重置 </a>");
            return nRow;
        }
    });
}
function repass(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    bootConfirm("亲，您确定要重置此用户密码吗？", function () {
        reSetPass(id);
    });

}
function power(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    window.location.href = $(".btn-power").attr("data") + "?id=" + $(e).attr("data");
}
function eidt(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    window.location.href = $(".btn-edit").attr("data") + "?id=" + $(e).attr("data");
}
function del(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    bootConfirm("亲，您确定要删除这个用户吗？", function () {
        deleteRow(id);
    });
}
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {ids: ids}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            if (ids.split(",").length > 1) {
                $(".tr-selected").remove();
            } else {
                $("#tr_" + ids).remove();
            }
            var table = $("#simpledatatable").DataTable();
            table.ajax.reload();
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
function reSetPass(id) {
    $.post($(".btn-repass").attr("data"), {id: id}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}