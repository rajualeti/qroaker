@extends('app')
@section('title', 'Qroak Users')
@section('content')
	
<div class="container main-bg">
	@if(Session::get('success_message'))
		<div class="alert alert-success" role="alert"><strong><span class="result">{!! Session::get('success_message') !!}</span></strong></div>
	@else
		<div class="alert alert-success" role="alert" style="display: none;"><strong><span class="result"></span></strong></div>
	@endif
	<div class="alert alert-danger" role="alert" style="display: none;"><strong><span class="result"></span></strong></div>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	
	<div class="row">
		<div class="col-md-12">
			<div class="headings-h2">
                <h2>{{ trans('labels.qroak_users') }}</h2>
				<div class="selectBox1">
					<input value="value 1" class="admin_users" type="hidden">
					<a href="#" class="popover-link" rel="user_switch" data-popover-content=".user_switch"><span class="selectArrow1"></span></a>
			        <div class="hide">
			         	<div class="user_switch">
			              <ul class="profile_pos">
			             	<li><a href="{{ url('qroak-users') }}">{{ trans('labels.qroak_users') }}</a></li>
		              		<li><a href="{{ url('roles') }}">{{ trans('labels.qroak_roles') }}</a></li>
			              </ul>
			           </div>
		         	</div>
				</div>
		        <div class="find-truck-icns">
		        
		        <div id="search_1">
		        	<input class="search clearable" placeholder="Search" id="table_search" type="text">
			     </div>
			 		@if(Auth::user()->can('create-qroakuser')|| Auth::user()->hasRole('admin'))
			        	<a href="{{ url('qroak-users/create') }}"><i class="fa fa-plus"></i> New Qroak User</a>
			       	@endif
				</div>
			</div>
		</div> 
	</div>                

	<div class="clearfix"></div>
	
	<div class="col-md-12 no-pad">
		<div class="qroak-div">
			<table class="footable searchable">
                <thead>
                     <tr>
                        <th class="expand"></th>
                        <th></th>
                        <th data-hide="phone,tablet"></th>
                        <th data-hide="phone,tablet"></th>
                        <th data-hide="phone"></th>
                        <th data-hide="phone"></th>
                    </tr>
				</thead>
                
                <tbody>

                	@if(count($qroakusers) > 0)

	                	@foreach($qroakusers as $user)
	                	
	                	<tr id="row_{{ $user->qroak_user_id }}">
	
	                    	<td class="expand footable-first-column">
		                    	@if(!empty($user->user->image))
		                		<img src="{{ url($user->user->image) }}" class="profile-image" alt="Profile Image">
		                		@else
		                		<img src="{{ url('img/default-user.png') }}" class="profile-image" alt="Profile Image">
		                		@endif
	                    	</td>
	
	                    	<td><div style="text-align:left;">
	                    		<a href="{{ URL('qroak-users', $user->qroak_user_id) }}" title="{!! $user->user->name !!}" data-toggle="tooltip" data-placement="bottom">{!! $user->user->name !!}</a>
								<br><span class="btm-txt"><label><strong>{!! $user->qroak_user_id !!}</strong> | {!! $user->user->location !!} </label></span></div></td>
	
	                    	<td><div><span class="btm-txt"><label>{!! $user->user->email !!}</label> | <label>{!! $user->user->mobile !!} </label></span></div></td>
	                    	<td>
	                    		<div class="truck-capicity"><span style="float: left;">Roles: </span>
									<?php $first = true; ?>
									<label>
		                    		@foreach($user->user->roles as $role)
				                    	<?php if ($first) $first = false;  else  echo ",<br>"; ?>
										{!! $role->display_name !!}
			                    	@endforeach
			                    	</label>
		                    	</div>
	                    	</td>
								
							 @if(Auth::user())
	                			@if(Auth::user()->hasRole('admin') || Auth::user()->can('edit-qroakuser') || (Auth::user()->can('edit-own-profile')  && Auth::id() == $user->id))
			                    	<td><a href="{!! url('qroak-users/'.$user->qroak_user_id.'/edit') !!}"><i class="fa fa-pencil custom"></i></a></td>
			                    @else
			                    	<td>&nbsp;</td>
			                    @endif
			                 @endif
	
							@if(Auth::user())
	                			@if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-qroakuser'))
	                    			<td class="footable-last-column"><a href="#" data-toggle="modal" data-target="#delete_modal_{{ $user->qroak_user_id }}"><i class="fa fa-remove custom"></i></a></td>
	                    		@else
			                    	<td class="footable-last-column">&nbsp;</td>
	                    		@endif
	                    	@endif	
	
							<!-- Delete modal tulip -->
	                  	  	<div class="modal fade bs-example-modal-md" id="delete_modal_{{ $user->qroak_user_id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  							<div class="modal-dialog modal-md" role="document">
	 							   <div class="modal-content">
	     								 <div class="text-center modal-body">
	     								 <h5 class="" id="myModalLabel">Are you sure you want to delete <strong>{!! $user->user->name !!}</strong>?</h5>
	     								 </div>
										<div class="modal-footer modal-footer-confirm">
       										<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">
        									<button type="button" onclick="deleteQroakUser({{ $user->qroak_user_id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
                                          </div>
   									 </div>
  								</div>
							</div>
							<!-- Delete modal tulip -->
                    	</tr>
	
						@endforeach

                    @else
                    	<tr><td colspan="5">{{ trans('labels.no_results_found') }}</td></tr>
                    @endif
                  </tbody>
			</table>
		</div>
	</div>
</div>
           
<script>         

$(function(){
$('[rel="user_switch"]').popover({
	container: 'body',
	html: true,
	placement: "bottom",
	content: function () {
		var clone = $($(this).data('popover-content')).clone(true).removeClass('hide-menu');
		return clone;
	  }
	 }).click(function(e) {
	e.preventDefault();
});
});

$(document).click(function (e) {
$('[rel="user_switch"]').each(function () {
	if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
		$(this).popover('hide'); // this hides popover, but content remains
		return;
	}
});
});

function deleteQroakUser(qroak_user_id) {
	
	var deleteUrl = "{{ url('qroak-users').'/' }}"+qroak_user_id;
	
	$('.alert-success').hide();
	$('.alert-danger').hide();

	$.ajax({
      url: deleteUrl ,
      type: 'DELETE',
      beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function( msg ) {
            if ( msg.status === 'success' ) {
				$('#row_'+qroak_user_id).fadeOut(1000,function(){
					$('#row_'+qroak_user_id).remove();
					$('.alert-success .result').text(msg.msg);
					$('.alert-success').show();
				}); 
            }
            else
            {
				$('.alert-danger .result').text(msg.msg);
	        	$('.alert-danger').show();
			}

        },
        error: function( msg ) {
			$('.alert-danger .result').text('Something went wrong');
			$('.alert-danger').show();
        }
	});
}
           
 </script> 
@endsection
           
