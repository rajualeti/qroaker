@extends('home')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Create User</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mobile</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Designation</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="designation" value="{{ old('designation') }}" required="required">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Role</label>
							<div class="col-md-6">
								<select name="business_type_id" required="required">
							    	<option value="">Select Role</option>
							    	@foreach($roles as $role)
							    		@if($role->id == old('role_id'))
						        			<option value="{!! $role->id !!}" selected="selected">{!! $role->name !!}</option>
						        		@else
						        			<option value="{!! $role->id !!}">{!! $role->name !!}</option>
						        		@endif
							    	@endforeach
							    </select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 text-right">
								<button type="reset" class="btn_cancel btn-primary">
									Clear
								</button>
							</div>
							<div class="col-md-6">
								<button type="submit" class="btn2green btn-primary">
									Submit
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
