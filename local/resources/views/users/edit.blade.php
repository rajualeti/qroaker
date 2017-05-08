@extends('app')
@section('title', 'Edit User')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Create User</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('users/'.$user->id) }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PATCH">
						
				       <div class="form-group">
							<label class="col-md-4 control-label">Full Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Full Name" maxlength="{!! str_limit(Config::get('constants.input-text-limit') ) !!}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mobile</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}"  placeholder="Mobile Number" onkeypress = "return isNumber(event);" minLength="10"  maxLength="10" required="required">
							</div>
						</div>

						<div class="form-group tulip-radio">
							<label class="col-md-4 control-label no-pad">Gender</label>
							<div class="col-md-6">
								<div class="col-xs-4">
									<input type="radio" id="male" name="gender" value="1" {!! $user->gender == 1 ? 'checked="checked"' : '' !!}>
									<label for="male"><span></span>Male</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="female" name="gender" value="2" {!! $user->gender == 2 ? 'checked="checked"' : '' !!}>
									<label for="female"><span></span>Female</label>
								</div>
							</div>
						</div>
				        <div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Location" name="location" id="location" value="{{ $user->location }}" onfocus="getCityFromGoogle('location');" required="required">
							</div>
						</div>
				        
				        <div class="form-group tabs">
		                    <label class="col-md-3 control-label no-pad"></label>
							<div class="col-md-7">
		                        <ul class="nav nav-tabs" role="tablist">
		                            <li role="presentation" class="active"><a href="#caricature" aria-controls="caricature" role="tab" data-toggle="tab">Pick Caricature</a></li>
		                            <li><span class="tab-seperator">|</span></li>
		                            <li role="presentation"><a href="#browse" aria-controls="Browse" role="tab" data-toggle="tab">Browse Picture</a></li>
		                        </ul>
		                    
		                        <div class="tab-content">
		                            <div role="tabpanel" class="tab-pane active" id="caricature">
	                                    <input name="profile_caricature" id="av1" type="radio" value="img/avatars/avatar1.png" />
	                                    <label for="av1"><span><img src="{{ url('img/avatars/avatar1.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av2" type="radio" value="img/avatars/avatar2.png" />
	                                    <label for="av2"><span><img src="{{ url('img/avatars/avatar2.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av3" type="radio" value="img/avatars/avatar3.png" />
	                                    <label for="av3"><span><img src="{{ url('img/avatars/avatar3.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av4" type="radio" value="img/avatars/avatar4.png" />
	                                    <label for="av4"><span><img src="{{ url('img/avatars/avatar4.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av5" type="radio" value="img/avatars/avatar5.png" />
	                                    <label for="av5"><span><img src="{{ url('img/avatars/avatar5.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av6" type="radio" value="img/avatars/avatar6.png" />
	                                    <label for="av6"><span><img src="{{ url('img/avatars/avatar6.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av7" type="radio" value="img/avatars/avatar7.png" />
	                                    <label for="av7"><span><img src="{{ url('img/avatars/avatar7.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av8" type="radio" value="img/avatars/avatar8.png" />
	                                    <label for="av8"><span><img src="{{ url('img/avatars/avatar8.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av9" type="radio" value="img/avatars/avatar9.png" />
	                                    <label for="av9"><span><img src="{{ url('img/avatars/avatar9.png') }}" alt="" class="avatar-img" /></span></label>
	                                    
	                                    <input name="profile_caricature" id="av10" type="radio" value="img/avatars/avatar10.png" />
	                                    <label for="av10"><span><img src="{{ url('img/avatars/avatar10.png') }}" alt="" class="avatar-img" /></span></label>
		                            </div>
		                            <div role="tabpanel" class="tab-pane" id="browse">
		                            	<div class="file-preview-frame">
											<input id="file-0b" class="file" type="file" placeholder="logo" name="profile_image">
										</div>
		                            </div>
		                        </div>
		                    </div>
		                    </div>
				        <div class="form-group">
							<div class="col-md-6 col-xs-6 text-right">
								<a href="{{ url('users') }}" class="btn btn-cancel">Cancel</a>
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
