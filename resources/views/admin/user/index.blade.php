@extends('admin.layout.index')

@section('css')
<link rel="stylesheet" href="text/css" href='/admin/css/page_page.css'>
@endsection
@section('content')
  <div class="mws-panel grid_8"> 
   <div class="mws-panel-header"> 
    <span><i class="icon-table"></i> Data Table with Numbered Pagination</span> 
   </div> 
   <div class="mws-panel-body no-padding"> 
    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
     <div id="DataTables_Table_1_length" class="dataTables_length">
     <form action="/admin/user/index" method='get'>
      <label>显示 <select size="1" name="count" aria-controls="DataTables_Table_1">
      		<option value="10" @if(!empty($request['count']) && $request['count'] == 10) selected @endif>10</option>
      		<option value="20" @if(!empty($request['count']) && $request['count'] == 20) selected @endif>20</option>
      		<option value="30" @if(!empty($request['count']) && $request['count'] == 30) selected @endif>30</option>
      		</select> 条</label>
     </div>
     <div class="dataTables_filter" id="DataTables_Table_1_filter">
      <label>关键字: <input type="text" name='search' placeholder="用户名" value="{{ $request['search'] or '' }}" /></label>
      <button>搜索</button>
     </div>
     </form>
     <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info"> 
      <thead> 
       <tr role="row">
        	<th>ID</th>
        	<th>用户名</th>
        	<th>邮箱</th>
        	<th>手机号</th>
        	<th>年龄</th>
        	<th>注册时间</th>
        	<th>操作</th>
       </tr> 
      </thead> 
      <tbody role="alert" aria-live="polite" aria-relevant="all"> 
       	@foreach($data as $k => $v)
       <tr class="odd"> 
	       	<td>{{ $v['id'] }}</td>
	       	<td>{{ $v['username'] }}</td>
	       	<td>{{ $v['email'] }}</td>
	       	<td>{{ $v['phone'] }}</td>
	       	<td>{{ $v['age'] }}</td>
	       	<td>{{ date('Y-m-d H:i:s',$v['ctime']) }}</td>
	       	<td>
	       		<a href="/admin/user/delete/{{ $v['id'] }}">删除</a>
	       		<a href="/admin/user/edit/{{ $v['id'] }}">修改</a>
	       	</td>
       </tr>
       @endforeach
      </tbody>
     </table>
     <div class="dataTables_info" id="DataTables_Table_1_info">
     分页
     </div>
     <!-- <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
      <a tabindex="0" class="first paginate_button paginate_button_disabled" id="DataTables_Table_1_first">First</a>
      <a tabindex="0" class="previous paginate_button paginate_button_disabled" id="DataTables_Table_1_previous">Previous</a>
      <span><a tabindex="0" class="paginate_active">1</a><a tabindex="0" class="paginate_button">2</a><a tabindex="0" class="paginate_button">3</a><a tabindex="0" class="paginate_button">4</a><a tabindex="0" class="paginate_button">5</a></span>
      <a tabindex="0" class="next paginate_button" id="DataTables_Table_1_next">Next</a>
      <a tabindex="0" class="last paginate_button" id="DataTables_Table_1_last">Last</a>
     </div> -->
     <div class='' id="page_page">
     	{!! $data->appends($request)->render() !!}
     </div>
    </div> 
   </div> 
  </div> 
@endsection