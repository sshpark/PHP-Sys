<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Profile extends Controller
{
    public function index()
    {
        $arr = model('user') -> getUserInfo(Session::get('user_id'));
        $userInfo['avater'] = $arr['avater'];
        $userInfo['email'] = $arr['email'];
        $userInfo['link'] = $arr['link'];
        $userInfo['username'] = $arr['login_name'];
        $userInfo['real_name'] = $arr['real_name'];
        $isLogin = Session::get('user_name') != NULL ? 'yes' : 'no';
        $userProfile = model('file') -> query();
        $userLeaveInfo = array();
        $userWorkInfo = array();
        $userCodeInfo = array();
        foreach ($userProfile as $key => $value)
            if ($value['filetype'] == 1 && $value['iscode'] == 0)
                array_push($userLeaveInfo, $value);
            else if ($value['filetype'] == 2 && $value['iscode'] == 0)
                array_push($userWorkInfo, $value);
            else
                array_push($userCodeInfo, $value);
        $this -> fetch('public/header', [
            'userInfo' => $userInfo,
            'isLogin' => $isLogin,
            'user_name' => Session::get('user_name'),
            'leave' => $userLeaveInfo,
            'work' => $userWorkInfo,
            'code' => $userCodeInfo,
        ]);
        return $this -> fetch();
    }

}
