<?php
/**
 * Created by PhpStorm.
 * User: 程鹏辉
 * Date: 2016/4/8
 * Time: 19:56
 */
namespace Admin\Controller;

use Think\Controller;

define('TOKEN_EXPIRES', 172800); //自动确认时间为，两天

class StudController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function manage_list()
    {
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称
        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("deparment", $get_deparment_name); //添加系别
        $this->display();
    }

    //显示list数据详情
    public function get_data()
    {
        $dict_college = M('dict_college');
        $data_deitl = I("aoData");
        $college = $data_deitl['college_id'];
        $specialty = $data_deitl['specialty_id'];
        $class = $data_deitl['class_id'];
        $status = $data_deitl['status'];
        $code = $data_deitl['code'];
        $name = trim($data_deitl['student_name']);
        $deparment = $data_deitl['deparment'];
        if (!empty($name)) {
            $map["name"] = array("like", "%" . $name . "%");
        }

        if ($college != 0) {
            $map['college_id'] = $college;
        } else {
            $map['college_id'] = array('EGT', 0);
        }

        if ($deparment != 0) {
            $map['department_id'] = $deparment;
        } else {
            $map['department_id'] = array('EGT', 0);
        }

        if ($specialty != 0) {
            $map['specialty_id'] = $specialty;
        } else {
            $map['specialty_id'] = array('EGT', 0);
        }

        if ($class != 0) {
            $map['class_id'] = $class;
        } else {
            $map['class_id'] = array('EGT', 0);
        }

        if ($code != "全部") {
            $map['code'] = $code;
        }
        if ($status == 0) {
            $map['status'] = 1;
        } else {
            $map['status'] = 0;
        }

        $stud_collection = M("stud_collection");
        $dict_class = M("dict_class"); //班级
        $dict_college = M("dict_college"); //院系
        $dict_specialty = M("dict_specialty"); //专业
        $urp_user = M("urp_user");

        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出系名称
        $get_department_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_department_name as $item) { //获取院系名称
            $get_department_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        $get_data_list = $stud_collection->where($map)->order('update_time desc')->select();
        if (empty($get_data_list)) {
            $get_data_list = array();
        }


        for ($i = 0; $i < count($get_data_list); $i++) { //对名称进行对应
            if ($get_data_list[$i]["college_id"] == 0) {
                $get_data_list[$i]["college_id"] = "全部";
            } else {
                $get_data_list[$i]["college_id"] = $get_college_data[intval($get_data_list[$i]["college_id"])];
            }

            if ($get_data_list[$i]["department_id"] == 0) {
                $get_data_list[$i]["department_id"] = "全部";
            } else {
                $get_data_list[$i]["department_id"] = $get_department_data[intval($get_data_list[$i]["department_id"])];
            }

            if ($get_data_list[$i]["class_id"] == 0) {
                $get_data_list[$i]["class_id"] = "全部";
            } else {
                $get_data_list[$i]["class_id"] = $get_class_data[intval($get_data_list[$i]["class_id"])];
            }

            if ($get_data_list[$i]["specialty_id"] == 0) {
                $get_data_list[$i]["specialty_id"] = "全部";
            } else {
                $get_data_list[$i]["specialty_id"] = $get_specialty_data[intval($get_data_list[$i]["specialty_id"])];
            }


            $get_data_list[$i]["creator"] = $get_user_data[intval($get_data_list[$i]["creator"])];
            if ($get_data_list[$i]["updator"] == 0) {
                $get_data_list[$i]["updator"] = "暂无";
            } else {
                $get_data_list[$i]["updator"] = $get_user_data[intval($get_data_list[$i]["updator"])];
            }

            $get_data_list[$i]["create_time"] = date("Y-m-d H:i:s", $get_data_list[$i]['create_time']);
            if ($get_data_list[$i]["update_time"] == 0) {
                $get_data_list[$i]["update_time"] = "暂无";
            } else {
                $get_data_list[$i]["update_time"] = date("Y-m-d H:i:s", $get_data_list[$i]['update_time']);
            }
        }
        $this->ajaxReturn(array("data" => $get_data_list));
    }

    //添加采集信息页面
    public function manage_add_view()
    {
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称
        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("deparment", $get_deparment_name); //添加系别
        $this->display();
    }

    //提交修改按钮
    public function manage_add_save()
    {
        $stud_collection = M('stud_collection');
        $data['name'] = trim(I("post.name"));
        $data['code'] = I("post.code");
        $college = I("post.college_id");
        $type = I("post.type");
        $department = I("post.department");
        $data['college_id'] = $college;
        $data['department_id'] = $department;
        $data['specialty_id'] = I("post.specialty_id");
        $data['class_id'] = I("post.class_id");
        $data['creator'] = $_SESSION["USER_ID"];
        $data['create_time'] = strtotime(date("Y-m-d", time()));
        $data['update_time'] = time();
        $data['updator'] = $_SESSION["USER_ID"];
        $data['status'] = 1;
        $add_to_table = $stud_collection->data($data)->add();
        if ($add_to_table) { //添加成功后获取数据信息添加到URL路径中
            if ($type == 0) { //新生数据采集
                $path = "/home/stud/freshman";
            } elseif ($type == 1) { //学籍数据采集
                $path = "/home/stud/status";
            } elseif ($type == 2) {
                $path = "/home/stud/graduate";
            }
            $url = "http://" . $_SERVER['SERVER_NAME'] . __ROOT__ . $path . "?" . "xy_id=" . $college . "&" . "yx_id=" . $department . "&" . "zy_id=" . $data['specialty_id'] . "&" . "bj_id=" . $data['class_id'] . "&" . "id=" . $add_to_table;
            $save_url = $stud_collection->where("Id=$add_to_table")->save(array('url' => $url));
            if ($save_url) {
                $stud_collection->commit();
                $this->ajaxReturn(0); //添加数据成功
            } else {
                $stud_collection->rollback();
                $this->ajaxReturn(1); //添加数据失败
            }
        } else {
            $this->ajaxReturn(1); //添加数据失败
        }
    }

    //删除数据信息
    public function manage_delete()
    {
        $stud_collection = M('stud_collection');
        $id = I("id");
        $change_status = $stud_collection->where("id in(" . $id . ")")->save(array('status' => 2));
        if ($change_status) {
            responseToJson(0, "亲，删除成功啦~~~"); //删除数据成功
        } else {
            responseToJson(1, "亲，删除失败啦~~~"); //添加数据失败
        }
    }

    /*数据采集编辑页面显示
     **/
    public function manage_edit_view()
    {
        $stud_collection = M('stud_collection'); //数据信息表
        $id = $_GET['id'];
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院系名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_deparment_name as $item) { //获取系名称
            $get_deparment_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        $find_data = $stud_collection->where("Id=$id")->find();
        $get_data_detail = $stud_collection->where("Id=$id")->select();

        for ($i = 0; $i < count($get_data_detail); $i++) { //对名称进行对应
            if ($get_data_detail[$i]["college_id"] == 0) {
                $get_data_detail[$i]["college_id"] = "全部";
            } else {
                $get_data_detail[$i]["college_id"] = $get_college_data[intval($get_data_detail[$i]["college_id"])];
            }

            if ($get_data_detail[$i]["department_id"] == 0) {
                $get_data_detail[$i]["department_id"] = "全部";
            } else {
                $get_data_detail[$i]["department_id"] = $get_deparment_data[intval($get_data_detail[$i]["department_id"])];
            }

            if ($get_data_detail[$i]["class_id"] == 0) {
                $get_data_detail[$i]["class_id"] = "全部";
            } else {
                $get_data_detail[$i]["class_id"] = $get_class_data[intval($get_data_detail[$i]["class_id"])];
            }

            if ($get_data_detail[$i]["specialty_id"] == 0) {
                $get_data_detail[$i]["specialty_id"] = "全部";
            } else {
                $get_data_detail[$i]["specialty_id"] = $get_specialty_data[intval($get_data_detail[$i]["specialty_id"])];
            }
        }

        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("data_detail", $get_data_detail);
        $this->assign("deparment", $get_deparment_name);
        $this->assign("data", $find_data);
        $this->display();
    }

    //提交编辑页面的内容
    public function manage_edit_save()
    {
        $stud_collection = M('stud_collection');
        $id = I("post.id");
        $getdata_code = I("post.getdata_code");
        $data['name'] = I("post.name");
        $data['code'] = $code = I("post.code");
        $data['college_id'] = I("post.college_id");
        $data['department_id'] = I("post.department_id");
        $data['specialty_id'] = I("post.specialty_id");
        $data['class_id'] = I("post.class_id");
        $data['updator'] = $_SESSION["USER_ID"];
        $data['update_time'] = time();
        if ($getdata_code == 0) { //新生数据采集
            $path = "/home/stud/freshman";
        } elseif ($getdata_code == 1) { //学籍数据采集
            $path = "/home/stud/status";
        } elseif ($getdata_code == 2) { //毕业生数据信息采集
            $path = "/home/stud/graduate";
        }
        $url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . $path . "?" . "xy_id=" . $data['college_id'] . "&" . "yx_id=" . $data['department_id'] . "&" . "zy_id=" . $data['specialty_id'] . "&" . "bj_id=" . $data['class_id'] . "&" . "id=" . $id;
        $data['url'] = $url;
        $save = $stud_collection->where("Id=$id")->data($data)->save();
        if ($save) {
            $this->ajaxReturn(0); //成功返回0
        } else {
            $this->ajaxReturn(1); //失败返回1
        }
    }

    //开启,关闭数据信息
    public function change_status()
    {
        $Id = I("post.id");
        $status = I("post.status");
        $stud_collection = M("stud_collection");
        if ($status == 0) {
            $save_change = $stud_collection->where("Id=$Id")->save(array("status" => 1)); //开启状态
            if ($save_change) {
                responseToJson(0, "亲，开启成功啦~~~"); //删除数据成功
            } else {
                responseToJson(1, "亲，开启失败啦~~~"); //删除数据成功
            }
        } elseif ($status == 1) {
            $save_change = $stud_collection->where("Id=$Id")->save(array("status" => 0)); //关闭状态
            if ($save_change) {
                responseToJson(2, "亲，关闭成功啦~~~"); //删除数据成功
            } else {
                responseToJson(3, "亲，关闭失败啦~~~"); //删除数据成功
            }
        }
    }


    //审核新生信息
    public function freshman_query()
    {
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $stud_collection = M('stud_collection');
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称
        $get_collection_name = $stud_collection->where("status < 2")->select();
        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("collection", $get_collection_name);
        $this->assign("deparment", $get_deparment_name); //添加系别
        $this->display();
    }

    //获取新生数据
    public function get_freshman_data()
    {
        $dict_college = M("dict_college");
        $data_deitl = I("aoData");
        $now_page = $data_deitl['iDisplayStart'];
        $cult_page = $data_deitl['iDisplayLength']; //每页显示多少条数据
        $college = $data_deitl['college_id'];
        $specialty = $data_deitl['specialty_id'];
        $class = $data_deitl['class_id'];
        $status = $data_deitl['status'];
        $collection = $data_deitl['collection_id'];
        $name = trim($data_deitl['student_name']);
        $deparment = $data_deitl['deparment'];
        $aColumns = explode(",", $data_deitl["sColumns"]);
        $iSortCol = $aColumns[intval($data_deitl["iSortCol_0"])];
        $sSortDir = $data_deitl["sSortDir_0"];
        $order = $iSortCol . " " . $sSortDir;
        if (!empty($name)) {
            $map["name"] = array("like", "%" . $name . "%");
        }
        if ($deparment != 0) {
            $map['college_id'] = $deparment;
        } else {
            if ($college != 0) {
                $get_id_arry = $dict_college->field("Id")->where("p_id=$college and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $dat[] = (int)$college;
                $map['college_id'] = array('in', $dat);
            } else {
                $map['college_id'] = array('EGT', 0);
            }
        }

        if ($specialty != 0) {
            $map['specialty_id'] = $specialty;
        } else {
            $map['specialty_id'] = array('EGT', 0);
        }

        if ($class != 0) {
            $map['class_id'] = $class;
        } else {
            $map['class_id'] = array('EGT', 0);
        }

        if ($collection != 0) {
            $map['collection_id'] = $collection;
        } else {
            $map['collection_id'] = array('EGT', 0);
        }
        if ($status == 3) {
            $map['status'] = array('lt', 3);;
        } else {
            $map['status'] = $status;
        }

        $stud_freshman = M("stud_freshman");
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $stud_collection = M('stud_collection');
        $get_class_name = $dict_class->select(); //列出班级的名称
        $get_college_name = $dict_college->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->select(); //列出专业名称
        $get_collection_name = $stud_collection->select();
        $total_number = $stud_freshman->where($map)->select();
        $number = count($total_number);
        $get_freshman_list = $stud_freshman->where($map)->limit($now_page, $cult_page)
            ->order($order)->select();
        if (empty($get_freshman_list)) {
            $get_freshman_list = array();
        }

        $urp_user = M("urp_user");
        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称
        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_collection_name as $item) { //获取用户名称
            $get_collection_data[$item["Id"]] = $item["name"];
        }

        for ($i = 0; $i < count($get_freshman_list); $i++) { //对名称进行对应
            if ($get_freshman_list[$i]["college_id"] == 0) {
                $get_data_list[$i]["college_id"] = "未知";
            } else {
                $get_freshman_list[$i]["college_id"] = $get_college_data[intval($get_freshman_list[$i]["college_id"])];
            }

            if ($get_freshman_list[$i]["class_id"] == 0) {
                $get_freshman_list[$i]["class_id"] = "未知";
            } else {
                $get_freshman_list[$i]["class_id"] = $get_class_data[intval($get_freshman_list[$i]["class_id"])];
            }

            if ($get_freshman_list[$i]["specialty_id"] == 0) {
                $get_freshman_list[$i]["specialty_id"] = "未知";
            } else {
                $get_freshman_list[$i]["specialty_id"] = $get_specialty_data[intval($get_freshman_list[$i]["specialty_id"])];
            }

            if ($get_freshman_list[$i]["sex"] == 0) {
                $get_freshman_list[$i]["sex"] = "未知";
            } elseif ($get_freshman_list[$i]["sex"] == 1) {
                $get_freshman_list[$i]["sex"] = "男";
            } else {
                $get_freshman_list[$i]["sex"] = "女";
            }

            $get_freshman_list[$i]["create_time"] = date("Y-m-d", $get_data_list[$i]['create_time']);
            $get_freshman_list[$i]["collection_id"] = $get_collection_data[intval($get_freshman_list[$i]["collection_id"])];
            $get_freshman_list[$i]["creator"] = $get_user_data[intval($get_freshman_list[$i]["creator"])];
            if ($get_freshman_list[$i]["updator"] == 0) {
                $get_freshman_list[$i]["updator"] = "暂无";
            } else {
                $get_freshman_list[$i]["updator"] = $get_user_data[intval($get_freshman_list[$i]["updator"])];
            }
            if ($get_freshman_list[$i]["update_time"] == 0) {
                $get_freshman_list[$i]["update_time"] = "暂无";
            } else {
                $get_freshman_list[$i]["update_time"] = date("Y-m-d", $get_freshman_list[$i]['update_time']);
            }
        }
        session('freshman_list', $get_freshman_list);
        $this->ajaxReturn(array("aaData" => $get_freshman_list, "iTotalRecords" => $number, "iTotalDisplayRecords" => $number, "sEcho" => intval($data_deitl["sEcho"])));
    }

    public function look_data()
    {
        $stud_freshman = M('stud_freshman');
        $id = I('post.id');
        $dict_class = M("dict_class"); //班级
        $dict_college = M("dict_college"); //院系
        $dict_specialty = M("dict_specialty"); //专业
        $urp_user = M("urp_user");

        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0")->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        $find_data = $stud_freshman->where("Id =$id")->select();

        for ($i = 0; $i < count($find_data); $i++) { //对名称进行对应
            if ($find_data[$i]["sex"] == 0) {
                $find_data[$i]["sex"] = "未知";
            } elseif ($find_data[$i]["sex"] == 1) {
                $find_data[$i]["sex"] = "男";
            } else {
                $find_data[$i]["sex"] = "女";
            }
            $find_data[$i]["photo"] = $find_data[$i]["photo"] != "" ? __ROOT__ . $find_data[$i]["photo"] : __ROOT__ . "/Public/Static/img/default.jpg";
            $find_data[$i]["college_id"] = $get_college_data[intval($find_data[$i]["college_id"])];
            $find_data[$i]["class_id"] = $get_class_data[intval($find_data[$i]["class_id"])];

            $find_data[$i]["specialty_id"] = $get_specialty_data[intval($find_data[$i]["specialty_id"])];
            $find_data[$i]["creator"] = $get_user_data[intval($find_data[$i]["creator"])];
            if ($find_data[$i]["updator"] == 0) {
                $find_data[$i]["updator"] = "暂无";
            } else {
                $find_data[$i]["updator"] = $get_user_data[intval($find_data[$i]["updator"])];
            }

            $find_data[$i]["create_time"] = date("Y-m-d", $find_data[$i]['create_time']);
            if ($find_data[$i]["update_time"] == 0) {
                $find_data[$i]["update_time"] = "暂无";
            } else {
                $find_data[$i]["update_time"] = date("Y-m-d", $find_data[$i]['update_time']);
            }

            if ($find_data[$i]["openid"] == 0) {
                $find_data[$i]["openid"] = "暂无";
            } else {
                $find_data[$i]["openid"] = $find_data[$i]['openid'];
            }
        }
        $this->ajaxReturn($find_data);
    }

    //导出新生数据信息
    public function get_exel()
    {
        $people = session('freshman_list');
        foreach ($people as $k => $info) {
            $list[$k]["name"] = $info['name'];
            $list[$k]["sex"] = $info['sex'];
            $list[$k]["idcard"] = $info['idcard'];
            $list[$k]["wheremidd"] = $info['wheremidd'];
            $list[$k]["ticketnumber"] = $info['ticketnumber'];
            $list[$k]["phone"] = $info['phone'];
            $list[$k]["addr"] = $info['addr'];
            $list[$k]["speciality"] = $info['speciality'];
            $list[$k]["category"] = $info['category'];
            $list[$k]["totalscore"] = $info['totalscore'];
            /* $list[$k]["photo"] = $info['photo'];*/
            $list[$k]["remark"] = $info['remark'];

        }

        foreach ($list as $field => $v) {
            if ($field == 'name') {
                $headArr[] = '姓名';
            }
            if ($field == 'sex') {
                $headArr[] = '性别';
            }

            if ($field == 'idcard') {
                $headArr[] = '身份证号';
            }

            if ($field == 'wheremidd') {
                $headArr[] = '中招考试所在地';
            }

            if ($field == 'ticketnumber') {
                $headArr[] = '准考证号';
            }

            if ($field == 'phone') {
                $headArr[] = '手机号';
            }

            if ($field == 'addr') {
                $headArr[] = '家庭地址';
            }

            if ($field == 'speciality') {
                $headArr[] = '专业名称';
            }

            if ($field == 'category') {
                $headArr[] = '专业类别';
            }

            if ($field == 'totalscore') {
                $headArr[] = '考试总分';
            }

            /*if ($field == 'photo') {
                 $headArr[] = '个人相片';
             }*/

            if ($field == 'remark') {
                $headArr[] = '备注';
            }
        }
        $filename = "";
        To_Exel($filename, $headArr, $list);
    }

    //改变数据的状态
    public function change_fresh_status()
    {
        $stud_freshman = M("stud_freshman");
        $id = I("post.id");
        $status = I("post.status");
        if ($status == 0) { //把未审核状态变为审核状态
            $save_status = $stud_freshman->where("Id=$id")->save(array("status" => 1));
            if ($save_status) {
                responseToJson(0, "亲，已经审核成功了~~~"); //审核数据成功
            } else {
                responseToJson(1, "亲，已经审核失败了~~~"); //审核数据失败
            }
        } elseif ($status == 1) {
            $save_status = $stud_freshman->where("Id=$id")->save(array("status" => 2));
            if ($save_status) {
                responseToJson(2, "亲，已经确定成功了~~~"); //审核数据成功
            } else {
                responseToJson(3, "亲，确定失败了~~~"); //审核数据失败
            }
        }
    }

    //显示学籍详情界面
    public function status_query()
    {
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $stud_collection = M('stud_collection');
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称
        $get_collection_name = $stud_collection->where("status < 2")->select();
        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("collection", $get_collection_name);
        $this->assign("deparment", $get_deparment_name); //添加系别
        $this->display();
    }

    //获取学生的学籍信息
    public function get_status_data()
    {
        $dict_college = M("dict_college");
        $data_deitl = I("aoData");
        $college = $data_deitl['college_id'];
        $specialty = $data_deitl['specialty_id'];
        $class = $data_deitl['class_id'];
        $status = $data_deitl['status'];
        $collection = $data_deitl['collection_id'];
        $name = trim($data_deitl['student_name']);
        $now_page = $data_deitl['iDisplayStart'];
        $cult_page = $data_deitl['iDisplayLength'];
        $deparment = $data_deitl['deparment'];
        $aColumns = explode(",", $data_deitl["sColumns"]);
        $iSortCol = $aColumns[intval($data_deitl["iSortCol_0"])];
        $sSortDir = $data_deitl["sSortDir_0"];
        $order = $iSortCol . " " . $sSortDir;

        if (!empty($name)) {
            $map["name"] = array("like", "%" . $name . "%");
        }

        if ($deparment != 0) {
            $map['college_id'] = $deparment;
        } else {
            if ($college != 0) {
                $get_id_arry = $dict_college->where("p_id=$college and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $dat[] = (int)$college;
                $map['college_id'] = array('in', $dat);
            } else {
                $map['college_id'] = array('EGT', 0);
            }
        }

        if ($specialty != 0) {
            $map['specialty_id'] = $specialty;
        } else {
            $map['specialty_id'] = array('EGT', 0);
        }

        if ($class != 0) {
            $map['class_id'] = $class;
        } else {
            $map['class_id'] = array('EGT', 0);
        }

        if ($collection != 0) {
            $map['collection_id'] = $collection;
        } else {
            $map['collection_id'] = array('EGT', 0);
        }

        if ($status == 3) {
            $map['status'] = array('lt', 3);;
        } else {
            $map['status'] = $status;
        }

        $stud_collection = M("stud_collection");
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $dict_nation = M('dict_nation');
        $stud_status = M('stud_status');
        $dict_source = M('dict_source');
        $get_nation_name = $dict_nation->select(); //列出民族名称
        $get_class_name = $dict_class->select(); //列出班级的名称
        $get_college_name = $dict_college->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->select(); //列出专业名称
        $get_collection_name = $stud_collection->select();
        $get_source_name = $dict_source->select(); //生源

        $total_number = $stud_status->where($map)->select();
        $number = count($total_number);
        $get_status_list = $stud_status->where($map)->limit($now_page, $cult_page)->order($order)->select();
        if (empty($get_status_list)) {
            $get_status_list = array();
        }

        $urp_user = M("urp_user");
        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称


        foreach ($get_source_name as $item) { //获取班级名称
            $get_source_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_nation_name as $item) { //获取民族名称
            $get_nation_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_collection_name as $item) { //获取民族名称
            $get_collection_data[$item["Id"]] = $item["name"];
        }

        for ($i = 0; $i < count($get_status_list); $i++) { //对名称进行对应
            $get_status_list[$i]["nation_id"] = $get_nation_data[intval($get_status_list[$i]["nation_id"])];
            $get_status_list[$i]["source_id"] = $get_source_data[intval($get_status_list[$i]["source_id"])];
            if ($get_status_list[$i]["college_id"] == 0) {
                $get_status_list[$i]["college_id"] = "未知";
            } else {
                $get_status_list[$i]["college_id"] = $get_college_data[intval($get_status_list[$i]["college_id"])];
            }

            if ($get_status_list[$i]["class_id"] == 0) {
                $get_status_list[$i]["class_id"] = "未知";
            } else {
                $get_status_list[$i]["class_id"] = $get_class_data[intval($get_status_list[$i]["class_id"])];
            }

            if ($get_status_list[$i]["specialty_id"] == 0) {
                $get_status_list[$i]["specialty_id"] = "全部";
            } else {
                $get_status_list[$i]["specialty_id"] = $get_specialty_data[intval($get_status_list[$i]["specialty_id"])];
            }
            if ($get_status_list[$i]["sex"] == 0) {
                $get_status_list[$i]["sex"] = "未知";
            } elseif ($get_status_list[$i]["sex"] == 1) {
                $get_status_list[$i]["sex"] = "男";
            } else {
                $get_status_list[$i]["sex"] = "女";
            }
            $get_status_list[$i]["create_time"] = date("Y-m-d", $get_status_list[$i]['create_time']);

            $get_status_list[$i]["collection_id"] = $get_collection_data[intval($get_status_list[$i]["collection_id"])];

            $get_status_list[$i]["creator"] = $get_user_data[intval($get_status_list[$i]["creator"])];
            if ($get_status_list[$i]["updator"] == 0) {
                $get_status_list[$i]["updator"] = "暂无";
            } else {
                $get_status_list[$i]["updator"] = $get_user_data[intval($get_status_list[$i]["updator"])];
            }

            if ($get_status_list[$i]["update_time"] == 0) {
                $get_status_list[$i]["update_time"] = "暂无";
            } else {
                $get_status_list[$i]["update_time"] = date("Y-m-d", $get_status_list[$i]['update_time']);
            }
        }
        session('status', $get_status_list);
        $this->ajaxReturn(array("aaData" => $get_status_list, "iTotalRecords" => $number, "iTotalDisplayRecords" => $number, "sEcho" => intval($data_deitl["sEcho"])));
    }

    //导出学生学籍信息表
    public function get_status_excel()
    {
        $status = session('status');

        foreach ($status as $k => $info) {
            $list[$k]["name"] = $info['name'];
            $list[$k]["sex"] = $info['sex'];
            $list[$k]["pinyin"] = $info['pinyin'];
            $list[$k]["idcard"] = $info['idcard'];
            $list[$k]["wheremidd"] = $info['wheremidd'];
            $list[$k]["ticketnumber"] = $info['ticketnumber'];
            $list[$k]["nation_id"] = $info['nation_id'];
            $list[$k]["phone"] = $info['phone'];
            $list[$k]["birth"] = $info['birth'];
            $list[$k]["class_id"] = $info['class_id'];
            $list[$k]["native"] = $info['native'];
            $list[$k]["domicile"] = $info['domicile'];
            $list[$k]["parent1_name"] = $info['parent1_name'];
            $list[$k]["parent1_idcard"] = $info['parent1_idcard'];
            $list[$k]["parent1_birth"] = $info['parent1_birth'];
            $list[$k]["parent1_rela"] = $info['parent1_rela'];
            if ($info['parent1_guardian'] == 0) {
                $list[$k]["parent1_guardian"] = "否";
            } else {
                $list[$k]["parent1_guardian"] = "是";
            }
            $list[$k]["parent1_phone"] = $info['parent1_phone'];
            $list[$k]["parent2_name"] = $info['parent2_name'];
            $list[$k]["parent2_idcard"] = $info['parent2_idcard'];
            $list[$k]["parent2_birth"] = $info['parent2_birth'];
            $list[$k]["parent2_rela"] = $info['parent2_rela'];
            if ($info['parent2_guardian'] == 0) {
                $list[$k]["parent2_guardian"] = "否";
            } else {
                $list[$k]["parent2_guardian"] = "是";
            }
            $list[$k]["parent2_phone"] = $info['parent2_phone'];

            if ($info['accounttype'] == 0) {
                $list[$k]["accounttype"] = "农业户口";
            } elseif ($info['accounttype'] == 1) {
                $list[$k]["accounttype"] = "非农业户口";
            } else {
                $list[$k]["accounttype"] = "集体户口";
            }

            if ($info['allowances'] == 0) {
                $list[$k]["allowances"] = "否";
            } else {
                $list[$k]["allowances"] = "是";
            }
            $list[$k]["homecode"] = $info['homecode'];
            $list[$k]["homeaddr"] = $info['homeaddr'];
            $list[$k]["homepolice"] = $info['homepolice'];
            $list[$k]["source_id"] = $info['source_id'];

            if ($info['polity'] == 0) {
                $list[$k]["polity"] = "团员";
            } elseif ($info['polity'] == 1) {
                $list[$k]["polity"] = "党员";
            } else {
                $list[$k]["polity"] = "群众";
            }

            $list[$k]["grades"] = $info['grades'];

            $list[$k]["qq"] = $info['qq'];
            $list[$k]["email"] = $info['email'];
        }

        foreach ($list as $field => $v) {
            if ($field == 'name') {
                $headArr[] = '姓名';
            }
            if ($field == 'sex') {
                $headArr[] = '性别';
            }

            if ($field == 'pinyin') {
                $headArr[] = '姓名拼音';
            }

            if ($field == 'idcard') {
                $headArr[] = '身份证号';
            }

            if ($field == 'wheremidd') {
                $headArr[] = '中招考试所在地';
            }

            if ($field == 'ticketnumber') {
                $headArr[] = '准考证号';
            }

            if ($field == 'nation_id') {
                $headArr[] = '民族';
            }

            if ($field == 'phone') {
                $headArr[] = '电话';
            }

            if ($field == 'birth') {
                $headArr[] = '出生日期';
            }

            if ($field == 'class') {
                $headArr[] = '班级';
            }

            if ($field == 'native') {
                $headArr[] = '户籍所在地';
            }

            if ($field == 'domicile') {
                $headArr[] = '户籍所在详细地址';
            }

            if ($field == 'parent1_name') {
                $headArr[] = '家长1姓名';
            }

            if ($field == 'parent1_idcard') {
                $headArr[] = '家长1身份证号码';
            }

            if ($field == 'parent1_birth') {
                $headArr[] = '家长1出生年月';
            }

            if ($field == 'parent1_rela') {
                $headArr[] = '家长1关系';
            }


            if ($field == 'parent1_guardian') {
                $headArr[] = '家长1是否监护人';
            }

            if ($field == 'parent1_phone') {
                $headArr[] = '家长1电话';
            }


            if ($field == 'parent2_name') {
                $headArr[] = '家长2姓名';
            }

            if ($field == 'parent2_idcard') {
                $headArr[] = '家长2身份证号码';
            }

            if ($field == 'parent2_birth') {
                $headArr[] = '家长2出生年月';
            }

            if ($field == 'parent2_rela') {
                $headArr[] = '家长2关系';
            }

            if ($field == 'parent2_guardian') {
                $headArr[] = '家长2是否监护人';
            }

            if ($field == 'parent2_phone') {
                $headArr[] = '家长2电话';
            }


            if ($field == 'accounttype') {
                $headArr[] = '户口类型';
            }

            if ($field == 'allowances') {
                $headArr[] = '是否低保';
            }

            if ($field == 'homecode') {
                $headArr[] = '家庭邮编';
            }

            if ($field == 'homeaddr') {
                $headArr[] = '家庭住址';
            }

            if ($field == 'homepolice') {
                $headArr[] = '家庭所属派出所';
            }

            if ($field == 'source_id') {
                $headArr[] = '学生来源';
            }

            if ($field == 'polity') {
                $headArr[] = '政治面貌';
            }

            if ($field == 'grades') {
                $headArr[] = '中考成绩';
            }

            if ($field == 'qq') {
                $headArr[] = 'QQ';
            }


            if ($field == 'email') {
                $headArr[] = '邮箱';
            }
        }
        $filename = "";
        To_Exel($filename, $headArr, $list);
    }

    //改变学籍状态
    public function change_statu_status()
    {
        $stud_status = M("stud_status");
        $id = I("post.id");
        $status = I("post.status");
        if ($status == 0) { //把未审核状态变为审核状态
            $save_status = $stud_status->where("Id=$id")->save(array("status" => 1));
            if ($save_status) {
                responseToJson(0, "亲，已经审核成功了~~~"); //审核数据成功
            } else {
                responseToJson(1, "亲，已经审核失败了~~~"); //审核数据失败
            }
        } elseif ($status == 1) {
            $save_status = $stud_status->where("Id=$id")->save(array("status" => 2));
            if ($save_status) {
                responseToJson(2, "亲，已经确定成功了~~~"); //审核数据成功
            } else {
                responseToJson(3, "亲，确定失败了~~~"); //审核数据失败
            }
        }
    }

    //查看学生学籍详情
    public function look_status_data()
    {
        $stud_status = M('stud_status');
        $id = I('post.id');
        $dict_class = M("dict_class"); //班级
        $dict_college = M("dict_college"); //院系
        $dict_specialty = M("dict_specialty"); //专业
        $urp_user = M("urp_user");
        $dict_nation = M('dict_nation');
        $dict_source = M('dict_source');
        $get_nation_name = $dict_nation->select(); //列出民族名称
        $get_user_name = $urp_user->select(); //列出用户名称
        $get_class_name = $dict_class->select(); //列出班级的名称
        $get_college_name = $dict_college->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->select(); //列出专业名称
        $get_source_name = $dict_source->select();

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_source_name as $item) { //获取班级名称
            $get_source_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_nation_name as $item) { //获取民族名称
            $get_nation_data[$item["Id"]] = $item["name"];
        }

        $find_data = $stud_status->where("Id =$id")->select();

        for ($i = 0; $i < count($find_data); $i++) { //对名称进行对应
            $find_data[$i]["photo"] = $find_data[$i]["photo"] != "" ? __ROOT__ . $find_data[$i]["photo"] : __ROOT__ . "/Public/Static/img/default.jpg";
            $find_data[$i]["nation_id"] = $get_nation_data[intval($find_data[$i]["nation_id"])];
            $find_data[$i]["source_id"] = $get_source_data[intval($find_data[$i]["source_id"])];
            if ($find_data[$i]["sex"] == 0) {
                $find_data[$i]["sex"] = "未知";
            } elseif ($find_data[$i]["sex"] == 1) {
                $find_data[$i]["sex"] = "男";
            } else {
                $find_data[$i]["sex"] = "女";
            }
            $find_data[$i]["college_id"] = $get_college_data[intval($find_data[$i]["college_id"])];
            $find_data[$i]["class_id"] = $get_class_data[intval($find_data[$i]["class_id"])];


            $find_data[$i]["specialty_id"] = $get_specialty_data[intval($find_data[$i]["specialty_id"])];
            $find_data[$i]["creator"] = $get_user_data[intval($find_data[$i]["creator"])];
            if ($find_data[$i]["updator"] == 0) {
                $find_data[$i]["updator"] = "暂无";
            } else {
                $find_data[$i]["updator"] = $get_user_data[intval($find_data[$i]["updator"])];
            }

            if ($find_data[$i]["parent1_guardian"] == 0) {
                $find_data[$i]["parent1_guardian"] = "否";
            } else {
                $find_data[$i]["parent1_guardian"] = "是";
            }

            if ($find_data[$i]["parent2_guardian"] == 0) {
                $find_data[$i]["parent2_guardian"] = "否";
            } else {
                $find_data[$i]["parent2_guardian"] = "是";
            }

            if ($find_data[$i]["allowances"] == 0) {
                $find_data[$i]["allowances"] = "否";
            } else {
                $find_data[$i]["allowances"] = "是";
            }

            if ($find_data[$i]["accounttype"] == 0) {
                $find_data[$i]["accounttype"] = "农业户口";
            } elseif ($find_data[$i]["accounttype"] == 1) {
                $find_data[$i]["accounttype"] = "非农业户口";
            } else {
                $find_data[$i]["accounttype"] = "集体户口";
            }

            if ($find_data[$i]["polity"] == 0) {
                $find_data[$i]["polity"] = "团员";
            } elseif ($find_data[$i]["polity"] == 1) {
                $find_data[$i]["polity"] = "党员";
            } else {
                $find_data[$i]["polity"] = "群众";
            }

            $find_data[$i]["create_time"] = date("Y-m-d", $find_data[$i]['create_time']);
            $find_data[$i]["birth"] = $find_data[$i]['birth'];
            $find_data[$i]["parent1_birth"] = $find_data[$i]['parent1_birth'];
            $find_data[$i]["parent2_birth"] = $find_data[$i]['parent2_birth'];
            if ($find_data[$i]["update_time"] == 0) {
                $find_data[$i]["update_time"] = "暂无";
            } else {
                $find_data[$i]["update_time"] = date("Y-m-d", $find_data[$i]['update_time']);
            }

            if ($find_data[$i]["openid"] == 0) {
                $find_data[$i]["openid"] = "暂无";
            } else {
                $find_data[$i]["openid"] = $find_data[$i]['openid'];
            }
        }
        $this->ajaxReturn($find_data);
    }

    //显示毕业生信息界面
    public function graduation_query()
    {
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $stud_collection = M('stud_collection');
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0 and type=0")->select(); //列出院名称
        $get_deparment_name = $dict_college->where("status=0 and type=1")->select(); //列出系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称
        $get_collection_name = $stud_collection->where("status < 2")->select();
        $this->assign("class", $get_class_name);
        $this->assign("college", $get_college_name);
        $this->assign("specialty", $get_specialty_name);
        $this->assign("collection", $get_collection_name);
        $this->assign("deparment", $get_deparment_name); //添加系别
        $this->display();
    }

    //获取毕业生数据
    public function get_graduation_data()
    {
        $dict_college = M("dict_college");
        $data_deitl = I("aoData");
        $now_page = $data_deitl['iDisplayStart'];
        $cult_page = $data_deitl['iDisplayLength'];
        $college = $data_deitl['college_id'];
        $specialty = $data_deitl['specialty_id'];
        $class = $data_deitl['class_id'];
        $status = $data_deitl['status'];
        $collection = $data_deitl['collection_id'];
        $name = trim($data_deitl['student_name']);
        $deparment = $data_deitl['deparment'];
        $aColumns = explode(",", $data_deitl["sColumns"]);
        $iSortCol = $aColumns[intval($data_deitl["iSortCol_0"])];
        $sSortDir = $data_deitl["sSortDir_0"];
        $order = $iSortCol . " " . $sSortDir;

        if (!empty($name)) {
            $map["name"] = array("like", "%" . $name . "%");
        }

        if ($deparment != 0) {
            $map['college_id'] = $deparment;
        } else {
            if ($college != 0) {
                $get_id_arry = $dict_college->where("p_id=$college and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $dat[] = (int)$college;
                $map['college_id'] = array('in', $dat);
            } else {
                $map['college_id'] = array('EGT', 0);
            }
        }

        if ($specialty != 0) {
            $map['specialty_id'] = $specialty;
        } else {
            $map['specialty_id'] = array('EGT', 0);
        }

        if ($class != 0) {
            $map['class_id'] = $class;
        } else {
            $map['class_id'] = array('EGT', 0);
        }

        if ($collection != 0) {
            $map['collection_id'] = $collection;
        } else {
            $map['collection_id'] = array('EGT', 0);
        }

        if ($status == 3) {
            $map['status'] = array('lt', 3);;
        } else {
            $map['status'] = $status;
        }

        $stud_graduation = M("stud_graduation");
        $dict_college = M('dict_college'); //适用院系
        $dict_specialty = M('dict_specialty'); //适用专业
        $dict_class = M('dict_class'); //适用班级
        $dict_nation = M('dict_nation');
        $stud_collection = M('stud_collection');
        $get_nation_name = $dict_nation->select(); //列出民族名称
        $get_class_name = $dict_class->select(); //列出班级的名称
        $get_college_name = $dict_college->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->select(); //列出专业名称
        $get_collection_name = $stud_collection->select();
        $total_number = $stud_graduation->where($map)->select();
        $number = count($total_number);
        $get_graduation_list = $stud_graduation->where($map)->limit($now_page, $cult_page)->order($order)->select();
        if (empty($get_graduation_list)) {
            $get_graduation_list = array();
        }

        $urp_user = M("urp_user");
        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_nation_name as $item) { //获取民族名称
            $get_nation_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_collection_name as $item) { //获取民族名称
            $get_collection_data[$item["Id"]] = $item["name"];
        }

        for ($i = 0; $i < count($get_graduation_list); $i++) { //对名称进行对应

            $get_graduation_list[$i]["nation"] = $get_nation_data[intval($get_graduation_list[$i]["nation"])];

            if ($get_graduation_list[$i]["college_id"] == 0) {
                $get_graduation_list[$i]["college_id"] = "未知";
            } else {
                $get_graduation_list[$i]["college_id"] = $get_college_data[intval($get_graduation_list[$i]["college_id"])];
            }

            if ($get_graduation_list[$i]["class_id"] == 0) {
                $get_graduation_list[$i]["class_id"] = "未知";
            } else {
                $get_graduation_list[$i]["class_id"] = $get_class_data[intval($get_graduation_list[$i]["class_id"])];
            }

            if ($get_graduation_list[$i]["specialty_id"] == 0) {
                $get_graduation_list[$i]["specialty_id"] = "全部";
            } else {
                $get_graduation_list[$i]["specialty_id"] = $get_specialty_data[intval($get_graduation_list[$i]["specialty_id"])];
            }
            if ($get_graduation_list[$i]["sex"] == 0) {
                $get_graduation_list[$i]["sex"] = "未知";
            } elseif ($get_graduation_list[$i]["sex"] == 1) {
                $get_graduation_list[$i]["sex"] = "男";
            } else {
                $get_graduation_list[$i]["sex"] = "女";
            }
            $get_graduation_list[$i]["create_time"] = date("Y-m-d", $get_graduation_list[$i]['create_time']);

            $get_graduation_list[$i]["collection_id"] = $get_collection_data[intval($get_graduation_list[$i]["collection_id"])];

            $get_graduation_list[$i]["creator"] = $get_user_data[intval($get_graduation_list[$i]["creator"])];
            if ($get_graduation_list[$i]["updator"] == 0) {
                $get_graduation_list[$i]["updator"] = "暂无";
            } else {
                $get_graduation_list[$i]["updator"] = $get_user_data[intval($get_graduation_list[$i]["updator"])];
            }

            if ($get_graduation_list[$i]["update_time"] == 0) {
                $get_graduation_list[$i]["update_time"] = "暂无";
            } else {
                $get_graduation_list[$i]["update_time"] = date("Y-m-d", $get_graduation_list[$i]['update_time']);
            }
        }
        session('graduation', $get_graduation_list);
        $this->ajaxReturn(array("aaData" => $get_graduation_list, "iTotalRecords" => $number, "iTotalDisplayRecords" => $number, "sEcho" => intval($data_deitl["sEcho"])));
    }

    //导出毕业生信息
    public function get_groduction_exel()
    {
        $people = session('graduation');
        foreach ($people as $k => $info) {
            $list[$k]["name"] = $info['name'];
            $list[$k]["sex"] = $info['sex'];
            $list[$k]["idcard"] = $info['idcard'];
            $list[$k]["company"] = $info['company'];
            $list[$k]["companycode"] = $info['companycode'];
            $list[$k]["addr"] = $info['addr'];
            $list[$k]["postcode"] = $info['postcode'];
            $list[$k]["contacts"] = $info['contacts'];
            $list[$k]["contactphone"] = $info['contactphone'];
            $list[$k]["phone"] = $info['phone'];
            $list[$k]["addrnow"] = $info['addrnow'];
            $list[$k]["email"] = $info['email'];
            $list[$k]["qq"] = $info['qq'];
            $list[$k]["speciality"] = $info['speciality'];
            $list[$k]["nation"] = $info['nation'];
            $list[$k]["homeaddr"] = $info['homeaddr'];


        }

        foreach ($list as $field => $v) {
            if ($field == 'name') {
                $headArr[] = '姓名';
            }
            if ($field == 'sex') {
                $headArr[] = '性别';
            }

            if ($field == 'idcard') {
                $headArr[] = '身份证号';
            }

            if ($field == 'company') {
                $headArr[] = '单位名称';
            }

            if ($field == 'companycode') {
                $headArr[] = '单位组织机构代码';
            }

            if ($field == 'addr') {
                $headArr[] = '单位地址';
            }

            if ($field == 'postcode') {
                $headArr[] = '单位邮编';
            }

            if ($field == 'contacts') {
                $headArr[] = '单位联系人';
            }

            if ($field == 'contactphone') {
                $headArr[] = '单位电话';
            }

            if ($field == 'phone') {
                $headArr[] = '毕业生联系电话';
            }


            if ($field == 'addrnow') {
                $headArr[] = '单位实际所在地';
            }

            if ($field == 'email') {
                $headArr[] = '毕业生邮箱';
            }

            if ($field == 'qq') {
                $headArr[] = '毕业生QQ';
            }

            if ($field == 'speciality') {
                $headArr[] = '专业';
            }

            if ($field == 'nation') {
                $headArr[] = '民族';
            }

            if ($field == 'homeaddr') {
                $headArr[] = '家庭地址';
            }
        }
        $filename = "";
        To_Exel($filename, $headArr, $list);
    }

    //对毕业生信息进行审核
    public function change_graduation_status()
    {
        $stud_graduation = M("stud_graduation");
        $id = I("post.id");
        $status = I("post.status");
        if ($status == 0) { //把未审核状态变为审核状态
            $save_status = $stud_graduation->where("Id=$id")->save(array("status" => 1));
            if ($save_status) {
                responseToJson(0, "亲，已经审核成功了~~~"); //审核数据成功
            } else {
                responseToJson(1, "亲，已经审核失败了~~~"); //审核数据失败
            }
        } elseif ($status == 1) {
            $save_status = $stud_graduation->where("Id=$id")->save(array("status" => 2));
            if ($save_status) {
                responseToJson(2, "亲，已经确定成功了~~~"); //审核数据成功
            } else {
                responseToJson(3, "亲，确定失败了~~~"); //审核数据失败
            }
        }
    }

    //查看毕业生详情
    public function look_graduate_data()
    {
        $stud_graduation = M('stud_graduation');
        $id = I('post.id');
        $dict_class = M("dict_class"); //班级
        $dict_college = M("dict_college"); //院系
        $dict_specialty = M("dict_specialty"); //专业
        $urp_user = M("urp_user");
        $dict_nation = M("dict_nation");

        $get_user_name = $urp_user->where("status=0")->select(); //列出用户名称
        $get_class_name = $dict_class->where("status=0")->select(); //列出班级的名称
        $get_college_name = $dict_college->where("status=0")->select(); //列出院系名称
        $get_specialty_name = $dict_specialty->where("status=0")->select(); //列出专业名称

        $get_nation_name = $dict_nation->where("status=0")->select(); //列出专业名称

        foreach ($get_class_name as $item) { //获取班级名称
            $get_class_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_nation_name as $item) { //获取班级名称
            $get_nation_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_college_name as $item) { //获取院系名称
            $get_college_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_specialty_name as $item) { //获取院系名称
            $get_specialty_data[$item["Id"]] = $item["name"];
        }

        foreach ($get_user_name as $item) { //获取用户名称
            $get_user_data[$item["Id"]] = $item["name"];
        }

        $find_data = $stud_graduation->where("Id =$id")->select();

        for ($i = 0; $i < count($find_data); $i++) { //对名称进行对应
            if ($find_data[$i]["sex"] == 0) {
                $find_data[$i]["sex"] = "未知";
            } elseif ($find_data[$i]["sex"] == 1) {
                $find_data[$i]["sex"] = "男";
            } else {
                $find_data[$i]["sex"] = "女";
            }
            $find_data[$i]["college_id"] = $get_college_data[intval($find_data[$i]["college_id"])];
            $find_data[$i]["class_id"] = $get_class_data[intval($find_data[$i]["class_id"])];
            $find_data[$i]["nation"] = $get_nation_data[intval($find_data[$i]["nation"])];
            $find_data[$i]["specialty_id"] = $get_specialty_data[intval($find_data[$i]["specialty_id"])];
            $find_data[$i]["creator"] = $get_user_data[intval($find_data[$i]["creator"])];
            if ($find_data[$i]["updator"] == 0) {
                $find_data[$i]["updator"] = "暂无";
            } else {
                $find_data[$i]["updator"] = $get_user_data[intval($find_data[$i]["updator"])];
            }

            $find_data[$i]["create_time"] = date("Y-m-d", $find_data[$i]['create_time']);
            if ($find_data[$i]["update_time"] == 0) {
                $find_data[$i]["update_time"] = "暂无";
            } else {
                $find_data[$i]["update_time"] = date("Y-m-d", $find_data[$i]['update_time']);
            }

            if ($find_data[$i]["openid"] == 0) {
                $find_data[$i]["openid"] = "暂无";
            } else {
                $find_data[$i]["openid"] = $find_data[$i]['openid'];
            }
        }
        $this->ajaxReturn($find_data);
    }

    //新生信息统计界面
    public function freshman_summary()
    {
        $start_time = date("Y-m-d", time() - 2592000);
        $end_time = date("Y-m-d", time());
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->display();
    }

    //获取新生统计信息界面
    public function freshman_data()
    { //获取所有
        $dict_college = M('dict_college'); //院系，专业，班级
        $dict_specialty = M('dict_specialty'); //专业
        $dict_class = M('dict_class'); //班级
        $stud_freshman = M('stud_freshman');
        $start_time = strtotime(I('post.start_time')); //开始时间
        if (empty($start_time)) { //起始时间为空的情况下
            $start_time = strtotime(date("Y-m-d", time() - 2592000));
        }

        $end_time = strtotime(I('post.end_time')) + 86400; //终止时间
        if (empty($end_time)) { //终止时间为空的情况下
            $end_time = time();
        }
        $type = I('post.type');
        $data = array();
        if ($type == 0) { //学院
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type=0')->select();
            $get_status_number = $stud_freshman->field('Id,status,college_id')->where("create_time >= $start_time and create_time <= $end_time")->select(); //查出所有数据
            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $dat = [];
                $id = (int)$get_college_id[$j]['Id'];
                $get_id_arry = $dict_college->where("p_id=$id and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $map['college_id'] = array('in', $dat);
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_freshman->where("status=0")->where($map)->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_freshman->where("status=1")->where($map)->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_freshman->where("status=2")->where($map)->count(); //已确定的总数
                }
            }
        } elseif ($type == 1) { //系别
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type = 1')->select();
            $get_status_number = $stud_freshman->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $id = (int)$get_college_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_freshman->where("status=0 and college_id=$id")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_freshman->where("status=1 and college_id=$id")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_freshman->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        } elseif ($type == 2) { //专业
            $get_specialty_id = $dict_specialty->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_freshman->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_specialty_id); $i++) {
                $data[$i]['name'] = $get_specialty_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_specialty_id); $j++) {
                $id = (int)$get_specialty_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_freshman->where("status=0 and college_id=$id")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_freshman->where("status=1 and college_id=$id")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_freshman->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        } else { //班级
            $get_class_id = $dict_class->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_freshman->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_class_id); $i++) {
                $data[$i]['name'] = $get_class_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_class_id); $j++) {
                $id = (int)$get_class_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_freshman->where("status=0 and college_id=$id")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_freshman->where("status=1 and college_id=$id")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_freshman->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        }

        $this->ajaxReturn($data);
    }

    //显示学籍信息统计界面
    public function status_summary()
    {
        $start_time = date("Y-m-d", time() - 2592000);
        $end_time = date("Y-m-d", time());
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->display();
    }

    //获取学籍信息图表数据
    public function status_data()
    {
        $dict_college = M('dict_college'); //院系，专业，班级
        $dict_specialty = M('dict_specialty'); //专业
        $dict_class = M('dict_class'); //班级
        $stud_status = M('stud_status');

        $start_time = strtotime(I('post.start_time')); //开始时间
        if (empty($start_time)) { //起始时间为空的情况下
            $start_time = strtotime(date("Y-m-d", time() - 2592000));
        }

        $end_time = strtotime(I('post.end_time')) + 86400; //终止时间加一天
        if (empty($end_time)) { //终止时间为空的情况下
            $end_time = time();
        }

        $type = I('post.type');
        $data = array();
        if ($type == 0) { //学院
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type = 0')->select();
            $get_status_number = $stud_status->where("create_time >= $start_time and create_time <= $end_time")->select();
            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $dat = []; //循环每次清空一下数组
                $id = (int)$get_college_id[$j]['Id'];
                $get_id_arry = $dict_college->where("p_id=$id and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $map['college_id'] = array('in', $dat);
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_status->where("status=0 ")->where($map)->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_status->where("status=1")->where($map)->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_status->where("status=2")->where($map)->count(); //已确定的总数
                }
            }

        } elseif ($type == 1) { //系别
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type = 1')->select();
            $get_status_number = $stud_status->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $id = (int)$get_college_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_status->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_status->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_status->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        } elseif ($type == 2) { //专业
            $get_specialty_id = $dict_specialty->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_status->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_specialty_id); $i++) {
                $data[$i]['name'] = $get_specialty_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_specialty_id); $j++) {
                $id = (int)$get_specialty_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_status->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_status->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_status->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        } else { //班级
            $get_class_id = $dict_class->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_status->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_class_id); $i++) {
                $data[$i]['name'] = $get_class_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_class_id); $j++) {
                $id = (int)$get_class_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_status->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_status->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_status->where("status=2 and college_id=$id ")->count(); //已确定的总数
                }
            }
        }
        $this->ajaxReturn($data);
    }

    //显示毕业生信息统计界面
    public function graduation_summary()
    {
        $start_time = date("Y-m-d", time() - 2592000);
        $end_time = date("Y-m-d", time());
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->display();
    }

    //获取毕业生图表中的数据
    public function graduation_data()
    {
        $dict_college = M('dict_college'); //院系，专业，班级
        $dict_specialty = M('dict_specialty'); //专业
        $dict_class = M('dict_class'); //班级
        $stud_graduation = M('stud_graduation'); //毕业生数据信息显示

        $start_time = strtotime(I('post.start_time')); //开始时间
        if (empty($start_time)) { //起始时间为空的情况下
            $start_time = strtotime(date("Y-m-d", time() - 2592000));
        }

        $end_time = strtotime(I('post.end_time')) + 86400; //终止时间
        if (empty($end_time)) { //终止时间为空的情况下
            $end_time = time();
        }

        $type = I('post.type');
        $data = array();
        if ($type == 0) { //学院
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type = 0')->select();
            $get_status_number = $stud_graduation->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $dat = [];
                $id = (int)$get_college_id[$j]['Id'];
                $get_id_arry = $dict_college->where("p_id=$id and status=0")->select();
                foreach ($get_id_arry as $item) { //获取院系名称
                    $dat[] = (int)$item["Id"];
                }
                $map['college_id'] = array('in', $dat);
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_graduation->where("status=0 ")->where($map)->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_graduation->where("status=1 ")->where($map)->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_graduation->where("status=2 ")->where($map)->count(); //已确定的总数
                }
            }

        } elseif ($type == 1) { //系别
            $get_college_id = $dict_college->field('Id,name')->where('status=0 and type = 1')->select();
            $get_status_number = $stud_graduation->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_college_id); $i++) {
                $data[$i]['name'] = $get_college_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_college_id); $j++) {
                $id = (int)$get_college_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_graduation->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_graduation->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_graduation->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        } elseif ($type == 2) { //专业
            $get_specialty_id = $dict_specialty->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_graduation->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_specialty_id); $i++) {
                $data[$i]['name'] = $get_specialty_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_specialty_id); $j++) {
                $id = (int)$get_specialty_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_graduation->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_graduation->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_graduation->where("status=2 and college_id=$id ")->count(); //已确定的总数
                }
            }
        } else { //班级
            $get_class_id = $dict_class->field('Id,name')->where('status=0')->select();
            $get_status_number = $stud_graduation->where("create_time >= $start_time and create_time <= $end_time")->select();

            for ($i = 0; $i < count($get_class_id); $i++) {
                $data[$i]['name'] = $get_class_id[$i]['name'];
            }

            for ($j = 0; $j < count($get_class_id); $j++) {
                $id = (int)$get_class_id[$j]['Id'];
                for ($i = 0; $i < count($get_status_number); $i++) {
                    $data[$j]['un_status'] = $stud_graduation->where("status=0 and college_id=$id ")->count(); //未审核的总数
                    $data[$j]['do_status'] = $stud_graduation->where("status=1 and college_id=$id ")->count(); //已审核的总数
                    $data[$j]['suer_status'] = $stud_graduation->where("status=2 and college_id=$id")->count(); //已确定的总数
                }
            }
        }
        $this->ajaxReturn($data);
    }

}
