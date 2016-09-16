<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function _initialize()
    {

    }

    public function index()
    {
        $sql = "select * from wx_category where is_desktop=1 and status=0 ORDER by sort ASC ";
        $data = D()->query($sql);
        for($i=0;$i<count($data);$i++){
            $data[$i]["icon"] = __ROOT__."/".$data[$i]["icon"];
        }
        $this->assign("data", $data);
        $M = M("wx_news");
        $news = $M->join("wx_category on wx_news.category_id=wx_category.Id")->field("wx_news.*,wx_category.name")->order("update_time desc")->limit(5)->select();
        $this->assign("news", $news);
        $this->display();
    }

    /**
     * 资讯搜索
     **/
    public function s()
    {
        $s = 10;
        $id = intval(I("id"));
        $p = intval(I("p"));
        $k = I("k");
        $M = M("wx_news");
        if ($id != 0) {
            $where["wx_news.category_id"] = $id;
            $dd = M("wx_category")->where(array("Id" => $id))->field("name")->find();
        } else {
            $where["wx_news.Id"] = array("gt", 0);
            $dd["name"] = "所有类别";
        }
        if (!empty($k)) {
            $where["wx_news.title"] = array("like", "%" . $k . "%");
        }
        $news = $M->join("wx_category on wx_news.category_id=wx_category.Id")->field("wx_news.Id,wx_news.title,wx_news.tags,wx_news.abstract,wx_news.url,wx_news.thumb,wx_news.abstract,wx_news.update_time,wx_category.name")->order("update_time desc")->where($where)->limit($s * $p, $s)->select();
        if ($news == null) {
            $news = array();
        }
        for ($j = 0; $j < count($news); $j++) {
            $news[$j]["update_time"] = date("Y-m-d", $news[$j]["update_time"]);
        }
        $data["data"] = $news;
        $data["sum"] = $M->where($where)->count();
        $data["name"] = $dd["name"];

        $this->ajaxReturn($data);
    }

    /**
     *  更多咨询资讯页面
     **/
    public function m()
    {
        $M = M("wx_category");
        $p = $M->where(array("Id" => I("id"), "status" => 0))->find();
        $this->assign("p", $p);
        $this->display();
    }


    /**
     * 二级类别页面
     **/
    public function p()
    {


        $M = M("wx_category");
        $p = $M->where(array("Id" => I("id"), "status" => 0))->find();
        $this->assign("p", $p);

        $data = $M->where(array("pid" => I("id"), "status" => 0))->select();
        for ($i = 0; $i < count($data); $i++) {
            $M = M("wx_news");
            $news = $M->join("wx_category on wx_news.category_id=wx_category.Id")->field("wx_news.*,wx_category.name")->order("update_time desc")->where(array("wx_news.category_id" => $data[$i]["Id"]))->limit(5)->select();
            $data[$i]["news"] = $news;
        }
        $this->assign("data", $data);
        $this->display();
    }

    /**
     * 资讯详情
     * */
    public function d()
    {
        $id = I("id");
        $data = M("wx_news")->where(array("Id" => $id))->find();
        $this->assign("data", $data);
        M("wx_news")->where(array("Id" => $id))->setInc("views", 1);
        $this->display();
    }

    /**
     * 脚本
     **/
    public function job()
    {
        $date_start = explode("-", date("Y-m-d", strtotime("-1 day")));
        $date_end = explode("-", date("Y-m-d", time()));
        $date_start = mktime(0, 0, 0, $date_start[1], $date_start[2], $date_start[0]);
        $date_end = mktime(0, 0, 0, $date_end[1], $date_end[2], $date_end[0]);
        //PV
        $where = array();
        $data = array();
        $where["date_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("sys_logs")->where($where)->count();
        $data["type"] = 0;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //UV
        $where = array();
        $data = array();
        $where["date_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("sys_logs")->where($where)->count("distinct ip");
        $data["type"] = 1;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //news
        $where = array();
        $data = array();
        $where["create_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("wx_news")->where($where)->count();
        $data["type"] = 2;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //offers
        $where = array();
        $data = array();
        $where["create_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $where["status"] = 1;
        $data["number"] = M("wx_offers")->where($where)->count();
        $data["type"] = 3;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //新生
        $where = array();
        $data = array();
        $where["create_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("stud_freshman")->where($where)->count();
        $data["type"] = 4;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //毕业生
        $where = array();
        $data = array();
        $where["create_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("stud_graduation")->where($where)->count();
        $data["type"] = 5;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //学籍
        $where = array();
        $data = array();
        $where["create_time"] = array(array("egt", $date_start), array("lt", $date_end), "and");
        $data["number"] = M("stud_status")->where($where)->count();
        $data["type"] = 6;
        $data["date_time"] = $date_start;
        M("sys_statistics")->add($data);

        //自动确认
        $date_time = date("Y-m-d", strtotime("-2 day"));
        $where = array();
        $where["status"] = 1;
        $where["update_time"] = array("lt", mktime(0, 0, 0, $date_time[1], $date_time[2], $date_time[0]));
        M("stud_freshman")->where($where)->save(array("status" => 2, "update_time" => time(), "updator" => -1));
        M("stud_graduation")->where($where)->save(array("status" => 2, "update_time" => time(), "updator" => -1));
        M("stud_status")->where($where)->save(array("status" => 2, "update_time" => time(), "updator" => -1));
    }
}