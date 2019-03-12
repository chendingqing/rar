<?php
/**
 * 短信发送
 * User: wj
 * Date: 2018/9/30
 * Time: 18:56
 */
namespace app\demo\controller;

use app\common\logic\SmsverifLogic;
use app\common\service\DysmsService;
use app\common\logic\SmslogLogic;
class Sms extends BaseController
{
    public function dy_index(){
       return $this->fetch();
    }
    /**
     * 阿里云大鱼发送短信
     * wj
     * 2018-9-30
     */
    public function dy_sendcode(){
        $request = request();
        $mobile =$request->post('mobile');//手机号码
        $token = $request->post('token');//token
        SmsverifLogic::check_mobile(['mobile'=>$mobile,'token'=>$token]);//验证token
        SmslogLogic::code_send_valideate(['sms_phone'=>$mobile]);//验证发送短信是否合法，防止短信轰炸
        $smsService = new DysmsService();
        $add_params['sms_code'] = $params['code'] = $this->rand_code();//验证码
        $add_params['sms_phone'] = $params['mobile'] =$mobile;
        $params['sign'] ='阿里云短信测试专用';
        $params['template'] ='SMS_135295130';
        $add_params['sms_type'] = 1;
        $add_params['ip'] = $request->ip();
        /*SmslogLogic::add_mobile($add_params);//将验证码存入数据库
        success_return(['msg'=>'短信发送成功，请注意查收']);*/
        $result = $smsService->sendSms($params);
        if ($result->Code =='OK'){//短信发送成功
            $add_params['sms_type'] = 1;
            $add_params['ip'] = $request->ip();
            SmslogLogic::add_mobile($add_params);//将验证码存入数据库
            success_return(['msg'=>'短信发送成功，请注意查收']);
        }else{//短信发送失败
            $msg = $result->Message;//短信发送失败信息
            fail_return(['msg'=>$msg]);
        }
    }

    /**
     * 随机获取数字
     * @param int $len 长度
     * @return int 返回数字
     * wj
     * 2018-9-30
     */
    public function rand_code($len = 4){
        $number='';
        for($i=0;$i<$len;$i++){
            $number .=rand(0,9);
        }
        return $number;
    }
    /**
     * 发送短信前将手机号码保存到数据库，防止短信轰炸
     * wj
     * 2018-10-8
     */
    public function sms_verif_add(){
        $request = request();
        $mobile =$request->post('mobile');//手机号码
        $token = SmsverifLogic::add_mobile(['mobile'=>$mobile]);
        $data['token'] = $token;//返回token
        success_return(['data'=>$data]);
    }

    /**
     * 验证短信验证码
     * wj
     * 2018-10-8
     */
    public function verify_code(){
        $request = request();
        $params['sms_phone'] =$request->post('mobile');//手机号码
        $params['sms_code'] = $request->post('code');//验证码
        $params['sms_type'] = 1;//类型
        SmslogLogic::verify_code($params);
        success_return(['msg'=>'验证成功']);
    }

}
