<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    //显示首页的页面信息
    public function index()
    {
        $news = M("wx_news")->order("views desc")->limit(0, 5)->select();
        $offers = M("wx_offers")->where(array("status" => 1))->order("views desc")->limit(0, 5)->select();
        $data = array();
        foreach ($news as $v) {
            $item["id"] = $v["Id"];
            $item["type"] = 0;
            $item["title"] = $v["title"];
            $item["views"] = $v["views"];
            array_push($data, $item);
        }
        foreach ($offers as $v) {
            $item["id"] = $v["Id"];
            $item["type"] = 1;
            $item["title"] = $v["name"];
            $item["views"] = $v["views"];
            array_push($data, $item);
        }
        $this->assign('tops', $data);
        $start_time = date("Y-m-d", strtotime("-30 day"));
        $end_time = date("Y-m-d", strtotime("-1 day"));
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->display();
    }

    //获取首页页面的数据
    public function getindex()
    {
        $sys_statistics = M('sys_statistics');
        $start_time = I('post.start_time');
        $sys_t = I("post.t");
        if (empty($start_time)) {
            $start_time = strtotime(date("Y-m-d", strtotime("-30 day")));
        } else {
            $start_time = strtotime($start_time);
        }
        $end_time = I('post.end_time');
        if (empty($end_time)) {
            $end_time = strtotime(date("Y-m-d", strtotime("-1 day")));
        } else {
            $end_time = strtotime($end_time);
        }

        $get_detail_time = $end_time - $start_time;
        $temp_time = $start_time;
        for ($i = 0; $i <= $get_detail_time; $i = $i + 86400) {
            $k = $i / 86400;
            $data[$k]['time'] = date("m.d", $temp_time);
            $data[$k]['name_time'] = date("Y-m-d", $temp_time);
            $data[$k]['pv_number'] = 0;
            $data[$k]['uv_number'] = 0;
            $data[$k]['news_number'] = 0;
            $data[$k]['offers_number'] = 0;
            $data[$k]['xs_number'] = 0;
            $data[$k]['bys_number'] = 0;
            $data[$k]['xj_number'] = 0;
            $temp_time = $temp_time + 86400;
        }

       /* $end_time = strtotime(date("Y-m-d", time()));*/
        if (intval($sys_t) == 1) {
            //TODO 只要PV和UV
            $where["type"] = array(array("eq", 0), array("eq", 1), "or");
        } else if (intval($sys_t) == 3) {
            //TODO 只要新生、毕业生、学籍
            $where["type"] = array(array("eq", 4), array("eq", 5), array("eq", 6), "or");
        } else if (intval($sys_t) == 2) {
            //TODO 只要news和offers
            $where["type"] = array(array("eq", 2), array("eq", 3), "or");
        } else if (intval($sys_t) == 0) {
            //TODO 全部
        } else {
            $this->ajaxReturn(array());
            exit;
        }

        $where["date_time"] = array(array("egt", $start_time), array("lt", $end_time), "and");

        $temp = $sys_statistics->field('date_time,number,type')->where($where)->select();

        $dict0 = $dict1 = $dict2 = $dict3 = $dict4 = $dict5 = $dict6 = array();
        foreach ($temp as $item) {
            switch (intval($item["type"])) {
                case 0:
                    $dict0[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 1:
                    $dict1[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 2:
                    $dict2[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 3:
                    $dict3[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 4:
                    $dict4[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 5:
                    $dict5[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
                case 6:
                    $dict6[date("Y-m-d", $item["date_time"])] = $item["number"];
                    break;
            }
        }
        for ($j = 0; $j < count($data); $j++) {
            $data[$j]['pv_number'] = $dict0[$data[$j]['name_time']] == null ? 0 : $dict0[$data[$j]['name_time']];
            $data[$j]['uv_number'] = $dict1[$data[$j]['name_time']] == null ? 0 : $dict1[$data[$j]['name_time']];
            $data[$j]['news_number'] = $dict2[$data[$j]['name_time']] == null ? 0 : $dict2[$data[$j]['name_time']];
            $data[$j]['offers_number'] = $dict3[$data[$j]['name_time']] == null ? 0 : $dict3[$data[$j]['name_time']];
            $data[$j]['xs_number'] = $dict4[$data[$j]['name_time']] == null ? 0 : $dict4[$data[$j]['name_time']];
            $data[$j]['bys_number'] = $dict5[$data[$j]['name_time']] == null ? 0 : $dict5[$data[$j]['name_time']];
            $data[$j]['xj_number'] = $dict6[$data[$j]['name_time']] == null ? 0 : $dict6[$data[$j]['name_time']];
        }

        $this->ajaxReturn($data);
    }

    public function message()
    {
        $this->display();
    }

    /**
     * 修改密码页面
     */
    public function pass()
    {
        $this->display();
    }

    /**
     * 修改密码
     */
    public function dopass()
    {
        //TODO 修改密码的方法
        $old_pass = md5(md5(trim(I("o"))));
        $new_pass = md5(md5(trim(I("n"))));
        $res_pass = md5(md5(trim(I("r"))));
        $M = M("urp_user");
        $user = $M->where(array("Id" => $_SESSION["USER_ID"]))->find();
        if ($user) {
            if ($new_pass != $old_pass) {
                if ($new_pass == $res_pass) {
                    if ($user["pwd"] == $old_pass) {
                        $data["pwd"] = $new_pass;
                        $data["update_time"] = time();
                        $data["updator"] = $_SESSION["USER_ID"];
                        $rlt = $M->where(array("Id" => $_SESSION["USER_ID"]))->save($data);
                        if ($rlt) {
                            responseToJson(0, "亲，密码修改成功~~~");
                        } else {
                            responseToJson(3, "亲，密码修改失败~~~");
                        }
                    } else {
                        responseToJson(1, "亲，原密码错误~~~");
                    }
                } else {
                    responseToJson(2, "亲，两次新密码输入不一致~~~");
                }
            } else {
                responseToJson(4, "亲，新密码和原密码不能一样~~~");
            }
        }
    }

    /**
     * 登出系统
     */
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        $this->redirect("login");
    }

    /**
     * 登录页面
     */
    public function login()
    {

        $this->display();
    }

    /**
     * 登录系统
     */
    public function dologin()
    {
        $account = strtolower(trim(I("t")));
        $pwd = md5(md5(trim(I("p"))));
        $model = M("urp_user");
        $condition["code"] = $account;
        $user = $model->where($condition)->find();
        if (count($user) > 0) {
            if ($pwd == $user['pwd']) {
                $_SESSION["USER_ID"] = $user["Id"];
                $_SESSION["USER_NAME"] = $user["name"];
                cookie("userAccount", $account);
                cookie("userName", $user["name"]);
                if ($account == "admin") {
                    $_SESSION["USER_ROLE_ID"] = "0";
                } else {
                    $user_roles = D()->query("select * from urp_role_user where user_id=" . $user["Id"]);
                    $roleIds = "-1";
                    foreach ($user_roles as $item) {
                        $roleIds = $roleIds . "," . $item["role_id"];
                    }
                    $_SESSION["USER_ROLE_ID"] = $roleIds;

                    $pages = D()->query("select DISTINCT p.action ,p.function from urp_role_page rp left join urp_page p on rp.page_id=p.id where rp.role_id in (" . $roleIds . ")");
                    $arrAction = array();
                    foreach ($pages as $item) {
                        array_push($arrAction, $item["action"]);
                        if (!empty($item["function"])) {
                            $temp = explode(",", $item["function"]);
                            foreach ($temp as $vo) {
                                array_push($arrAction, $vo);
                            }
                        }
                    }
                    $_SESSION["USER_ACTION"] = $arrAction;
                }
                $json_str["code"] = 0;
                $json_str["msg"] = "OK";
            } else {
                $json_str["code"] = 1;
                $json_str["msg"] = "输入的登录密码不正确";
            }
        } else {
            $json_str["code"] = 2;
            $json_str["msg"] = "输入的登录帐号不正确";
        }
        $this->ajaxReturn($json_str);
    }

}
