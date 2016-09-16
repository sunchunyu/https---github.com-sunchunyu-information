/**
 * Created by liuwanqiu on 2016/4/10.
 */
/**
 * Created by liuwanqiu on 2016/4/10.
 */
var ue = UE.getEditor('myEditor');
$(function(){
    $('.dropify').dropify();
    //提交表单
    $('.employer_add_save').click(function(){
        var cemployer_title = $('#cemployer_title').val();
        var industry_title = $('#industry_title').val();
        var com_size = $('#com_size').val();
        var addr = $('#addr').val();
        var tel = $('#tel').val();
        var email = $('#email').val();
        //验证邮箱的正则
        var em = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if(!$.trim(cemployer_title)){
            bootMessage("info", "亲，请输入岗位名称~~~");
            return;
        }
        if($.trim($('input[name="url"]').val())){
            if(!(/http:\/\/.+/.test($('input[name="url"]').val()))){
                bootMessage("info", "亲，网址输入不合法~~~");
                return;
            }
        }
        if(!$.trim(addr)){
            bootMessage("info", "亲，请输入单位详细地址~~~");
        }else if(!$.trim(tel)){
            bootMessage("info", "亲，请输入单位电话~~~");
        }else if(!$.trim(email)){
            bootMessage("info", "亲，请输入单位邮箱~~~");
        }else if(!em.test(email)){
            bootMessage("info", "亲，请输入单位邮箱的正确格式~~~");
        }else{
            $('#hide').val(UE.getEditor('myEditor').getContent());
            $('#img_status').val($('.dropify-render img').attr('src'));
            $('form').submit();
        }
    });
});
window.onload=function(){
    $('.dropify-clear').text("移除");
    $('.dropify-infos-message').text('拖文件至此处或者点击此处');

}