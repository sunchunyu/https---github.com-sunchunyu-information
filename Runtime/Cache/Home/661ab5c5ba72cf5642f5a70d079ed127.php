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
    <link href="/informationcollection/Public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/informationcollection/Public/assets/css/beyond.min.css" rel="stylesheet">
    <link href="/informationcollection/Public/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/informationcollection/Public/Static/css/wx_app.css" rel="stylesheet">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    
    <link href="/informationcollection/Public/Static/css/wx_freshman.css" rel="stylesheet">
    <link rel="stylesheet" href="/informationcollection/Public/assets/dropify/dist/css/dropify.min.css">

    <title>
        信息采集
    </title>
    <script>
        /*wx.config({
         appId: "<?php echo ($appId); ?>",
         timestamp: parseInt("<?php echo ($timestamp); ?>"),
         nonceStr: "<?php echo ($nonceStr); ?>",
         signature: "<?php echo ($signature); ?>",
         jsApiList: [
         'onMenuShareTimeline',
         'onMenuShareAppMessage'
         ]
         });
         wx.hideOptionMenu();
         wx.error(function (res) {
         //alert(JSON.stringify(res));
         });*/
    </script>
</head>
<body>
<div class="content">
    <div class="widget-header">
        <span class="widget-caption">基本信息</span>
    </div>
    <div class="widget-body" style="margin-bottom: 10px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">学院
                            </button>
                        </span>
                    <input class="form-control" id="txt-xy" readonly value="<?php echo ($baseInfo["xy"]); ?>"/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">院系
                            </button>
                        </span>
                    <input class="form-control" id="txt-yx" readonly value="<?php echo ($baseInfo["yx"]); ?>"/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">专业
                            </button>
                        </span>
                    <input class="form-control" id="txt-zy" readonly value="<?php echo ($baseInfo["zy"]); ?>"/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">班级
                            </button>
                        </span>
                    <input class="form-control" id="txt-bj" readonly value="<?php echo ($baseInfo["bj"]); ?>"/>
                </div>
            </div>
        </div>
    </div>
    
<div class="widget-header">
    <span class="widget-caption">学籍采集</span>
</div>

<div class="widget-body">
<div id="registration-form">
<div class="row">
<input id="save-url" data="<?php echo U('Home/Stud/status_save');?>" type="hidden">

<!--姓名-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="name">姓名</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="name" placeholder="本人姓名" value="<?php echo ($stud["name"]); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--性别-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="sex">性别</label>
                    <!--获取用户的所有信息-->
                        <select class="form-control" id="sex">
                            <option value="0">保密</option>
                            <?php if($stud['sex'] == 1 ): ?><option value="1" selected>男</option>
                                <?php else: ?>
                                <option value="1">男</option><?php endif; ?>
                            <?php if($stud['sex'] == 2 ): ?><option value="2" selected>女</option>
                                <?php else: ?>
                                <option value="2">女</option><?php endif; ?>
                        </select>
                </span>
</div>
<!--姓名拼音-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="pinyin">姓名拼音</label>
                    <span class="input-icon icon-right">
                        <input type="text" value="ddd" name="pinyin" class="form-control" id="pinyin"
                               placeholder="本人姓名拼音" value="<?php echo ($stud["pinyin"]); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--身份证号-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="idcard">身份证号</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="idcard" placeholder="本人身份证号" value="<?php echo ($stud["idcard"]); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--中招考试所在地-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="wheremidd">中招考试所在地</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud["wheremidd"]); ?>" id="wheremidd"
                               placeholder="中招考试所在">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--准考证号-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="ticketnumber">准考证号</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['ticketnumber']); ?>" id="ticketnumber"
                               placeholder="本人准考证号">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--民族-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="nation">民族</label>
                    <!--获取区域的所有信息-->
                    <select class="form-control" id="nation_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($nation)): $i = 0; $__LIST__ = $nation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["Id"] == $stud['nation_id']): ?><option value="<?php echo ($vo["Id"]); ?>" selected> <?php echo ($vo["name"]); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
</div>
<!--电话-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="phone">电话</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['phone']); ?>" id="phone" placeholder="本人电话">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--出生日期-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="birth">出生日期</label>
                    <span class="input-icon icon-right">
                        <input type="date" class="form-control" value="<?php echo ($stud['birth']); ?>" id="birth"
                               placeholder="yyyy-mm-dd">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--班级-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="class">班级</label>
                    <!--获取区域的所有信息-->
                    <select class="form-control" id="class">
                        <option value="0">请选择</option>
                        <?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["Id"] == $stud['class']): ?><option class="bj_<?php echo ($vo["specialty_id"]); ?>" value="<?php echo ($vo["Id"]); ?>" selected> <?php echo ($vo["name"]); ?></option>
                                <?php else: ?>
                                <option class="bj_<?php echo ($vo["specialty_id"]); ?>" value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
