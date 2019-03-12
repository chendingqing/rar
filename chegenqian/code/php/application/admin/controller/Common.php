<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/7
 * Time: 22:50
 */
namespace app\admin\controller;
use think\Controller;


class Common extends Controller{
    /**
     * @return \think\response\Json
     * @throws \app\lib\exception\UploadException\
     */
    public function upload(){
        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $file_path = $info->getSaveName();
                $path ='/uploads/'.strtr($file_path,"\\","/");
                return json(['code'=>1,'path'=>$path],200);
            }else{
                $error =  $file->getError();
                throw new \app\lib\exception\UploadException(['msg'=>$error]);
            }
        }
    }
}