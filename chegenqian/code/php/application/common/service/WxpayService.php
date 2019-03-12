<?php
/**
 * 微信支付
 * User: wj
 * Date: 2018/9/30
 * Time: 15:23
 */

namespace app\common\service;

class WxpayService extends  BaseService{
    public $appid;
    public $secret;
    public $mch_id;
    public $key;
    public $notify_url;
    public $trade_type;//取值如下：JSAPI，NATIVE，APP
    public function __construct($appid,$secret,$mch_id,$key,$notify_url,$trade_type) {
        $this->appid = $appid;
        $this->secret = $secret;
        $this->mch_id = $mch_id;
        $this->key = $key;
        $this->notify_url = $notify_url;
        $this->trade_type =$trade_type;
    }
    /**
     *
     * 统一下单
     */
    public function unified_pay($param){
        $post_data['appid'] =  $this->appid;
        $post_data['mch_id'] =  $this->mch_id;
        $post_data['nonce_str'] =  $this->createNoncestr();
        if (empty($param['body'])){
            return 'body不能为空';
        }
        $post_data['body'] =  $param['body'];//'商品或支付单简要描述';
        if (!empty($param['detail'])){
            $post_data['detail'] = $param['detail'];// '商品名称明细列表';//可不要
        }
        if (!empty($param['attach'])){
            $post_data['attach'] =$param['attach'];//  '附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据';//可不要
        }
        if (empty($param['out_trade_no'])){
            return 'out_trade_no不能为空';
        }
        $post_data['out_trade_no'] = $param['out_trade_no'];//商户系统内部的订单号
        if ($param['total_fee']<1){
            return 'total_fee不能小余1';//订单总金额，单位为分
        }
        $post_data['total_fee'] =  $param['total_fee'];//订单总金额，单位为分
        if (empty($param['spbill_create_ip'])){
            return 'spbill_create_ip不能为空';
        }
        $post_data['spbill_create_ip'] =  $param['spbill_create_ip'];//APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
        if (!empty($param['goods_tag'])){
            $post_data['goods_tag'] =  '';//商品标记，代金券或立减优惠功能的参数 可以不要
        }
        $post_data['notify_url'] =  $this->notify_url;
        $post_data['trade_type'] =  $this->trade_type;//取值如下：JSAPI，NATIVE，APP
        if ( $this->trade_type=='NATIVE'){
            if (empty($param['product_id'])){
                return 'product_id不能为空';
            }else{
                $post_data['product_id'] =  $param['product_id'];//trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
            }
        }
        //$post_data['limit_pay'] =  '';//no_credit--指定不能使用信用卡支付
        if ($this->trade_type=='JSAPI'){
            if (empty($param['openid'])){
                return 'openid不能为空';
            }else{
                $post_data['openid'] =  $param['openid'];//trade_type=JSAPI，此参数必传
            }
        }

        $sign = $this-> create_sign($post_data);//生成签名
        $post_data['sign'] = $sign;
        //dump($post_data);exit;
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml_data = $this->arrayToXml($post_data);//生成xml
        //echo $xml_data;exit;
        $return_xml = $this->http_post($url, $xml_data);//请求返回的数据
        //dump($return_xml);
        $return_arr=$this->xmlToArray($return_xml);//转换为数组
        //dump($return_arr);
        if ($return_arr['return_code'] =='SUCCESS' and $return_arr['result_code'] =='SUCCESS'){
            $return_data['status'] = 1;
            $return_data['prepay_id'] =$return_arr['prepay_id'];
            $return_data['code_url'] =$return_arr['code_url'];
        }else{
            $return_data['status'] = 0;
            if ($return_arr['return_code'] !='SUCCESS'){
                $return_data['return_code'] = $return_arr['return_code'];
                $return_data['return_msg'] = $return_arr['return_msg'];
            }elseif (!empty($return_arr['err_code'])){
                $return_data['return_code'] = $return_arr['err_code'];
                $return_data['return_msg'] = $return_arr['err_code_des'];
            }
        }
        return $return_data;
    }
    /**
     *
     * 生成前端支付参数
     */
    public function create_payparam($prepayid){
        $post_data['appid'] = $this->appid;
        $post_data['partnerid'] = $this->mch_id;
        $post_data['prepayid'] = $prepayid;
        $post_data['package'] = 'Sign=WXPay';
        $post_data['noncestr'] = $this->createNoncestr();
        $post_data['timestamp'] = time();
        $post_data['sign'] = $this-> create_sign($post_data);//生成签名
        return $post_data;
    }
    public function js_pay($prepayid){
        $post_data['appId'] = $this->appid;
        $post_data['timeStamp'] = "time()";
        $post_data['nonceStr'] = $this->createNoncestr();
        $post_data['package'] = 'prepay_id='.$prepayid;
        $post_data['signType'] = 'MD5';
        $post_data['paySign'] = $this-> create_sign($post_data);//生成签名
        return $post_data;
    }
    /**
     *
     * 验证回调
     */
    public function chcek_notify_url(){
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $arr = $this->xmlToArray($xml);
        if ($arr['return_code']=='SUCCESS' and $arr['result_code']=='SUCCESS'){//支付成功
            $r = $this->checkSign($arr);//验证参数的合法性
            if ($r){//验证通过
                $r_data['status'] =1;
                $r_data['data'] = $arr;//返回的数据
                $r_data['msg'] = '签名验证成功';
                return $r_data;
            }else{
                $r_data['status'] =0;
                $r_data['msg'] = '签名验证失败';
                $r_data['data'] =$arr;
                return $r_data;
            }
        }else{
            $r_data['status'] =0;
            $r_data['msg'] = '回调内容错误';
            $r_data['return_msg'] = $arr['return_msg'];
            $r_data['data'] =$arr;
            return $r_data;
        }
    }
    /**
     * 验证参数的合法性
     */
    public function checkSign($arr)
    {
        $tmpData = $arr;
        unset($tmpData['sign']);
        $sign = $this->create_sign($tmpData);//本地签名
        if ($arr['sign'] == $sign) {
            return TRUE;
        }
        return FALSE;
    }


    /**
     *
     * 生成认证签名
     * create_time 2015-10-12
     * author wj
     */
    public function create_sign($data){
        $str ='';
        ksort($data);//数组排序
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
    /**
     * 	作用：产生随机字符串，不长于32位
     */
    public function createNoncestr( $length = 32 ){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @return string content
     */
    public function http_post($url,$param){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_string($param)) {
            $strPOST = $param;
            if(substr($param,0,1) == '@'){
                $strPOST = array('file'=>$param);
            }
        } else {
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$param);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }
    /**
     * GET 请求
     * @param string $url
     */
    public function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }
    /**
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }
    /**
     * 	作用：array转xml
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (1==1)
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

}