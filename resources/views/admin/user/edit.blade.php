@extends('admin.layout.index')

@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>Inline Form</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form class="mws-form" action="/admin/user/update" method='post'>
    		{{ csrf_field() }}
    		<div class="mws-form-inline">
    		@if (count($errors) > 0)
    			<div class="mws-form-message error">
    				这里有错误
                    <ul>
                    	@foreach($errors->all() as $error)
                    		<li>{{ $error }}</li>
                    	@endforeach
                    </ul>
                </div>
                @endif
    			<div class="mws-form-row">
    				<label class="mws-form-label">用户名</label>
    				<div class="mws-form-item">
    					{{ $arr['username'] }}
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">年龄</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='age' value='{{ $arr['age'] }}'>
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">手机号</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='phone' value='{{ $arr['phone'] }}'>
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">邮箱</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='email' value='{{ $arr['email'] }}'>
    				</div>
    			</div>
                <div class="mws-form-row">
                    <label class="mws-form-label">注册时间</label>
                    <div class="mws-form-item">
                        {{ date('Y-m-d H:i:s',$arr['ctime']) }}
                    </div>
                </div>
    		</div>
            <input type="hidden" name="id" value="{{ $arr['id'] }}">
    		<div class="mws-button-row">
    			<input type="submit" value="修改" class="btn btn-danger">
    			
    		</div>
    	</form>
    </div>    	
</div>
@endsection