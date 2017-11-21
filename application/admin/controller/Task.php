<?php
namespace app\admin\controller;
use think\Controller;
use app\common\controller\Base;

class Task extends Base
{
    public function index()
    {
        return $this -> fetch();
    }

    /**
     * @param $filename 文件名
     * 获取文件后缀名
     */
    public function getFileNameExt($filename)
    {
        return substr($filename, strpos($filename, '.'));
    }

    public function save($data, $times)
    {
        $saveData  = array(
            'img_address' => 'uploads/admin/task' . DS . date("Ymd") . '/' . $data['filename'],
            'filename' => $data['filename'],
            'date' => time(),
            'times' => $times,
        );
        model('task') -> add($saveData);
    }

    public function addTask()
    {
        $taskTimes = input('post.')['times'];
        $taskFile = request() -> file("img_address");
        if (empty($taskFile))
            $this -> error('请选择上传文件');
        $data = $taskFile->getInfo();
        $data['filename'] = md5(time()) . $this->getFileNameExt($data['name']);
        $info = $taskFile -> move(ROOT_PATH . 'public' . DS . 'uploads/admin/task' . DS . date("Ymd"), $data['filename']);
        if ($info) {
            //保存到数据库
            $this->save($data, $taskTimes);
            $this->success('文件上传成功');
        } else {
            // 上传失败获取错误信息
            $this->error($taskFile->getError());
        }

    }
}