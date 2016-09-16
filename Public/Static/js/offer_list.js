/**
 * Created by liuwanqiu on 2016/4/10.
 */
$(function () {
    $("#e1").select2();
    $('.date-picker').datepicker();
    GetData();
    $(".loading-container").show();
    $('.category-add').on('click', function () {
        window.location.href = $(this).attr("data");
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
    $(".btn-edit").on("click", function () {
        var id = $(".tr-selected").attr("data");
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要编辑的用户~~~");
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });

});
var resultDataTable = null;
var Id = "";
function GetData() {
    var $searchResult = $("#offer_table");
    $searchResult.dataTable().fnDestroy();
    resultDataTable = $searchResult.dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
        "bAutoWidth": false,
        "bProcessing": true, //开启读取服务器数据时显示正在加载中……特别是大数据量的时候，开启此功能比较好
        "searching": false,
        "bStateSave": true,
        "bServerSide": true,//开启服务器模式
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
            {"data": "offer_name"},
            {"data": "addr"},
            {"data": "salary"},
            {"data": "number"},
            {"data": "education"},
            {"data": "worklife"},
            {"data": "category"},
            {"data": "update_time"},
            {"data": "is_top","bSortable": false},
            {"data": "Id","bSortable": false}
        ],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 9 ] }
        ],
        "aaSorting": [
            [7, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData["salary"] = $('#salary option:selected').val();
            aoData["name"] = $('#name').val();
            aoData["addr"] = $('#addr').val();
            aoData["education"] = $('#education option:selected').val();
            aoData["count"] = $('#count').val();
            aoData["category"] = $('#e1 option:selected').val();
            aoData["worklife"] = $('#worklife option:selected').val();
            aoData["begin_time"] = $('#id-date-picker-1').val();
            aoData["end_time"] = $('#id-date-picker-2').val();

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
            $("input[type=search]").attr("placeholder", "筛选");
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
            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='eidt(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='del(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>&nbsp;");
            if (aData.is_top == 1) {
                $(nRow).find("td:last").prev().html('<label><input' +
                    ' class="checkbox-slider colored-blue"' + ' type="checkbox" checked><span class="text"' +
                    '  onclick="top_change(this,event)" data="' + aData.Id + '"></span></label>');
            } else {
                $(nRow).find("td:last").prev().html('<label data="' + aData.Id + '"><input' +
                    ' class="checkbox-slider colored-blue"' + ' type="checkbox"><span class="text"  data="' + aData.Id + '"onclick="top_change(this,event)"></span></label>');
            }
            return nRow;
        }
    });
}
function top_change(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    $.post($('.btn-top').attr('data'), {id: $(e).attr('data')}, function (mag) {
        if (mag) {
            bootMessage("success", d.message);
        } else {
            bootMessage("danger",d.message);
        }
    });
}
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {ids: ids}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            location.reload();
        } else {
            bootMessage("danger",d.message);
        }
    });
}
function del(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    var e = $(e);
    bootConfirm("亲，您确定要删除这个用户吗？", function () {
        e.closest('tr').addClass('tr-selected');
        deleteRow(id);
    });
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