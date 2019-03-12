<?php
namespace app\demo\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取http传入的参数
        // 对这些参数做检验
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if (!$result)
        {
            $e = new ParameterException(
                [
                    'msg' => $this->getError(),
                ]);
            throw $e;
        }
        else
        {
            return true;
        }
    }

    /**
     * 场景验证
     * @param string $scene 验证场景
     * @return bool
     * @throws ParameterException
     * wj
     * 2018-7-14
     */
    public function doCheck($scene=''){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->scene($scene)->check($params);
        if (!$result){
            $e = new ParameterException(['msg' => $this->getError()]);
            throw $e;
        }else{
            return true;
        }
    }

    /**
     * 带参数验证
     * @param $data 验证参数
     * @param string $scene 验证场景
     * wj
     * 2018-8-8
     * @return bool
     * @throws ParameterException
     */
    public function checkParams($data,$scene=''){
        if (empty($data)){
            $e = new ParameterException(['msg' => '参数不能为空']);
            throw $e;
        }
        $result = $this->scene($scene)->check($data);
        if (!$result){
            $e = new ParameterException(['msg' => $this->getError()]);
            throw $e;
        }else{
            return true;
        }
    }
    /**
     * 判断是否为整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */
    protected function isPositiveInteger($value, $rule = '',$data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * 数据不能为空
     * @param $value 判断的数据是否为空
     * @return bool
     * wj
     * 2018-7-5
     */
    protected function isNotEmpty($value)
    {
        if (empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     *  判断是否为正整数
     * @param $value
     * @return bool
     * wj
     * 2018-8-8
     */
    public function is_number($value){
        //大于0
        if ($value<=0){
            return false;
        }
        //是数字
        if (!is_numeric($value)){
            return false;
        }
        //取整数部分
        if (floor($value) !=$value){
            return false;
        }
        return true;
    }

    /**
     * 检查图片列表的合法性
     * @param $value
     * @return bool
     * wj
     * 2018-8-8
     */
    public function checkImageList($value){
        //不能为空
        if (!$value){
            return false;
        }
        //必须是数组
        if(!is_array($value)){
            return false;
        }
        //元素不能为空
        foreach($value as $v){
            if (!$v){
                return false;
            }
        }
        return true;
    }
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) |
            array_key_exists('uid', $arrays)
        )
        {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException(
                [
                    'msg' => '参数中包含有非法的参数名user_id或者uid'
                ]);
        }

        $newArray = [];

        foreach ($this->rule as $key => $value)
        {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
    /**
     * 检查图片列表是否存在
     * wj
     * 2018-8-8
     */
    public function checkUpload(){
        $request = Request::instance();
        $params = $request->param();
        if(array_key_exists('image_list',$params)){
            if (empty($params['image_list'])){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    /**
     * 是否是手机号
     * @param $value
     * @return bool
     */
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 验证是否是手机号码或者是座机
     * wj
     * 2018-9-26
     * @param $value
     * @return bool
     */
    public function is_telphone($value){
        $isMob='^1(3|4|5|7|8)[0-9]\d{8}$^';//手机规则
        $isTel="/^([0-9]{3,4}-)?[0-9]{7,8}$/";//座机规则
        if(preg_match($isMob,$value) || preg_match($isTel,$value)){//满足其中一个条件就可以
            return true;
        }
        return false;
    }
    /**
     * 验证日期格式是否正确(ps:2018-9-26)
     * wj
     * 2018-9-26
     * @param $value
     * @return bool
     */
    public function checkDate($value){
        if (date('Y-m-d',strtotime($value)) ==$value){
            return true;
        }
        return false;
    }
}