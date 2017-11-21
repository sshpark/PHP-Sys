<?php
namespace app\common\model;
use think\Model;

class Task extends Model
{
    public function queryTaskTimes()
    {
        return $this -> max('times');
    }


    public function add($data)
    {
        return $this -> save($data);
    }

    public function queryTask()
    {
        $arr = array();
        $arr['times'] = $this -> queryTaskTimes();
        $imgsrc = $this -> where('times', $arr['times']) -> field('img_address') -> find();
        $arr['imgsrc'] = $imgsrc['img_address'];
        return $arr;
    }
}
