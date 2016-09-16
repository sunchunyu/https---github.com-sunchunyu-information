<?php
namespace Admin\Controller;

use Think\Controller;

class UrpController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 用户列表页面
     * */
    public function user_list()
    {
        $this->display();
    }

    /**
     * 用户查询
     * */
    public function user_query()
    {
        $dd = I("aoData");
        //$iPage = $dd["i"]; //当前页，0是第一页
        //$iLength = $dd["l"]; //每页多少条
        $M = M("urp_user");
        $map["status"] = 0;
        if (!empty($dd["n"])) {
            $map["name"] = array("like", "%" . $dd["n"] . "%");
        }
        if (!empty($dd["c"])) {
            $map["code"] = array("like", "%" . $dd["c"] . "%");
        }
        if (!empty($dd["p"])) {
            $map["phone"] = array("like", "%" . $dd["p"] . "%");
        }
        if (!empty($dd["m"])) {
            $map["email"] = array("like", "%" . $dd["m"] . "%");
        }
        $data = $M->where($map)->select();
        $rlt = array();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]["code"] != "admin") {
                $temp = D()->query("select r . name from urp_role_user ru left join urp_role r on ru . role_id = r . Id where r . status = 0 and ru . user_id = " . $data[$i]["Id"]);
                $role = "";
                foreach ($temp as $v) {
                    $role = $role . "," . $v["name"];
                }
                if (strlen($role) > 0) {
                    $role = substr($role, 1, strlen($role));
                }
                $data[$i]["role"] = $role;
                array_push($rlt, $data[$i]);
            }
        }
        //$this->ajaxReturn(array("data" => $rlt, "total"=>100));
        $this->ajaxReturn(array("data" => $rlt));
    }

    /**
     * 重置密码
     * */
    public function user_repass()
    {
        $id = I("id");
        $M = M("urp_user");
        $time = time();
        $data["pwd"] = md5(md5("gm123456"));
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = $M->where(array("Id" => $id))->save($data);
        if ($rlt) {
            responseToJson(0, "亲，用户密码重置成功,新密码gm123456~~~");
        } else {
            responseToJson(3, "亲，用户密码重置失败~~~");
        }
    }

    /**
     * 用户保存
     * */
    public function user_save()
    {
        $id = I("id");
        $name = I("name");
        $code = I("code");
        $phone = I("phone");
        $email = I("email");
        $time = time();
        $M = M("urp_user");
        $data["name"] = $name;
        $data["code"] = $code;
        $data["phone"] = $phone;
        $data["email"] = $email;
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) {
            $data["pwd"] = md5(md5("gm123456"));
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("code" => $code, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，此用户帐号已经存在啦~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，用户新增成功啦~~~");
                } else {
                    responseToJson(1, "亲，用户新增失败啦~~~");
                }
            }
        } else {
            $map['Id'] = array('neq', $id);
            $map['code'] = $code;
            $map["status"] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，用户帐号已经存在~~~");
            } else {
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，用户编辑成功~~~");
                } else {
                    responseToJson(3, "亲，用户编辑失败~~~");
                }
            }
        }
    }

    /**
     * 角色删除
     * */
    public function user_delete()
    {
        $ids = I("ids");
        $data["status"] = 1;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_DI"];
        $rlt = M("urp_user")->where("id in(" . $ids . ")")->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /**
     * 用户新增、编辑页面
     * */
    public function user_view()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $rlt = M("urp_user")->where($where)->find();
            $this->assign("user", $rlt);
        } else {
            $this->assign("user", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 角色列表页面
     * */
    public function role_list()
    {
        $this->display();
    }

    /**
     * 角色新增、编辑页面
     * */
    public function role_view()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $rlt = M("urp_role")->where($where)->find();
            $this->assign("role", $rlt);
        } else {
            $this->assign("role", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 角色查询
     * */
    public function role_query()
    {
        $sql = "select * from urp_role where status = 0";
        $data = D()->query($sql);
        $this->ajaxReturn(array("data" => $data));
    }

    /**
     * 角色保存
     * */
    public function role_save()
    {
        $id = I("id");
        $name = I("name");
        $time = time();
        $M = M("urp_role");
        if ($id == 0) {
            $data["name"] = $name;
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $data["update_time"] = $time;
            $data["updator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，角色名称已经存在~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，新增角色成功~~~");
                } else {
                    responseToJson(2, "亲，新增角色失败~~~");
                }
            }
        } else {
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map["status"] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，角色名称已经存在~~~");
            } else {
                $data["name"] = $name;
                $data["update_time"] = $time;
                $data["updator"] = $_SESSION["USER_ID"];
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，角色编辑成功~~~");
                } else {
                    responseToJson(3, "亲，角色编辑失败~~~");
                }
            }
        }
    }

    /**
     * 角色删除
     * */
    public function role_delete()
    {
        $ids = I("ids");
        $data["status"] = 1;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = M("urp_role")->where("id in(" . $ids . ")")->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /*
     * 保存用户所拥有的角色
     * */
    public function user_role_save()
    {
        $ids = I("ids");
        $uid = I("uid");
        $M = M("urp_role_user");
        $M->startTrans();
        try {
            $rlt = $M->where(array("user_id" => $uid))->delete();
            $arrIds = explode(",", $ids);
            foreach ($arrIds as $v) {
                $data["user_id"] = $uid;
                $data["role_id"] = $v;
                $M->add($data);
            }
            $M->commit();
            responseToJson(0, "亲，保存成功啦~~~");
        } catch (Exception $e) {
            $M->rollback();
            responseToJson(1, "亲，保存失败啦~~~");
        }
    }

    /*
     * 获取用户所拥有的角色
     * */
    public function user_role_list()
    {
        $uid = I("id");
        $roles = D()->query("select Id,name from urp_role where status = 0");
        $myroles = D()->query("select role_id from urp_role_user where user_id = " . $uid);
        $arrRoles = $data = array();
        foreach ($myroles as $vo) {
            array_push($arrRoles, $vo["role_id"]);
        }
        for ($i = 0; $i < count($roles); $i++) {
            array_push($data, array("name" => $roles[$i]["name"], "type" => "item", "id" => $roles[$i]["Id"], "additionalParameters" => array("item-selected" => in_array($roles[$i]["Id"], $arrRoles))));
        }
        responseToJson(0, "OK", $data);
    }

    public function user_role_view()
    {
        $id = I("id");
        $M = M("urp_user");
        $user = $M->where(array("Id" => $id))->find();
        $this->assign("user", $user);
        $this->display();

    }

    public function role_page_save()
    {
        $ids = I("ids");
        $rid = I("rid");
        $M = M("urp_role_page");
        $M->startTrans();
        try {
            $rlt = $M->where(array("role_id" => $rid))->delete();
            $arrIds = explode(",", $ids);
            foreach ($arrIds as $v) {
                $data["role_id"] = $rid;
                $data["page_id"] = $v;
                $M->add($data);
            }
            $M->commit();
            responseToJson(0, "亲，保存成功啦~~~");
        } catch (Exception $e) {
            $M->rollback();
            responseToJson(1, "亲，保存失败啦~~~");
        }
    }

    public function role_page_list()
    {
        $pages = D()->query("select Id,name,pid from urp_page");
        $data = array();
        foreach ($pages as $item) {
            array_push($data, array("id" => $item["Id"], "name" => $item["name"], "pId" => $item["pid"], "open" => true));
        }
        echo json_encode($data);
        exit;
    }

    public function role_page_view()
    {
        $id = I("id");
        $M = M("urp_role");
        $role = $M->where(array("Id" => $id))->find();
        $myPages = D()->query("select page_id from urp_role_page where role_id = " . $id);
        $arrPages = array();
        foreach ($myPages as $vo) {
            array_push($arrPages, $vo["page_id"]);
        }
        $this->assign("role", $role);
        $this->assign("pages", json_encode($arrPages));
        $this->display();
    }

}
