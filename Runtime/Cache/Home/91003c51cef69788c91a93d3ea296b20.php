<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="user-scalable=no,width=device-width, initial-scale=1,maximum-scale=1" name="viewport">
    <meta name="format-detection" content="telephone=no"/>
    <meta content="Title" name="apple-mobile-web-app-title">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <link href="//cdn.bootcss.com/meyer-reset/2.0/reset.min.css" rel="stylesheet">
    <link href="/informationcollection/Public/Static/css/wx.app.css" rel="stylesheet">
    <link href="/informationcollection/Public/Static/css/weui.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
    <script src="/Public/assets/js/jquery.scrollUp.js"></script>
    <title><?php echo C('AppName')?></title>
    
    
    <script>
        function getCookie(c_name) {
            if (document.cookie.length > 0) {
                c_start = document.cookie.indexOf(c_name + "=")
                if (c_start != -1) {
                    c_start = c_start + c_name.length + 1
                    c_end = document.cookie.indexOf(";", c_start)
                    if (c_end == -1) c_end = document.cookie.length
                    return unescape(document.cookie.substring(c_start, c_end))
                }
            }
            return ""
        }
        function setCookie(c_name, value, expiredays) {
            var exdate = new Date()
            exdate.setDate(exdate.getDate() + expiredays)
            document.cookie = c_name + "=" + escape(value) +
            ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
        }
        function showMsg(msg) {
            $(".weui_toast_content").html(msg);
            $('#toast').show();
            setTimeout(function () {
                $('#toast').hide();
            }, 2000);
        }
        $(function () {
            $.scrollUp({
                animation: 'fade',
                scrollImg: {
                    active: true
                }
            });
        })
    </script>
</head>
<body>
<div class="header" style="height: 50px;width: 100%;background-color: white;line-height: 50px;text-align: center;">
    
</div>


<div style="background-color: #FFFFFF;width: 100%;margin-top: 10px;text-align: center;color: #D5D5D6;font-size: 14px;padding: 10px 0px;">
    © 2016-2017 <?php echo C('AppName')?> <br>
    豫ICP备09018109号<br>
</div>
<!-- toast-->
<div id="toast" style="display: none;">
    <div class="weui_mask_transparent"></div>
    <div style="position: fixed;
    z-index: 3;
    width: 10em;
    left: 50%;
    margin-left: -5em;
    background: rgba(40, 40, 40, 0.75);
    text-align: center;
    border-radius: 5px;
    color: #FFFFFF;">
        <p style=" margin:  10px 0 10px 0px;"></p>
    </div>
</div>
<!--end toast-->

<!-- loading toast -->
<div id="loading" class="weui_loading_toast" style="display:none;">
    <div class="weui_mask_transparent"></div>
    <div class="weui_toast">
        <div class="weui_loading">
            <div class="weui_loading_leaf weui_loading_leaf_0"></div>
            <div class="weui_loading_leaf weui_loading_leaf_1"></div>
            <div class="weui_loading_leaf weui_loading_leaf_2"></div>
            <div class="weui_loading_leaf weui_loading_leaf_3"></div>
            <div class="weui_loading_leaf weui_loading_leaf_4"></div>
            <div class="weui_loading_leaf weui_loading_leaf_5"></div>
            <div class="weui_loading_leaf weui_loading_leaf_6"></div>
            <div class="weui_loading_leaf weui_loading_leaf_7"></div>
            <div class="weui_loading_leaf weui_loading_leaf_8"></div>
            <div class="weui_loading_leaf weui_loading_leaf_9"></div>
            <div class="weui_loading_leaf weui_loading_leaf_10"></div>
            <div class="weui_loading_leaf weui_loading_leaf_11"></div>
        </div>
        <p class="weui_toast_content">数据加载中</p>
    </div>
</div>
</body>



</html>