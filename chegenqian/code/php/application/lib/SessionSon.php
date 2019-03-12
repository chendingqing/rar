<?php
/**
 * session 优化
 * User: Dell
 * Date: 2018/7/11
 * Time: 22:24
 */
namespace app\lib;

use think\Session;

class SessionSon extends Session{
    /**
     * @param string $name
     * @param null $prefix
     * @return string| array
     * wj
     * 2018-7-11
     */
    public static function get_session($name = '', $prefix = null){
        $array = self::get($name,$prefix);
        if (empty($array)){
            return null;
        }
        if (!is_array($array)){
            return null;
        }
        if (!array_key_exists('session_expire',$array)){
            return null;
        }
        if ($array['session_expire']<=0){
            return $array['value'];
        }
        $session_start_time = $array['session_start_time'];//设置时间
        $session_expire = $array['session_expire'];//过期时间 秒
        if((time()-$session_start_time)>=$session_expire){//已过期
            self::delete($name);
            return null;
        }
        return $array['value'];
    }

    /**
     * @param $name 名字
     * @param string $value 内容
     * @param int $session_expire 到期时间
     * @param null $prefix
     * wj
     * 2018-7-11
     */
    public static function set_session($name,$value = '',$session_expire=0,$prefix = null){
        if ($session_expire<=0){//如果没有设置有效时间，就读取配置
            $session_expire = config('session_expiry_time');
        }
        $array = ['value'=>$value,'session_start_time'=>time(),'session_expire'=>$session_expire];
        self::set($name,$array,$prefix);
    }
}