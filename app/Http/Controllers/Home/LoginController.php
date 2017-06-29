<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('home.login.login');
    }

    public function postInsert(Request $request)
    {
        $data = $request ->except('_token');
        $res = DB::table('user_phone')->where('phone',$data['phone'])->first();
        if(!$res){
            return back()->with('error','用户名不存在');
        }else{
            if($data['password'] == $res['password']){
                 return '跳转到前台主页面';
                // return redirect('/home/index/index');
            }else{
                return back()->with('error','用户名或密码错误');
            }
        }
    }
}
