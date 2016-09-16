<?php
namespace Home\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Think\Controller;


class StudController extends BaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->bind(intval(I("xy_id")), intval(I("yx_id")), intval(I("zy_id")), intval(I("bj_id")));
    }

    private function bind($xy_id, $yx_id, $zy_id, $bj_id)
    {
        $where_xy["status"] = 0;
        $where_xy["type"] = 0;
        if ($xy_id != 0) {
            $where_xy["Id"] = $xy_id;
            $where_yx["p_id"] = $xy_id;
        }
        $dict_xy = M("dict_college")->field("Id,name,p_id as pid")->where($where_xy)->select();

        $where_yx["status"] = 0;
        $where_yx["type"] = 1;
        if ($yx_id != 0) {
            $where_yx["Id"] = $yx_id;
            $where_zy["college_id"] = $yx_id;
        }
        $dict_yx = M("dict_college")->field("Id,name,p_id as pid")->where($where_yx)->select();

        $where_zy["status"] = 0;
        if ($zy_id != 0) {
            $where_zy["Id"] = $zy_id;
            $where_bj["specialty_id"] = $zy_id;
        }
        $dict_zy = M("dict_specialty")->field("Id,name,college_id as pid")->where($where_zy)->select();

        $where_bj["status"] = 0;
        if ($bj_id != 0) {
            $where_bj["Id"] = $bj_id;
        }
        $dict_bj = M("dict_class")->field("Id,name,specialty_id as pid")->where($where_bj)->select();
        $this->assign("dict_xy", $dict_xy);
        $this->assign("dict_yx", $dict_yx);
        $this->assign("dict_zy", $dict_zy);
        $this->assign("dict_bj", $dict_bj);
    }

    public function index()
    {
        $this->display();
    }

    /*
     * 新生信息添加@liuwanqiu
     */
    public function freshman($st = 0)
    {
        $specialty = M('dict_specialty');
        $collection_id = I('id');
        //$collection_id = 1;
        $wh['openid'] = session('weChat_user')['openid'];
        $wh['collection_id'] = $collection_id;
        $fr_rs = M('stud_freshman')
            ->where($wh)
            ->find();
        if ($fr_rs == null) {
            $stud = M("stud_student")->where(array("openid" => $wh['openid']))->find();
            $fr_rs["Id"] = "0";
            $fr_rs["name"] = $stud["name"];
            $fr_rs["sex"] = $stud["sex"];
            $fr_rs["idcard"] = $stud["idcard"];
            $fr_rs["wheremidd"] = "";
            $fr_rs["ticketnumber"] = "";
            $fr_rs["phone"] = $stud["phone"];
            $fr_rs["addr"] = $stud["native"];
            $fr_rs["speciality"] = "0";
            $fr_rs["category"] = "0";
            $fr_rs["totalscore"] = "";
            $fr_rs["photo"] = $stud["photo"];
            $fr_rs["remark"] = "";
            $fr_rs["status"] = "3";
            $baseInfo["xy"] = "";
            $baseInfo["yx"] = "";
            $baseInfo["zy"] = "";
            $baseInfo["bj"] = "";
            $baseInfoId["xy"] = I("xy_id");
            $baseInfoId["yx"] = I("yx_id");
            $baseInfoId["zy"] = I("zy_id");
            $baseInfoId["bj"] = I("bj_id");
        } else {
            $dict_class = M("dict_class")->field("Id,name")->where(array("Id" => $fr_rs["class_id"]))->find();
            $dict_specialty = M("dict_specialty")->field("Id,name")->where(array("Id" => $fr_rs["specialty_id"]))->find();
            $dict_college = M("dict_college")->field("Id,name,p_id")->where(array("Id" => $fr_rs["college_id"]))->find();
            $dict_college_yx = M("dict_college")->field("Id,name")->where(array("Id" => $dict_college["p_id"]))->find();

            $baseInfo["xy"] = $dict_college_yx["name"];
            $baseInfoId["xy"] = $dict_college_yx["Id"];
            $baseInfo["yx"] = $dict_college["name"];
            $baseInfoId["yx"] = $dict_college["Id"];
            $baseInfo["zy"] = $dict_specialty["name"];
            $baseInfoId["zy"] = $dict_specialty["Id"];
            $baseInfo["bj"] = $dict_class["name"];
            $baseInfoId["bj"] = $dict_class["Id"];
        }
        $where["status"] = 0;
        if (intval(I("yx_id")) != 0) {
            $where["college_id"] = I("yx_id");
        }
        $specialty_rs = $specialty->field('Id,name')->where($where)->select();
        $this->assign('specialty_rs', $specialty_rs);
        $category = C('OfferCfg')["category"];
        $this->assign('category', $category);
        $this->assign('fresh', $fr_rs);
        $this->assign('baseInfoId', $baseInfoId);
        $this->assign('baseInfo', $baseInfo);
        $this->assign('st', $st);
        $this->assign('collection_id', $collection_id);
        $this->display();
    }

    /*
     * 新生信息保存@liuwanqiu
     */
    public function freshman_save()
    {
        $id = I('id'); //当前记录的id
        $collection_id = I('collection_id');

        $fh = I('get.fh', 0); //得到修改记录的id
        $name = trim(I('name'));
        $sex = I('sex');
        $idcard = trim(I('idcard'));

        $wheremidd = trim(I('wheremidd'));
        $ticketnumber = trim(I('ticketnumber'));
        $phone = trim(I('phone'));
        $addr = trim(I('addr'));
        $remark = I('remark');
        $speciality = I('speciality');
        $category = I('category');
        $totalscore = trim(I('totalscore'));
        if ($_POST['img_status'] != '') {
            if (!empty($_FILES['dropify']['tmp_name'])) {
                $upload = new \Think\Upload(); // 实例化上传类
                $upload->upload();
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
                $uploaddir = DOC_ROOT . '/Public/Upload/avatar/'; //设置文件保存目录
                $upload->rootPath = $uploaddir; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {
                    $this->ajaxReturn(array(false, '信息添加失败'));
                } else {
                    foreach ($info as $file) {
                        $photo = '/Public/Upload/avatar/' . $file['savepath'] . $file['savename'];
                    }
                }
                $fr_add['photo'] = $photo;
            }
        } else {
            $fr_add['photo'] = '';
        }
        $fr_add['name'] = $name;
        $fr_add['sex'] = $sex;
        $fr_add['idcard'] = $idcard;
        $fr_add['wheremidd'] = $wheremidd;
        $fr_add['ticketnumber'] = $ticketnumber;
        $fr_add['phone'] = $phone;
        $fr_add['addr'] = $addr;
        $fr_add['speciality'] = $speciality;
        $fr_add['category'] = $category;
        $fr_add['totalscore'] = $totalscore;

        $fr_add['remark'] = $remark;
        $time = time();
        $fr_add['update_time'] = $time;
        $fr_add['updator'] = session('weChat_user')['id'];
        $fr_add['collection_id'] = $collection_id;
        $fr_add['college_id'] = I('college_id');
        $fr_add['specialty_id'] = I('specialty_id');
        $fr_add['class_id'] = I('class_id');
        $fr_add['openid'] = session('weChat_user')['openid'];

        $Arguments["xy_id"] = I('xy_id');
        $Arguments["yx_id"] = $fr_add['college_id'];
        $Arguments["zy_id"] = $fr_add['specialty_id'];
        $Arguments["bj_id"] = $fr_add['class_id'];
        $Arguments["id"] = $collection_id;

        $freshman = M('stud_freshman');
        $student = M('stud_student');

        $st_rs = $student->where('Id = ' . session('weChat_user')['id'])->find();
        if ($st_rs) {
            foreach ($fr_add as $key => $val) {
                if ($key == 'ticketnumber' || $key == 'wheremidd' || $key == 'speciality' || $key == 'category' || $key == 'totalscore' || $key == 'remark' || $key == 'collection_id' || $key == 'college_id' || $key == 'specialty_id' || $key == 'class_id') {
                    continue;
                } else {
                    if ($fr_add[$key] != $st_rs[$key]) {
                        $wh[$key] = $val;
                    }
                }
            }
            $wh['update_time'] = $time;
        }
        $student->startTrans();
        $st_rs = $student->where('Id = ' . session('weChat_user')['id'])->save($wh);

        if ($st_rs) {
            if ($fh > 0) {
                $where['stud_freshman.openid'] = session('weChat_user')['openid'];
                $where['stud_freshman.collection_id'] = $collection_id;
                $fr_rs = M('stud_freshman')
                    ->where($where)->find();
                $fr_add['status'] = 0;
                $arr = array();
                foreach ($fr_add as $key => $val) {
                    if ($fr_rs[$key] != $val) {
                        $arr[$key] = $val;
                    }
                }
                $st_rs = $freshman->where('Id = ' . $fr_rs['Id'])->save($arr);
                if ($st_rs) {
                    $student->commit();
                    $Arguments["st"] = 1;

                } else {
                    $student->rollback();
                    $Arguments["st"] = 2;
                }
            } else {
                $fr_add['create_time'] = $time;
                $fr_add['creator'] = session('weChat_user')['id'];
                $st_rs = $freshman->add($fr_add);
                if ($st_rs) {
                    $student->commit();
                    $Arguments["st"] = 1;
                } else {
                    $student->rollback();
                    $Arguments["st"] = 2;
                }
            }
        } else {
            $student->rollback();
            $Arguments["st"] = 2;
        }
        $this->redirect('freshman', $Arguments);
    }

    /*
     * 把状态该为已审核@liuwanqiu
     */
    public function change_status()
    {
        $id = I('fh', 0);
        if ($id > 0) {
            $wh['status'] = 2;
            $wh["update_time"] = time();
            $wh["updator"] = $_SESSION["weChat_user"]["id"];
            $st_rs = M('stud_freshman')->where('Id = ' . $id)->save($wh);
            if ($st_rs) {
                $this->ajaxReturn(true);
            } else {
                $this->ajaxReturn(false);
            }
        }
    }

    public function graduate()
    {
        $collection_id = I("id");
        $openid = $_SESSION["weChat_user"]["openid"];
        $nation = M("dict_nation")->where("status=0")->select();
        $user = M("stud_graduation")->where(array("openid" => $openid, "collection_id" => $collection_id))->find();

        if ($user) { //已存在的，编辑或确认
            $data = $user;
            $status = $user["status"];
            //基础数据赋值
            $dict_class = M("dict_class")->field("Id,name")->where(array("Id" => $user["class_id"]))->find();
            $dict_specialty = M("dict_specialty")->field("Id,name")->where(array("Id" => $user["specialty_id"]))->find();
            $dict_college = M("dict_college")->field("Id,name,p_id")->where(array("Id" => $user["college_id"]))->find();
            $dict_college_yx = M("dict_college")->field("Id,name")->where(array("Id" => $dict_college["p_id"]))->find();
            $baseInfo["xy"] = $dict_college_yx["name"];
            $baseInfoId["xy"] = $dict_college_yx["Id"];
            $baseInfo["yx"] = $dict_college["name"];
            $baseInfoId["yx"] = $dict_college["Id"];
            $baseInfo["zy"] = $dict_specialty["name"];
            $baseInfoId["zy"] = $dict_specialty["Id"];
            $baseInfo["bj"] = $dict_class["name"];
            $baseInfoId["bj"] = $dict_class["Id"];
        } else { //为存在，新建
            //创建时，读取默认数据
            $baseData = M("stud_student")->where(array("openid" => $openid))->find();
            $data = $baseData;
            $data['Id'] = 0;
            $data['homeaddr'] = $baseData['addr'];
            $status = 3;
            //基础数据
            $baseInfo["xy"] = "";
            $baseInfo["yx"] = "";
            $baseInfo["zy"] = "";
            $baseInfo["bj"] = "";
            $baseInfoId["xy"] = I("xy_id");
            $baseInfoId["yx"] = I("yx_id");
            $baseInfoId["zy"] = I("zy_id");
            $baseInfoId["bj"] = I("bj_id");
        }
        $where["status"] = 0;
        if (intval(I("yx_id")) != 0) {
            $where["college_id"] = I("yx_id");
        }
        $specialty = M("dict_specialty")->field('Id,name')->where($where)->select();
        $this->assign("collection", $collection_id);
        $this->assign("status", $status);
        $this->assign("specialty", $specialty); //  专业列表
        $this->assign("nation", $nation); //  民族
        $this->assign("data", $data);
        $this->assign('baseInfoId', $baseInfoId);
        $this->assign('baseInfo', $baseInfo);
        $this->display();
    }

    public function graduate_save()
    {
        $id = I("id");
        $data = I("data");
        $data["status"] = "0"; //新增和保存后将状态置为0：未审核
        //$openid = "ofeo0s_DhbyKasywIF8HmzwN1WzI1";
        $openid = $_SESSION["weChat_user"]["openid"];
        $collection_id = $data["collection_id"];

        $graduation = M("stud_graduation");
        $student = M("stud_student");
        $student->startTrans(); //设置事务回滚
        //设置基础数据
        $student_data["name"] = $data["name"];
        $student_data["sex"] = $data["sex"];
        $student_data["idcard"] = $data["idcard"];
        $student_data["nation_id"] = $data["nation"];
        $student_data["phone"] = $data["phone"];
        $student_data["addr"] = $data["homeaddr"];
        $student_data["qq"] = $data["qq"];
        $student_data["email"] = $data["email"];

        $student_rlt = $student->where(array("openid" => $openid))->save($student_data);

        //默认更新时间为创建时间

        $data["update_time"] = time();

        $data["updator"] = $_SESSION["weChat_user"]["id"];
        if ($id == 0) { //新增记录
            $data["create_time"] = time();
            $data["creator"] = $_SESSION["weChat_user"]["id"];
            $rlt = $graduation->where(array("openid" => $data["openid"], "collection_id" => $collection_id))->find();
            if ($rlt) {
                $student->rollback(); //不成功，则回滚
                responseToJson(1, "已提交过");
            } else {
                $data["openid"] = $openid;

                $rlt = $graduation->add($data);
                if ($rlt) {
                    $student->commit(); //成功则提交
                    responseToJson(0, "提交成功");
                } else {
                    $student->rollback(); //不成功，则回滚
                    responseToJson(1, "提交失败");
                }
            }

        } else { //编辑记录
            $rlt = $graduation->where(array("Id" => $id))->save($data);
            if ($rlt) {
                $student->commit(); //成功则提交
                responseToJson(0, "提交成功");
            } else {
                $student->rollback(); //不成功，则回滚
                responseToJson(1, "提交失败");
            }
        }
    }

    /*
 * 把状态该为已审核
 */
    public function graduate_status()
    {
        $id = I("id", 0);
        if ($id > 0) {
            $data['status'] = 2;
            $data["update_time"] = time();
            $data["updator"] = $_SESSION["weChat_user"]["id"];
            $rlt = M('stud_graduation')->where('Id = ' . $id)->save($data);
            if ($rlt) {
                responseToJson(0, "确认成功");
            } else {
                responseToJson(1, "确认失败");
            }
        }
    }

    public function status()
    {

        $specialty = M('dict_specialty');
        $collection_id = I('id');
        $wh['openid'] = session('weChat_user')['openid'];
        $wh['collection_id'] = $collection_id;
        $stu_rs = M('stud_status')
            ->where($wh)
            ->find();
        if ($stu_rs == null) {
            $stud = M("stud_student")->where(array("openid" => $wh['openid']))->find();
            $stu_rs["Id"] = "0";
            $stu_rs["name"] = $stud["name"];
            $stu_rs["sex"] = $stud["sex"];
            $stu_rs["pinyin"] = "";
            $stu_rs["idcard"] = $stud["idcard"];
            $stu_rs["wheremidd"] = "";
            $stu_rs["ticketnumber"] = "";
            $stu_rs["nation_id"] = $stud['nation_id'];
            $stu_rs["phone"] = $stud["phone"];
            $stu_rs["birth"] = $stud['birth'];
            $stu_rs["class"] = "0";
            $stu_rs["native"] = $stud["native"];
            $stu_rs["domicile"] = $stud["domicile"];
            $stu_rs["parent1_name"] = "";
            $stu_rs["parent1_idcard"] = "";
            $stu_rs["parent1_birth"] = "";
            $stu_rs["parent1_rela"] = "";
            $stu_rs["parent1_guardian"] = "0";
            $stu_rs["parent1_phone"] = "";
            $stu_rs["parent2_name"] = "";
            $stu_rs["parent2_idcard"] = "";
            $stu_rs["parent2_birth"] = "";
            $stu_rs["parent2_rela"] = "";
            $stu_rs["parent2_guardian"] = "0";
            $stu_rs["parent2_phone"] = "";
            //户口类型没写
            $stu_rs["allowances"] = "0";
            $stu_rs["homecode"] = "";
            $stu_rs["homeaddr"] = "";
            $stu_rs["homepolice"] = "";
            $stu_rs["source_id"] = "0";
            $stu_rs["polity"] = $stud["political"];
            $stu_rs["grades"] = "";
            $stu_rs["qq"] = $stud["qq"];
            $stu_rs["email"] = $stud["email"];
            $stu_rs["photo"] = $stud["photo"];
            $stu_rs["status"] = 3;

            $baseInfo["xy"] = "";
            $baseInfo["yx"] = "";
            $baseInfo["zy"] = "";
            $baseInfo["bj"] = "";
            $baseInfoId["xy"] = I("xy_id");
            $baseInfoId["yx"] = I("yx_id");
            $baseInfoId["zy"] = I("zy_id");
            $baseInfoId["bj"] = I("bj_id");
        } else {

            $dict_class = M("dict_class")->field("Id,name")->where(array("Id" => $stu_rs["class_id"]))->find();
            $dict_specialty = M("dict_specialty")->field("Id,name")->where(array("Id" => $stu_rs["specialty_id"]))->find();
            $dict_college = M("dict_college")->field("Id,name,p_id")->where(array("Id" => $stu_rs["college_id"]))->find();
            $dict_college_yx = M("dict_college")->field("Id,name")->where(array("Id" => $dict_college["p_id"]))->find();

            $baseInfo["xy"] = $dict_college_yx["name"];
            $baseInfoId["xy"] = $dict_college_yx["Id"];
            $baseInfo["yx"] = $dict_college["name"];
            $baseInfoId["yx"] = $dict_college["Id"];
            $baseInfo["zy"] = $dict_specialty["name"];
            $baseInfoId["zy"] = $dict_specialty["Id"];
            $baseInfo["bj"] = $dict_class["name"];
            $baseInfoId["bj"] = $dict_class["Id"];

        }
        $where["status"] = 0;
        if (intval(I("yx_id")) != 0) {
            $where["college_id"] = I("yx_id");
        }

        $polity = C("polity"); //获取config的政治面貌数组
        $accounttype = C("accounttype"); //获取config的户籍类型的数组
        $nation = M('dict_nation')->where("status=0")->select(); //读取全部民族的数据
        $class = M("dict_class")->where("status=0")->select(); //读取全部班级的数据
        $source = M("dict_source")->where("status=0")->select(); //读取全部学生的数据

        $specialty_rs = $specialty->field('Id,name')->where($where)->select();
        $this->assign('specialty_rs', $specialty_rs);

        $this->assign("stud", $stu_rs);
        $this->assign('baseInfoId', $baseInfoId);
        $this->assign('baseInfo', $baseInfo);
        $this->assign('collection_id', $collection_id);

        $this->assign('polity', $polity); //添加政治面貌数据
        $this->assign("accounttype", $accounttype); //添加户籍类型数据
        $this->assign("nation", $nation); //添加民族数据
        $this->assign("class", $class); //添加班级数据
        $this->assign("source", $source); //添加学生数据

        $this->display();
    }

    public function status_change()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $data['status'] = 2;
            $data["update_time"] = time();
            $data["updator"] = $_SESSION["weChat_user"]["id"];
            $rlt = M('stud_status')->where('Id = ' . $id)->save($data);
            if ($rlt) {
                responseToJson(0, "确认成功");
            } else {
                responseToJson(1, "确认失败");
            }
        }
    }

    public function status_save()
    {
        $id = 0;
        $datas = I('data');
        foreach ($datas as $item) {
            $kv = explode("#=#", $item);
            if ($kv[0] == "id") {
                $id = intval($kv[1]);
            } else if ($kv[0] == "photo") {
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $kv[1], $result)) {
                    var_dump($result);
                    $type = $result[2];
                    $file = time();
                    $new_file = "Public/Upload/avatar/" . $file . "." . $type;
                    $size = file_put_contents($new_file, base64_decode(str_replace($result[1], '', $kv[1])));
                    if ($size) {
                        $data[$kv[0]] = "/" . $new_file;
                    } else {
                        responseToJson(1, "提交失败");
                    }
                } else {
                    $sss = explode("avatar", $kv[1]);
                    $data[$kv[0]] = "/Public/Upload/avatar" . $sss[1];
                }
            } else {
                $data[$kv[0]] = $kv[1];
            }
            $dict = array("name", "sex", "idcard", "phone", "birth", "native", "domicile", "qq", "email", "photo", "nation");
            if (in_array($kv[0], $dict)) {
                if (($kv[0] . "_id") == "nation_id") {
                    $stud["nation_id"] = $kv[1];
                } else {
                    $stud[$kv[0]] = $kv[1];
                }
            }
            $stud["create_time"] = time();
            $stud["creator"] = session('weChat_user')['id'];
            $stud["update_time"] = time();
            $stud["updator"] = session('weChat_user')['id'];
        }

        $data["create_time"] = time();
        $data["creator"] = session('weChat_user')['id'];
        $data["update_time"] = time();
        $data["updator"] = session('weChat_user')['id'];
        $data["openid"] = session('weChat_user')['openid'];
        $data["status"] = 0;
        $M = M("stud_status");
        $M->startTrans();
        if ($id == 0) {
            $rlt = $M->add($data);
        } else {
            $rlt = $M->where(array("Id" => $id))->save($data);
        }
        if ($rlt) {
            $rlt = M("stud_student")->where(array("openid" => $data["openid"]))->save($stud);
            if ($rlt) {
                $M->commit();
                responseToJson(0, "提交成功");
            } else {
                $M->rollback();
                responseToJson(1, "提交失败");
            }
        } else {
            responseToJson(2, "提交失败");
            $M->rollback();
        }
    }


}


















