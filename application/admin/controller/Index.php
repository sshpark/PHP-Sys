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
        $status =  $file -> delete();
        if ($status) {
            unlink($path);
            return $this->success('删除成功', '/admin', 2, 2);
        }
        else
            return $this -> error('删除失败', '/admin', 2, 2);
    }

}
