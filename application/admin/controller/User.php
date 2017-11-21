<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;

class User extends Controller
{
    /**
     * @return mixed
     * 登陆界面
     */
    public function index()
    {
        return $this -> fetch();
    }

    public function login() {
        $user_info = input('post.');
        $find = model('user') -> check($user_info['user_name'], $user_info['password'], 1);
        if ($find != null) {
            Session::set('admin', $find['real_name']);
            $this -> success('登陆成功', '/admin/', 2, 2);
        } else {
            $this -> error('登陆失败', '/admin/', 2, 2);
        }
    }
}