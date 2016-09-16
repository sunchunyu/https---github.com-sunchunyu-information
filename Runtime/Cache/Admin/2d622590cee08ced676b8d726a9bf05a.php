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
    
    <!--本页面CSS-->
    <!--本页面CSS-->
    <link href="/informationcollection/Public/assets/css/dataTables.bootstrap.css" rel="stylesheet"/>

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
                                        <span class="caption">管理员</span>
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
                    
    <li >信息采集</li>
    <li class="active">学籍信息采集管理</li>

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
                    <span class="widget-caption"><i class="fa fa-table"></i>&nbsp;&nbsp;学籍信息采集列表</span>

                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="table-toolbar">
                        <div class="panel-group accordion" id="accordion" style="margin-bottom: 8px;">
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapseOne">
                                            <i class="fa fa-search"></i> 高级搜索
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>学院</label>
                                                    <select  id="college" style="min-width: 129px">
                                                        <option value="0">全部</option>
                                                        <?php if(is_array($college)): foreach($college as $key=>$vo): ?><option value="<?php echo ($vo["Id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>

                                                    <label>系别</label>
                                                    <select  id="deparment" style="min-width: 129px">
                                                        <option value="0" data-parent="0">全部</option>
                                                        <?php if(is_array($deparment)): foreach($deparment as $key=>$vo): ?><option value="<?php echo ($vo["Id"]); ?>" data-parent="<?php echo ($vo["p_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>

                                                    <label>专业</label>
                                                    <select   id="specialty" style="min-width: 129px">
                                                        <option value="0" data-parent="0">全部</option>
                                                        <?php if(is_array($specialty)): foreach($specialty as $key=>$vo): ?><option value="<?php echo ($vo["Id"]); ?>" data-parent="<?php echo ($vo["college_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label>班级</label>
                                                    <select   id="class" style="min-width: 129px">
                                                        <option value="0" data-parent="0">全部</option>
                                                        <?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["Id"]); ?>" data-parent="<?php echo ($vo["specialty_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>


                                                <label>采集批次</label>
                                                <select   id="collection_status" style="min-width: 129px">
                                                    <option value="0">全部</option>
                                                    <?php if(is_array($collection)): foreach($collection as $key=>$vo): ?><option value="<?php echo ($vo["Id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                </select>

                                                <label>状态</label>
                                                <select   id="status" style="min-width: 129px">
                                                    <option value="3">全部</option>
                                                    <option value="0">未审核</option>
                                                    <option value="1">已审核</option>
                                                    <option value="2">已确认</option>
                                                </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label>名称</label><input type="text" id="student_name"  placeholder="名称" style="min-width: 129px;margin-left: 4px">
                                                    <button type="submit" class="btn btn-primary" onclick="javascript:GetData();" style="padding: 7px; margin-top: -3px;">
                                                        <i class="fa fa-search"></i>搜索
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-get"
                                data="<?php echo U('admin/stud/get_status_excel',null,false,false,false);?>"><i
                                class="fa fa-download"></i> 导出
                        </button>

                        <button type="button" class="btn btn-default btn-look" style="display: none;"
                                data="<?php echo U('admin/stud/look_status_data',null,false,false,false);?>"><i
                                class="fa fa-download"></i> 查看
                        </button>

                        <button type="button" class="btn btn-default btn-status" style="display: none;"
                                data="<?php echo U('admin/stud/change_statu_status',null,false,false,false);?>"><i
                                class="fa fa-download"></i> 状态
                        </button>

                        <button type="button" class="btn btn-primary btn-query" style="display: none;"
                                data="<?php echo U('admin/Stud/get_status_data',null,false,false,false);?>">
                            <i class="fa fa-search"></i> 数据信息
                        </button>
                    </div>
                    <div role="grid" id="simpledatatable_wrapper" class="dataTables_wrapper form-inline no-footer serverSide" style="margin-top: 8px;">
                        <table class="table table-striped table-bordered table-hover" id="simpledatatable">
                            <thead>
                            <tr>
                                <th> 姓名</th>
                                <th> 性别</th>
                                <th> 采集批次</th>
                                <th> 电话</th>
                                <th> 院系</th>
                                <th> 专业</th>
                                <th> 班级</th>
                                <th> 状态</th>
                                <th> 学生详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--新生详情内容-->
    <button class="btn btn-default" data-toggle="modal" data-target=".bs2-example-modal-lg" style="display: none" id="look_detail">edit</button>
    <div class="modal fade bs2-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel12">新生数据详情</h4>
                </div>
                <div class="modal-body">
                    <div id="registration-form1">
                        <div class="row">
                            <div class="col-sm-4">
                                    <span class="input-icon icon-right">
                                        <label>姓名</label>
                                        <!--获取用户的所有信息-->
                                       <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="name" disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4">
                                    <span class="input-icon icon-right">
                                        <label>性别</label>
                                        <!--获取区域的所有信息-->
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="sex"  disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4">
                                    <span class="input-icon icon-right">
                                        <label>姓名拼音</label>
                                        <!--获取区域的所有信息-->
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="pinyin"  disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                    <span class="input-icon icon-right" >
                                        <label class="setbounds">中招考试所在地</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="wheremidd"  disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">准考证号</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="ticketnumber"  disabled="disabled">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">民族</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" id="nation" disabled="disabled">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                    <span class="input-icon icon-right">
                                        <label>电话</label>
                                        <span class="input-icon icon-right">
                                            <input type="text"  id="phone" class="form-control" disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" >
                                     <span class="input-icon icon-right">
                                        <label>出生日期</label>
                                        <span class="input-icon icon-right">
                                            <input type="text"  id="birth" class="form-control" disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" >
                                     <span class="input-icon icon-right">
                                        <label>班级</label>
                                        <span class="input-icon icon-right">
                                            <input type="text"  id="stu_class" class="form-control" disabled="disabled">
                                        </span>
                                    </span>
                            </div>

                            <!--<hr class="wide" />-->
                            <div class="col-sm-4" style="margin-top: 10px">
                                    <span class="input-icon icon-right">
                                        <label>户籍所在地</label>
                                        <span class="input-icon icon-right">
                                             <input  disabled="disabled" id="native" class="form-control" type="text" >
                                        </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px" >
                                <span class="input-icon icon-right">
                                    <label>户籍所在详细地址</label>
                                     <span class="input-icon icon-right">
                                         <input  disabled="disabled" id="domicile" class="form-control" type="text" >
                                     </span>
                                </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                    <span class="input-icon icon-right">
                                        <label>家长1姓名</label>
                                        <span class="input-icon icon-right">
                                          <input  disabled="disabled" id="parent1_name" class="form-control" type="text" >
                                       </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长1身份证号码</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent1_idcard">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长1出生年月</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent1_birth">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长1是否监护人</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent1_guardian">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长1电话</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent1_phone">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                    <span class="input-icon icon-right">
                                        <label>家长2姓名</label>
                                        <span class="input-icon icon-right">
                                          <input  disabled="disabled" id="parent2_name" class="form-control" type="text" >
                                       </span>
                                    </span>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长2身份证号码</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent2_idcard">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长2出生年月</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent2_birth">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长2是否监护人</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent2_guardian">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家长2电话</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="parent2_phone">
                                        </span>
                                </div>
                            </div>


                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">户口类型</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="accounttype">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">是否低保</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="allowances">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家庭邮编</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="homecode">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家庭住址</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="homeaddr">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">家庭所属派出所</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="homepolice">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">学生来源</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="source">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">政治面貌</label>
                                        <span class="input-icon icon-right">
                                             <input type="text" class="form-control" disabled="disabled" id="polity">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">中考成绩</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled="disabled" id="grades">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">QQ</label>
                                        <span class="input-icon icon-right">
                                             <input type="text" class="form-control" disabled="disabled" id="qq">
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">邮箱</label>
                                        <span class="input-icon icon-right">
                                             <input type="text" class="form-control" disabled="disabled" id="email">
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-4" style="margin-top: 10px">
                                <div class="form-group">
                                    <label class="setbounds">个人照片</label>
                                        <span class="input-icon icon-right">
                                             <img src="/informationcollection/Public/Static/img/default.jpg" width="200px" height="150px" id="photo">
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


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


    <!--本页面JavaScript-->
    <!--本页面JavaScript-->
    <script src="/informationcollection/Public/assets/js/datatable/jquery.dataTables.min.js"></script>
    <script src="/informationcollection/Public/assets/js/datatable/dataTables.bootstrap.min.js"></script>
    <script src="/informationcollection/Public/Static/js/status_query.js" ></script>


</body>
</html>