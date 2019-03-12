<?php
/**
 * 接口入口基类
 * User: wj
 * Date: 2018/10/14
 * Time: 15:16
 */
namespace app\api\controller;

class Apibase extends BaseController{
    public $version;//版本号
    public $plat;//客户端平台 1 安卓，2 ios，3小程序
    public $app_code;//手机唯一编号
    public $now_time;//当前时间戳
    public $nonce_str;//随机数
    public $method;//方法名
    public $apidata;//应用数据（业务参数）
    public $app_token; //token
    public $key='abc123';//token加密码
    public $sign;//签名

    public function _initialize(){
        $request = request();
        $this->version = $request->post('version');
        $this->plat = $request->post('plat');
        $this->app_code = $request->post('app_code');
        $this->now_time = $request->post('now_time');
        $this->nonce_str = $request->post('nonce_str');
        $this->method = $request->post('method');
        $this->apidata = $request->post('apidata/a');
        $this->app_token = $request->post('app_token');
        $this->sign = $request->post('sign');
        if (empty($this->version)) {
            fail_return(['msg' => '版本号不能为空']);
        }
        if (empty($this->plat)) {
            fail_return(['msg' => '客户端标示不能为空']);
        }
        if (empty($this->app_code)) {
            fail_return(['msg' => '手机标示不能为空']);
        }
        if (empty($this->now_time)) {
            fail_return(['msg' => '当前时间不能为空']);
        }
        if (empty($this->nonce_str)) {
            fail_return(['msg' => '随机数不能为空']);
        }
        if (empty($this->method)) {
            fail_return(['msg' => '参数异常']);
        }
        $verify_token_list = ['add_goods','staffOpinionSendParam','sendSmsCodeParam',
            'beforSmsSendParam','staffEditePasswordParam','getEnterListParam',
            'completeStaffParam','getMyStaffCompleteParam','getMyCodeImgParam',
            'staffOwnInfoParam','staffStatusEditeParam','getSystemListParam',
            'goodEditeParam','enterStaffcheckParam'
        ];//需要token验证的方法
        if (in_array($this->method, $verify_token_list)) {//验证token

        }
    }
    
    /**
     *
     * 生成认证签名
     * create_time 2015-10-12
     * author wj
     */
    public function create_sign($data){
        $str ='';
        ksort($data);
        foreach($data as $k=>$v){//拼接成相关规则的字符串
            if (!empty($v)){
                if ($str==''){
                    $str =$k . "=" . $v ;
                }else{
                    $str .='&'.$k . "=" . $v ;
                }
            }
        }
        $str .="&key=$this->key";
        //加密
        $str = MD5($str);
        $res = strtoupper($str);
        return $res;
    }
}