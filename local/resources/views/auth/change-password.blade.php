@extends('home')
@section('title', 'Change Password')
@section('content')

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
					@if(Session::has('success_message'))
						<div class="alert alert-success" role="alert"><span class="result">{{ session('success_message') }}</span> </div>
					@else
						<div class="alert alert-success" role="alert" style="display:none;"><span class="result"></span> </div>	
					@endif
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('update-password') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="id" value="{{ Auth::id() }}">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Old Password</label>
							<div class="col-md-6">
								<input  type="password" class="form-control" name="old_password" autocomplete="new-password" placeholder="Old Password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">New Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="new_password" autocomplete="new-password" id="new_password" minLength="5" placeholder="New Password"  title="Password should be alphanumeric and length should be atleast 6" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d][A-Za-z\d!#@$]{5,}$" onfocus="focusFunction()" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm New Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password" id="confirm_password" minLength="5"  title="Password should be alphanumeric and length should be atleast 6" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,}$" placeholder="Confirm New Password"  required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-xs-6 text-right">
								<button type="reset" class="btn btn_cancel" onclick="window.history.go(-1);">
									Cancel
								</button>
							</div>
							<div class="col-md-6 col-xs-6">
								<button type="submit" class="btn btn_blue">
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

<script type="text/javascript">
								
function focusFunction() {
	$("#new_password").passwordValidator({
		require: ['length','digit','lower','blank','special'],
		length: 6
	});
}
 
</script> 
@endsection