</div>
<!--户籍所在地-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="native">户籍所在地</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['native']); ?>" id="native"
                               placeholder="本人户籍所在地">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--户籍所在详细地址-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="domicile">户籍所在详细地址</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['domicile']); ?>" id="domicile"
                               placeholder="本人户籍所在详细地址">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长1姓名-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent1_name">家长1姓名</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent1_name']); ?>" id="parent1_name"
                               placeholder="家长1姓名">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长1身份证号码-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent1_idcard">家长1身份证号码</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent1_idcard']); ?>" id="parent1_idcard"
                               placeholder="家长1身份证号码">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长1出生年月-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent1_birth">家长1出生年月</label>
                    <span class="input-icon icon-right">
                        <input type="date" class="form-control" id="parent1_birth"
                               placeholder="yyyy-mm-dd" value="<?php echo ($stud['parent1_birth']); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长1关系-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent1_rela">家长1关系</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent1_rela']); ?>" id="parent1_rela"
                               placeholder="本人与家长1关系">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长1是否监护人-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="parent1_guardian">家长1是否监护人</label>
                    <!--获取用户的所有信息-->
                    <select class="form-control" id="parent1_guardian">
                        <?php if($stud['parent1_guardian'] == 0 ): ?><option value="0" selected>否</option>
                            <option value="1">是</option>
                            <?php else: ?>
                            <option value="0">否</option>
                            <option value="1" selected>是</option><?php endif; ?>

                    </select>
                </span>
</div>
<!--家长1电话-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent1_phone">家长1电话</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent1_phone']); ?>" id="parent1_phone"
                               placeholder="家长1电话">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>


<!--家长2姓名-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent2_name">家长2姓名</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent2_name']); ?>" id="parent2_name"
                               placeholder="家长2姓名">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长2身份证号码-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent2_idcard">家长2身份证号码</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent2_idcard']); ?>" id="parent2_idcard"
                               placeholder="家长2身份证号码">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长2出生年月-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent2_birth">家长2出生年月</label>
                    <span class="input-icon icon-right">
                        <input type="date" class="form-control" value="<?php echo ($stud['parent2_birth']); ?>" id="parent2_birth"
                               placeholder="yyyy-mm-dd">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长2关系-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent2_rela">家长2关系</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent2_rela']); ?>" id="parent2_rela"
                               placeholder="本人与家长2关系">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家长2是否监护人-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="parent2_guardian">家长2是否监护人</label>
                    <!--获取用户的所有信息-->
                    <select class="form-control" id="parent2_guardian">
                        <?php if($stud['parent2_guardian'] == 0 ): ?><option value="0" selected>否</option>
                            <option value="1">是</option>
                            <?php else: ?>
                            <option value="0">否</option>
                            <option value="1" selected>是</option><?php endif; ?>
                    </select>
                </span>
</div>
<!--家长2电话-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="parent2_phone">家长2电话</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['parent2_phone']); ?>" id="parent2_phone"
                               placeholder="家长2电话">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--户口类型-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="accounttype">户口类型</label>
                    <select class="form-control" id="accounttype">
                        <?php if(is_array($accounttype)): $k = 0; $__LIST__ = $accounttype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($k-1 == $stud['polity']): ?><option value="<?php echo ($k-1); ?>" selected><?php echo ($vo); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($k-1); ?>"><?php echo ($vo); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
</div>
<!--是否低保-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="allowances">是否低保</label>
                    <select class="form-control" id="allowances">
                        <?php if($stud['allowances'] == 0 ): ?><option value="0" selected>否</option>
                            <option value="1">是</option>
                            <?php else: ?>
                            <option value="0">否</option>
                            <option value="1" selected>是</option><?php endif; ?>
                    </select>
                </span>
</div>
<!--家庭邮编-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="homecode">家庭邮编</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['homecode']); ?>" id="homecode"
                               placeholder="本人家庭邮编">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家庭住址-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="homeaddr">家庭住址</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['homeaddr']); ?>" id="homeaddr"
                               placeholder="本人家庭住址">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--家庭所属派出所-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="homepolice">家庭所属派出所</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" value="<?php echo ($stud['homepolice']); ?>" id="homepolice"
                               placeholder="本人家庭所属派出所">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--学生来源-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="source">学生来源</label>
                    <!--获取区域的所有信息-->
                    <select class="form-control" id="source_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($source)): $i = 0; $__LIST__ = $source;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if( $vo["Id"] == $stud['source_id']): ?><option value="<?php echo ($vo["Id"]); ?>" selected> <?php echo ($vo["name"]); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
