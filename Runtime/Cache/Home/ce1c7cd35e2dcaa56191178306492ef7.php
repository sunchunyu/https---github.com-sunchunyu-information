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
        <span class="widget-caption">毕业生信息收集</span>

        <div class="widget-buttons gamma-refresh" style="padding-right: 10px;">
            <i class="glyphicon glyphicon-refresh"></i>
        </div>
    </div>
    <div class="widget-body">
        <div id="registration-form">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">姓名</label>
                    <span class="input-icon icon-right">
                        <input type="hidden" id="id" value="<?php echo ((isset($data["Id"]) && ($data["Id"] !== ""))?($data["Id"]):'0'); ?>" data-status="<?php echo ((isset($status) && ($status !== ""))?($status):'3'); ?>" data-collection="<?php echo ($collection); ?>">
                        <input type="text" class="form-control" id="name"
                               autofocus placeholder="请输入您的姓名" value="<?php echo ((isset($data["name"]) && ($data["name"] !== ""))?($data["name"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">身份证号</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="idcard" autofocus placeholder="请输入身份证号" value="<?php echo ((isset($data["idcard"]) && ($data["idcard"] !== ""))?($data["idcard"]):''); ?>">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">民族</label>
                        <select class="form-control" id="nation">
                            <!-- <option value="0">请选择</option> -->
                            <?php if(is_array($nation)): $i = 0; $__LIST__ = $nation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($data['nation'] == $vo["Id"] ): ?><option value="<?php echo ($vo["Id"]); ?>" selected><?php echo ($vo["name"]); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($vo["Id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </span>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">性别</label>
                        <span class="input-icon icon-right">
                            <!--获取用户的所有信息-->
                            <select class="form-control" id="sex">
                                <option value="0">保密</option>
                                <?php if($data['sex'] == 1 ): ?><option value="1" selected>男</option>
                                    <?php else: ?>
                                    <option value="1">男</option><?php endif; ?>
                                <?php if($data['sex'] == 2 ): ?><option value="2" selected>女</option>
                                    <?php else: ?>
                                    <option value="2">女</option><?php endif; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">个人电话</label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" maxlength="11" id="phone"
                                   autofocus placeholder="请输入本人电话" value="<?php echo ((isset($data["phone"]) && ($data["phone"] !== ""))?($data["phone"]):''); ?>">
                            <!--                        <i class="fa fa-cny"></i>-->
                        </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">家庭住址</label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" id="homeaddr"
                                       autofocus placeholder="请输入家庭住址" value="<?php echo ((isset($data["homeaddr"]) && ($data["homeaddr"] !== ""))?($data["homeaddr"]):''); ?>">
                                <!--                        <i class="fa fa-cny"></i>-->
                            </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <span class="input-icon icon-right">
                        <label class="setbounds">专业</label>
                        <select class="form-control" id="speciality">
                            <!-- <option value="0">请选择</option> -->
                            <?php if(is_array($specialty)): $i = 0; $__LIST__ = $specialty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($data['speciality'] == $vo["name"] ): ?><option value="<?php echo ($vo["name"]); ?>" selected><?php echo ($vo["name"]); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </span>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">QQ</label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" id="qq"
                                   autofocus placeholder="请输入QQ账号" value="<?php echo ((isset($data["qq"]) && ($data["qq"] !== ""))?($data["qq"]):''); ?>">
                            <!--                        <i class="fa fa-cny"></i>-->
                        </span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">邮箱</label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" id="email"
                                   autofocus placeholder="请输入邮箱" value="<?php echo ((isset($data["email"]) && ($data["email"] !== ""))?($data["email"]):''); ?>">
                            <!--                        <i class="fa fa-cny"></i>-->
                        </span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位名称</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="company"
                               autofocus placeholder="请输入单位名称" value="<?php echo ((isset($data["company"]) && ($data["company"] !== ""))?($data["company"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">组织代码</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="companycode"
                               autofocus placeholder="请输入组织代码" value="<?php echo ((isset($data["companycode"]) && ($data["companycode"] !== ""))?($data["companycode"]):''); ?>">
                    </span>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位地址</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="addr"
                               autofocus placeholder="请输入单位地址" value="<?php echo ((isset($data["addr"]) && ($data["addr"] !== ""))?($data["addr"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位实际地址</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="addrnow"
                               autofocus placeholder="请输入单位实际地址" value="<?php echo ((isset($data["addrnow"]) && ($data["addrnow"] !== ""))?($data["addrnow"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位邮编</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="postcode"
                               autofocus placeholder="请输入单位邮编" value="<?php echo ((isset($data["postcode"]) && ($data["postcode"] !== ""))?($data["postcode"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位联系人</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="contacts"
                               autofocus placeholder="请输入单位联系人" value="<?php echo ((isset($data["contacts"]) && ($data["contacts"] !== ""))?($data["contacts"]):''); ?>">
                    </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="setbounds">单位电话</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" id="contactphone"
                               autofocus placeholder="请输入单位电话" value="<?php echo ((isset($data["contactphone"]) && ($data["contactphone"] !== ""))?($data["contactphone"]):''); ?>">
                    </span>
                    </div>
                </div>
            <div class="col-sm-12" style="margin-top: 20px;">
                <?php if($status == 2): ?><a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="2"
                       disabled="disabled">已确认</a>
                    <?php elseif($status == 0): ?>
                    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="0"
                       disabled="disabled">审核中</a>
                    <?php elseif($status == 1): ?>
                    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn"
                       data="3" url="<?php echo U('/home/stud/graduate_save',null,false,false,false);?>">重新提交</a>
                    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary affirm-btn" data="1"
                       url="<?php echo U('/home/stud/graduate_status',null,false,false,false);?>">请确认</a>
                    <?php else: ?>
                    <a style="margin-bottom: 10px;width: 100%" class="btn btn-primary save-btn" data="3" url="<?php echo U('/home/stud/graduate_save',null,false,false,false);?>">提交</a><?php endif; ?>
            </div>
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

    <!--本页面JavaScript-->
    <script src="/informationcollection/Public/Static/js/wx_graduate.js"></script>