<?php
include 'vendor/autoload.php';

function gm_substr($str, $index, $length)
{
    return mb_substr($str, $index, $length, "utf-8");
}

function get_tags($str)
{
    $html = "";
    if ($str != "") {
        $strs = explode(",", $str);
        foreach ($strs as $v) {
            $html .= "<span class='tag'>" . $v . "</span>";
        }
    } else {
        $html = "<span class='tag'>资讯</span>";
    }
    return $html;
}

function addLogs()
{
    $data["ip"] = $_SERVER["HTTP_HOST"];
    $data["agent"] = $_SERVER["HTTP_USER_AGENT"];
    $data["page"] = $_SERVER["REQUEST_URI"];
    $data["date_time"] = time();
    M("sys_logs")->add($data);
}

/*
 * 格式化返回结果
 * */
function responseToJson($code = 0, $message = '', $paras = null)
{
    $res["code"] = $code;
    $res["message"] = $message;
    if (!empty($paras)) {
        $res["result"] = $paras;
    }
    //response()->json($res);
    echo json_encode($res);
    exit;
}