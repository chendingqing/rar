<?php
/**
 * 短信相关
 * User: wj
 * Date: 2018/10/8
 * Time: 11:40
 */
namespace app\common\logic;

use app\common\model\Smsverif;
use app\common\validate\SmsveriValidate;

class SmsverifLogic extends BaseLogic{
    /**
     * 将手机号码保存到验证表中,并返回token
     * wj
     * 2018-10-8
     * @param $params
     * $params['mobile'] 手机号码
     * @return string
     */
    public static function add_mobile($params){
        $validate = new SmsveriValidate();
        $validate->checkParams($params);//验证参数
        $smsverif = new Smsverif();
        $token = md5($params['mobile'].time());
        $params['token'] = $token;
        $res = $smsverif->save($params);
        if ($res<=0){
            fail_return(['msg'=>'数据异常']);
        }
        return $token;
    }

    /**
     * 检测token
     * wj
     * 2018-10-8
     * @param $params
     * $params['mobile'] 手机号码
     * $params['token'] token
     * @return bool
     */
    public static function check_mobile($params){
        $map['mobile'] = array('eq',$params['mobile']);
        $map['token'] = array('eq',$params['token']);
        $smsverif = new Smsverif();
        $info = $smsverif->where($map)->order('create_time desc')->find();
        if (empty($info) || empty($info->mobile)){
            fail_return(['msg'=>'非法发送短信']);
        }
        $verif_time = strtotime($info->create_time)+config('sms.token_time');
        if (time()>$verif_time){
            fail_return(['msg'=>'短信发送超时，请重新验证']);
        }
        return true;
    }
}