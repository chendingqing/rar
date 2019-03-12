<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 14:21
 */

namespace app\admin\controller;
use app\admin\model\Node as NodeModel;
use app\lib\page\pageUrl;

class Efoam extends BaseController
{
    /*
     * 卢浩    创建用于测试上传图片：：：：
     */
    public function upload(){
        return $this->fetch();
    }

    /*
     * 卢浩    创建用于测试分页：：：：
     */
    public function page(){
        $model = new NodeModel;
        $list = $model->order('node_id desc')->paginate(10);
        $page = new pageUrl($list->total,$list->listRows());
        $this->assign('page',$page->show());
        $this->assign('total',$list->total);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     * 图片上传处理函数
     */
    public function picUpload(){
        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $file_path = $info->getSaveName();
                $path ='/uploads/'.strtr($file_path,"\\","/");
                if($path)
                    return json(['code'=>200,'msg'=>'上传成功','data'=>['path'=>$path]],200);
                return json(['code'=>400,'msg'=>'上传失败'.$file->getError(),'data'=>['path'=>$path]],200);
            }else{
                return json(['code'=>400,'msg'=>'上传失败,无文件上传','data'=>'failed'],400);
            }
        }
    }
    function post(){
        dump($_POST);
    }

}