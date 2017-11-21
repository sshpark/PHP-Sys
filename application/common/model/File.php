<?php
namespace app\common\model;
use think\Db;
use think\Model;
use think\Session;

class File extends Model
{
    public function add($data)
    {
        return $this -> save($data);
    }

    public function query()
    {
        return $this -> where('username', Session::get('user_name')) -> select();
    }

    public function getFiles()
    {
        return $this -> select();
    }
}