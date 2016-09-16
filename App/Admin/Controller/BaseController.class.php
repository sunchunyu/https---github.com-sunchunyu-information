<?php
namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{

    /**
     * 初始化控制器，加载权限，判断登陆
     * */
    public function _initialize()
    {
        $action = strtolower("/admin/" . CONTROLLER_NAME . "/" . ACTION_NAME);
        $tmparray = array("/admin/index/login", "/admin/index/logout", "/admin/index/message", "/admin/index/dologin", "/admin/index/getindex");
        if (in_array($action, $tmparray)) {
            //TODO 登陆相关页面和操作不需要判断
        } else {
            //TODO 判断登陆
            if (isset($_SESSION["USER_ROLE_ID"])) {
                //TODO 页面菜单
                $menus = $this->getMyMenu();
                $this->assign("menus", $menus);

                //TODO 页面权限
                if ($_SESSION["USER_ROLE_ID"] != "0") {
                    $myActions = $_SESSION["USER_ACTION"];
                    //TODO 默认权限页面
                    array_push($myActions, "/admin/index/index", "/admin/index/pass", "/admin/index/dopass");
                    foreach ($menus as $item) {
                        foreach ($item["child"] as $vo) {
                            array_push($myActions, $vo["url"]);
                        }
                    }
                    if (!in_array($action, $myActions)) {
                        if ($this->isAjaxRequest()) {
                            responseToJson(999, "没有权限");
                        } else {
                            $this->redirect("index/message");
                        }
                    }
                }
            } else {
                $this->redirect("index/login");
            }
        }

        if ($action == "/admin/index/index") {
            $this->assign("index", 1);
        } else {
            $this->assign("index", 0);
        }
    }

    /**
     * 判断是否Ajax请求
     */
    private function isAjaxRequest()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 根据权限获取菜单
     * */
    private function getMyMenu()
    {
        $action = strtolower("/admin/" . CONTROLLER_NAME . "/" . ACTION_NAME);
        if ($_SESSION["USER_ROLE_ID"] == "0") {
            $sql = "select * from urp_page where status=0";
        } else {
            $sql = "select distinct p.* from urp_role_page rp left join urp_page p on rp.page_id=p.id where p.status=0 and rp.role_id in (" . $_SESSION["USER_ROLE_ID"] . ")";
        }
        $menus = D()->query($sql);
        $arrMenus = array();
        foreach ($menus as $vo) {
            if (intval($vo["level"]) == 0) {
                $arrMenus[$vo["Id"]] = array("open" => (strtolower("/admin/" . CONTROLLER_NAME) == strtolower($vo["action"]) ? 1 : 0), "icon" => $vo["icon"], "name" => $vo["name"], "url" => __ROOT__ . $vo["action"], "child" => array());
            }
        }
        foreach ($menus as $vo) {
            if (intval($vo["level"]) == 1) {
                array_push($arrMenus[$vo["pid"]]["child"], array("active" => ($action == strtolower($vo["action"]) ? 1 : 0), "name" => $vo["name"], "url" => __ROOT__ . $vo["action"]));
            }
        }
        return $arrMenus;
    }

    public function index()
    {
        $this->redirect("index/message");
    }
}