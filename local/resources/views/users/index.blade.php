@extends('app')
@section('title', 'Users')
@section('content')
	
<!-- Content starts here-->
<div class="container main-bg">
	@if(session()->has('success_message'))
  		<div class="alert alert-success" role="alert"><span class="result">{{ session('success_message') }}</span></div>
 	@else
 		<div class="alert alert-success" role="alert" style="display:none;"><span class="result"></span></div>
 	@endif
 	
    <div class="alert alert-danger" role="alert" style="display:none;"><span class="result"></span></div>
    
	<div class="row">

		<div class="col-md-12">

        	<div class="headings-h2">
                <h2>{{ trans('labels.users') }}</h2>
				
		        <div class="find-truck-icns">
		        
		        <div id="search_1">
		        	<input class="search clearable" placeholder="Search" id="table_search" type="text">
			    </div>
			 		@if(Auth::user()->can('create-user')|| Auth::user()->hasRole('admin'))
			        	<a href="{{ url('users/create') }}"><i class="fa fa-plus"></i> New User</a>
			       	@endif
				</div>
			</div>

		</div> 

	</div>                

	<div class="clearfix"></div>

	<div class="col-md-12 no-pad">

		<div class="qroak-div">

			<table class="footable searchable" >

                <thead>
                    <tr>
                        <th class="expand"></th>
                        <th></th>
                        <th data-hide="phone,tablet"></th>
                        <th data-hide="phone"></th>
                        <th data-hide="phone"></th>
                        <th data-hide="phone"></th>
                        <th></th>
                    </tr>
				</thead>

                <tbody>
                @if(count($users) > 0)
					@foreach($users as $user)
		            	<tr class="load-more" id="row_{{ $user->id }}">
		
		                	<td class="expand footable-first-column">
		                    	@if(!empty($user->image))
		                		<img src="{{ url($user->image) }}" class="profile-image" alt="Profile Image">
		                		@else
		                		<img src="{{ url('img/default-user.png') }}" class="profile-image" alt="Profile Image">
		                		@endif
	                    	</td>
		
							<td><div style="text-align:left;">
	                    		<a data-original-title="{{ $user->name }}" href="{{ url('users/'.$user->id) }}" title="" data-toggle="tooltip" data-placement="bottom">{{ $user->name }}</a>
								<br><span class="btm-txt"><label>{{ $user->id }} | {{ gender($user->gender) }} </label></span></div></td>
	
	                    	<td><div>{{ $user->mobile }}<br><span class="btm-txt"><label>{{ $user->email }}</label></span></div></td>
	
	                    	<td><div>{{ $user->location }}</div></td>
	
	                    	<td>
		                    	@if(Auth::user()->hasRole('admin') || (Auth::user()->can('edit-user')  && (Auth::id() == $user->user_id || Auth::user()->user_type == 1)))
		                    		<a href="{{ url('users/'.$user->id.'/edit') }}"><i class="fa fa-pencil custom"></i></a>
		                    	@endif
	                    	</td>
			                    		                 
							<td>
								@if(Auth::user()->can('delete-user')|| Auth::user()->hasRole('admin'))
									<a href="javascript:void(0);" data-toggle="modal" data-target="#modal_delete_user_{!! $user->id !!}"><i class="fa fa-remove custom"></i></a>
								@endif
							</td>
							
							<td class="footable-last-column">
								<ul class="nav navbar-right drops">
						       		<li class="dropdown user-box"><a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
										<ul class="dropdown-menu dropdown-user">
				                    		@if(Auth::user()->hasRole('admin') || Auth::user()->can('view-users'))
				                    			<li><a href="{{ url('users/'.$user->id) }}"><i class="fa fa-user"></i> Profile</a></li>
				                    		@endif
				                    		
					                    	@if(Auth::user()->hasRole('admin') || Auth::user()->can('reset-user-password'))
												<li><a href="javascript:void(0);" data-toggle="modal" data-target="#reset_password_confirmation_modal_{{ $user->id }}"><i class="fa fa-key"></i> Reset Password</a></li>
											@endif
											
											@if(Auth::user()->can('block-user') || Auth::user()->hasRole('admin'))
											<li>
												@if($user->status == 1)
													<a href="javascript:void(0);" data-toggle="modal" data-target="#inactivate_user_confirmation_modal_{{ $user->id }}"><i class="fa fa-lock"></i> Block User</a>
												@else
													<a href="javascript:void(0);" data-toggle="modal" data-target="#activate_user_confirmation_modal_{{ $user->id }}"><i class="fa fa-unlock"></i> Unblock User</a>
												@endif
											</li>
											@endif
										</ul>
									</li>
								</ul>
								
								<!-- password reset modal -->
								<div class="modal fade bs-example-modal-md" id="reset_password_confirmation_modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
								  <div class="modal-dialog modal-md">
								    <div class="modal-content">
								   
								     <div class="text-center modal-body">
								     	<h4  style="text-align: center; line-height: 24px;"> Are you sure you want to Reset Password? </h4>
									</div>
									<div class="modal-footer modal-footer-confirm">
									
								        <input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;
								        <button type="button" onclick="resetPassword({{ $user->id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
								
								     </div>
								    </div>
								  </div>
								</div>
								<!-- password reset  modal -->
								
								<!-- confirmation active user modal  -->
								<div class="modal fade bs-example-modal-md" id="activate_user_confirmation_modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
					         		<div class="modal-dialog modal-md" role="document">
						             	<div class="modal-content" >
										   
										     <div class="text-center modal-body">
										     	<h4  style="text-align: center;line-height: 24px;">Are you sure you want to Activate  <br> "{!! $user->name !!}" ?</h4>
											</div>
											<div class="modal-footer modal-footer-confirm">
											
										       <input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">&nbsp;&nbsp;&nbsp;
										       <button type="button" onclick="unblockUser({{ $user->id }})" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
										
										     </div>
										 </div>
					                </div>
								 </div>
								 <!-- confirmation active user modal -->
								 				
								
								 <!-- confirmation user inactive modal  -->
								 <div class="modal fade bs-example-modal-md" id="inactivate_user_confirmation_modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
								  <div class="modal-dialog modal-md">
								    <div class="modal-content" >
								   
								     <div class="text-center modal-body">
								     	<h4  style="text-align: center;line-height: 24px;">Are you sure you want to Inactivate <br> "{!! $user->name !!}" ? </h4>
									 </div>
									 <div class="modal-footer modal-footer-confirm">
								       	 <input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;
								       	 <button type="button" data-toggle="modal" data-target="#inactive_user_modal_{{ $user->id }}" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
								     </div>
								    </div>
								  </div>
								</div>
								<!-- End of user inactive confirmation modal -->
								
								
								<!-- user inactive modal -->
								<div class="modal fade" id="inactive_user_modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<div class="modal-header"> <a href="#" class="p_close js__p_close" title="Close" data-dismiss="modal"></a>
												<h4 class="modal-title modal-title-confirm" id="myModalLabel">Inactivate user</h4>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" role="form">
													<span id="blocked_msg"></span>
													<div class="form-group">
														<label class="col-md-4 control-label">Reason</label>
														<div class="col-md-6">
															<select id="blocked_reason_id_{{ $user->id }}" class="form-control">
													        	<option value="">Select Reason</option>
													        	@if(count($block_user_reasons) > 0)
																	@foreach($block_user_reasons as $reason)
																	<option value="{{ $reason->reason_id }}">{{ $reason->reason }}</option>
																	@endforeach
																@endif
														    </select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label">Description</label>
														<div class="col-md-6">
															<textarea id="blocked_desc_{{ $user->id }}" class="form-control" maxlength="{!! config('constants.additional-info-limit') !!}" placeholder="Enter description"></textarea>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer modal-footer-confirm">
											<div class="col-md-6 col-xs-6 text-right">
												<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">
											</div>
											<div class="col-md-3 col-xs-3">	
												<button type="button" onclick="blockUser({{ $user->id }})" class="inactive-user btn btn-yes">{{ trans('labels.modal_btn_yes') }}</button>
											</div>
											</div>
										</div>
									</div>
								</div>
								<!-- End of user inactive modal -->
											
		
								<!-- Delete modal -->
								<div class="modal fade bs-example-modal-md" id="modal_delete_user_{!! $user->id !!}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<div class="text-center modal-body">
												<h5>Are you sure you want to delete<strong> {!! $user->company_name !!}</strong>?</h5>
											</div>
											<div class="modal-footer modal-footer-confirm">
												<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">
												<button type="button" class="btn btn-yes" onclick="deleteUser({{ $user->id }})" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
											</div>
										</div>
									</div>
								</div>
								<!-- Delete modal End -->
							</td>
						</tr>
					@endforeach
				@else 
					<tr><td colspan="7">{{ trans('labels.no_results_found') }}</td></tr>
				@endif
                </tbody>

			</table>
			 @if($users)
				{!! str_replace('/?', '?',  $users->render()) !!}
			 @endif
		</div>

	</div>
