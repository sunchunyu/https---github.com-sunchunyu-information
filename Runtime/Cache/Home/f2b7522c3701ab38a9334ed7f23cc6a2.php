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
    <!--上传图片插件css-->
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
    
    <form method="post" name="category_form" method="post" enctype="multipart/form-data"
          action="<?php echo U('Home/Stud/freshman_save');?>?fh=<?php echo ($fresh["Id"]); ?>">
        <div class="widget-header">
            <input type="hidden" id="st_hiden" value="<?php echo ($st); ?>"/>
            <span class="widget-caption">新生报道</span>
        </div>
        <div class="widget-body">
            <div id="registration-form">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label class="setbounds">姓名</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="姓名" maxlength="10" value="<?php echo ($fresh["name"]); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="setbounds">性别</label>
                        <select class="form-control" id="sex" name="sex">
                            <option value="0">未知</option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label class="setbounds">身份证号</label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" id="idcard"
                                   placeholder="身份证号码" name="idcard" maxlength="20" value="<?php echo ($fresh["idcard"]); ?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">中招考试所在地</label>
                        <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="wheremidd" name="wheremidd"
                               placeholder="河南省-郑州市-中原区" maxlength="30" value="<?php echo ($fresh["wheremidd"]); ?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                    </span>
                    </div>
                    <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">准考证号</label>
                        <span class="input-icon icon-right">
                        <input type="text" class="form-control" name="ticketnumber" id="ticketnumber"
                               placeholder="准考证号码" maxlength="30" value="<?php echo ($fresh["ticketnumber"]); ?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                    </span>
                    </div>
                    <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">电话号码</label>
                        <span class="input-icon icon-right">
                        <input type="text" class="form-control" name="phone" id="phone"
                               placeholder="固定电话或手机号码" maxlength="11" value="<?php echo ($fresh["phone"]); ?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                    </span>
                    </div>
                    <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">家庭住址</label>
                        <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="addr"
                               placeholder="身份证上的地址" name="addr" maxlength="30" value="<?php echo ($fresh["addr"]); ?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                    </span>
                    </div>
                    <div class="col-sm-12"style="display: none">
                    <span class="input-icon icon-right">
                        <label class="setbounds">专业名称</label>
                        <select class="form-control" id="speciality" name="speciality">
                            <?php if(is_array($specialty_rs)): $i = 0; $__LIST__ = $specialty_rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>" data="<?php echo ($vo["Id"]); ?>"> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </span>
                    </div>
                    <div class="col-sm-12">
                <span class="input-icon icon-right">
                    <label class="setbounds">专业类别</label>
                    <select class="form-control" id="category" name="category">
                        <option value="0">请选择专业类别</option>
                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate); ?>" data="<?php echo ($i-1); ?>"><?php echo ($cate); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
                    </div>
                    <div class="col-sm-12">
                    <span class="input-icon icon-right">
                         <span class="input-icon icon-right">
                            <label class="setbounds">考试总分</label>
                             <span class="input-icon icon-right">
                                <input type="number" class="form-control" name="totalscore" id="totalscore"
                                       placeholder="高考或中考总分" maxlength="10" value="<?php echo ($fresh["totalscore"]); ?>">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                        </span>
                    </span>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>备注</label>
                        <span class="input-icon icon-right">
                            <textarea class="form-control" rows="4" id="remark" name="remark"
                                    ><?php echo ($fresh["remark"]); ?></textarea>
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label>个人相片（2寸白底）</label>
                        <input type="hidden" value="" id="img_status" name="img_status"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="file" id="photo" class="dropify" name="dropify"
                                       data-default-file="<?php echo ($fresh["photo"]); ?>"/>
                                <br/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?php if($fresh["status"] == 2): ?><a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="2"
                               disabled="disabled">已确认</a>
                        <?php elseif($fresh["status"] == 0): ?>
                            <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="0"
                               disabled="disabled">审核中</a>
                        <?php elseif($fresh["status"] == 1): ?>
                            <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn"
                               data="3">重新提交</a>
                            <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="1" data-type="0">请确认</a>
                        <?php else: ?>
                        <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="3" data-type="1">提交</a><?php endif; ?>
                    </div>
                </div>
                <input type="hidden" id="status" value="<?php echo ($fresh["status"]); ?>"
                       data="<?php echo U('Home/Stud/change_status');?>?fh=<?php echo ($fresh["Id"]); ?>"/>
            </div>
            <input type="hidden" value="<?php echo ($collection_id); ?>" id="collection_id" name="collection_id">
            <input type="hidden" value="<?php echo ($baseInfoId["xy"]); ?>" id="xy_id" name="xy_id"/>
            <input type="hidden" value="<?php echo ($baseInfoId["yx"]); ?>" id="college_id" name="college_id"/>
            <input type="hidden" value="<?php echo ($baseInfoId["zy"]); ?>" id="specialty_id" name="specialty_id"/>
            <input type="hidden" value="<?php echo ($baseInfoId["bj"]); ?>" id="class_id" name="class_id"/>
            <input id="my_id" type="hidden" value="<?php echo ($fresh["Id"]); ?>">
            <input id="my_sex" type="hidden" value="<?php echo ($fresh["sex"]); ?>">
            <input id="my_category" type="hidden" value="<?php echo ($fresh["category"]); ?>">
            <input id="my_speciality" type="hidden" value="<?php echo ($fresh["speciality"]); ?>">
        </div>
    </form>

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

    <script src="/informationcollection/Public/Static/js/wx_freshman.js"></script>
    <!--上传图片插件-->
    <script src="/informationcollection/Public/assets/dropify/dist/js/dropify.min.js"></script>