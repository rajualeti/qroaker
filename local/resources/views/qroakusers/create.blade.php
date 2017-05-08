@extends('app')
@section('title', 'Create Qroak User')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Create Qroak User</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('qroak-users') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Full Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" maxlength="{!! str_limit(Config::get('constants.input-text-limit') ) !!}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Profile Image</label>
							<div class="col-md-6 file-preview-frame">
							 <input id="file-0b" class="file" type="file" placeholder="logo" name="profile_image" value="{{ old('profile_image') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder = "Email" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mobile</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"  placeholder = "Mobile no" onkeypress = "return isNumber(event);" minLength = "10"  maxLength = "10" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Secret Pin</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" value="{{ old('password') }}"  placeholder="Secret Pin" onkeypress="return isNumber(event);" minLength="4"  maxLength="4" required="required">
							</div>
						</div>

						<div class="form-group tulip-radio">
							<label class="col-md-4 control-label no-pad">Gender</label>
							<div class="col-md-6">
								<div class="col-xs-4">
									<input type="radio" id="male" name="gender" value="1" checked="checked">
									<label for="male"><span></span>Male</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="female" name="gender" value="2">
									<label for="female"><span></span>Female</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="other" name="gender" value="3">
									<label for="other"><span></span>Other</label>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">DOB</label>
							<div class="col-md-6">
								<div class="input-group date" data-date="" data-date-format="dd M yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
			                    	<input type="date" class="form-control" name="dob" value="{{ old('dob') }}" placeholder="DOB" required="required">
			    					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                		</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Address</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Location" name="location" id="location" value="{{ old('location') }}" id="location" onfocus="getCityFromGoogle('location');" required="required">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">City</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" required="required">
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-4 control-label">Roles</label>
							<div class="col-md-6">
								<div class="qroak-role-multiselect">
							    	@foreach($roles as $role)
										<h3>
											<input type="checkbox" id="role_{!! $role->id!!}" name="checked_roles[]" value="{!! $role->id !!}"/>
											<label for="role_{!! $role->id!!}"><span></span>{!! $role->display_name !!}</label>
										</h3>
									@endforeach
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-xs-6 text-right">
								<a href="{{ url('qroak-users') }}" class="btn btn-cancel">Cancel</a>
							</div>
							<div class="col-md-6 col-xs-6">
								<button type="submit" class="btn btn-submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
