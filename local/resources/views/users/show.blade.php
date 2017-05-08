@extends('app')
@section('title', 'User Profile')
@section('content')

<div class="container main-bg">
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	
	<div class="alert alert-success" role="alert" style="display:none;"><span class="result"></span> </div>
	<div class="alert alert-danger" role="alert" style="display:none;"><span class="result"></span></div>
	
	<div class="row">
	<div class="col-md-12">
	    <div class="headings-h2"><h2 style="padding-top:0px;">{{ trans('labels.profile') }}</h2></div>
		<div class="find-truck-icns" style="padding-top:0px;">
			<nav id="colorNav">
				<ul>
					<li><a href="javascript:void(0);"><img src="{!! Request::root() !!}/img/settings.png"></a>
						<ul>
							@if(Auth::user()->id != $profile->id)
								@if(Auth::user()->hasRole('admin') || Auth::user()->can('reset-user-password'))
									<li><a href="javascript:void(0);" data-toggle="modal" data-target="#reset_password_confirmation_modal">Reset Password</a></li>
								@endif
			
								<!-- @if(Auth::user()->hasRole('admin') || Auth::user()->can('block-user'))
									<li>
										@if($profile->status == 1)
											<a href="javascript:void(0);" data-toggle="modal" data-target="#user_inactive_confirmation_modal">Block User</a>
										@else
											<a href="javascript:void(0);" data-toggle="modal" data-target="#user_active_confirmation_modal">Unblock User</a>
										@endif
									</li>
								@endif -->
							@endif
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
				
	<div class="clearfix"></div>
	
	<div class="col-md-12">
		<div class="qroak-div">
			<div class="row dark-bg">
				<div class="col-sm-6 find-truck-icns text-right">
					@if(Auth::user()->hasRole('admin') || Auth::user()->can('edit-user') || (Auth::user()->can('user-edit-own-profile')  && Auth::id() == $profile->id))
						<a href="{!! url('users/'.$profile->id.'/edit') !!}" class="edit-profile"><i class="fa fa-pencil"></i> Edit Details</a>
					@endif
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-7">
					<ul class="comp-details">
						<li class="col-xs-6 col-sm-4 col-md-3">
							@if(!empty($profile->user->image))
		                		<img src="{{ url($profile->image) }}" class="profile-image-big" alt="Profile Image">
		                	@else
		                		<img src="{{ url('img/default-user.png') }}" class="profile-image-big" alt="Profile Image">
		                	@endif
						</li>
						<li class="col-xs-6 col-sm-8 col-md-9">
							<h2>{!! $profile->name !!}</h2>
							<span class="btm-txt">
								ID: <label><strong>{!! $profile->id !!}</strong></label><br>
								Location: <label>{!! $profile->location !!}</label><br>
								Gender: <label>{!! gender($profile->gender) !!}</label><br>
								Joined on: <label> {{ format_date($profile->created_at) }}</label>
							</span> 
						</li>
					</ul>
				</div>
				<div class="col-sm-5">
                    <ul class="comp-ownr-details">
	                    <li>
		                    <h2>Personal Details</h2>
		                    <span class="btm-txt">
		                 	 Email: <label>{!! $profile->email !!} </label><br>
		                 	 Phone: <label>{!! $profile->mobile !!} </label>
		                    </span> 
	                    </li>
                    </ul>
            	</div>
			</div>
			</div>
		</div>
	</div>
</div>

<!-- password reset modal -->
<div class="modal fade bs-example-modal-md" id="reset_password_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="text-center modal-body">
				<h4  style="text-align: center; line-height: 24px;"> Are you sure you want to Reset Password? </h4>
			</div>
			<div class="modal-footer modal-footer-confirm">
				<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" onclick="resetPassword({{ $profile->id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- password reset modal -->
		                	
<!-- confirmation Active User modal  -->
<div class="modal fade bs-example-modal-md" id="user_active_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" >
			<div class="text-center modal-body">
				<h4 id="status_modal_text" style="text-align: center;line-height: 24px;">Are you sure you want to Unblock <br> "{{ $profile->name }}" ?</h4>
			</div>
			<div class="modal-footer modal-footer-confirm">
				<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close close_{{ $profile->qroak_user_id }}" data-dismiss="modal">
        		<button type="button" onclick="inactivateUser({{ $profile->id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- confirmation Active User modal -->				

<!-- confirmation Inactive User modal  -->
<div class="modal fade bs-example-modal-md" id="user_inactive_confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" >
			<div class="text-center modal-body">
				<h4 id="status_modal_text" style="text-align: center;line-height: 24px;">Are you sure you want to Block <br> "{{ $profile->name }}" ?</h4>
			</div>
			<div class="modal-footer modal-footer-confirm">
				<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close close_{{ $profile->qroak_user_id }}" data-dismiss="modal">
        		<button type="button" onclick="activateUser({{ $profile->id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- confirmation Inactive User modal -->


<script type="text/javascript">

function blockUser(id) {

	$.ajax({
        url: '{!! URL("block-user") !!}/'+id,
        type: 'POST',
        beforeSend: function (xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');
          	if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
          	}
     	},
        data: { status: 0 } ,
        success: function (response) {
	        if(response.status == 'success') {
	        	$('.alert-success .result').text(response.msg);
		        $('.alert-success').show();
		        $('.alert-danger').hide();
		        window.setTimeout(function(){ location.reload(); },1000);
	        } 
	        else {
	        	$('.alert-danger .result').text(response.msg);
		        $('.alert-success').hide();
		        $('.alert-danger').show();
	       }
        },
        error: function () {
        	$('.result').text('Something went wrong!');
        	$('.alert-success').hide();
	        $('.alert-danger').show();
		}
    });
}

function activateUser(id) {

	$.ajax({
        url: '{!! URL("unblock-user") !!}/'+id,
        type: 'POST',
        beforeSend: function (xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');
          	if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
          	}
     	},
        data: { status: 1 } ,
        success: function (response) {
	        if(response.status == 'success') {
	        	$('.alert-success .result').text(response.msg);
		        $('.alert-success').show();
		        $('.alert-danger').hide();
		        window.setTimeout(function(){ location.reload(); },1000);
	        } 
	        else {
	        	$('.alert-danger .result').text(response.msg);
		        $('.alert-success').hide();
		        $('.alert-danger').show();
	       }
        },
        error: function () {
        	$('.result').text('Something went wrong!');
        	$('.alert-success').hide();
	        $('.alert-danger').show();
		}
    });
}

function resetPassword(id) {

	$.ajax({
		url: '{{ URL("reset-password") }}/'+id,
        type: 'POST',
        beforeSend: function (xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');

			if (token) {
				return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			}
		},
		success: function( data ) {
			$('.result').text(data.msg);
			$('.alert-success').show();
		},
		error: function( data ) {
			$('.alert-denger').show();
		}
	});
}

</script>
@endsection
