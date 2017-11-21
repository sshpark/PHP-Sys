<?php
/**
 * Created by PhpStorm.
 * User: huangjiaming
 * Date: 2017/11/13
 * Time: 16:26
 */

namespace app\index\controller;
use think\Controller;
use think\Session;

class File extends Controller
{
    /**
     * @param $rawFileName 初始文件名
     * @param $taskTimes 第几次任务
     * @return string 文件名字
     */
    public function getFileName($rawFileName, $taskTimes)
    {
        if ($taskTimes != null)
            return Session::get('user_name') . date("Ymd") . '(' . $taskTimes . ')' . substr($rawFileName, strpos($rawFileName, '.'));
        else
            return Session::get('user_name') . date("Ymd") . substr($rawFileName, strpos($rawFileName, '.'));
    }

    /**
     * @param $rawName 初始文件名
     * @param $taskTimes 第几次任务
     * @param $kth_task 第几个任务
     */
    public function getCodeName($rawName, $taskTimes, $kth_task)
    {
        return Session::get('user_name') . date("Ymd") . '(' . $taskTimes . ')_' . '任务' . $kth_task . substr($rawName, strpos($rawName, '.'));
    }
    /**
     * @param $data 上传文件信息
     */
    public function save($data)
    {
        $saveData = array();
        $saveData['fileaddress'] = $data['fileaddress']; 
        $saveData['filename'] = $data['filename'];
        $saveData['times'] = $data['times'];
        $saveData['iscode'] = $data['iscode'];
        $saveData['username'] = Session::get('user_name');
        $saveData['filetype'] = intval($data['filetype']);
        $saveData['file_create_date'] = time();
        model('file') -> add($saveData);
    }

    /**
     * 上传工作简报以及请假条
     */
    public function uploadFile()
    {
        if (Session::get('user_name') == null)
            $this->error('请登录', '/index/user/');
        $getWork = input('post.');
        $file = request() -> file("files");
        $taskTimes = model('task') -> queryTaskTimes();
        if (empty($file))
            $this -> error('请选择上传文件');
        // 保存文件信息到数据库
        $data = $file->getInfo();
        // 第几次任务
        $data['times'] = $taskTimes;
        // 如果是请假条活着工作简报，1代表请假条，2代表工作简报
        $data['filetype'] = $getWork['filetype'];


        // 判断是否为代码上传
        if ($getWork['work'] == 0) {
	    $data['iscode'] = 0;
            if ($data['filetype'] == 1)
                $data['filename'] = $this->getFileName($data['name'], '');
            else
                $data['filename'] = $this->getFileName($data['name'], $taskTimes);
            $info = $file-> move(ROOT_PATH . 'public' . DS . 'uploads' . DS . date("Ymd"), $data['filename']);
            if ($info) {
		$data['fileaddress'] = '/uploads/' . date("Ymd") . DS . $data['filename'];
		$this->save($data);
                $this->success('文件上传成功');
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        } else {
            $data['iscode'] = 1;
            $data['filename'] = $this -> getCodeName($data['name'], $taskTimes, $data['filetype']);
            $info = $file->validate(['ext'=>'zip,html,sql,txt,pdf'])->move(ROOT_PATH . 'public' . DS . 'uploads/code' . DS . date("Ymd"), $data['filename']);
            if ($info) {
		$data['fileaddress'] = '/uploads/code/' . date("Ymd") . DS . $data['filename'];
		$this->save($data);
                $this->success('文件上传成功');
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
    }
}
