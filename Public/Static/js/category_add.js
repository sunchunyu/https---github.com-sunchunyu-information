/**
 * Created by liuwanqiu on 2016/4/9.
 */
$(function(){
    //上传文件插件初始化
    $('#father-select').hide();
    $('.dropify').dropify();
    //选择父类或子类的change事件
    $("input[name='type-radio']").change(function(){
        var val = $("input[name='type-radio']:checked").val();
        $('#father-select label').next().remove();
        if(val==1){
            //小类
            $.post($('#type').attr('data'),{},function(msg){
                    if(msg){
                        var node = $('#father-select').append('<select class="form-control father" name="category_type"></select>');
                        var l = msg.length;
                        for(var i=0;i<l;i++){
                            $('#father-select select').append('<option value="'+msg[i]['Id']+'">'+msg[i]['name']+'</option>');
                        }
                        $('#father-select').show();
                    }
                }
            );
        }else{
            $('#father-select').hide();
        }
    });
    //点击保存按钮
    $('.category_add_save').click(function(){
        var url = $(this).attr('data');
        var category_title = $('#category_title').val();
        var icon = $('#input-file-now').val();
        //判断上传文件类型
        var re = /(\\+)/g;
        var filename=icon.replace(re,"#");
        var one=filename.split("#");
        var two=one[one.length-1];
        //再对文件名进行截取，以取得后缀名
        var three=two.split(".");
        //获取截取的最后一个字符串，即为后缀名
        var last=three[three.length-1];
        //添加需要判断的后缀名类型
        var tp ="jpg,gif,JPG,GIF,png,jpeg";
        //返回符合条件的后缀名在字符串中的位置
        var rs=tp.indexOf(last);
        if(!$.trim(category_title)){
            bootMessage("info", "亲，请输入资讯名称~~~");
            return;
        }
        if($.trim($('input[name="url"]').val())){
            if(!(/http:\/\/.+/.test($('input[name="url"]').val()))){
                bootMessage("info", "亲，网址输入不合法~~~");
                return;
            }
        }
        if(rs<0){
            bootMessage("warnning", "亲，上传类型错误~~~");
        }else{
            $('#img_status').val($('.dropify-render img').attr('src'));
            $('form').submit();
        }
    });
});
window.onload=function(){
    $('.dropify-clear').text("移除");
    $('.dropify-infos-message').text('拖文件至此处或者点击此处');
    if($('#hide_fa').val() != 0){
        $.post($('#type').attr('data'),{},function(msg){
                if(msg){
                    var node = $('#father-select').append('<select class="form-control father" name="category_type"></select>');
                    var l = msg.length;
                    for(var i=0;i<l;i++){
                        $('#father-select select').append('<option value="'+msg[i]['Id']+'">'+msg[i]['name']+'</option>');
                    }
                    $('#father-select').show();
                    $("select[name='category_type']").val($('#hide_fa').val());
                }
            }
        );

    }
}
