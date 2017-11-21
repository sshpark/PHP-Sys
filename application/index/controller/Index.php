<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller
{
    public function index()
    {
        $isLogin = Session::get('user_name') != NULL ? 'yes' : 'no';
        $arr = model('user') -> getUserInfo(Session::get('user_id'));
        $userInfo['avater'] = $arr['avater'];
        $userInfo['email'] = $arr['email'];
        $userInfo['link'] = $arr['link'];
        $userInfo['username'] = $arr['login_name'];
        $userInfo['real_name'] = $arr['real_name'];
        $taskinfo = model('task') -> queryTask();
        $this -> fetch('public/header', [
            'isLogin' => $isLogin,
            'user_name' => Session::get('user_name'),
            'taskinfo' => $taskinfo,
            'userInfo' => $userInfo,
        ]);
        return $this->fetch();
    }

}
