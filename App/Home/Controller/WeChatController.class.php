<?php
namespace Home\Controller;

use Think\Controller;
use EasyWeChat\Foundation\Application;

class WeChatController extends Controller
{
    public function index()
    {
        $_SESSION["weChat_user"] = null;
        echo "缓存清除成功";
        exit;
    }

    public function check()
    {
        if ($this->checkSignature()) {
            echo($_GET['echostr']);
        }
        exit;
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = C("weChat")["token"];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function oauth_callback()
    {
        $app = new Application(C("weChat"));
        $oauth = $app->oauth;
        $user = $oauth->user();
        $tt = $user->getOriginal();
        $data["openid"] = $tt["openid"];
        $data["photo"] = "";
        $data["sex"] = $tt["sex"];
        $data["name"] = $tt["nickname"];
        $data["addr"] = $tt["country"] . " " . $tt["province"] . " " . $tt["city"];
        $data["update_time"] = time();
        $data["updator"] = -1;
        $data["create_time"] = time();
        $data["creator"] = -1;
        $M = M("stud_student");
        $where['openid'] = $tt["openid"];
        $rlt = $M->where($where)->find();
        if ($rlt) {
            $tt["id"] = $rlt["Id"];
            //$M->where($where)->save($data);
        } else {
            $M->add($data);
            $tt["id"] = $rlt["Id"];
        }
        $_SESSION['weChat_user'] = $tt;
        header('location:' . $_SESSION["target_url"]);
    }
}