</div>
<!--政治面貌-->
<div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="polity">政治面貌</label>
                    <select class="form-control" id="polity">
                        <?php if(is_array($polity)): $k = 0; $__LIST__ = $polity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($k-1 == $stud['polity']): ?><option value="<?php echo ($k-1); ?>" selected><?php echo ($vo); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($k-1); ?>"><?php echo ($vo); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
</div>
<!--中考成绩-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="grades">中考成绩</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="grades" placeholder="本人中考成绩"
                               value="<?php echo ($stud['grades']); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--QQ-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="qq">QQ</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="qq" placeholder="本人QQ号" value="<?php echo ($stud['qq']); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<!--邮箱-->
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom: 0px;">
        <label class="email">邮箱</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="email" placeholder="本人邮箱" value="<?php echo ($stud['email']); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
    </div>
</div>
<div class="col-sm-12">
    <label>本人相片(2寸白底)</label>

    <div class="row">
        <div class="col-sm-12">

            <input type="file" id="photo" class="dropify" name="dropify" data-default-file="<?php echo ($stud['photo']); ?>"/>

            <br/>
        </div>
    </div>

</div>
</div>
<input id="id" value="<?php echo ($stud['Id']); ?>" data="<?php echo ($stud["status"]); ?>" type="hidden">
<input type="hidden" value="<?php echo ($collection_id); ?>" id="collection_id">

<?php if($stud['status'] == 2): ?><a style="margin-bottom: 10px;width: 100%" class="btn btn-primary" data="2"
       disabled="disabled">已确认</a>
    <?php elseif($stud['status'] == 0): ?>
    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary" data="0"
       disabled="disabled">审核中</a>
    <?php elseif($stud['status'] == 1): ?>
    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn"
       data="3" url="<?php echo U('/home/stud/status_save',null,false,false,false);?>">重新提交</a>
    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary affirm-btn" data="1"
       url="<?php echo U('/home/stud/status_change',null,false,false,false);?>">请确认</a>
    <?php else: ?>
    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="3"
       url="<?php echo U('/home/stud/status_save',null,false,false,false);?>">提交</a><?php endif; ?>
</div>
</div>

</div>
<div class="gamma-search-layer animated">
    <div class="widget-header">
        <span class="widget-caption">选择院系、专业、班级</span>

        <!--<div class="widget-buttons gamma-remove" style="padding-right: 10px;">
            <i class="glyphicon glyphicon-remove"></i>
        </div>-->
    </div>
    <div class="widget-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">学院
                            </button>
                        </span>
                    <select class="form-control" id="gamma-xy">
                        <?php if(count($dict_xy) > 1 ): ?><option value="0" data="0" selected>请选择</option><?php endif; ?>
                        <?php if(is_array($dict_xy)): $i = 0; $__LIST__ = $dict_xy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option data="<?php echo ($vo["pid"]); ?>" value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">院系
                            </button>
                        </span>
                    <select class="form-control" id="gamma-yx">
                        <?php if(count($dict_yx) > 1 ): ?><option value="0" data="0" selected>请选择</option><?php endif; ?>
                        <?php if(is_array($dict_yx)): $i = 0; $__LIST__ = $dict_yx;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option data="<?php echo ($vo["pid"]); ?>" value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">专业
                            </button>
                        </span>
                    <select class="form-control" id="gamma-zy">
                        <?php if(count($dict_zy) > 1 ): ?><option value="0" data="0" selected>请选择</option><?php endif; ?>
                        <?php if(is_array($dict_zy)): $i = 0; $__LIST__ = $dict_zy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option data="<?php echo ($vo["pid"]); ?>" value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">班级
                            </button>
                        </span>
                    <select class="form-control" id="gamma-bj">
                        <?php if(count($dict_bj) > 1 ): ?><option value="0" data="0" selected>请选择</option><?php endif; ?>
                        <?php if(is_array($dict_bj)): $i = 0; $__LIST__ = $dict_bj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option data="<?php echo ($vo["pid"]); ?>" value="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <a style="width: 100%" class="btn btn-primary search-btn">确定</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="gm-xy" value="<?php echo ($baseInfoId["xy"]); ?>"/>
<input type="hidden" id="gm-yx" value="<?php echo ($baseInfoId["yx"]); ?>"/>
<input type="hidden" id="gm-zy" value="<?php echo ($baseInfoId["zy"]); ?>"/>
<input type="hidden" id="gm-bj" value="<?php echo ($baseInfoId["bj"]); ?>"/>
</body>
</html>
<script src="//cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
<script src="/informationcollection/Public/Static/js/wx_app.js"></script>

    <script src="/informationcollection/Public/Static/js/wx_status.js"></script>
    <script src="/informationcollection/Public/assets/dropify/dist/js/dropify.min.js"></script>