</div>
<script type="text/javascript">

function deleteUser(id) {
	
	$('.alert-success').hide();
	$('.alert-danger').hide();

	$.ajax({
      url: "{{ url('users').'/' }}"+id ,
      type: 'DELETE',
      beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function( msg ) {
            if ( msg.status === 'success' ) {
				$('#row_'+id).fadeOut(1000,function(){
					$('#row_'+id).remove();
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

function blockUser(id) {
	 
	var reason_id = $("#blocked_reason_id_"+id).val();
	var desc = $("#blocked_desc_"+id).val();
	  
	if(reason_id  == '' || desc  == ''){
		$("#blocked_msg").html("<div class='alert alert-danger'>Please fill all the details.</div>");
	}
	else{
		$("#blocked_msg").html("");

		$.ajax({
			
			url: "{{ url('block-user') }}/"+id,
	        type: 'POST',
	        beforeSend: function (xhr) {
	              var token = $('meta[name="csrf_token"]').attr('content');

	              if (token) {
	                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	              }
			},
	        data:{ reason_id : reason_id, desc : desc},
	        success: function( data ) {
	        	if(data.status === 'error')
		        {
		        	$("#blocked_msg").html("<div class='alert alert-danger'>"+data.msg+"</div>");
			    }
				else
		        {
					$("#blocked_msg").html("<div class='alert alert-success'>"+data.msg+"</div>");
					window.setTimeout(function(){ window.location.reload(); }, 1000);
				}
			},
			error: function( data ) {
	        	$("#blocked_msg").html("<div class='alert alert-danger'>Something went wrong</div>");
			}
		});
	}
}


function unblockUser(id) {

	$('.alert-success').hide();
	$('.alert-danger').hide();
	
	$.ajax({
		url: "{{ url('unblock-user') }}/"+id,
        type: 'POST',
        beforeSend: function (xhr) {
              var token = $('meta[name="csrf_token"]').attr('content');

              if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
              }
          },
          success: function( data ) {
        	  if(data.status === 'error')
	            {
 					$('.alert-danger .result').text(data.msg);
  	        		$('.alert-danger').show();
		        }
	            else
	            {
	            	$('.alert-success .result').text(data.msg);
					$('.alert-success').show();
	            	window.setTimeout(function(){ window.location.reload(); }, 1000);
		        }
          },
          error: function( data ) {
        	  $("#inactive_user_error_msg").html("<label class='alert alert-danger'>Error in request.</label>");
          }
          
	});
		 
}

function resetPassword(id){
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
        	if(data.status === 'error') {
        		$('.alert-danger .result').text(data.msg);
            	$('.alert-danger').show();
        	} else {
        		$('.alert-success .result').text(data.msg);
	        	$('.alert-success').show();
            }
		},
        error: function( data ) {
        	$('.alert-danger .result').text('Error in ajax request');
        	$('.alert-danger').show();
        }
	});
}

</script>
@endsection