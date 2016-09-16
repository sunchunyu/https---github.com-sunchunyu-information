/**
 * Created by liuwanqiu on 2016/4/7.
 */
window.onload=function(){
    if($('#st_status').val() == 2){
        bootMessage("warning", "操作失败~~~");
    }else if($('#st_status').val() == 1){
        bootMessage("success", "操作成功~~~");
    }
    $.post($('#clear_session').val(),{},function(){});
}
$(function () {

    $("#e1").select2();
    $('.date-picker').datepicker();
    $(".news-add").on("click", function () {
        window.location.href = $(this).attr("data");
    });
    $(".btn-del").on("click", function () {
        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除的资讯信息~~~");
        } else {
            bootConfirm("亲，您确定要删除这个资讯信息吗？", function () {
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
            bootMessage("warning", "亲，请先选择要编辑的资讯信息~~~");
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });
    $("#query").on("click", function () {
        GetData();
    })
    GetData();
});

var resultDataTable = null;
var Id = "";
function GetData() {
    $(".loading-container").show();
    var $searchResult = $("#list_table");
    $searchResult.dataTable().fnDestroy();
    resultDataTable = $searchResult.dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
        "searching": false,
        "bAutoWidth": false,
        "bStateSave": true,
        //"bProcessing": true, //开启读取服务器数据时显示正在加载中……特别是大数据量的时候，开启此功能比较好
        "bServerSide": true,//开启服务器模式
        "sAjaxSource": $("#list_table").attr("data"),
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
            {"data": "title", "sName": "title"},
            {"data": "type", "sName": "type"},
            {"data": "name", "sName": "name"},
            {"data": "update_time", "sName": "update_time"},
            {"data": "views", "sName": "views"},
            {"data": "tags", "sName": "tags"},
            {"data": "Id", "sName": "Id", "bStorable": false}
        ],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 6 ] }
        ],
        "aaSorting": [
            [3, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData["category_id"] = $('#e1 option:selected').val();
            aoData["type"] = $('#zixun option:selected').val();
            aoData["title"] = $('#title').val();
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
            $(nRow).find("td:last").html("<a class='btn btn-primary btn-xs' data='" + aData.Id + "' onclick='eidt(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='news_del(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>");
            return nRow;
        }
    });
}
function news_del(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    var e = $(e);
    bootConfirm("亲，您确定要删除这条数据？", function () {
        e.closest('tr').addClass('tr-selected');
        deleteRow(id);
    });
}
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {ids: ids}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            location.reload();
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
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