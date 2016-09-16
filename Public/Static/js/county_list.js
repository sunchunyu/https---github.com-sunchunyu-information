/**
 * Created by MrLiu on 2016/4/9.
 */
/**
 * Created by MrLiu on 2016/4/8.
 */
$(function () {
    $('.loading-container').removeClass("loading-inactive");
    $('.loading-container').show();
    GetData();
    $(".btn-add").on("click", function () {
        window.location.href = $(this).attr("data");
    });
    $(".btn-edit").on("click", function () {
        var id = $(".tr-selected").attr("data")
        if (id === undefined) {
            bootMessage("warning", "亲，请先选择要编辑的地区~~~")
        } else {
            window.location.href = $(this).attr("data") + "?id=" + id;
        }
    });
    $(".btn-del").on("click", function () {

        var ids = $(".tr-selected");
        if (ids.length == 0) {
            bootMessage("warning", "亲，请先选择要删除的地区~~~");
        } else {
            bootConfirm("亲，您确定要删除这个地区吗？", function () {
                var arr = [];
                $.each(ids, function (i, id) {
                    arr.push($(id).attr("data"));
                });
                deleteRow(arr.join(","));
            });
        }
    });
    /*初始化省市区函数*/
    $('.btn-init').on("click", function () {
        var rel = bootConfirm("亲，您确定要初始化省市区信息么？", function () {
            $('.loading-container').removeClass("loading-inactive");
            $('.loading-container').show();
            inputNation();
            setTimeout(function () {
                location.reload();
            }, 4000);
        });

    });
    $(".search").click(function () {
        $('.loading-container').removeClass("loading-inactive");
        $('.loading-container').show();
        GetData();
    });

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
            "oPaginate": {
                "sPrevious": "上一页",
                "sNext": "下一页"
            }
        },

        "columns": [
            {"data": "name"},
            {"data": "type"},
            {"data": "city_id"},
            {"data": "province_id"},
            {"data": "Id", "bSearchable": false},
        ],
        "aaSorting": [
            [3, 'asc'],[2,'asc'],[1,'asc']
        ],
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData = {
                "pro_id": $("#pro-list").find("option:selected").val(),
                "city_id": $("#city-list").find("option:selected").val(),
                "name": $(".Name").val(),
            };
            console.log(aoData);
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
            $('.loading-container').hide();

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

function inputNation() {
    var post_url = $('#county-url').attr('data');

    $.post(post_url, function (data) {
        if (data.code == 1) {
            bootMessage("success", "数据初始化完成~~~")
        } else {
            bootMessage("warning", "亲，初始化失败~~~")
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
    bootConfirm("亲，您确定要删除这个地区吗？", function () {
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

//市区列表级联更新
$('#pro-list').change(function () {
    $('#city-list option').remove();
    if (($('#pro-list').val()) != 0) {
        $.post($("#get-city-rul").attr("data"), {
            "Id": $('#pro-list').val(),
        }, function (d) {
            if (d.info.code == 0) {
                var city_data = d.data;
                var option_group = '';
                $('#city-list').append('<option value=-1>未选</option>');
                for (var i = 0; i < city_data.length; i++) {
                    option_group = option_group + '<option value=' + city_data[i].Id + '>' + city_data[i].name + '</option>';
                }
                $('#city-list').append(option_group);
            }else{
                $('#city-list').append('<option value=-1>未选</option>');
            }
        });
    } else {
        $('#city-list').append('<option value=-1>未选</option>');
    }

});