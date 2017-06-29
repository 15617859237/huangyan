<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use DB;
class UserController extends Controller
{
   /**
    *  用户添加页面
    */

   public function getAdd()
   {
        return view('admin.user.add');
   }

   public function postInsert(Request $request){
      
       //验证 数据是否必须
       $this ->validate($request,[
            'username' =>'required',
            'password' =>'required',
            'repassword'=>'required|same:password',
            'age'      =>'required',
            'phone'    =>'required',
            'email'    =>'required|email',
        ],[
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'repassword.required' => '确认密码不能为空',
            'repassword.same' => '密码不一致',
            'age.required' => '年龄不能为空',
            'phone.required' => '手机号不能为空',
            'email.required' => '邮箱不能为空',
            'email.email' =>'邮箱格式不正确',
        ]);

       //接收值
       $data = $request->except('_token','repassword');
       $data['password'] = Hash::make($data['password']);
       //注册时间
       $data['ctime'] = time();
       $data['token'] = str_random(50);

       //添加到数据库
       $res = DB::table('user')->insert($data);
       if($res){
         return redirect('/admin/user/index')->with('success','注册成功');
       }else{
        return back()->with('error','注册失败');
       }
       // dump($data);
   }

   public function getIndex(Request $request)
   {
        //获取搜索值
        $arr = $request->all();//显示条数
        $count = $request->input('count',10);
        $search = $request->input('search','');
        $all =$request ->all();
        $data = DB::table('user')->where('username','like','%'.$search.'%')->paginate($count);
        return view('admin.user.index',['data'=>$data,'request'=>$all]);
   }

   //删除
   public function getDelete($id)
   {
        $res = DB::table('user') ->where('id',$id)->delete();
        if($res){
             return redirect('/admin/user/index')->with('success','删除成功');
           }else{
            return back()->with('error','删除失败');
       }
   }

   //修改
    public function getEdit($id)
    {
        //获取数据
        $arr = DB::table('user')->where('id',$id)->first();
        //加载修改页面
        return  view('admin.user.edit',['arr'=>$arr]);
    }
    //执行修改
    public function postUpdate(Request $request)
    {
        $arr = $request ->only(['age','phone','email']);
        $id = $request->input('id');
        $res = DB::table('user')->where('id',$id)->update($arr);

        if($res){
             return redirect('/admin/user/index')->with('success','修改成功');
           }else{
            return back()->with('error','修改失败');
       }
    }
}
