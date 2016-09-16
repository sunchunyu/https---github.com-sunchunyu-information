<?php
return array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '114.215.155.69',
    'DB_NAME' => 'informationcollection',
    'DB_USER' => 'root',
    'DB_PWD' => 'Gamma0903',

    'URL_MODEL' => 2,
    'AppName' => "洛阳幼儿师范学校",

    "weChat" => array(
        'debug' => true,
        'app_id' => 'wx704c7e06bc8a8e11', // AppID
        'secret' => '5b79a054d64c866008bb49a09218973d', // AppSecret
        'token' => 'lyys', // Token
        'aes_key' => '7Z362uuRNBAzSbzr82b4W1J1gfen9SKsbZJdgDYxgyY ', // EncodingAESKey
        'log' => array(
            'level' => 'debug',
            'file' => '/home/www/lyys.yunxiaoqu.cc/Runtime/Logs/wechat.log', // XXX: 绝对路径！！！！
        ),
        'oauth' => array(
            'scopes' => ['snsapi_userinfo'],
            'callback' => '/Home/weChat/oauth_callback',
        )
    ),
    "OfferCfg" => array(
        "salary" => array("面议", "0-1000", "1000-2000", "2000-3000", "3000-5000", "5000-8000", "8000-12000", "12000-20000", "20000~"),
        "education" => array("不限", "高中", "技校", "中专", "大专", "本科", "硕士", "博士"),
        "worklife" => array("不限", "1年以下", "1-2年", "3-5年", "6-7年", "8-10年", "10年以上"),
        "category" => array("五年制", "四年制", "3+2大专")
    ),
    "polity" => array("团员", "党员", "群众"),
    "accounttype" => array("农业户口", "非农业户口", "集体户口")

);