<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/10/9
 * Time: 10:54
 */
namespace app\demo\controller;

import('qrcode.phpqrcode.phpqrcode', EXTEND_PATH);

class Qrcode extends BaseController{
    /**
     * @param $value 二维码保存的数据
     * @param bool $outfile 生成二维码保存地址,如果是false则不保存
     * @param $level
     * 默认为L，这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)、M(QR_ECLEVEL_M，15%)、Q(QR_ECLEVEL_Q，25%)、H(QR_ECLEVEL_H，30%)，
     * 这个参数控制二维码容错率，不同的参数表示二维码可被覆盖的区域百分比，也就是被覆盖的区域还能识别
     * @param $size 控制生成图片的大小，默认为4；
     * @param $margin 控制生成二维码的空白区域大小；
     * @param $saveandprint 保存二维码图片并显示出来，$outfile必须传递图片路径
     * wj
     * 2018-10-9
     */
    public function create_code(){
        ob_end_clean();//关闭数据输出缓冲，否则会出现乱码
        $value = 'http://www.baidu.com';
        $file_path = 'uploads/code/';
        $file_name  =time().'.png';
        create_folders($file_path);//创建目录
        $outfile = $file_path.$file_name;
        $level = 'H';
        $size = 16;
        $margin = 3;
        $saveandprint = true;
        \QRcode::png($value,$outfile,$level,$size,$margin,$saveandprint);
        $logo = 'log.jpg';
        $this->addLogo($outfile,$logo,$outfile);//如果需要添加logo图片这调用
        echo '<img src="/'.$outfile.'" alt="111">';
    }
    /**
     * 为二维码添加logo
     * @param $qrcode 二维码地址
     * @param $logo logo图片地址
     * @param $filepath 保存路劲
     * wj
     * 2018-10-9
     */
    public function addLogo($qrcode,$logo,$filepath){
        $QR = imagecreatefromstring(file_get_contents($qrcode));    //目标图象连接资源。
        $logo = imagecreatefromstring(file_get_contents($logo));  //源图象连接资源。
        $QR_width = imagesx($QR);      //二维码图片宽度
        $QR_height = imagesy($QR);     //二维码图片高度
        $logo_width = imagesx($logo);    //logo图片宽度
        $logo_height = imagesy($logo);   //logo图片高度
        $logo_qr_width = $QR_width / 4;   //组合之后logo的宽度(占二维码的1/5)
        $scale = $logo_width/$logo_qr_width;  //logo的宽度缩放比(本身宽度/组合后的宽度)
        $logo_qr_height = $logo_height/$scale; //组合之后logo的高度
        $from_width = ($QR_width - $logo_qr_width) / 2;  //组合之后logo左上角所在坐标点
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
        imagepng($QR,$filepath);
        imagedestroy($QR);
        imagedestroy($logo);
    }
}