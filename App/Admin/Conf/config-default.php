<?php
return array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '114.215.155.69',
    'DB_NAME' => "informationcollection",
    'DB_USER' => 'root',
    'DB_PWD' => 'Gamma0903',

    'DB_PORT' => 3306,
    'DB_PREFIX' => '',

    //TODO Redis缓存配置
    'DATA_CACHE_PREFIX' => '',    //缓存前缀
    'DATA_CACHE_TYPE' => 'Redis', //默认动态缓存为Redis
    'REDIS_RW_SEPARATE' => true,  //Redis读写分离 true 开启
    'REDIS_HOST' => '127.0.0.1',  //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT' => '6379',       //端口号默认是6379
    'REDIS_TIMEOUT' => '300',     //超时时间
    'REDIS_PERSISTENT' => false,  //是否长连接 false=短连接
    'REDIS_AUTH' => '',           //AUTH认证密码
    'DATA_CACHE_TIME' => '0',      //设置缓存时间

    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/Static',
        '__IMG__' => __ROOT__ . '/Public/Static/images',
        '__CSS__' => __ROOT__ . '/Public/Static/css',
        '__JS__' => __ROOT__ . '/Public/Static/js'
    ),

    'URL_MODEL' => 2,
    'AppName' => "洛阳幼儿师范学校",

    "QINIU_URL" => "http://7xsqzj.com2.z0.glb.qiniucdn.com/",
    "QINIU_AK" => "DQpyEsKVRtLz9AtHxafW87JNlGWSG4271Feu5FcI",
    "QINIU_SK" => "6psz9gsrHxQSXc7GvR5LvUjvyBn6HXaJZyzEGLnI",
    "QINIU_BK" => "lyys-ics",
    "OfferCfg" => array(
        "salary" => array("面议", "0-1000", "1000-2000", "2000-3000", "3000-5000", "5000-8000", "8000-12000", "12000-20000", "20000~"),
        "education" => array("不限", "高中", "技校", "中专", "大专", "本科", "硕士", "博士"),
        "worklife" => array("不限", "1年以下", "1-2年", "3-5年", "6-7年", "8-10年", "10年以上"),
        "industry"=>array("教育","培训","学校"),
        "com_size"=>array("1-3人","5-10人","10人-20人","20-30人","50-100人","100-200人","300-500人","500人以上")
    )
);