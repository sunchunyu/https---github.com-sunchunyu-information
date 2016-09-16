<?php
require_once  'vendor/autoload.php';

// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
//不带图片没有超出范围的
function To_Exel($fileName, $headArr, $data)
{
    //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
    import("Org.Util.PHPExcel");
    import("Org.Util.PHPExcel.Writer.Excel5");
    import("Org.Util.PHPExcel.IOFactory.php");

    $date = date("YmdHis",time());
    $fileName .= "{$date}.xls";

    //创建PHPExcel对象，注意，不能少了\
    $objPHPExcel = new \PHPExcel();
    $objProps = $objPHPExcel->getProperties();
    //设置表头
    $key = 0;
    //print_r($headArr);exit;
    foreach($headArr as $v){
        //注意，不能少了。将列数字转换为字母\
        $colum = \PHPExcel_Cell::stringFromColumnIndex($key);
        $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
        $key += 1;
    }
    $column = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    foreach($data as $key => $rows){ //行写入
        $span = 0;
        foreach($rows as $keyName=>$value){// 列写入
            $j = \PHPExcel_Cell::stringFromColumnIndex($span);
             $objActSheet->setCellValue($j.$column, $value);
             $span++;
        }
        $column++;
    }

    $fileName = iconv("utf-8", "gb2312", $fileName);
    //重命名表
    $objPHPExcel->getActiveSheet()->setTitle($date);
    //设置字体大小
    $objPHPExcel->getDefaultStyle()->getFont()->setSize();
    //设置单元格宽度
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth();
    //设置默认行高
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight();
    //设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    header('Cache-Control: max-age=0');

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output'); //文件通过浏览器下载
    $path = "Public/download/" . $fileName;
    $objWriter->save($path);
    exit;
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

/**
 * 生成七牛Token
 * */
function qiniu_token()
{
    $accessKey = C("QINIU_AK");
    $secretKey = C("QINIU_SK");

    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);

    // 要上传的空间
    $bucket = C("QINIU_BK");

    // 生成上传 Token
    $token = $auth->uploadToken($bucket);
    return $token;
}

/**
 * 向七牛上传图片
 * */
function qiniu_upload($file)
{
    // 需要填写你的 Access Key 和 Secret Key
    $accessKey = C("QINIU_AK");
    $secretKey = C("QINIU_SK");

    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);

    // 要上传的空间
    $bucket = C("QINIU_BK");

    // 生成上传 Token
    $token = $auth->uploadToken($bucket);

    // 要上传文件的本地路径
    $filePath = './uploads/';

    // 上传到七牛后保存的文件名
    $key = 'ic_' . millisecond();

    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();
    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath . $file);
    //echo "\n====> putFile result: \n";
    if ($err !== null) {
        //var_dump($err);
        return null;
    } else {
        return $ret["key"];
    }
}
