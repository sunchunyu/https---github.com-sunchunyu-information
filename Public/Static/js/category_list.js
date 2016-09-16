/**
 * Created by liuwanqiu on 2016/4/9.
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
    $('.category-add').on('click', function () {
        window.location.href = $(this).attr("data");
    });
    GetData();
    $(".btn-del").on("click", function () {
        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除类别~~~")
        } else {
            bootConfirm("亲，您确定要删除这个类别吗？", function () {
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
            bootMessage("warning", "亲，请先选择要编辑的类别~~~")
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });
});
function deleteRow(ids) {
    $.post($(".btn-del").attr("data"), {ids: ids}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            var table = $("#simpledatatable").DataTable();
            table.ajax.reload();
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
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
        "iDisplayLength": 100,
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
            {"data": "Id", "width": "20px", "bSortable": false},
            {"data": "name", "width": "300px"},
            {"data": "icon"},
            {"data": "url"},
            {"data": "status", "bSortable": false},
            {"data": "Id", "bSortable": false},
        ],
        "aaSorting": [
            [1, 'desc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = null;
            $.ajax({
                "type": 'post',
                "url": sSource,
                "dataType": "json",
                "data": {
                    aoData: 0
                },
                "success": function (resp) {
                    fnCallback(resp);
                    $(".loading-container").hide();

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
            $($(nRow).find("td:eq(0)")).html(aData.url == "" ? "<i class='fa fa-plus-square i-expand'></i>" : "<i class='fa fa-minus-square'></i>");
            $(nRow).find("td:eq(2)").html(aData.icon == "" ? "<a class='btn btn-success btn-xs'>" + aData.name.substr(0, 1) + "</a>" : "<a class='btn btn-success btn-xs' href='" + aData.icon + "' target='_blank'><i class='fa fa-external-link-square'></i> 预览</a>");
            $(nRow).find("td:eq(3)").html(aData.url == "" ? "" : "<a class='btn btn-darkorange btn-xs' title='" + aData.url + "' href='" + aData.url + "' target='_blank'><i class='fa fa-chain'></i> 查看</a>");
            $(nRow).find("td:eq(4)").html(aData.is_desktop == 0 ? "否" : "是");
            $(nRow).attr("data", aData.Id);
            $(nRow).attr("title", aData.name);
            $(nRow).attr("id", "tr_" + aData.Id);
            var html = "";
            if (aData.is_desktop == 0) {
                html = "<a class='btn btn-primary btn-xs btn-desktop' data='" + aData.Id + "'><i class='fa fa-star'></i> 设为显示 </a>&nbsp;";
            } else {
                html = "<a class='btn btn-primary btn-xs btn-desktop' data='" + aData.Id + "'><i class='fa fa-star-o'></i> 取消显示 </a>&nbsp;";
            }
            //html += "<a class='btn btn-sky btn-xs btn-up' data='" + aData.Id + "' onclick='power(this)'><i class='fa fa-arrow-up'></i></a>&nbsp;<a class='btn btn-sky btn-xs btn-down' data='" + aData.Id + "' onclick='power(this)'><i class='fa fa-arrow-down'></i></a>";
            html += "<a class='btn btn-info btn-xs' data='" + aData.Id + "' onclick='tr_edit(this,event)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + aData.Id + "' onclick='tr_delete(this,event)'><i class='glyphicon glyphicon-trash'></i> 删除 </a>";
            $(nRow).find("td:last").html(html);
            $(nRow).find(".i-expand").one("click", function () {
                openHtml(this);
            });
            $(nRow).find(".btn-desktop").one("click", function (event) {
                if (aData.is_desktop == 0) {
                    tr_show(this,event);
                }
                else {
                    tr_hide(this,event);
                }
            });
            return nRow;
        }
    });
}
function tr_show(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    $.post($("#desktop").val(), {id: id, s: 1}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            $(e).parent().parent().find("td:eq(4)").html("是");
            $(e).html("<i class='fa fa-star-o'></i> 取消显示</a>&nbsp;");
            $(e).one("click", function (event) {
                tr_hide(e,event);
            })
        } else {
            bootMessage("danger", d.message);
        }
    }, "json")
}
function tr_hide(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    $.post($("#desktop").val(), {id: id, s: 0}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
            $(e).parent().parent().find("td:eq(4)").html("否");
            $(e).html("<i class='fa fa-star'></i> 设为显示</a>&nbsp;");
            $(e).one("click", function (event) {
                tr_show(e,event);
            });
        }
        else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
function tr_edit(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    window.location.href = $(".btn-edit").attr("data") + "?id=" + $(e).attr("data");
}
function tr_delete(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    var id = $(e).attr("data");
    bootConfirm("亲，您确定要删除这个类别吗？", function () {
        deleteRow(id);
    });
}
function closeHtml(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    $(".add").remove();
    $(e).removeClass("fa-minus-square").addClass("fa-plus-square");
    $(e).one("click", function (event) {
        openHtml(this,event);
    });
    $(".btn-down,.btn-up").show();
}
function openHtml(e, event) {
    $(".loading-container").removeClass("loading-inactive").show();
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    $(e).one("click", function (event) {
        closeHtml(this,event);
    });

    var id = $(e).parent().parent().attr("data");
    $.post($(".btn-query").attr("data"), {aoData: id},
        function (d) {
            $(".loading-container").hide();
            if (d.data.length > 0) {

                $.each(d.data, function (i, item) {
                    var tr = "";
                    var td = "";
                    if (i == 0) {
                        //td = "<td rowspan='" + d.data.length + "'>" + $(e).parent().parent().attr("title") + "</td>";
                    }
                    td = "<td></td>";
                    td += "<td>" + item["name"] + "</td>";
                    if (item["icon"] == "") {
                        td += "<td><a class='btn btn-success btn-xs'>" + item["name"].substr(0, 1) + "</a></td>";
                    } else {
                        td += "<td><a class='btn btn-success btn-xs' href='" + item["icon"] + "' target='_blank'><i class='fa fa-external-link-square'></i> 预览</a></td>";
                    }
                    if (item["url"] == "") {
                        td += "<td></td>";
                    } else {
                        td += "<td><a class='btn btn-darkorange btn-xs' title='" + item["url"] + "' href='" + item["url"] + "' target='_blank'><i class='fa fa-chain'></i> 查看</a></td>";
                    }
                    var dd = "";
                    var is_desktop = item["is_desktop"];
                    if (is_desktop == 0) {
                        td += "<td>否</td>";
                    } else {
                        td += "<td>是</td>";
                    }
                    if (is_desktop == 0) {
                        dd = "<a class='btn btn-primary btn-xs add-desktop' data='" + item["Id"] + "'><i class='fa fa-star'></i> 设为显示 </a>&nbsp;";
                    } else {
                        dd = "<a class='btn btn-primary btn-xs add-desktop' data='" + item["Id"] + "'><i class='fa fa-star-o'></i> 取消显示 </a>&nbsp;";
                    }
                    tr += "<tr class='add' data=" + item["Id"] + " id='tr_" + item["Id"] + "'>" + td + "<td>" + dd + "<a class='btn btn-info btn-xs' data='" + item["Id"] + "' onclick='tr_edit(this)'><i class='glyphicon glyphicon-pencil'></i> 编辑 </a>&nbsp;<a class='btn btn-danger btn-xs' data='" + item["Id"] + "' onclick='tr_delete(this)'><i class='glyphicon glyphicon-trash'></i> 删除 </a></td></tr>";
                    $(e).parent().parent().after(tr);
                    $("#tr_" + item["Id"] + ">td").find(".add-desktop").one("click", function (event) {
                        if ($.trim($(this).parent().parent().find("td:eq(4)").html()) == "否") {
                            tr_show(this,event);
                        }
                        else {
                            tr_hide(this,event);
                        }
                    });

                });

                $(e).removeClass("fa-plus-square").addClass("fa-minus-square");
                $(".btn-down,.btn-up").hide();
            } else {
                bootMessage("info", "亲，没有子类别信息~~~");
            }
        }, "json");

}

function tr_edit(e, event) {
    event = event || window.event;
    if (event.stopPropagation) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
    window.location.href = $(".btn-edit").attr("data") + "?id=" + $(e).attr("data");
}

