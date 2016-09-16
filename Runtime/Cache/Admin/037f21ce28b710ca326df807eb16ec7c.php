<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8"/>
    <title>登录::信息采集系统</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="/informationcollection/Public/assets/img/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/informationcollection/Public/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/informationcollection/Public/assets/css/font-awesome.min.css" rel="stylesheet"/>

    <!--Fonts-->
    <link href="http://fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300"
          rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="/informationcollection/Public/assets/css/beyond.min.css" rel="stylesheet"/>
    <link href="/informationcollection/Public/assets/css/animate.min.css" rel="stylesheet"/>

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="/informationcollection/Public/assets/js/skins.min.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body>
<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white" style="height: 240px!important;padding-top: 5px;">
        <div class="loginbox-title">系统登录</div>
        <div class="loginbox-social">
        </div>
        <div class="loginbox-textbox">
            <input type="text" class="form-control account" placeholder="登录帐号"/>
        </div>
        <div class="loginbox-textbox">
            <input type="password" class="form-control pwd" placeholder="登录密码"/>
        </div>
        <div class="loginbox-submit">
            <input type="submit" class="btn btn-primary btn-block" onclick="doLogin()" value="登录">
        </div>
        <p style="text-align: center;padding-bottom: 10px;color: #999;">© <?php echo C('AppName')?></p>
    </div>
    <div class="alert alert-warning" style="margin-top: 20px;display: none;">
        <i class="fa-fw fa fa-warning"></i>
        <span class="msg"></span>
    </div>
</div>

<!--Basic Scripts-->
<script src="//cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="/informationcollection/Public/assets/js/beyond.min.js"></script>
<script>
    function doLogin() {
        var tel = $.trim($(".account").val()); //获取手机号
        var pwd = $.trim($(".pwd").val());
        if (tel.length == 0) {
            $(".msg").html("请输入登录帐号");
            $(".alert").fadeIn();
            setTimeout(function () {
                $(".alert").fadeOut();
            }, 3000);
            return;
        }
        if (pwd.length == 0) {
            $(".msg").html("请输入登录密码");
            $(".alert").fadeIn();
            setTimeout(function () {
                $(".alert").fadeOut();
            }, 3000);
            return;
        }

        $.post("<?php echo U('admin/index/dologin');?>", {t: tel, p: pwd}, function (s, d) {
            if (s.code == "0") {
                window.location.href = "<?php echo U('admin/index/index',null,false,false,false);?>";
            } else {
                $(".msg").html(s.msg);
                $(".alert").fadeIn();
                setTimeout(function () {
                    $(".alert").fadeOut();
                }, 3000)
            }
        }, "json");
    }
    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            var c_start = document.cookie.indexOf(c_name + "=")
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1
                var c_end = document.cookie.indexOf(";", c_start)
                if (c_end == -1) c_end = document.cookie.length
                return unescape(document.cookie.substring(c_start, c_end))
            }
        }
        return ""
    }
    $(function () {
        $(".account").val(getCookie("userAccount"));
        $(".pwd").keydown(function (e) {
            var ev = document.all ? window.event : e;
            if (ev.keyCode == 13) {
                doLogin();
            }
        });
    })
    ;
</script>
</body>
<!--Body Ends-->
</html>