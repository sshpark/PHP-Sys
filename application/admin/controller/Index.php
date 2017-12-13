<?php
namespace app\admin\controller;
use app\common\controller\Base;

class Index extends Base
{
    public function index()
    {
        $getFileList = model('file') -> getFiles();
        $this -> assign('list', $getFileList);
        return $this -> fetch();
    }

    public function del($id)
    {
        $file = model('file') -> where('id', $id) -> find();
        $path = ROOT_PATH . 'public' . DS . $file['fileaddress'];
        $status = $file -> delete();
        if ($status) {
            unlink($path);
            $arr['status'] = true;
            $arr['text'] = "删除成功";
        } else {
            $arr['status'] = false;
            $arr['text'] = "删除失败";
        }
        echo json_encode($arr);
    }
}
