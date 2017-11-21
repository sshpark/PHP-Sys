<?php
namespace app\index\controller;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use phpDocumentor\Reflection\Types\Null_;
use think\Controller;
use think\Session;

class User extends Controller
{
    /**
     * @return mixed 初始化页面
     */
    public function index()
    {
        $isLogin = Session::get('user_name') != NULL ? 'yes' : 'no';
        $this -> fetch('public/header', [
            'isLogin' => $isLogin,
            'user_name' => Session::get('user_name'),

        ]);
        return $this -> fetch();
    }

    /**
     * @param $user_name 用户名
     * @param $password 密码
     *
     * 登陆成功后设置session
     */
    public function login() {
        $user_info = input('post.');
        $find = model('user') -> check($user_info['user_name'], $user_info['password'], 0);
        if ($find != null) {
            Session::set('user_name', $find['real_name']);
            Session::set('user_id', $find['id']);
            $this -> success('登陆成功', '/', 2, 2);
        } else {
            $this -> error('登陆失败', 'index/user', 2, 2);
        }
//          $password = $_POST['password'];
//          echo $password;
    }

    /**
     * @param $name 退出的用户
     */
    public function logout($name) {
        Session::set('user_name', null);
        return $this -> success('退出成功', '/', 2, 2);
    }

    public function setting()
    {
        $isLogin = Session::get('user_name') != NULL ? 'yes' : 'no';
        $arr = model('user') -> getUserInfo(Session::get('user_id'));
        $userInfo['avater'] = $arr['avater'];
        $userInfo['email'] = $arr['email'];
        $userInfo['link'] = $arr['link'];
        $userInfo['username'] = $arr['login_name'];
        $userInfo['real_name'] = $arr['real_name'];
        $this -> fetch('public/header', [
            'isLogin' => $isLogin,
            'userInfo' => $userInfo,
        ]);
        return $this -> fetch();
    }

    public function updateUser()
    {
        $data = input('post.');
        $file = request() -> file("avater");
        if ($file) {
            $info = $file->validate(['size' => 1048576, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads/avater');
            if ($info)
                $data['avater'] = 'uploads/avater/' . $info->getSaveName();
            else
                return $this -> error($file->getError(), '/index/user/setting/');
        }
        $data['password'] = $data['password'] == null ? $data['password'] : md5($data['password']);
        model('user') -> updateUser(Session::get('user_id'), $data);
        return $this -> success('更新成功', '/index/user/setting/', 2, 2);
    }
}
