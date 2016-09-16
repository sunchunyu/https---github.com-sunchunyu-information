<?php
namespace Home\Controller;

use Think\Controller;
use EasyWeChat\Foundation\Application;

class BaseController extends Controller
{

    public function _initialize()
    {
        addLogs();
        if (APP_DEBUG) {
            $_SESSION['weChat_user'] = array("openid" => "ofeo0s_DhbyKasywIF8HmzwN1WzI", "id" => 3);
        }
        $app = new Application(C("weChat"));
        if (empty($_SESSION['weChat_user'])) {
            $_SESSION["target_url"] = __SELF__;
            $app->oauth->redirect()->send();
            exit;
        }
    }

    public function index()
    {

    }

} 