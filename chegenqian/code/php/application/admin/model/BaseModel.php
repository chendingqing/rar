<?php

namespace app\admin\model;

use think\Model;

class BaseModel extends Model
{
    //PSR-4,PSR-0
    protected function prefixImgUrl ($value,$data){
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}
