<?php
/**
 * 短信验证码
 * User: wj
 * Date: 2018/10/8
 * Time: 11:40
 */
namespace app\common\logic;

use app\common\model\Smslog;
use app\common\validate\SmslogValidate;

class SmslogLogic extends BaseLogic{
    /**
     * 检查当前手机号码发送短信是否有异常，同一个手机号码每天最多可以发送50条短信，10分钟内最多可以发送10条短信
     * wj
     * 2018-19-8
     * @param $params
     * $params['sms_phone'] 手机号码
     * @return bool
     */
    public static function code_send_valideate($params){
        $map['sms_phone'] = array('eq',$params['sms_phone']);
        $begin_time=mktime(0,0,0,date('m'),date('d'),date('Y'));//今日开始时间戳
        $end_time=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//今日结束时间戳
        $map['create_time'] = array('between',[$begin_time,$end_time]);
        $smslog = new Smslog();
        $count = $smslog->where($map)->count();
        if ($count>=50){
            fail_return(['msg'=>'今日短信发送过于频繁']);
        }
        $time = time()-600;//当前时间10分钟内
        $map['create_time'] = array('>=',$time);
        $count = $smslog->where($map)->count();
        if ($count>=10){
            fail_return(['msg'=>'短信发送过于频繁,请稍后再试']);
        }
        return true;
    }
    /**
     * 将手机号码和验证码保存到验证表中
     * wj
     * 2018-10-8
     * @param $params
     * $params['sms_phone'] 手机号码
     * $params['sms_code'] 验证码
     * $params['sms_type'] 那个地方发送的
     * @return bool
     */
    public static function add_mobile($params){
        $validate = new SmslogValidate();
        $validate->checkParams($params);//验证参数
        $smslog = new Smslog();
        $res = $smslog->save($params);
        if ($res<=0){
            fail_return(['msg'=>'短信发送失败']);
        }
        return true;
    }
    /**
     * 验证码验证
     * wj
     * 2018-10-8
     * @param $params
     * $params['mobile']手机号
     * $params['code'] 验证码
     * $params['sms_type'] 位置
     * @return bool
     */
    public static function verify_code($params){
        $validate = new SmslogValidate();
        $validate->checkParams($params);//验证参数
        $smslog = new Smslog();
        $info = $smslog->where($params)->find();
        if(empty($info)){
            fail_return(['msg'=>'验证码错误']);
        }
        $verif_time = strtotime($info->create_time)+config('sms.expired_time');
        if (time()>$verif_time){
            fail_return(['msg'=>'验证码已失效，请重新发送']);
        }
        return true;
    }

}