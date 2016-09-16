/**
 * Created by liuwanqiu on 2016/4/7.
 */
window.onload=function(){
    $('.dropify-clear').text("移除");
    $('.dropify-infos-message').text('拖文件至此处或者点击此处');
    if($('#cate_hide').val() != ''){
        var arr = [];
        var node = $('#category option');
        for(var i = 0,l = node.length;i<l;i++){
            arr[i] = $(node[i]).attr('value');
        }
        //判断是否存在
        if(arr.indexOf($('#cate_hide').val()) != -1){
            $('#category').val($('#cate_hide').val());
        }
    }
    if($('input[name="news-type-radio"]:checked').val() == 0){
        $('#other_url').attr('disabled',true);
    }else{
        $('#other_url').attr('disabled',false);
    }
}
var ue = UE.getEditor('myEditor');
ue.ready(function () {
    $("#edui1").css("z-index", 0);
});
$(function () {
    $('.dropify').dropify();

    $("#upload_up").on("click", function () {
        if ($(this).val() != "") {
            window.location.href = $(this).val();
        }
    });
    //隐藏一些元素
    $('#other_url').attr("disabled", "disabled");
    //判断是修改还是上传
    String.prototype.endWith = function (endStr) {
        var d = this.length - endStr.length;
        return (d >= 0 && this.lastIndexOf(endStr) == d)
    }
    var str = $('input[name="img_up"]').val();
    if (str.endWith(".png")) {
        sourceLink = '';
    } else {
        sourceLink = str;
    }
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: 'upload_img',         // 上传选择的点选按钮ID，**必需**
        uptoken: $("#upload_up").attr("data"),                // 七牛的token
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        domain: $("#upload_div").attr("data"),     // bucket 域名，下载资源时用到，**必需**
        container: 'upload_div',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
        max_file_size: '5mb',               // 最大文件体积限制
        flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入 flash,相对路径
        max_retries: 3,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: 'upload_div',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        init: {
            'FilesAdded': function (up, files) {
                plupload.each(files, function (file) {
                });
            },
            'BeforeUpload': function (up, file) {
            },
            'UploadProgress': function (up, file) {
            },
            'FileUploaded': function (up, file, info) {
                var domain = up.getOption('domain');

                var res = JSON.parse(info);
                sourceLink = domain + res.key;
                console.log(sourceLink);
            },
            'Error': function (up, err, errTip) {
            },
            'UploadComplete': function () {
                $('#upload_up').val(sourceLink);
            },
            'Key': function (up, file) {
                var key = file;
                return key;
            }
        }
    });
    //单选类型按钮的change事件
    $("input[name='news-type-radio']").on('change', function () {
            var zx_radio = $("input[name='news-type-radio']:checked").val();
            if (zx_radio == 0) {
                $('#ue').show();
                $('#other_url').attr("disabled", "disabled");
            } else {
                $('#ue').hide();
                $('#other_url').removeAttr("disabled");
            }
        }
    );
    //保存咨询信息
    $('.news_add_save').click(function () {
        var zx_title = $('#zx_title').val();
        var zx_radio = $("input[name='news-type-radio']:checked").val();
        var zx_se = $("#category option:selected").val();
        var other_url = $('#other_url').val();
        var img_url = sourceLink;
        var textarea = $('textarea').val();
        var ue_html = UE.getEditor('myEditor').getContent();
        var tag = $('#tags').val();
        var len = $('.label-info').length;
        if(len>0){
            for(var i = 0;i<len;i++){
                if($($('.label-info')[i]).text().length>10){
                    bootMessage("info", "亲，标签输入长度不合法~~~");
                    return;
                }
            }
        }
        if (!$.trim(zx_title)) {
            bootMessage("info", "亲，请输入咨询标题~~~");
        } else if (!$.trim(textarea)) {
            bootMessage("info", "亲，请输入咨询摘要~~~");
        } else if (!$.trim(img_url)) {
            bootMessage("info", "亲，请上传封面图~~~");
        } else {
            if (zx_radio == 1) {
                if (!$.trim(other_url)) {
                    bootMessage("info", "亲，请输入外站链接~~~");
                    return;
                }
            }
            $("input[name='hide_img']").val(img_url);
            $('#img_status').val($('.dropify-render img').attr('src'));
            $('form').submit();
        }
    });
});
