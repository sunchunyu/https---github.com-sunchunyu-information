function myTreeInit() {
    var DataSourceTree = function (option) {
        this._data = option.data;
    };

    DataSourceTree.prototype = {
        data: function (options, callback) {
            var self = this;
            var data = $.extend(true, [], self._data);
            callback({data: data});
        }
    };
    $('#MyTree').tree({
        dataSource: new DataSourceTree(getRoles()),
        folderSelect: false,
        multiSelect: true,
        cacheItems: true,
        loadingHTML: '<div class="tree-loading"><i class="fa fa-rotate-right fa-spin"></i></div>'
    });
}
function getRoles() {
    //同步
    var temp_tree_data = {data: []};
    $.ajax({
        async: false,
        cache: false,
        type: 'POST',
        url: $("#btn-power").val(),
        data: {id: $("#btn-power").attr("data")},
        dataType: "json",
        error: function () {

        },
        success: function (result) {
            temp_tree_data.data = result.result;
        }
    });
    return temp_tree_data;
}
function addRole(ids) {
    $.post($(".btn-save").attr("data"), {ids: ids, uid: $("#btn-power").attr("data")}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
$(function () {
    myTreeInit();
    $('.btn-save').on('click', function () {
        //console.log('item selected: ', $('#MyTree').tree('selectedItems'));
        var selected = $('#MyTree').tree('selectedItems');
        if (selected.length == 0) {
            bootConfirm("亲，你没有选择任何角色，确定要移除用户的所有角色吗？", function () {
                addRole("");
            });
        } else {
            var ids = [];
            $.each(selected, function (i, item) {
                ids.push(item.id);
            });
            addRole(ids.join(","));
        }
    });
});