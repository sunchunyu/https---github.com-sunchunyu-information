<?php
namespace Home\Controller;

use Think\Controller;
use EasyWeChat\Foundation\Application;

class OfferController extends Controller
{
    public function index()
    {

        $this->display();
    }

    public function s()
    {
        $salary = C("OfferCfg")["salary"];
        $k = I("k");
        $p = I("p");
        $s = 10;
        $where["wx_offers.status"] = 1;
        if (!empty($k)) {
            $where["wx_offers.name"] = array("like", "%" . $k . "%");
        }
        $offers = M("wx_offers")
            ->join("left join wx_employers on wx_offers.employer_id = wx_employers.id")
            ->field("wx_offers.Id,wx_offers.name,wx_offers.addr,wx_offers.salary,wx_offers.welfare,wx_offers.update_time,wx_offers.views,wx_offers.is_top as top,wx_employers.name as employer_name")
            ->where($where)
            ->order("is_top desc,update_time desc")
            ->limit($s * $p, $s)
            ->select();
        for ($j = 0; $j < count($offers); $j++) {
            $offers[$j]["update_time"] = date("Y-m-d", $offers[$j]["update_time"]);
            $offers[$j]["salary"] = $salary[$offers[$j]["salary"]];
        }
        if ($offers == null) {
            $offers = array();
        }
        $data["data"] = $offers;
        $data["sum"] = M("wx_offers")->where($where)->count();
        $this->ajaxReturn($data);
    }

    public function  d()
    {
        $salary = C("OfferCfg")["salary"];
        $education = C("OfferCfg")["education"];
        $worklife = C("OfferCfg")["worklife"];
        $id = I("id");
        $offer = M("wx_offers")
            ->where(array("wx_offers.Id" => $id))
            ->find();
        $offer["salary"] = $salary[$offer["salary"]];
        $offer["education"] = $education[$offer["education"]];
        $offer["worklife"] = $worklife[$offer["worklife"]];
        $comm = M("wx_employers")
            ->where(array("wx_employers.Id" => $offer["employer_id"]))
            ->find();
        $this->assign("offer", $offer);
        $this->assign("comm", $comm);
        M("wx_offers")->where(array("Id" => $id))->setInc("views", 1);
        $this->display();
    }
}