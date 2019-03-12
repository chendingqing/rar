<?php
/**
 * 短信发送
 * User: wj
 * Date: 2018/9/30
 * Time: 18:56
 */
namespace app\demo\controller;

use app\common\service\WxpayService;
import('qrcode.phpqrcode.phpqrcode', EXTEND_PATH);
class Wxpay extends BaseController
{
    public function index(){
        $request = request();
        $appid='wxf3713e303ebf6fd4';
        $secret='1';
        $mch_id='1505833641';
        $key='lwwqq1234567890lwwqq1234567890lw';
        $notify_url='http://base.mx5918.com/demo/Wxpay/pay_success';
        $trade_type='NATIVE';
        $sevice = new WxpayService($appid,$secret,$mch_id,$key,$notify_url,$trade_type);
        $params['body']='支付测试';
        $params['attach']='id=123';
        $params['out_trade_no']='sn_000001';
        $params['total_fee']=1;
        $params['spbill_create_ip']=$request->ip();
        $params['product_id']=1;
        $r = $sevice->unified_pay($params);
        dump($r);
        $code_url = $r['code_url'];
        ob_end_clean();//关闭数据输出缓冲，否则会出现乱码
        $value = $code_url;
        $file_path = 'uploads/code/';
        $file_name  =time().'.png';
        create_folders($file_path);//创建目录
        $outfile = $file_path.$file_name;
        $level = 'H';
        $size = 16;
        $margin = 3;
        $saveandprint = true;
        \QRcode::png($value,$outfile,$level,$size,$margin,$saveandprint);
        //$logo = 'log.jpg';
        //$this->addLogo($outfile,$logo,$outfile);//如果需要添加logo图片这调用
        echo '<img src="/'.$outfile.'" alt="111">';
    }
    public function pay_success(){
        echo 111;
        $appid='wxf3713e303ebf6fd4';
        $secret='1';
        $mch_id='1505833641';
        $key='lwwqq1234567890lwwqq1234567890lw';
        $notify_url='http://base.mx5918.com/demo/Wxpay/pay_success';
        $trade_type='NATIVE';
        $sevice = new WxpayService($appid,$secret,$mch_id,$key,$notify_url,$trade_type);
    }
}
