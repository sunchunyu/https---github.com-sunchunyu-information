var setting = {
    check: {
        enable: true,
        chkStyle: "checkbox",
        expandSpeed: "fast",
        chkboxType: {"Y": "ps", "N": "s"}
    },
    view: {
        showIcon: false,
        dblClickExpand: false
    },
    callback: {
        onClick: function (event, treeId, treeNode) {
            treeObj.checkNode(treeNode, !treeNode.checked, true);
        },
        onAsyncSuccess: function () {
            var arrPages = JSON.parse($("#pages").val());
            $.each(arrPages, function (i, item) {
                var nodes = treeObj.getNodesByParam("id", item, null);
                treeObj.checkNode(nodes[0], true, false);
            });
        }
    },
    data: { // 必须使用data
        simpleData: {
            enable: true,
            idKey: "id", // id编号命名
            pIdKey: "pId", // 父id编号命名
            rootId: 0
        }
    },
    async: {
        enable: true,
        dataType: "json",
        url: $("#btn-power").val()
    }
};

var treeObj = null;
$(document).ready(function () {
    treeObj = $.fn.zTree.init($("#treeDemo"), setting);
    $(".btn-save").on("click", function () {
        var nodes = treeObj.getCheckedNodes(true);
        var ids = [];
        $.each(nodes, function (i, item) {
            ids.push(item.id);
        });
        if (ids.length == 0) {
            bootConfirm("亲，你没有选择任何权限，确定要移除角色的所有权限吗？", function () {
                addPages(ids);
            });
        } else {
            addPages(ids)
        }

    });
});
function addPages(ids) {
    $.post($(".btn-save").attr("data"), {ids: ids.join(","), rid: $("#btn-power").attr("data")}, function (d) {
        if (d.code == 0) {
            bootMessage("success", d.message);
        } else {
            bootMessage("danger", d.message);
        }
    }, "json");
}
