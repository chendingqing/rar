<?php
/**
 * 图片
 * User: wj
 * Date: 2018/8/8
 * Time: 11:11
 */
namespace app\admin\logic;
use app\admin\validate\ImageList as ImageListValidate;
use app\admin\model\ImageList as ImageListModel;
use app\lib\exception\Fail;
class ImageList extends BaseLogic{
    /**
     *  添加图片
     * @param $params
     * $params['relation_id'] 关联id
     * $params['image_type'] 关联类型
     * $params['image_list'] 图片列表
     * @return bool
     * @throws Fail
     * wj
     * 2018-8-8
     */
    static public function add_img($params){
        //验证参数
        $validate = new ImageListValidate();
        $validate->checkParams($params);
        $imageModel = new ImageListModel();
        //删除图片
        $map['relation_id'] = array('eq',$params['relation_id']);
        $map['image_type'] = array('eq',$params['image_type']);
        $imageModel->where($map)->delete();
        //添加图片
        $data = [];
        $i = 0;
        foreach($params['image_list'] as $v){
            if (!$v){
                continue;
            }
            $data[$i]['relation_id'] = $params['relation_id'];
            $data[$i]['image_type'] = $params['image_type'];
            $data[$i]['image_url'] = $v;
            $i++;
        }
        if (!$data){
            throw new Fail(['code'=>402,'errorCode'=>20001,'msg'=>'图片不能为空']);
        }
        $result = $imageModel->saveAll($data);
        if (!$result){
            throw new Fail(['code'=>402,'errorCode'=>20002,'msg'=>'图片添加失败']);
        }
        return true;
    }
}