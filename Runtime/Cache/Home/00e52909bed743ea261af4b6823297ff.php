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
    <script src="/informationcollection/Public/assets/js/jquery.scrollUp.js"></script>
    <title><?php echo C('AppName')?></title>
    
    <!--本页面CSS-->
    <link href="//cdn.bootcss.com/Swiper/3.3.1/css/swiper.min.css" rel="stylesheet">
    <style>
        .cell-span {
            background-color: #e8e8e8;
            color: #000000;
            width: 28px;
            height: 28px;
            display: inline-block;
            text-align: center;
            line-height: 28px;
            border-radius: 3px;
            font-weight: bolder;
        }
    </style>

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
    
    首页

</div>

    <!--本页面Body-->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img data="http://7xsqzj.com2.z0.glb.clouddn.com/lyys0.jpg"></div>
            <div class="swiper-slide"><img data="http://7xsqzj.com2.z0.glb.clouddn.com/lyys1.jpg"></div>
            <div class="swiper-slide"><img data="http://7xsqzj.com2.z0.glb.clouddn.com/lyys2.jpg"></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="weui_grids" style="background-color: white;margin-top: 10px;">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["url"] != ''): ?><a href="<?php echo ($vo["url"]); ?>" class="weui_grid js_grid" data-id="cell">
                    <?php else: ?>
                    <a href="<?php echo U('p');?>?id=<?php echo ($vo["Id"]); ?>" class="weui_grid js_grid"
                       data-id="cell"><?php endif; ?>
            <div class="weui_grid_icon">
                <?php if($vo["icon"] != ''): ?><img src="<?php echo ($vo["icon"]); ?>" alt="<?php echo ($vo["name"]); ?>">
                    <?php else: ?>
                    <span class="cell-span"><?php echo (gm_substr($vo["name"],0,1)); ?></span><?php endif; ?>
            </div>
            <p class="weui_grid_label">
                <?php echo (gm_substr($vo["name"],0,5)); ?>
            </p>
            </a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="weui_panel">
        <div class="weui_panel_hd">新闻资讯</div>
        <div class="weui_panel_bd">
            <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["url"] == ''): ?><div class="weui_media_box weui_media_text" data="<?php echo U('home/index/d');?>?id=<?php echo ($vo["Id"]); ?>">
                        <?php else: ?>
                        <div class="weui_media_box weui_media_text" data="<?php echo ($vo["url"]); ?>"><?php endif; ?>

                <h4 class="weui_media_title"><?php echo ($vo["title"]); ?></h4>

                <p class="weui_media_desc"><?php echo ($vo["abstract"]); ?></p>
                <ul class="weui_media_info">
                    <li class="weui_media_info_meta"><?php echo ($vo["name"]); ?></li>
                    <li class="weui_media_info_meta weui_media_info_meta_extra"><?php echo (date("Y-m-d",$vo["update_time"])); ?></li>
                    <!--<li class="weui_media_info_meta">浏览<?php echo ($vo["views"]); ?>次</li>-->
                </ul>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <a href="<?php echo U('home/index/m');?>?id=0" class="weui_panel_ft" style="font-size: 13px;">查看更多</a>
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

    <!--本页面JavaScript-->
    <script src="//cdn.bootcss.com/Swiper/3.3.1/js/swiper.min.js"></script>
    <script>
        $(function () {
            var w = document.body.clientWidth;
            $(".swiper-slide>img").each(function () {
                $(this).attr("src", $(this).attr("data") + "?imageView2/1/w/" + w + "/h/180");
            });
            var swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                loop: true,
                autoplay: 3000,
                speed: 1000,
            });
            $(".weui_media_box").on("click", function () {
                window.location.href = $(this).attr("data");
            })
        });
    </script>

</html>