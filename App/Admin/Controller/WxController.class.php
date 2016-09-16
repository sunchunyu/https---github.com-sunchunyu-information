<?php
namespace Admin\Controller;

use Think\Controller;

class WxController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    //咨询信息管理列表显示
    public function news_list()
    {
        $wx_category = M('wx_category');
        $cate_rs = $wx_category->field('Id,name')->where('status = 0')->order('Id desc')->select();
        $this->assign('cate_rs', $cate_rs);
        if (session('?st_status')) {
            $this->assign('st_status', session('st_status'));
        } else {
            $this->assign('st_status', 0);
        }
        $this->assign('count', M('wx_news')->count(1));
        $this->display();
    }

    public function clear_session()
    {
        session('st_status', null);
    }

    //查询
    public function news_query()
    {
        $wx_news = M('wx_news');
        $data_deitl = I("aoData");
        $in = 'mDataProp_' . $data_deitl['iSortCol_0']; //正序还是倒叙
        $sort_sql = $data_deitl[$in]; //点击的排序名字
        $iPage = $data_deitl["iDisplayStart"];
        $iLength = $data_deitl["iDisplayLength"]; //每页多少条

        if ($data_deitl['category_id'] == 0 && $data_deitl['type'] == 2 && $data_deitl['title'] === '' &&
            $data_deitl['begin_time'] == '' && $data_deitl['end_time'] == ''
        ) {
            $wh['wx_news.type'] = array('in', '0,1');
        } else {
            if ($data_deitl['category_id'] != 0) {
                $wh['wx_news.category_id'] = $data_deitl['category_id'];
            }
            if ($data_deitl['type'] != 2) {
                $wh['wx_news.type'] = $data_deitl['type'];
            }
            if ($data_deitl['title'] !== '') {
                $title = $data_deitl['title'];
                $wh['wx_news.title'] = array("like", "%" . $title . "%");
            }
            if ($data_deitl['begin_time'] != '') {
                $begin_time = strtotime($data_deitl['begin_time']);
                if ($data_deitl['end_time'] != '') {
                    $end_time = strtotime($data_deitl['end_time']);
                    $max_time = $begin_time >= $end_time ? $begin_time : $end_time;
                    $min_time = $begin_time < $end_time ? $begin_time : $end_time;
                    if ($max_time != $min_time) {
                        $wh['wx_news.update_time'] = array('between', array($max_time, $min_time));
                    } else {
                        $wh['wx_news.update_time'] = $max_time;
                    }
                } else {
                    $wh['wx_news.update_time'] = $begin_time;
                }
            }
        }

        $wx_news_rs = $wx_news->field('wx_news.Id,wx_news.type,wx_news.title,FROM_UNIXTIME(wx_news.create_time,"%Y-%m-%d") as create_time,FROM_UNIXTIME(wx_news.update_time,"%Y-%m-%d") as update_time,wx_news.views,wx_news.tags,wx_category.name')
            ->join('wx_category on wx_news.category_id = wx_category.id')
            ->where($wh)
            ->order('wx_news.' . $sort_sql . ' ' . $data_deitl['sSortDir_0'])
            ->limit($iPage, $iLength)
            ->select();
        $count = $wx_news->where($wh)->count();
        foreach ($wx_news_rs as $key => $val) {
            if ($val['type'] == 0) {
                $wx_news_rs[$key]['type'] = '本站';
            } else {
                $wx_news_rs[$key]['type'] = '外站';
            }
            if ($val['update_time'] == 0) {
                $wx_news_rs[$key]['update_time'] = $val['create_time'];
            }
        }
        if ($wx_news_rs == null) {
            $wx_news_rs = array();
        }
        $this->ajaxReturn(array("aaData" => $wx_news_rs, "iTotalRecords" => $count, "iTotalDisplayRecords" => $count, "sEcho" => intval($data_deitl["sEcho"])));
    }

    //删除
    public function news_del()
    {
        $ids = I("ids");
        $wx_news = M('wx_news');
        $rs = $wx_news->delete($ids);
        if ($rs) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    //增添咨询信息页面
    public function news_add()
    {
        $id = intval(I("id", 0));
        if ($id > 0) {
            $this->assign("title", "编辑");
            $wh["Id"] = $id;
            $rs = M("wx_news")->field('Id,type,title,url,category_id,abstract,content,thumb,tags,attachment')->where($wh)
                ->find();
            $this->assign("news", $rs);
        } else {
            $this->assign("user", null);
            $this->assign("title", "新增");
        }
        $wx_category = M('wx_category');
        $where["status"] = 0;
        $where["pid"] = array("neq", 0);
        $wx_category_rs = $wx_category->field('Id,name')->where($where)->order('Id desc')->select();
        $this->assign('category_rs', $wx_category_rs);
        $this->assign('token', qiniu_token());
        $this->display();
    }

    //增添咨询信息操作数据库
    public function news_add_save()
    {
        $id = I('get.id', 0);
        $zx_title = trim($_POST['zx_title']);
        $zx_radio = trim($_POST['news-type-radio']);
        $zx_se = $_POST['category'];
        $other_url = trim($_POST['other_url']);
        $textarea = trim($_POST['textarea']);
        $img_url = trim($_POST['hide_img']);
        $ue_html = trim($_POST['myEditor']);
        $tag = trim($_POST['tags']);
        $wx_news = M('wx_news');
        if ($id > 0) {
            $old = $wx_news->where('Id = ' . $id)->find();
            if ($old['type'] != $zx_radio) {
                $news_add['type'] = $zx_radio;
            }
            if ($old['title'] != $zx_title) {
                $news_add['title'] = $zx_title;
            }
            if ($old['url'] != $other_url) {
                $news_add['url'] = $other_url;
            }
            if ($old['category_id'] != $zx_se) {
                $news_add['category_id'] = $zx_se;
            }
            if ($old['abstract'] = $textarea) {
                $news_add['abstract'] = $textarea;
            }
            if ($old['content'] != $ue_html) {
                $news_add['content'] = $ue_html;
            }
            if ($old['thumb'] != $img_url) {
                $news_add['thumb'] = $img_url;
            }
            if ($old['content'] = $ue_html) {
                $news_add['content'] = $ue_html;
            }
            if ($old['tags'] != $tag) {
                $news_add['tags'] = $tag;
            }
            if ($old['updator'] != session('USER_ID')) {
                $news_add['updator'] = session('USER_ID');
            }

        } else {
            $news_add['type'] = $zx_radio;
            $news_add['title'] = $zx_title;
            $news_add['url'] = $other_url;
            $news_add['category_id'] = $zx_se;
            $news_add['abstract'] = $textarea;
            $news_add['content'] = $ue_html;
            $news_add['thumb'] = $img_url;
            $news_add['content'] = $ue_html;
            $news_add['tags'] = $tag;

        }
        if ($_POST['img_status'] != '') {
            if (!empty($_FILES['upload']['tmp_name'])) {
                $upload = new \Think\Upload(); // 实例化上传类
                $upload->upload();
                $uploaddir = DOC_ROOT . '/Public/Upload/file/'; //设置文件保存目录
                $upload->rootPath = $uploaddir; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {
                    $this->ajaxReturn(array(false, '信息添加失败'));
                } else {
                    foreach ($info as $file) {
                        $db_info = $file['savepath'] . $file['savename'];
                    }
                }
                $news_add['attachment'] = '/Public/Upload/file/' . $db_info;
            }
        } else {
            $news_add['attachment'] = '';
        }
        if ($id > 0) {
            $news_add['update_time'] = time();
            $rs = $wx_news->where('Id = ' . $id)->save($news_add);
        } else {
            $time = time();
            $news_add['create_time'] = $time;
            $news_add['update_time'] = $time;
            $news_add['creator'] = session('USER_ID');
            $news_add['updator'] = session('USER_ID');
            $rs = $wx_news->add($news_add);
        }
        if ($rs) {
            session('st_status', '1');
            $this->redirect('news_list');
        } else {
            session('st_status', '2');
            $this->redirect('news_list');
        }
    }


    public function category_delete()
    {
        $ids = I("ids");
        $M = M("wx_category");
        $data["status"] = 1;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = $M->where("id in (" . $ids . ")")->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功~~~");
        } else {
            responseToJson(1, "亲，删除失败~~~");
        }
    }

    public function desktop_move()
    {
        $from_id = I("from_id");
        $from_sort = I("from_sort");
        $to_id = I("to_id");
        $to_sort = I("to_sort");
        $M = M("wx_category");
        $M->startTrans();
        try {
            $time = time();
            $data0["sort"] = $to_sort;
            $data0["update_time"] = $time;
            $data0["updator"] = $_SESSION["USER_ID"];
            $M->where("id=" . $from_id)->save($data0);

            $data1["sort"] = $from_sort;
            $data1["update_time"] = $time;
            $data1["updator"] = $_SESSION["USER_ID"];
            $M->where("id=" . $to_id)->save($data1);
            $M->commit();
            $this->desktop_query();
        } catch (Exception $e) {
            $M->rollback();
            $this->ajaxReturn(array("data" => 0));
        }
    }

    public function desktop_query()
    {
        $sql = "select * from wx_category where is_desktop=1 and status=0 ORDER by sort DESC ";
        $data = D()->query($sql);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]["icon"] = "http://" . $_SERVER["SERVER_NAME"] . __ROOT__ . $data[$i]["icon"];
        }
        $this->ajaxReturn(array("data" => $data));
    }

    public function desktop_list()
    {
        $this->display();
    }


    public function category_desktop()
    {
        $id = I("id");
        $s = I("s");
        $M = M("wx_category");
        $data["is_desktop"] = $s;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = $M->where("id=" . $id)->save($data);
        if ($rlt) {
            responseToJson(0, "亲，设置成功~~~");
        } else {
            responseToJson(1, "亲，设置失败~~~");
        }
    }

    public function category_query()
    {
        $id = I("aoData");
        $sql = "select Id,name,url,icon,sort,is_desktop,status from wx_category where pid=" . $id . " and status=0 ORDER by sort DESC ";
        $data = D()->query($sql);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]["icon"] != "") {
                $data[$i]["icon"] = "http://" . $_SERVER["SERVER_NAME"] . __ROOT__ . $data[$i]["icon"];
            }
        }

        $this->ajaxReturn(array("data" => $data));
    }

    public function category_list()
    {
        if (session('?st_status')) {
            $this->assign('st_status', session('st_status'));
        } else {
            $this->assign('st_status', 0);
        }
        $this->display();
    }

    //增加类型页面
    public function category_add()
    {
        $id = intval(I("id", 0));
        $category = M('wx_category');
        $wh['status'] = 0;
        $wh['is_desktop'] = 1;
        $wh['url'] = '';
        $category_rs = $category->field('name,Id')
            ->where($wh)
            ->select();
        if ($category_rs) {
            $status = 1;
        } else {
            $status = 0;
        }
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $rs = $category->where($where)->find();
            $this->assign("category", $rs);
        } else {
            $this->assign("category", null);
            $this->assign("title", "新增");
        }
        $this->assign('status', $status);
        $this->display();
    }

    //添加类型操作数据库
    public function category_add_save()
    {
        $id = $_GET['id'];
        $type = $_POST['type-radio'];
        $category_title = trim($_POST['category_title']);
        $url = trim($_POST['url']);
        if ($_POST['img_status'] != '') {
            if (!empty($_FILES['dropify']['tmp_name'])) {
                $upload = new \Think\Upload(); // 实例化上传类
                $upload->upload();
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
                $uploaddir = DOC_ROOT . '/Public/Upload/thumb/'; //设置文件保存目录
                $upload->rootPath = $uploaddir; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {
                    $this->ajaxReturn(array(false, '信息添加失败'));
                } else {
                    foreach ($info as $file) {
                        $db_info = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $wh['icon'] = '/Public/Upload/thumb/' . $db_info;
        } else {
            $wh['icon'] = '';
        }
        $category = M('wx_category');
        if ($id > 0) {
            $rs = $category->where('Id =' . $id)->find();
            if ($rs['name'] != $category_title) {
                $wh['name'] = $category_title;
            }

            if ($type == 0) {
                if ($rs['url'] != '') {
                    $wh['url'] = '';
                }
                if ($rs['pid'] != 0) {
                    $wh['pid'] = 0;
                }
            } else {
                if ($rs['url'] != $url) {
                    $wh['url'] = $url;
                }
                if ($rs['pid'] != $_POST['category_type']) {
                    $wh['pid'] = $_POST['category_type'];
                }
            }
            $wh['update_time'] = time();
            if ($rs['updator'] != session('USER_ID')) {
                $wh['updator'] = session('USER_ID');
            }
            $category_add = $category->where('Id =' . $id)->save($wh);
        } else {
            if ($type == 1) {
                $wh['pid'] = $_POST['category_type']; //子类别id
            }
            $wh['name'] = $category_title;
            $wh['url'] = $url;
            $time = time();
            $wh['create_time'] = $time;
            $wh['update_time'] = $time;
            $wh['creator'] = session('USER_ID');
            $wh['updator'] = session('USER_ID');
            $wh['icon'] = '/Public/Upload/thumb/' . $db_info;
            $category_add = $category->add($wh);
        }
        if ($category_add) {
            session('st_status', '1');
            $this->redirect('category_list');
        } else {
            session('st_status', '1');
            $this->redirect('category_list');
        }
    }

    //类型下拉框的change事件
    public function category()
    {
        $category = M('wx_category');
        $wh['status'] = 0;
        $wh['is_desktop'] = 1;
        $wh['url'] = '';
        $category_rs = $category->field('name,Id')
            ->where($wh)
            ->order('Id desc')->select();
        $this->ajaxReturn($category_rs);

    }

    //招聘信息管理
    public function offer_list()
    {
        $wx_category = M('wx_category')->field('name,Id')->order('Id desc')->select();
        $salary = C("OfferCfg")["salary"];
        $education = C("OfferCfg")["education"];
        $worklife = C("OfferCfg")["worklife"];
        $this->assign('salary', $salary);
        $this->assign('education', $education);
        $this->assign('worklife', $worklife);
        $this->assign('category', $wx_category);
        $this->display();
    }

    //招聘信息添加
    public function offer_add()
    {
        $id = intval(I("id", 0));
        $employer = M('wx_employers');
        $dict_county = M('dict_county');
        $wh_country['type'] = 0;
        $wh_country['status'] = 0;
        $county_rs = $dict_county->field('name,Id,type, 0 as pid')->where($wh_country)->order('Id asc')->select();
        $wh_country['type'] = 1;
        $cou_rs_all = $dict_county->field('name,Id,type,province_id as pid')->where($wh_country)->order('Id asc')->select();
        $wh_country['type'] = 2;
        $small_all = $dict_county->field('name,Id,type,city_id as pid')->where($wh_country)->order('Id asc')->select();
        if ($id > 0) {
            $where["Id"] = $id;
            $rs = M('wx_offers')->where($where)->find();
            $addr = $rs['addr'];
            $var = explode("-", $addr);
            $rs["p"] = $var[0];
            $rs["c"] = $var[1];
            $rs["t"] = $var[2];

            $this->assign("offers", $rs);
            $this->assign("title", "编辑");
        } else {
            $rs["p"] = 0;
            $rs["c"] = 0;
            $rs["t"] = 0;
            $this->assign("offers", $rs);
            $this->assign("title", "新增");
        }
        $employer_rs = $employer->field('Id,name')->where('status = 0')->order('Id desc')->select();
        if (!$employer_rs) {
            $employer_rs = array();
        }
        $industry = C("OfferCfg")["industry"];
        $this->assign('industry', $industry);
        $salary = C("OfferCfg")["salary"];
        $this->assign('salary', $salary);
        $education = C("OfferCfg")["education"];
        $this->assign('education', $education);
        $worklife = C("OfferCfg")["worklife"];
        $this->assign('worklife', $worklife);
        $this->assign('employer', $employer_rs);
        $this->assign('county_rs', $county_rs);

        $this->assign('city', $cou_rs_all);
        $this->assign('small', $small_all);
        $this->display();
    }

    //选择第二级
    public function county()
    {
        $id = I('id');
        $type = I('type');
        $county = M('dict_county');
        if ($type == 1) {
            $wh['status'] = 0;
            $wh['province_id'] = $id;
            $rs = $county->field('Id,name,type')->where($wh)->order('Id desc')->select();
        } else {
            $wh['status'] = 0;
            $wh['city_id'] = $id;
            $rs = $county->field('Id,name,type')->where($wh)->order('Id desc')->select();
        }
        if ($rs) {
            $this->ajaxReturn($rs);
        } else {
            $this->ajaxReturn(array());
        }
    }

    //招聘信息修改增添
    public function offer_add_save()
    {
        $id = I('get.id', 0);
        $name = trim($_POST['_offer_title']);
        $addr = trim($_POST['_offer_addr']);
        $salary = $_POST['_salary'];
        $number = trim($_POST['_number']);
        $education = $_POST['_education'];
        $worklife = $_POST['_worklife'];
        $welfare = $_POST['_welfare'];
        $content = trim($_POST['_ue_html']);
        $category = $_POST['_category'];
        $offers = M('wx_offers');
        if ($id > 0) {
            $old_rs = $offers->where('Id = ' . $id)->find();
            if ($old_rs['name'] != $name) {
                $offer_add['name'] = $name;
            }
            if ($old_rs['addr'] != $addr) {
                $offer_add['addr'] = $addr;
            }
            if ($old_rs['salary'] != $salary) {
                $offer_add['salary'] = $salary;
            }
            if ($old_rs['number'] != $number) {
                $offer_add['name'] = $number;
            }
            if ($old_rs['education'] != $education) {
                $offer_add['education'] = $education;
            }
            if ($old_rs['worklife'] != $worklife) {
                $offer_add['worklife'] = $worklife;
            }
            if ($old_rs['welfare'] != $welfare) {
                $offer_add['welfare'] = $welfare;
            }
            if ($old_rs['content'] != $content) {
                $offer_add['content'] = $content;
            }
            if ($old_rs['employer_id'] != $category) {
                $offer_add['employer_id'] = $category;
            }
            if ($old_rs['updator'] != session('USER_ID')) {
                $offer_add['updator'] = session('USER_ID');
            }
            $offer_add['update_time'] = time();
            $offer_rs = $offers->where('Id = ' . $id)->save($offer_add);
        } else {
            $offer_add['name'] = $name;
            $offer_add['addr'] = $addr;
            $offer_add['salary'] = $salary;
            $offer_add['number'] = $number;
            $offer_add['education'] = $education;
            $offer_add['worklife'] = $worklife;
            $offer_add['welfare'] = $welfare;
            $offer_add['content'] = $content;
            $offer_add['employer_id'] = $category;
            $time = time();
            $offer_add['create_time'] = $time;
            $offer_add['creator'] = session('USER_ID');
            $offer_add['updator'] = session('USER_ID');
            $offer_add['update_time'] = $time;
            $offer_rs = $offers->add($offer_add);
        }
        if ($offer_rs) {
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

    //置顶
    public function change_top()
    {
        $id = I('id');
        $offers = M('wx_offers');
        $is_top = $offers->field('is_top')->where('Id = ' . $id)->find();
        if ($is_top['is_top'] == 0) {
            $edit['is_top'] = 1;
        } else {
            $edit['is_top'] = 0;
        }
        $rs = $offers->where('Id = ' . $id)->save($edit);
        if ($rs) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }

    //查询
    public function offer_query()
    {
        $wx_offers = M('wx_offers');
        $data_deitl = I('aoData');
        $in = 'mDataProp_' . $data_deitl['iSortCol_0']; //正序还是倒叙
        $sort_sql = $data_deitl[$in]; //点击的排序名字
        $iPage = $data_deitl["iDisplayStart"];
        $iLength = $data_deitl["iDisplayLength"];
        if ($data_deitl['education'] === '' && $data_deitl['count'] === '' && $data_deitl['worklife'] === '' &&
            $data_deitl['category'] === '' && $data_deitl['salary'] === '' && trim($data_deitl['name']) === '' &&
            trim($data_deitl['addr']) === '' && $data_deitl['begin_time'] === '' && $data_deitl['end_time'] === ''
        ) {

        } else {
            if ($data_deitl['education'] !== '') {
                $wh['wx_offers.education'] = $data_deitl['education'];
            }
            if ($data_deitl['count'] != '') {
                $wh['wx_offers.number'] = $data_deitl['count'];
            }
            if ($data_deitl['worklife'] !== '') {
                $wh['wx_offers.worklife'] = $data_deitl['worklife'];
            }
            if ($data_deitl['category'] !== '') {
                $wh['wx_offers.employer_id'] = $data_deitl['category'];
            }
            if ($data_deitl['salary'] !== '') {
                $wh['wx_offers.salary'] = $data_deitl['salary'];
            }
            if (trim($data_deitl['name']) !== '') {
                $wh['wx_offers.name'] = array('like', '%' . $data_deitl['name'] . '%');
            }
            if (trim($data_deitl['addr']) !== '') {
                $wh['wx_offers.addr'] = array('like', '%' . $data_deitl['addr'] . '%');
            }
            if ($data_deitl['begin_time'] !== '') {
                $begin_time = strtotime($data_deitl['begin_time']);
                if ($data_deitl['end_time'] !== '') {
                    $end_time = strtotime($data_deitl['end_time']);
                    $max_time = $begin_time >= $end_time ? $begin_time : $end_time;
                    $min_time = $begin_time < $end_time ? $begin_time : $end_time;
                    if ($max_time != $min_time) {
                        $wh['begin_time.update_time'] = array('between', array($max_time, $min_time));
                    } else {
                        $wh['begin_time.update_time'] = $max_time;
                    }
                } else {
                    $wh['begin_time.update_time'] = $begin_time;
                }
            }
        }
        //var_dump($wh);
        $wh['wx_offers.status'] = 1;
        if ($sort_sql == 'category') {
            $table_name = 'category';
        } else if ($sort_sql == 'offer_name') {
            $table_name = 'offer_name';
        } else {
            $table_name = 'wx_offers.' . $sort_sql;
        }
        $offers_rs = $wx_offers->field('wx_employers.name as category,wx_offers.Id,wx_offers.name as offer_name,wx_offers.addr,
        wx_offers.salary,wx_offers.number,wx_offers.education,wx_offers.worklife,wx_offers.is_top,
        FROM_UNIXTIME(wx_offers.create_time,"%Y-%m-%d") as create_time,FROM_UNIXTIME(wx_offers.update_time,"%Y-%m-%d") as
        update_time')
            ->join('left join wx_employers on wx_employers.Id = wx_offers.employer_id')
            ->where($wh)
            ->order($table_name . ' ' . $data_deitl['sSortDir_0'])
            ->limit($iPage, $iLength)
            ->select();
        $count = $wx_offers->where($wh)->count(1);
        foreach ($offers_rs as $key => $val) {
            $offers_rs[$key]['salary'] = C("OfferCfg")["salary"][$val['salary']];
            $offers_rs[$key]['education'] = C("OfferCfg")["education"][$val['education']];
            $offers_rs[$key]['worklife'] = C("OfferCfg")["worklife"][$val['worklife']];
        }
        //$this->ajaxReturn(array("data" => $offers_rs));
        if ($offers_rs == null) {
            $offers_rs = array();
        }
        $this->ajaxReturn(array("aaData" => $offers_rs, "iTotalRecords" => $count, "iTotalDisplayRecords" => $count, "sEcho" => intval($data_deitl["sEcho"])));
    }

    //删除
    public function offer_del()
    {
        $ids = I("ids");
        $data["status"] = 0;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = M("wx_offers")->where("Id in (" . $ids . ")")->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            $this->ajaxReturn(false);
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }


    public function employer_list()
    {
        $com_size = C("OfferCfg")["com_size"];
        $industry = C("OfferCfg")["industry"];
        $this->assign('com_size', $com_size);
        $this->assign('industry', $industry);
        if (session('?st_status')) {
            $this->assign('st_status', session('st_status'));
        } else {
            $this->assign('st_status', 0);
        }
        $this->display();
    }

    public function employer_add()
    {
        $id = intval(I("id", 0));
        $employer = M('wx_employers');
        if ($id > 0) {
            $this->assign("title", "编辑");
            $where["Id"] = $id;
            $rs = $employer->where($where)->find();
            $this->assign("employer", $rs);
        } else {
            $this->assign("offers", null);
            $this->assign("title", "新增");
        }
        $industry = C("OfferCfg")["industry"];
        $this->assign('industry', $industry);
        $com_size = C("OfferCfg")["com_size"];
        $this->assign('id', $id);
        $this->assign('com_size', $com_size);
        $this->display();
    }

    public function employer_add_save()
    {
        $id = I('get.id', 0);
        if ($_POST['img_status'] != '') {
            if (!empty($_FILES['logo_img']['tmp_name'])) {
                $upload = new \Think\Upload(); // 实例化上传类
                $upload->upload();
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
                $uploaddir = DOC_ROOT . '/Public/Upload/icon/'; //设置文件保存目录
                $upload->rootPath = $uploaddir; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {
                    $this->ajaxReturn(array(false, '信息添加失败'));
                } else {
                    foreach ($info as $file) {
                        $db_info = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $wh_add['logo'] = '/Public/Upload/icon/' . $db_info;
        } else {
            $wh_add['logo'] = '';
        }
        $name = trim($_POST['employer_title']);
        $industry = $_POST['industry_title'];
        $com_size = $_POST['com_size'];
        $url = trim($_POST['url']);
        $addr = trim($_POST['addr']);
        $tel = trim($_POST['tel']);
        $email = trim($_POST['email']);
        $brief = trim($_POST['hide']);
        $wx_employers = M('wx_employers');

        if ($id > 0) {
            $old_rs = $wx_employers->where('Id =' . $id)->find();
            if ($old_rs['name'] != $name) {
                $wh_add['name'] = $name;
            }
            if ($old_rs['industry'] != $industry) {
                $wh_add['industry'] = $industry;
            }
            if ($old_rs['com_size'] != $com_size) {
                $wh_add['com_size'] = $com_size;
            }
            if ($old_rs['url'] != $url) {
                $wh_add['url'] = $url;
            }
            if ($old_rs['addr'] != $addr) {
                $wh_add['addr'] = $addr;
            }
            if ($old_rs['tel'] != $tel) {
                $wh_add['tel'] = $tel;
            }
            if ($old_rs['email'] != $email) {
                $wh_add['email'] = $email;
            }

            if ($old_rs['brief'] != $brief) {
                $wh_add['brief'] = $brief;
            }
            if ($old_rs['updator'] != session('USER_ID')) {
                $wh_add['updator'] = session('USER_ID');
            }
            $wh_add['update_time'] = time();
            $employers_rs = $wx_employers->where('Id = ' . $id)->save($wh_add);
        } else {
            $wh_add['name'] = $name;
            $wh_add['industry'] = $industry;
            $wh_add['com_size'] = $com_size;
            $wh_add['url'] = $url;
            $wh_add['addr'] = $addr;
            $wh_add['tel'] = $tel;
            $wh_add['email'] = $email;
            if ($db_info != '') {
                $wh_add['logo'] = '/Public/Upload/icon/' . $db_info;
            }
            $wh_add['brief'] = $brief;
            $time = time();
            $wh_add['create_time'] = $time;
            $wh_add['update_time'] = $time;
            $wh_add['updator'] = session('USER_ID');
            $wh_add['creator'] = session('USER_ID');
            $employers_rs = $wx_employers->add($wh_add);
        }
        if ($employers_rs) {
            session('st_status', '1');
            $this->redirect('employer_list');
        } else {
            session('st_status', '2');
            $this->redirect('employer_list');
        }
    }

    //招聘查询
    public function employer_query()
    {
        $wx_employers = M('wx_employers');
        $data_deitl = I("aoData");
        $in = 'mDataProp_' . $data_deitl['iSortCol_0']; //正序还是倒叙
        $sort_sql = $data_deitl[$in]; //点击的排序名字
        $iPage = $data_deitl["iDisplayStart"]; //当前页，0是第一页
        $iLength = $data_deitl["iDisplayLength"]; //每页多少条
        if ($data_deitl['industry'] === '' && trim($data_deitl['name']) === '' &&
            $data_deitl['com_size'] === '' && $data_deitl['begin_time'] === '' && $data_deitl['end_time'] === ''
        ) {

        } else {
            if ($data_deitl['com_size'] !== '') {
                $wh['wx_employers.com_size'] = $data_deitl['com_size'];
            }
            if ($data_deitl['industry'] !== '') {
                $wh['wx_employers.industry'] = $data_deitl['industry'];
            }
            if ($data_deitl['name'] !== '') {
                $wh['wx_employers.name'] = array('like', '%' . $data_deitl['name'] . '%');
            }
            if ($data_deitl['begin_time'] !== '') {
                $begin_time = strtotime($data_deitl['begin_time']);
                if ($data_deitl['end_time'] !== '') {
                    $end_time = strtotime($data_deitl['end_time']);
                    $max_time = $begin_time >= $end_time ? $begin_time : $end_time;
                    $min_time = $begin_time < $end_time ? $begin_time : $end_time;
                    if ($max_time != $min_time) {
                        $wh['wx_employers.update_time'] = array('between', array($max_time, $min_time));
                    } else {
                        $wh['wx_employers.update_time'] = $max_time;
                    }
                } else {
                    $wh['wx_employers.update_time'] = $begin_time;
                }
            }
        }
        $wh['status'] = 0;
        $employers_rs = $wx_employers->field('Id,name,industry,com_size,tel,email,url,FROM_UNIXTIME(create_time,"%Y-%m-%d") as create_time,FROM_UNIXTIME(update_time,"%Y-%m-%d") as update_time')
            ->where($wh)
            ->limit($iPage, $iLength)
            ->order('wx_employers.' . $sort_sql . ' ' . $data_deitl['sSortDir_0'])
            ->select();
        $count = $wx_employers->where($wh)->count();
        foreach ($employers_rs as $key => $val) {
            $employers_rs[$key]['com_size'] = C("OfferCfg")["com_size"][$val['com_size']];
            $employers_rs[$key]['industry'] = C("OfferCfg")["industry"][$val['industry']];
        }
        if ($employers_rs == null) {
            $employers_rs = array();
        }
        $this->ajaxReturn(array("aaData" => $employers_rs, "iTotalRecords" => $count, "iTotalDisplayRecords" => $count, "sEcho" => intval($data_deitl["sEcho"])));
    }

    //招聘删除
    public function employer_delete()
    {
        $ids = I("ids");
        $data["status"] = 1;
        $data["update_time"] = time();
        $data["updator"] = $_SESSION["USER_ID"];
        $rlt = M("wx_employers")->where("id in (" . $ids . ")")->save($data);
        if ($rlt) {
            responseToJson(0, "亲，删除成功啦~~~");
        } else {
            responseToJson(1, "亲，删除失败啦~~~");
        }
    }
}
