$(function () {
    GetData();
})

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
        "iDisplayLength": 100,
        "bAutoWidth": false,
        "sAjaxSource": $(".btn-query").attr("data"),
        "bStateSave": true,
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
        "aaSorting": [
            [0, 'asc']
        ],
        "columns": [
            {"data": "sort", "bSortable": false, width: "60px"},
            {"data": "name", "bSortable": false},
            {"data": "icon", "bSortable": false},
            {"data": "url", "bSortable": false},
            {"data": "Id", "bSortable": false, "bSearchable": false},
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = null;
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
            $(".sorting_asc").removeClass("sorting_asc");
            $("#simpledatatable_filter,#simpledatatable_length,.DTTTFooter,.btn-group").remove();
            var arr = $("tbody>tr");
            $.each(arr, function (i, item) {
                if (i == 0) {
                    $(item).find("td:eq(4)").find("a:first").attr("disabled", "disabled");
                } else if ((arr.length - 1) == i) {
                    $(item).find("td:eq(4)").find("a:last").attr("disabled", "disabled");
                } else {

                }
            });
        },
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).find("td:eq(0)").html(iDisplayIndex + 1);
            $(nRow).attr("data", aData.Id);
            $(nRow).attr("sort", aData.sort);
            $(nRow).find("td:eq(2)").html(aData.icon == "" ? "<a class='btn btn-success btn-xs'>" + aData.name.substr(0, 1) + "</a>" : "<a class='btn btn-success btn-xs' href='" + $("#path").val() + aData.icon + "' target='_blank'><i class='fa fa-external-link-square'></i> 预览</a>");
            $(nRow).find("td:eq(3)").html(aData.url == "" ? "" : "<a class='btn btn-darkorange btn-xs' title='" + aData.url + "' href='" + aData.url + "' target='_blank'><i class='fa fa-chain'></i> 查看</a>");
            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' sort='" + aData.sort + "' data='" + aData.Id + "' onclick='tr_up(this,event)'><i class='fa fa-arrow-up'></i></a>&nbsp;<a class='btn btn-primary btn-xs' sort='" + aData.sort + "' data='" + aData.Id + "' onclick='tr_down(this,event)'><i class='fa fa-arrow-down'></i></a>");
            return nRow;
        }
    });
}
function tr_up(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var _from_id = $(e).attr("data");
    var _from_sort = $(e).attr("sort");
    var _to_id = $(e).parent().parent().prev().attr("data");
    var _to_sort = $(e).parent().parent().prev().attr("sort");
    $.post($("#desktop_move").val(), {
        from_id: _from_id,
        from_sort: _from_sort,
        to_id: _to_id,
        to_sort: _to_sort
    }, function (d) {
        if (d.data == 0) {
            bootMessage("warning", "亲，操作失败~~~");
        } else {
            resultDataTable.fnClearTable();
            resultDataTable.fnAddData(d.data);
            resultDataTable.fnDraw();
            var arr = $("tbody>tr");
            $.each(arr, function (i, item) {
                if (i == 0) {
                    $(item).find("td:eq(4)").find("a:first").attr("disabled", "disabled");
                } else if ((arr.length - 1) == i) {
                    $(item).find("td:eq(4)").find("a:last").attr("disabled", "disabled");
                } else {

                }
            });
        }
    }, "json");
}
function tr_down(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var _from_id = $(e).attr("data");
    var _from_sort = $(e).attr("sort");
    var _to_id = $(e).parent().parent().next().attr("data");
    var _to_sort = $(e).parent().parent().next().attr("sort");
    $.post($("#desktop_move").val(), {
        from_id: _from_id,
        from_sort: _from_sort,
        to_id: _to_id,
        to_sort: _to_sort
    }, function (d) {
        if (d.data == 0) {
            bootMessage("warning", "亲，操作失败~~~");
        } else {
            resultDataTable.fnClearTable();
            resultDataTable.fnAddData(d.data);
            resultDataTable.fnDraw();
            var arr = $("tbody>tr");
            $.each(arr, function (i, item) {
                if (i == 0) {
                    $(item).find("td:eq(4)").find("a:first").attr("disabled", "disabled");
                } else if ((arr.length - 1) == i) {
                    $(item).find("td:eq(4)").find("a:last").attr("disabled", "disabled");
                } else {

                }
            });
        }
    }, "json");
}