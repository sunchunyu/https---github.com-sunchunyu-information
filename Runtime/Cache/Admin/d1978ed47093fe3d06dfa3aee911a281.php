<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>
        <?php echo C('AppName') ?>::信息采集
    </title>
    <meta name="description" content="Dashboard"/>
    <meta content="user-scalable=no,width=device-width, initial-scale=1,maximum-scale=1" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="format-detection" content="telphone=no, email=no"/>
    <link rel="shortcut icon" href="/informationcollection/Public/assets/img/favicon.png" type="image/x-icon">


    <!--Basic Styles-->
    <link href="//cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!--Fonts-->
    <!-- <link href="http://fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300"
           rel="stylesheet" type="text/css">-->

    <!--Beyond styles-->
    <link id="beyond-link" href="/informationcollection/Public/assets/css/beyond.min.css" rel="stylesheet" type="text/css"/>
    <link href="/informationcollection/Public/assets/css/typicons.min.css" rel="stylesheet"/>
    <link href="/informationcollection/Public/assets/css/animate.min.css" rel="stylesheet"/>

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="/informationcollection/Public/assets/js/skins.min.js"></script>
    <link href="/informationcollection/Public/assets/css/skins/teal.min.css" rel="stylesheet">
    
    <!--上传图片插件css-->
    <link rel="stylesheet" href="/informationcollection/Public/assets/dropify/dist/css/dropify.min.css">

    <link href="/informationcollection/Public/Static/css/offer_add.css" rel="stylesheet"/>

    <style>
        div.dataTables_filter label {
            float: right;
            margin-right: 70px;
        }

        div.dataTables_filter {
            margin-top: -31px;
        }
       .serverSide div.dataTables_length{
            top:-38px;
        }
        .modal-header {
            border-bottom: 3px solid #03b3b2;
        }

        input[type=checkbox]:checked + .text:before {
            border: 0px;
            background: transparent;
        }

        input[type=checkbox] + .text:before {
            border: 0px;
            color: #03b3b2;
            background: transparent;
        }

        .table-toolbar .dropdown label {
            width: 100%;
            cursor: pointer;
            margin-bottom: 0px;
        }

        .panel-body label {
            padding: 7px;
            border: 1px solid #d5d5d5;
            border-right: 0px;
            margin-top: 1px;
            color: #858585;
            background-color: #f5f5f5;
        }

        .panel-body input {
            padding: 7px;
            border: 1px solid #d5d5d5;
            color: #858585;
            background-color: #fbfbfb;
        }

        .dataTables_empty {
            text-align: center;
        }

        .panel-body .input-group {
            margin-right: 10px;
        }

        .panel-body select {
            -webkit-appearance: none;
            border-radius: 0px;

        }

        .panel-body .input-group-btn {
            left: -18px;
            z-index: 10;
        }

        .panel-group {
            margin-bottom: 10px;
        }

        .input-icon.icon-right > input {
            padding-left: 14px;
        }

        .panel-body .col-lg-2 {
            padding-left: 5px;
            padding-right: 5px;
        }

        .dropdown-menu {
            z-index: 999999;
        }

        .bootbox-confirm .modal-dialog {
            width: 250px;
        }

        .btn-group {
            z-index: 100;
        }

        .animated {
            -webkit-animation-duration: 0.5s;
            animation-duration: 0.5s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .table-striped > tbody > tr > td {
            cursor: pointer;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
        }

        .table-striped > tbody > tr.tr-selected > td {
            background-color: #eed;
        }

        .tree-selected > .tree-dot:before {
            content: "\f046";
            font-family: FontAwesome;
            font-style: normal;
            font-weight: normal;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
        }

        .table-toolbar .panel-body select, .panel-body input {
            min-width: 150px;
        }

        .table-toolbar .panel-body input {
            min-width: 150px;
        }

        .table-toolbar .panel-body label {
            border-radius: 0 !important;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgeG1sbnM9Imh0d…0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2xlc3NoYXQtZ2VuZXJhdGVkKSIgLz48L3N2Zz4=);
            background-image: -webkit-linear-gradient(top, #eee 0, #fbfbfb 100%);
            background-image: -moz-linear-gradient(top, #eee 0, #fbfbfb 100%);
            background-image: -o-linear-gradient(top, #eee 0, #fbfbfb 100%);
            background-image: linear-gradient(to bottom, #eee 0, #fbfbfb 100%);
            position: relative;
            left: 4px;
            padding: 7px 14px;
        }

        .table-toolbar {
            padding: 0px;
        }
    </style>
</head>
<body>
<!-- Loading Container -->
<div class="loading-container">
    <div class="loading-progress">
        <!--<div class="rotator">
            <div class="rotator">
                <div class="rotator colored">
                    <div class="rotator">
                        <div class="rotator colored">
                            <div class="rotator colored"></div>
                            <div class="rotator"></div>
                        </div>
                        <div class="rotator colored"></div>
                    </div>
                    <div class="rotator"></div>
                </div>
                <div class="rotator"></div>
            </div>
            <div class="rotator"></div>
        </div>
        <div class="rotator"></div>-->
        <img src="/informationcollection/Public/assets/img/loading.svg">
    </div>
</div>
<!--  /Loading Container -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                        <img style="width: 170px;height: 28px;margin-top: 6px;" src="/informationcollection/Public/assets/img/logo.png" alt=""/>
                    </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->

            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings --->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li style="right: -40px;">
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" style="border-left:0px;" title="点击修改密码或退出系统">
                                    <img src="/informationcollection/Public/assets/img/avatars/boy.png">
                                </div>
                                <section style="width: 105px;">
                                    <h2><span class="profile">您好，<?php echo $_SESSION["USER_NAME"] ?></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="email"><a>欢迎使用信息采集系统</a></li>
                                <li>
                                    <div class="avatar-area">
                                        <img src="/informationcollection/Public/assets/img/avatars/boy.png" class="avatar">
                                    </div>
                                </li>
                                <li class="dropdown-footer edit">
                                    <a href="<?php echo U('admin/index/pass',null,false,false,false);?>" class="pull-left" id="bootbox-options">修改密码</a>
                                    <a id="logout" href="#" data="<?php echo U('admin/index/logout',null,false,false,false);?>" class="pull-right">退出系统</a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>



<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar sidebar-fixed" id="sidebar">
            <div class="sidebar-header-wrapper">
                <input type="text" readonly class="searchinput" value="欢迎使用信息采集系统">
                <i class="searchicon fa fa-flag-checkered"></i>

                <!-- <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>-->
            </div>
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <!--Dashboard-->
                <?php if($index == 1 ): ?><li class="active">
                        <?php else: ?>
                    <li><?php endif; ?>
                <a href="<?php echo U('Admin/Index/index',null,false,false,false);?>">
                    <i class="menu-icon fa fa-home"></i>
                    <span class="menu-text">
                        首页
                    </span>
                </a>
                </li>
                <?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["open"] == 1 ): ?><li class="open">
                            <?php else: ?>
                        <li><?php endif; ?>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa <?php echo ($vo["icon"]); ?>"></i>
                                <span class="menu-text">
                                    <?php echo ($vo["name"]); ?>
                                </span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <?php if(is_array($vo['child'])): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($item["active"] == 1 ): ?><li class="active">
                                    <a class="has"
                                       href="<?php echo ($item["url"]); ?>">
                                        <span class="menu-text"><?php echo ($item["name"]); ?></span>
                                    </a>
                                </li>
                                <?php else: ?>
                                <li>
                                    <a class="has"
                                       href="<?php echo ($item["url"]); ?>">
                                        <span class="menu-text"><?php echo ($item["name"]); ?></span>
                                    </a>
                                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs breadcrumbs-fixed">
                <ul class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        &nbsp;&nbsp;首页
                    </li>
                    
    <li>微网站</li>
    <li class="active">招聘信息</li>

                </ul>

            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body" style="margin-top: 40px;">

                
    <!--本页面Body-->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="widget">
                <div class="widget-header ">
                    <span class="widget-caption"><i class="fa fa-pencil"></i>&nbsp;&nbsp;招聘信息<?php echo ($title); ?></span>

                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="btn-group">
                        <a class="btn btn-default offer_list"
                           href="<?php echo U('admin/Wx/offer_list');?>"><i
                                class="fa fa-chevron-left"></i> 返回
                        </a>
                        <button type="button" class="btn btn-default offer_add_save"
                                data="<?php echo U('admin/Wx/offer_add_save');?>?id=<?php echo ($offers['Id']); ?>"><i
                                class="fa fa-save"></i> 保存
                        </button>
                    </div>
                    <div class="form" style="padding: 20px 0px;">
                        <form method="post" id="form">
                            <div class="form-title">
                                招聘详情
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group margin father">
                                        <div class="col-sm-8">
                                            <label>岗位名称<span class="red">*</span></label>
                                             <span class="input-icon icon-right">
                                                <input type="text" list="edu" class="form-control"
                                                       placeholder="请输入招聘岗位名称"
                                                       maxlength="15" id="offer_title" value="<?php echo ($offers['name']); ?>">
                                                 <datalist id="edu">
                                                     <?php if(is_array($industry)): $i = 0; $__LIST__ = $industry;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
                                                 </datalist>
                                                <input class="roleId" type="hidden"/>
                                                <i class="fa fa-bookmark"></i>
                                            </span>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>工作地点<span class="red">*</span></label>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <select class="form-control" id="province">
                                                            <option data-id="0" data-pid="0" value="0">请选择省</option>
                                                            <?php if(is_array($county_rs)): $i = 0; $__LIST__ = $county_rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$county): $mod = ($i % 2 );++$i;?><option value="<?php echo ($county['name']); ?>"
                                                                        data-id="<?php echo ($county['Id']); ?>"
                                                                        data-pid="<?php echo ($county['pid']); ?>"><?php echo ($county['name']); ?>
                                                                </option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div id="county"
                                                             style="margin-left: 5px;">
                                                            <select class="form-control" id="county_child">
                                                                <option data-id="0" data-pid="0" value="0">请选择市</option>
                                                                <?php if(empty($city)): else: ?>
                                                                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$aa): $mod = ($i % 2 );++$i;?><option data-id="<?php echo ($aa['Id']); ?>"
                                                                                data-pid="<?php echo ($aa['pid']); ?>"
                                                                                value="<?php echo ($aa["name"]); ?>"><?php echo ($aa["name"]); ?>
                                                                        </option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div id="city"
                                                             style="margin-left: 5px;">
                                                            <select class="form-control" id="city_child">
                                                                <option data-id="0" data-pid="0" value="0">请选择区县
                                                                </option>
                                                                <?php if(empty($small)): else: ?>
                                                                    <?php if(is_array($small)): $i = 0; $__LIST__ = $small;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$small_vo): $mod = ($i % 2 );++$i;?><option data-id="<?php echo ($small_vo['Id']); ?>"
                                                                                data-pid="<?php echo ($small_vo['pid']); ?>"
                                                                                value="<?php echo ($small_vo['name']); ?>">
                                                                            <?php echo ($small_vo['name']); ?>
                                                                        </option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>期望薪水<span class="red">*</span></label>
                                            <input type="hidden" value="<?php echo ($offers['salary']); ?>" id="salary_hide"/>
                                            <select class="form-control" id="salary">
                                                <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i-1); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>招聘人数<span class="red">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="number" class="form-control" placeholder="请输入招聘人数"
                                                       maxlength="11" id="offer_number" value="<?php echo ($offers['number']); ?>">
                                                <input class="roleId" type="hidden"/>
                                                <i class="fa fa-bookmark"></i>
                                            </span>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>学历要求<span class="red">*</span></label>
                                            <input type="hidden" id="education_hide" value="<?php echo ($offers['education']); ?>"/>
                                            <select class="form-control" id="education">
                                                <?php if(is_array($education)): $i = 0; $__LIST__ = $education;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i-1); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>工作年限<span class="red">*</span></label>
                                            <input type="hidden" value="<?php echo ($offers['worklife']); ?>" id="worklife_hide"/>
                                            <select class="form-control" id="worklife">
                                                <?php if(is_array($worklife)): $i = 0; $__LIST__ = $worklife;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i-1); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>福利待遇</label>
                                            <input type="text" id="welfare" data-role="tagsinput"
                                                   placeholder="Add tags" value="<?php echo ($offers['welfare']); ?>"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <label>用人单位<span class="red">*</span></label>
                                            <select class="form-control" id="category">
                                                <?php if(is_array($employer)): $i = 0; $__LIST__ = $employer;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$op): $mod = ($i % 2 );++$i;?><option value="<?php echo ($op['Id']); ?>"><?php echo ($op['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            <input type="hidden" value="<?php echo ($offers['employer_id']); ?>" id="category_hide"/>
                                        </div>
                                        <div id="ue_content" class="col-sm-8">
                                            <label>请输入内容<span class="red">*</span></label>
                                            <textarea type="text/plain" id="myEditor"
                                                      style="width:100%;height: 300px;"><?php echo ($offers['content']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input id="p" value="<?php echo ($offers["p"]); ?>" type="hidden"/>
    <input id="c" value="<?php echo ($offers["c"]); ?>" type="hidden"/>
    <input id="t" value="<?php echo ($offers["t"]); ?>" type="hidden"/>

            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

</div>

<script src="//cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="/informationcollection/Public/assets/js/beyond.min.js"></script>
<script src="/informationcollection/Public/assets/js/bootbox/bootbox.js"></script>
<script src="/informationcollection/Public/assets/js/validation/bootstrapValidator.js"></script>
<script src="/informationcollection/Public/assets/js/Base.js"></script>


    <!--ue-->
    <script type="text/javascript" charset="utf-8" src="/informationcollection/Public/assets/ue/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/informationcollection/Public/assets/ue/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/informationcollection/Public/assets/ue/lang/zh-cn/zh-cn.js"></script>
    <!--标签插件-->
    <script src="/informationcollection/Public/assets/js/tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>
    <script src="/informationcollection/Public/Static/js/offer_add.js" type="text/javascript"></script>


</body>
</html>