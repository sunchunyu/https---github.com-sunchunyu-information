<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class DictController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     *生源管理
     */
    public function source_list()
    {
        $this->display();
    }

    public function source_query()
    {
        $get_data_list = D('dict_source')->where("status=0")->select();

        if ($get_data_list == null) {
            $get_data_list = array();
        }
        $this->ajaxReturn(array("data" => $get_data_list));
    }

    /**
     * 生源信息的保存
     * */
    public function source_save()
    {
        $id = I("id");
        $name = I("name");
        $time = time();
        $M = M("dict_source");
        $data["name"] = $name;
        //默认更新时间为创建时间
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) { //新增信息
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，已存在同名称记录~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息新增成功啦~~~");
                } else {
                    responseToJson(1, "亲，信息新增失败啦~~~");
                }
            }
        } else { //编辑信息
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map['status'] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，可能存在同名称记录~~~");
            } else {
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息编辑成功~~~");
                } else {
                    responseToJson(3, "亲，信息编辑失败~~~");
                }
            }
        }
    }

    /**
     * 生源信息删除
     * */
    public function source_delete()
    {
        $id = I("id");
        $where["Id"] = array('in', $id);
        $data["status"] = 1;
        $rlt = M("dict_source")->where($where)->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /**
     * 生源信息新增、编辑页面
     * */
    public function source_view()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $where["status"] = 0;
            $rlt = M("dict_source")->where($where)->find();
            $this->assign("data", $rlt);
        } else {
            $this->assign("data", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 省市区的数据的显示
     * */
    public function county_list()
    {
        $where['type'] = 0;
        $where['status'] = 0;
        $pro_data = M("dict_county")->where($where)->select();
        $this->assign('pro_data', $pro_data);
        $where['type'] = 1;
        $where['status'] = 0;
        $city_data = M("dict_county")->where($where)->select();
        $this->assign('city_data', $city_data);
        $this->display();
    }

    public function county_initialize()
    {
        M("dict_county")->execute("TRUNCATE TABLE dict_county;");
        $flag1 = $this->pro_initialize();
        $flag2 = $this->city_initialize();
        $flag3 = $this->area_initialize();

        if ($flag1 && $flag2 && $flag3) {
            $data = [
                'code' => 1,
                'msg' => "亲，初始化完成！",
            ];
            $this->ajaxReturn($data);
        } else {
            $data = [
                'code' => 0,
                'msg' => "亲，初始化失败！",
            ];
            $this->ajaxReturn($data);
        }
    }

    /**
     * 省的数据初始化函数
     * */
    public function pro_initialize()
    {
        $json_url = realpath(dirname(__FILE__) . '/../../../') . '/Public/Static/json/province.t';
        $pro_json = file_get_contents($json_url);
        $json_data = json_decode($pro_json, true);
        $area_data = $json_data['race'];
        for ($i = 0; $i < count($area_data); $i++) {
            $dataList[] = array('name' => $area_data[$i]['name'], 'create_time' => time(), 'update_time' => time(),'creator'=>$_SESSION["USER_ID"]);
        }
        $rel = M("dict_county")->addAll($dataList);
        if ($rel) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 市的数据初始化函数
     * */
    public function city_initialize()
    {
        $json_url = realpath(dirname(__FILE__) . '/../../../') . '/Public/Static/json/city.t';
        $city_json = file_get_contents($json_url);
        $json_data = json_decode($city_json, true);
        $city_data = $json_data['race'];
        for ($i = 0; $i < count($city_data); $i++) {
            $dataList[] = array('name' => $city_data[$i]['name'], 'province_id' => $city_data[$i]['ProID'], 'type' => 1, 'create_time' => time(), 'update_time' => time());
        }
        $rel = M("dict_county")->addAll($dataList);
        if ($rel) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 区的数据初始化函数
     * */
    public function area_initialize()
    {
        $json_url = realpath(dirname(__FILE__) . '/../../../') . '/Public/Static/json/area.t';
        $area_json = file_get_contents($json_url);
        $json_data = json_decode($area_json, true);
        $area_data = $json_data['race'];

        $where["type"] = 1;
        $get_data = M("dict_county")->where($where)->select();          //读取全部的市
        for ($i = 0; $i < count($get_data); $i++) {
            $pro_id_list[$i] = $get_data[$i]['province_id'];        //存放省id的数组
            $city_id_list[$i] = $get_data[$i]['Id'];        //存放市id的数组
        }
        for ($i = 0; $i < count($area_data); $i++) {
//            $dataList[] = array('name' => $area_data[$i]['DisName'], 'city_id' => $city_id_list[$area_data[$i]['CityID']], 'province_id' => $pro_id_list[$area_data[$i]['CityID']], 'type' => 2, 'create_time' => time(), 'update_time' => time());
            $dataList[] = array('name' => $area_data[$i]['DisName'], 'city_id' => $area_data[$i]['CityID']+34, 'province_id' => $pro_id_list[$area_data[$i]['CityID']-1], 'type' => 2, 'create_time' => time(), 'update_time' => time());
        }
        $rel = M("dict_county")->addAll($dataList);
        if ($rel) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 省市区的数据的读取
     * 我在写这段代码的时候，只有我和上帝知道它
     * 是用来做什么的，
     * 现在，就只剩上帝知道了。
     * */
    public function county_query()
    {
        $pro_where = $_POST['aoData']['pro_id'];
        $city_where = $_POST['aoData']['city_id'];
        $name_where = $_POST['aoData']['name'];
        /* var_dump(is_null($name_where));     //如果未空 这是true
         if(is_null($name_where)){
             var_dump("wy");
         }*/
        if ($pro_where > 0 || $city_where > 0 || !empty($name_where)) {
            //当有一个条件被输入的时候执行

            if ($pro_where > 0 && $city_where < 0 && empty($name_where)) {
                //当只选择省的时候执行
                $where["status"] = 0;
                $where["province_id"] = $pro_where;
                $this->get_data2($where);
            } else if ($pro_where < 0 && $city_where > 0 && empty($name_where)) {
                //当只选择市的时候执行
                $where["status"] = 0;
                $where["Id"] = $city_where;
                $this->get_data2($where);
            } else if ($pro_where < 0 && $city_where < 0 && !empty($name_where)) {
                //当只输入文本框的时候执行
                $where["status"] = 0;
                $where["name"] = array('like', "%" . $name_where . "%");
                $this->get_data2($where);
            } else if ($pro_where > 0 && $city_where < 0 && !empty($name_where)) {
                //当选择省并且输入文本的时候执行
                $where["status"] = 0;
                $where['province_id'] = $pro_where;
                $where["name"] = array('like', "%" . $name_where . "%");
                $this->get_data2($where);

            } else if ($pro_where < 0 && $city_where > 0 && !empty($name_where)) {
                //当选择市并且输入文本的时候执行
//                var_dump("省市类型条件");
                $where["status"] = 0;
                $where['city_id'] = $city_where;
                $where['type'] = 2;
                $where["name"] = array('like', "%" . $name_where . "%");
                $this->get_data2($where);
            } else if ($pro_where > 0 && $city_where > 0 && !empty($name_where)) {
                //当选择省并且选择市并且输入文本的时候执行
                $where["status"] = 0;
                $where['city_id'] = $city_where;
                $where['province_id'] = $pro_where;
                $where["name"] = array('like', "%" . $name_where . "%");
                $where['type'] = 2;
                $this->get_data2($where);
            } else if ($pro_where > 0 && $city_where > 0 && empty($name_where)) {
                $where["status"] = 0;
                $where['city_id'] = $city_where;
                $where['province_id'] = $pro_where;
                $where['type'] = 2;
                $this->get_data2($where);
            }
        } else {
            $where["status"] = 0;
            $this->get_data($where);
        }
    }

    public function get_data($find_where)
    {
        $county = M("dict_county");
        $where = $find_where;
        $data = $county->where($where)->select();
        $re_data = [];
        for ($i = 1; $i <= count($data); $i++) {
            $name_list [$i] = array('Id' => $data[$i - 1]['Id'], 'name' => $data[$i - 1]['name']);
        }
        for ($i = 1; $i <= count($data); $i++) {
            $re_data[$i - 1]['Id'] = $data[$i - 1]['Id'];
            $re_data[$i - 1]['name'] = $name_list[$i]['name'];

            if ($data[$i - 1]['type'] == 0) {
                $re_data [$i - 1]['type'] = '省';
            } else if ($data[$i - 1]['type'] == 1) {
                $re_data [$i - 1]['type'] = '市';
            } else if ($data[$i - 1]['type'] == 2) {
                $re_data [$i - 1]['type'] = '区/县';
            }
            if ($name_list[$data[$i - 1]['city_id']]['name'] == null) {
                $re_data [$i - 1]['city_id'] = '----';
            } else {
                $re_data [$i - 1]['city_id'] = $name_list[$data[$i - 1]['city_id']]['name'];
            }
            if ($name_list[$data[$i - 1]['province_id']]['name'] == null) {
                $re_data [$i - 1]['province_id'] = '----';
            } else {
                $re_data [$i - 1]['province_id'] = $name_list[$data[$i - 1]['province_id']]['name'];
            }
        }
        if ($re_data) {
            $this->ajaxReturn(array("data" => $re_data));
        } else {
            $data = [];
            $this->ajaxReturn(array("data" => $data));
        }
    }

    public function get_data2($find_where)
    {
        $county = M("dict_county");
        $where = $find_where;
        $data = $county->where($where)->select();

        for ($i = 1; $i <= count($data); $i++) {
            $re_data[$i - 1]['Id'] = $data[$i - 1]['Id'];
            $re_data[$i - 1]['name'] = $data[$i - 1]['name'];
            if ($data[$i - 1]['type'] == 0) {
                $re_data [$i - 1]['type'] = '省';
            } else if ($data[$i - 1]['type'] == 1) {
                $re_data [$i - 1]['type'] = '市';
            } else if ($data[$i - 1]['type'] == 2) {
                $re_data [$i - 1]['type'] = '区/县';
            }
            $where_city ['Id'] = $data[$i - 1]['city_id'];
            $where_pro ['Id'] = $data[$i - 1]['province_id'];
            $re_data [$i - 1]['city_id'] = $county->where($where_city)->getField('name');
            $re_data [$i - 1]['province_id'] = $county->where($where_pro)->getField('name');
            if($re_data [$i - 1]['city_id'] == null){
                $re_data [$i - 1]['city_id'] = "----";
            }
            if($re_data [$i - 1]['province_id'] == null){
                $re_data [$i - 1]['province_id'] = "----";
            }
        }
        if($re_data == null){
            $re_data = array();
        }
        if ($re_data) {

            $this->ajaxReturn(array("data" => $re_data));
        } else {

            $this->ajaxReturn(array("data" => $re_data));
        }
    }

    /**
     * 省市区的数据删除
     * */
    public function county_delete()
    {
        $source = $_POST;

        $where['Id'] = array('in', $source['id']);
        $county = M('dict_county');
        $data['status'] = 1;
        $data['updator'] = $_SESSION["USER_ID"];
        $rel = $county->where($where)->save($data); // 根据条件更新记录
        $county->startTrans();
        if ($rel) {
            try {
                $ids = $county->where(array("province_id" => array("in", $source['id'])))->getField("Id", true);
                $id = "-9,";
                foreach ($ids as $v) {
                    $id = $id . $v . ",";
                }
                $id = $id . $source['id'];
                $county->where(array("province_id" => array("in", $source['id'])))->save($data);
                $county->where(array("city_id" => array("in", $id)))->save($data);
                $data = [
                    'code' => 0,
                    'message' => "删除成功！",
                ];
                $county->commit();
                return $this->ajaxReturn($data);
            } catch (Exception $e) {
                $data = [
                    'code' => 2,
                    'message' => "删除失败！",
                ];
                $county->rollback();
                return $this->ajaxReturn($data);
            }
        } else {
            $data = [
                'code' => 1,
                'message' => "删除失败！",
            ];
            $county->rollback();
            return $this->ajaxReturn($data);
        }


    }

    /**
     * 省市区的添加、编辑页面
     * */
    public function county_view()
    {
        $id = intval(I("id"));

        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $where["status"] = 0;
            $rlt = M("dict_county")->where($where)->find();

            $type = $rlt['type'];
            if ($type == 0) {
                //省的代码
                $data = [
                    "text" => $rlt['name'],
                    'id' => $rlt['Id']
                ];
                $pro_flag = false;
                $city_flag = false;
                $this->assign('pro_flag', $pro_flag);
                $this->assign('city_flag', $city_flag);

                $this->assign('make', '0');
                $this->assign("data", $data);

            } elseif ($type == 1) {
                //市的代码
                $where['Id'] = $_GET['id'];
                $rlt = M('dict_county')->where($where)->find();

                $pro_where ['type'] = 0;
                $pro_where ['status'] = 0;
                $pro_list = M('dict_county')->where($pro_where)->select();

                $data = [
                    "text" => $rlt['name'],
                    'id' => $rlt['Id'],
                    'province_id' => $rlt['province_id']
                ];
                $pro_flag = true;
                $city_flag = false;
                $this->assign('pro_flag', $pro_flag);
                $this->assign('city_flag', $city_flag);

                $this->assign('list', $pro_list);

                $this->assign('make', '1');
                $this->assign("data", $data);
            } else {
                //区的代码
                $where['Id'] = $_GET['id'];
                $rlt = M('dict_county')->where($where)->find();

                $city_where ['type'] = 1;
                $city_where ['status'] = 0;
                $city_list = M('dict_county')->where($city_where)->select();
                $pro_where ['type'] = 0;
                $pro_where ['status'] = 0;
                $pro_list = M('dict_county')->where($pro_where)->select();


                $data = [
                    "text" => $rlt['name'],
                    'id' => $rlt['Id'],
                    'city_id' => $rlt['city_id'],
                    'province_id' => $rlt['province_id']
                ];
                $pro_flag = false;
                $city_flag = true;
                $this->assign('pro_flag', $pro_flag);
                $this->assign('city_flag', $city_flag);

                $this->assign('city_list', $city_list);
                $this->assign('list', $pro_list);
                $this->assign('city_id', $rlt['city_id']);

                $this->assign('make', '2');
                $this->assign("data", $data);
            }
        } else {
            $where["status"] = 0;
            $where["type"] = 0;
            $pro = M("dict_county")->where($where)->select();
            $this->assign("make", "3");
            $this->assign("data", null);
            $this->assign('pro', $pro);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 用于省市区的编辑保存
     */
    public function edit_save()
    {
//        var_dump($_POST);

        $make = $_POST['make'];
        if ($make == 0) {
            $where["Id"] = $_POST['id'];
            $data["name"] = $_POST['name'];
            $data['update_time'] = time();
            $data['updator'] = $_SESSION["USER_ID"];
            $rlt = M("dict_county")->where($where)->save($data);
            if ($rlt) {
                $info = [
                    'code' => 0,
                    'message' => "保存成功！",
                ];
                $this->ajaxReturn($info);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "保存失败！",
                ];
                $this->ajaxReturn($info);
            }
        } elseif ($make == 1) {
            $where["Id"] = $_POST['id'];
            $data["name"] = $_POST['name'];
            $data['province_id'] = $_POST['pro_id'];
            $data['update_time'] = time();
            $data['updator'] = $_SESSION["USER_ID"];
            $rlt = M("dict_county")->where($where)->save($data);
            if ($rlt) {
                $aa = [
                    'code' => 0,
                    'message' => "保存成功！"
                ];
                $this->ajaxReturn($aa);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "保存失败！",
                ];
                $this->ajaxReturn($info);
            }
        } elseif ($make == 2) {

            $id ['Id'] = $_POST['city_id'];
            $pro_id = M('dict_county')->where($id)->find();


            $where["Id"] = $_POST['id'];
            $data["name"] = $_POST['name'];
            $data['city_id'] = $_POST['city_id'];
            $data['province_id'] = $pro_id['province_id'];
            $data['update_time'] = time();
            $data['updator'] = $_SESSION["USER_ID"];


            $rlt = M("dict_county")->where($where)->save($data);
            if ($rlt) {
                $aa = [
                    'code' => 0,
                    'message' => "保存成功！"
                ];
                $this->ajaxReturn($aa);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "保存失败！",
                ];
                $this->ajaxReturn($info);
            }
        }
    }

    /**
     * 用于获取选中的省的下属市
     */
    public function get_city()
    {
        if ($_POST['Id'] > 0) {
            $where['province_id'] = $_POST['Id'];
            $where["status"] = 0;
            $where["type"] = 1;
            $city = M("dict_county")->where($where)->select();
            if ($city) {
                $info = [
                    'code' => 0,
                ];
                $this->ajaxReturn(array("data" => $city, 'info' => $info));
            } else {
                $info = [
                    'code' => 1,
                    'message' => "失败！",
                ];
                $this->ajaxReturn(array('info' => $info));
            }
        } else {
            $where["status"] = 0;
            $where["type"] = 1;
            $city = M("dict_county")->where($where)->select();
            if ($city) {
                $info = [
                    'code' => 0,
                ];
                $this->ajaxReturn(array("data" => $city, 'info' => $info));
            } else {
                $info = [
                    'code' => 1,
                    'message' => "失败！",
                ];
                $this->ajaxReturn(array('info' => $info));
            }
        }
    }

    /**
     * 省市区的数据添加
     * */
    public function county_save()
    {
        if ($_POST['type'] == 0) {
            //添加省
            $data['name'] = $_POST['name'];
            $data["create_time"] = time();
            $data["updator"] = $_SESSION["USER_ID"];
            $rlt = M("dict_county")->add($data);
            if ($rlt) {
                $info = [
                    'code' => 0,
                    'message' => "添加成功！",
                ];
                $this->ajaxReturn($info);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "添加失败！",
                ];
                $this->ajaxReturn($info);
            }

        } elseif ($_POST['type'] == 1) {
            //添加市
            $data['name'] = $_POST['name'];
            $data['province_id'] = $_POST['pro_id'];
            $data["create_time"] = time();
            $data["updator"] = $_SESSION["USER_ID"];
            $data['type'] = 1;
            $rlt = M("dict_county")->add($data);
            if ($rlt) {
                $info = [
                    'code' => 0,
                    'message' => "添加成功！",
                ];
                $this->ajaxReturn($info);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "添加失败！",
                ];
                $this->ajaxReturn($info);
            }
        } elseif ($_POST['type'] == 2) {
            //添加县区
            $data['name'] = $_POST['name'];
            $data['province_id'] = $_POST['pro_id'];
            $data['city_id'] = $_POST['city_id'];
            $data["create_time"] = time();
            $data['type'] = 2;
            $data["updator"] = $_SESSION["USER_ID"];
            $rlt = M("dict_county")->add($data);
            if ($rlt) {
                $info = [
                    'code' => 0,
                    'message' => "添加成功！",
                ];
                $this->ajaxReturn($info);
            } else {
                $info = [
                    'code' => 1,
                    'message' => "添加失败！",
                ];
                $this->ajaxReturn($info);
            }
        }
    }

    /**
     *班级管理
     */
    public function class_list()
    {
        $specialty = D('dict_specialty')->where("status=0")->select(); //返回专业
        $college_0 = D('dict_college')->where(array("type" => 0, "status" => 0))->select(); //返回院系
        $college_1 = D('dict_college')->where(array("type" => 1, "status" => 0))->select(); //返回学院

        if ($specialty == null) {
            $specialty = array();
        }

        if ($college_0 == null) {
            $college_0 = array();
        }

        if ($college_1 == null) {
            $college_1 = array();
        }

        $this->assign("specialty", $specialty);
        $this->assign("college_0", $college_0);
        $this->assign("college_1", $college_1);

        $this->display();
    }

    public function class_query()
    {
        $data = I("aoData");
        $p_id = $data["p_id"];
        $college_id = $data["college_id"];
        $specialty_id = $data["specialty_id"];

        $get_college_name = D('dict_college')->where("status=0")->select(); //列出院系
        foreach ($get_college_name as $item) { //获取院系名称
            //$get_college_data[$item["Id"]] = $item["name"];
            $get_college_data[$item["Id"]] = array(
                "name" => $item["name"],
                "college" => $item["p_id"]
            );

            if ($get_college_data[$item["Id"]]["name"] == null) {
                $get_college_data[$item["Id"]]["name"] = "";
            }
            if ($get_college_data[$item["Id"]]["p_id"] == null) {
                $get_college_data[$item["Id"]]["p_id"] = "";
            }
        }

        $get_specialty_name = D('dict_specialty')->where("status=0")->select(); //列出专业
        foreach ($get_specialty_name as $item) { //获取专业名称
            $get_specialty_data[$item["Id"]] = array(
                "name" => $item["name"],
                "college" => $item["college_id"]
            );

            if ($get_specialty_data[$item["Id"]]["name"] == null) {
                $get_specialty_data[$item["Id"]]["name"] = "";
            }
            if ($get_specialty_data[$item["Id"]]["college_id"] == null) {
                $get_specialty_data[$item["Id"]]["college_id"] = "";
            }
        }

        for ($i = 0; $i < count($get_specialty_data); $i++) {
            //更改院系id 为字符
            $get_specialty_data[$i]["college"] = $get_college_data[intval($get_specialty_data[$i]["college"])];
            $get_specialty_data[$i]["college"]["college"] = $get_college_data[intval($get_specialty_data[$i]["college"]["college"])]["name"];
            if($get_specialty_data[$i]["college"]["name"] == null){
                $get_specialty_data[$i]["college"]["name"] = "";
            }
            if($get_specialty_data[$i]["college"]["college"] == null){
                $get_specialty_data[$i]["college"]["college"] = "";
            }
        }

        //查询语句，根据不同值判断：学院，院系，专业
        $where = "status=0";

        if ($specialty_id != 0) {
            $where = "specialty_id=" . $specialty_id . " and " . $where;
        } else if ($college_id != 0) {
            $where = "specialty_id IN(SELECT id FROM dict_specialty WHERE college_id = " . $college_id . ") AND status=0";
        } else if ($p_id != 0) {
            $where = "specialty_id IN(SELECT id FROM dict_specialty WHERE college_id IN (SELECT id FROM dict_college WHERE p_id =" . $p_id . ")) AND status=0";
        }

        $get_data_list = D('dict_class')->where($where)->select();

        for ($i = 0; $i < count($get_data_list); $i++) {
            //更改专业id 为字符
            $get_data_list[$i]["specialty_id"] = $get_specialty_data[intval($get_data_list[$i]["specialty_id"])];
            if($get_data_list[$i]["specialty_id"]["name"] == null){
                $get_data_list[$i]["specialty_id"]["name"] = "";
            }
            if($get_data_list[$i]["specialty_id"]["college"] == null){
                $get_data_list[$i]["specialty_id"]["college"] ="";
            }
        }

        if ($get_data_list == null) {
            $get_data_list = array();
        }
        $this->ajaxReturn(array("data" => $get_data_list));
    }

    /**
     * 班级删除
     * */
    public function class_delete()
    {
        $id = I("id");
        $where["Id"] = array('in', $id);
        $data["status"] = 1;
        $rlt = M("dict_class")->where($where)->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /**
     * 班级信息的保存
     * */
    public function class_save()
    {
        $id = I("id");
        $name = I("name");
        $specialty_id = I("specialty_id");
        $time = time();
        $M = M("dict_class");
        $data["name"] = $name;
        $data["specialty_id"] = $specialty_id;
        //默认更新时间为创建时间
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) { //新增信息
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，已存在同名称记录~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息新增成功啦~~~");
                } else {
                    responseToJson(1, "亲，信息新增失败啦~~~");
                }
            }
        } else { //编辑信息
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map['status'] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，可能存在同名称记录~~~");
            } else {
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息编辑成功~~~");
                } else {
                    responseToJson(3, "亲，信息编辑失败~~~");
                }
            }
        }
    }

    /**
     * 班级信息新增、编辑页面
     * */
    public function class_view()
    {
        $dict_specialty = M('dict_specialty'); //适用专业
        $get_specialty_name = $dict_specialty->where(array("status" => 0))->select(); //列出专业名称
        $this->assign("specialty", $get_specialty_name);

        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $where["status"] = 0;
            $rlt = M("dict_class")->where($where)->find(); //查询该数据信息
            $this->assign("data", $rlt);
        } else {
            $this->assign("data", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    public function get_class_data()
    {
        $data = I("aoData");

        $get_college_name = D('dict_college')->where(array("status" => 0))->select(); //列出院系
        foreach ($get_college_name as $item) { //获取院系名称
            //$get_college_data[$item["Id"]] = $item["name"];
            $get_college_data[$item["Id"]] = array(
                "name" => $item["name"],
                "college" => $item["p_id"]
            );
        }

        $get_specialty_name = D('dict_specialty')->where("status=0")->select(); //列出专业
        foreach ($get_specialty_name as $item) { //获取专业名称
            $get_specialty_data[$item["Id"]] = array(
                "name" => $item["name"],
                "college" => $item["college_id"]
            );
        }

        for ($i = 0; $i < count($get_specialty_data); $i++) {
            //更改院系id 为字符
            $get_specialty_data[$i]["college"] = $get_college_data[intval($get_specialty_data[$i]["college"])];
            $get_specialty_data[$i]["college"]["college"] = $get_college_data[intval($get_specialty_data[$i]["college"]["college"])]["name"];
        }

        $get_data_list = D('dict_class')->where("status=0")->select();

        for ($i = 0; $i < count($get_data_list); $i++) {
            //更改专业id 为字符
            $get_data_list[$i]["specialty_id"] = $get_specialty_data[intval($get_data_list[$i]["specialty_id"])];
        }

        if ($get_data_list == null) {
            $get_data_list = array();
        }
        $this->ajaxReturn(array("data" => $get_data_list));

        $this->ajaxReturn(array("data" => $get_data_list));
    }

    /**
     *院系管理
     */
    public function college_list()
    {
        $college = D('dict_college')->where(array("type" => 0, "status" => 0))->select(); //列出学院

        if ($college == null) {
            $college = array();
        };
        $this->assign("college", $college);
        $this->display();
    }

    public function college_query()
    {
        $data = I("aoData");
        $college = $data["college"];
        $get_college_name = D('dict_college')->where(array("type" => 0))->order('p_id')->select(); //列出学院
        foreach ($get_college_name as $item) { //获取学院名称
            $get_college_data[$item["Id"]] = $item["name"];
        }
        if ($data["college"] != 0) {
            $where = array("p_id" => $college, "status" => 0);
        } else {
            $where = array("status" => 0);
        }
        $get_data_list = D('dict_college')->where($where)->order('Id desc')->select();

        for ($i = 0; $i < count($get_data_list); $i++) {
            //更改类型：0： 院； 1：系
            if ($get_data_list[$i]["type"] == 0) {
                $get_data_list[$i]["type"] = "院";

                //转换p_id 为对应字符
                $get_data_list[$i]["p_id"] = "";
            } elseif ($get_data_list[$i]["type"] == 1) {
                $get_data_list[$i]["type"] = "系";

                //转换p_id 为对应字符
                $get_data_list[$i]["p_id"] = $get_college_data[intval($get_data_list[$i]["p_id"])];
            }
        }
        if ($get_data_list == null) {
            $get_data_list = array();
        }
        $this->ajaxReturn(array("data" => $get_data_list));
    }

    /**
     * 院系删除
     * */
    public function college_delete()
    {
        $id = I("id");
        $where["Id"] = array('in', $id);
        $data["status"] = 1;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $M = M("dict_college");
        $rlt = $M->where($where)->save($data);
        if ($rlt) {
            try {
                $ids = M("dict_specialty")->where(array("college_id" => array("in", $id)))->getField("Id", true);
                $idid = "";
                foreach ($ids as $v) {
                    $idid = $idid . $v . ",";
                }
                $idid = $id . "-9";
                M("dict_college")->where(array("p_id" => array("in", $id)))->save($data);
                M("dict_specialty")->where(array("college_id" => array("in", $id)))->save($data);
                M("dict_class")->where(array("specialty_id" => array("in", $idid)))->save($data);
                $M->commit();
                responseToJson(0, "亲，删除成功啦~~~");
            } catch (Exception $e) {
                $M->rollback();
                responseToJson(2, "亲，删除失败啦~~~");
            }
        } else {
            $M->rollback();
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /**
     * 学院信息的保存
     * */
    public function college_save()
    {
        $id = I("id");
        $name = I("name");
        $p_id = I("p_id");
        //当所属学院为0时：类型为0（学院），否则其类型为1（系）
        if ($p_id == 0) {
            $type = 0;
        } else {
            $type = 1;
        }
        $time = time();
        $M = M("dict_college");
        $data["name"] = $name;
        $data["type"] = $type;
        $data["p_id"] = $p_id;
        //默认更新时间为创建时间
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) { //新增信息
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，已存在同名称记录~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息新增成功啦~~~", $rlt);
                } else {
                    responseToJson(1, "亲，信息新增失败啦~~~");
                }
            }
        } else { //编辑信息
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map['status'] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，可能存在同名称记录~~~");
            } else {
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息编辑成功~~~");
                } else {
                    responseToJson(3, "亲，信息编辑失败~~~");
                }
            }
        }
    }

    /**
     * 学院信息新增、编辑页面
     * */
    public function college_view()
    {
        $dict_college = M('dict_college'); //适用学院
        $get_college_name = $dict_college->where(array("status" => 0, "type" => 0))->select(); //列出学院名称
        $this->assign("college", $get_college_name);

        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $where["status"] = 0;
            $rlt = M("dict_college")->where($where)->find();
            $this->assign("data", $rlt);
        } else {
            $this->assign("data", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     *专业管理
     */
    public function specialty_list()
    {
        $college_0 = D('dict_college')->where(array("type" => 0, "status" => 0))->select(); //返回院系
        $college_1 = D('dict_college')->where(array("type" => 1, "status" => 0))->select(); //返回学院

        // var_dump($college_0);
        // exit();

        if ($college_0 == null) {
            $college_0 = array();
        }

        if ($college_1 == null) {
            $college_1 = array();
        }

        $this->assign("college_0", $college_0);
        $this->assign("college_1", $college_1);
        $this->display();
    }

    public function specialty_query()
    {
        $data = I("aoData");

        $get_college_name = D('dict_college')->select(); //列出院系


        if ($data["college_id"] != 0) {
            $get_data_list = D('dict_specialty')->where(array("college_id" => $data["college_id"], "status" => 0))->select();
        } else if ($data["p_id"] != 0) {
            $get_data_list = D('dict_specialty')->where("college_id IN(SELECT id FROM dict_college WHERE p_id = " . $data["p_id"] . ") AND STATUS = 0")->select();
        } else {
            $get_data_list = D('dict_specialty')->where(array("status" => 0))->select();
        }

        foreach ($get_college_name as $item) { //获取院系名称
            //$get_college_data[$item["Id"]] = $item["name"];
            $get_college_data[$item["Id"]] = array(
                "name" => $item["name"],
                "college" => $item["p_id"]
            );
        }

        for ($i = 0; $i < count($get_data_list); $i++) {
            //更改院系id 为字符
            $get_data_list[$i]["college_id"] = $get_college_data[intval($get_data_list[$i]["college_id"])];
            $get_data_list[$i]["college_id"]["college"] = $get_college_data[intval($get_data_list[$i]["college_id"]["college"])]["name"];

            if ($get_data_list[$i]["college_id"]["name"] == null) {
                $get_data_list[$i]["college_id"]["name"] = "";
            }
            if ($get_data_list[$i]["college_id"]["college"] == null) {
                $get_data_list[$i]["college_id"]["college"] = "";
            }

        }

        if($get_data_list == null){
            $get_data_list = array();
        }

        $this->ajaxReturn(array("data" => $get_data_list));
    }

    /**
     * 专业删除
     * */
    public function specialty_delete()
    {
        $id = (I("id"));
        $where["Id"] = array('in', $id);
        $data["status"] = 1;
        $M = M("dict_specialty");
        $M->startTrans();
        $rlt = $M->where($where)->save($data);
        if ($rlt) {
            try {
                M("dict_class")->where(array("specialty_id" => array("in", $id)))->save($data);
                $M->commit();
                responseToJson(0, "亲，删除成功啦~~~");
            } catch (Exception $e) {
                $M->rollback();
                responseToJson(2, "亲，删除失败啦~~~");
            }
        } else {
            $M->rollback();
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    /**
     * 专业信息的保存
     * */
    public function specialty_save()
    {
        $id = I("id");
        $name = I("name");
        $college_id = I("college_id");
        $time = time();
        $M = M("dict_specialty");
        $data["name"] = $name;
        $data["college_id"] = $college_id;
        //默认更新时间为创建时间
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) { //新增信息
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，已存在同名称记录~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息新增成功啦~~~");
                } else {
                    responseToJson(1, "亲，信息新增失败啦~~~");
                }
            }
        } else { //编辑信息
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map['status'] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，可能存在同名称记录~~~");
            } else {
                $rlt = $M->where(array("Id" => $id))->save($data);
                if ($rlt) {
                    responseToJson(0, "亲，信息编辑成功~~~");
                } else {
                    responseToJson(3, "亲，信息编辑失败~~~");
                }
            }
        }
    }

    /**
     * 专业信息新增、编辑页面
     * */
    public function specialty_view()
    {
        $dict_college = M('dict_college'); //适用院系
        $get_college_name = $dict_college->where(array("status" => 0, "type" => 1))->select(); //列出院系名称
        $this->assign("college", $get_college_name);

        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $where["status"] = 0;
            $rlt = M("dict_specialty")->where($where)->find(); //查询该数据信息
            $this->assign("data", $rlt);
        } else {
            $this->assign("data", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 民族的数据的显示
     * */
    public function nation_list()
    {
        $this->display();
    }

    /**
     * 民族的数据初始化
     * */
    public function nation_initialize()
    {
        M("dict_nation")->execute("TRUNCATE TABLE dict_nation;");
        $json_url = realpath(dirname(__FILE__) . '/../../../') . '/Public/Static/json/national.t';
        $area_json = file_get_contents($json_url);
        $json_data = json_decode($area_json, true);
        $nation_data = $json_data['race'];
        for ($i = 0; $i < count($nation_data); $i++) {
            $dataList[] = array('name' => $nation_data[$i]['value'], 'status' => 0, 'create_time' => time(), 'creator' => $_SESSION["USER_ID"]);
        }
        $rel = M("dict_nation")->addAll($dataList);
        if ($rel) {
            $data = [
                'code' => 1,
                'msg' => "初始化完成！",
            ];
            return $this->ajaxReturn($data);
        } else {
            $data = [
                'code' => 0,
                'msg' => "初始化失败！",
            ];
            return $this->ajaxReturn($data);
        }
    }

    /**
     * 民族的数据的读取
     * */
    public function nation_query()
    {
        $nation = M("dict_nation");
        $where["status"] = 0;
        $data = $nation->where($where)->order('id')->order(array('create_time' => 'desc'))->select();
        if ($data) {
            $this->ajaxReturn(array("data" => $data));
        } else {
            $data = [];
            $this->ajaxReturn(array("data" => $data));
        }

    }

    /**
     * 民族的数据删除
     * */
    public function nation_delete()
    {
        $source = $_POST;
        $where['Id'] = array('in', $source['id']);
        $nation = M('dict_nation');
        $data['status'] = 1;
        $data['updator'] = $_SESSION["USER_ID"];
        $rel = $nation->where($where)->save($data); // 根据条件更新记录
        if ($rel) {
            $data = [
                'code' => 0,
                'message' => "删除成功！",
            ];
            return $this->ajaxReturn($data);
        } else {
            $data = [
                'code' => 1,
                'message' => "删除失败！",
            ];
            return $this->ajaxReturn($data);
        }

    }

    /**
     * 民族新增、编辑页面
     * */
    public function nation_view()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $rlt = M("dict_nation")->where($where)->find();
            $this->assign("data", $rlt);
        } else {
            $this->assign("data", null);
            $this->assign("title", "新增");
        }
        $this->display();
    }

    /**
     * 民族新增、编辑
     * */
    public function nation_save()
    {
        $id = I("id");
        $name = I("name");
        $time = time();
        $M = M("dict_nation");
        $data["name"] = $name;

        //默认更新时间为创建时间
        $data["update_time"] = $time;
        $data["updator"] = $_SESSION["USER_ID"];
        if ($id == 0) { //新增信息
            $data["create_time"] = $time;
            $data["creator"] = $_SESSION["USER_ID"];
            $rlt = $M->where(array("name" => $name, "status" => 0))->find();
            if ($rlt) {
                responseToJson(1, "亲，已存在同名称记录~~~");
            } else {
                $rlt = $M->add($data);
                if ($rlt) {
                    responseToJson(0, "亲，用户新增成功啦~~~");
                } else {
                    responseToJson(1, "亲，用户新增失败啦~~~");
                }
            }
        } else { //编辑信息
            $map['Id'] = array('neq', $id);
            $map['name'] = $name;
            $map['status'] = 0;
            $rlt = $M->where($map)->find();
            if ($rlt) {
                responseToJson(1, "亲，可能存在同名称记录~~~");
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
}