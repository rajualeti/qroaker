@extends('home')
@section('title', 'Edit Qroak User')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Qroak User</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('qroak-users/'.$qroakuser->qroak_user_id) }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PATCH">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Full Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ $qroakuser->user->name }}" placeholder="Full Name" maxlength="{!! str_limit(Config::get('constants.input-text-limit') ) !!}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Profile Image</label>
							<div class="col-md-6 file-preview-frame">
							 <input id="file-0b" class="file" type="file" placeholder="logo" name="profile_image" value="{{ $qroakuser->user->profile_image }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ $qroakuser->user->email }}" placeholder = "Email" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mobile</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" value="{{ $qroakuser->user->mobile }}"  placeholder = "Mobile no" onkeypress = "return isNumber(event);" minLength = "10"  maxLength = "10" required="required">
							</div>
						</div>

						<div class="form-group tulip-radio">
							<label class="col-md-4 control-label no-pad">Gender- {{ $qroakuser->user->gender }}</label>
							<div class="col-md-6">
								<div class="col-xs-4">
									<input type="radio" id="male" name="gender" value="1" {!! $qroakuser->user->gender == 1 ? 'checked' : '' !!}>
									<label for="male"><span></span>Male</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="female" name="gender" value="2" {!! $qroakuser->user->gender == 2 ? 'checked' : '' !!}>
									<label for="female"><span></span>Female</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="other" name="gender" value="3" {!! $qroakuser->user->gender == 3 ? 'checked' : '' !!}>
									<label for="other"><span></span>Other</label>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">DOB</label>
							<div class="col-md-6">
								<div class="input-group date" data-date="" data-date-format="dd M yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
			                    	<input type="date" class="form-control" name="dob" value="{{ $qroakuser->user->dob }}" placeholder="DOB" required="required">
			    					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                		</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Address</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Address" name="address" value="{{ $qroakuser->address }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Location" name="location" value="{{ $qroakuser->user->location }}" id="location" onfocus="getCityFromGoogle('location');" required="required">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">City</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="City" name="city" value="{{ $qroakuser->city }}" required="required">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Roles</label>
							<div class="col-md-6">
								<div class="qroak-role-multiselect">
							    	@foreach($roles as $role)
										<h3>
											@if(in_array($role->id, $user_roles))
												<input type="checkbox" id="role_{!! $role->id!!}" name="checked_roles[]" value="{!! $role->id !!}" checked="checked"/>
											@else
												<input type="checkbox" id="role_{!! $role->id!!}" name="checked_roles[]" value="{!! $role->id !!}"/>
											@endif
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
								<button type="submit" class="btn btn-submit">Update</button>
							</div>
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
