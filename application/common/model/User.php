<?php
namespace app\common\model;
use think\Model;

class User extends Model
{
    public function check($name, $password, $checkPer)
    {
        $where['login_name'] = $name;
        $where['password'] = md5($password);
        $where['per'] = $checkPer;
        return $this -> where($where) -> find();
    }

    public function getUserInfo($id)
    {
        return $this -> where('id', $id) -> find();
    }

    public function updateUser($id, $data)
    {
        foreach ($data as $key => $value) {
            if ($value != null)
                $this -> where('id', $id) -> update([$key => $value]);
        }
    }
}