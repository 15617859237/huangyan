<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use DB;
use Mail;
use App\Http\Controllers\HttpController;

class ZhuceController extends Controller
{
    
    public function getAdd()
    {
        return view('home.zhuce.add');
    }

    public function postInsert(Request $request)
    {
    	  //验证 数据是否必须
       $this ->validate($request,[
       		'email'    =>'required|email',
            'password' =>'required',
            'repassword'=>'required|same:password',
        ],[
            'email.required' => '邮箱不能为空',
            'email.email' =>'邮箱格式不正确',
            'password.required' => '密码不能为空',
            'repassword.required' => '确认密码不能为空',
            'repassword.same' => '密码不一致',
        ]);

    	$data = $request ->except('_token','repassword');
    	
    	$data['password'] = Hash::make($data['password']);
    	$data['ctime'] = time();
    	$data['token'] = str_random(50);
    	// dump($data);
    	

    	// 发送邮件
    	$id = DB::table('users')->insertGetId($data);
       	if($id){
	    	self::mailto($data['email'],$id,$data['token']);
    	}
    }
    public static function mailto($email,$id,$token)
    {
    	Mail::send('home.mail.index', ['id' => $id,'token'=>$token,'email'=>$email], function ($m) use ($email) {
   
            $m->to($email)->subject('这是一封注册邮件');
        });
    }

    public function getJihuo(Request $request)
    {
    	$arr = $request ->all();
    	$token = DB::table('users')->where('id',$arr['id'])->select('token')->first();
    	if($arr['token'] == $token['token']){
	    	$res = DB::table('users')->where('id',$arr['id'])->update(['status'=>1,'token'=>str_random(50)]);
	    	if($res){
	    		echo '激活成功';
	    	}else{
	    		echo '激活失败';
	    	}
	    }else{
	    	return redirect('/home/zhuce/add')->with('error','验证失败');
	    }
    }

    //处理添加
    public function postInsert2(Request $request)
    {	

    	//手机号注册
    	$code = session('phone_code');
    	$phone_code = $request ->only('phone_code');
    	$data = $request ->except('_token','phone_code');
    	
    	$data['ctime'] = time();
    	$data['token'] = str_random(50);
    	if($code == $phone_code['phone_code']){
    		DB::table('user_phone')->insert($data);
    		return '注册成功';
    	}else{
    		
    		return redirect('/home/zhuce/add')->with('error','注册失败');
    	}


    }

    public function getPhone(Request $request)
    {	
    	$phone = $request->input('phone');
    	$res = self::phoneto($phone);
  		echo $res;
    }

    public static function phoneto($phone)
    {	
    	$phone_code = rand(1000,9999);
    	session(['phone_code'=>$phone_code]);
    	$str = 'http://106.ihuyi.com/webservice/sms.php?method=Submit&account=C72793654&password=8f2ca413965c70e3985b3f6f97ee8bcb&format=json&mobile='.$phone.'&content=您的验证码是：'.$phone_code.'。请不要把验证码泄露给其他人。';
    	$res = HttpController::get($str);
    	return $res;
    }
}
