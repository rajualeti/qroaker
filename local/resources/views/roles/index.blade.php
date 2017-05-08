@extends('app')
@section('title', 'Qroak Roles')
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

                <h2>{{ trans('labels.qroak_roles') }}</h2>

                <div class="selectBox1">

	                <input value="value 1" class="admin_users" type="hidden">
					<a class="popover-link" href="#" rel="user_role" data-popover-content=".user_role" style="color: white;"><span class="selectArrow1"></span></a>
	     
			        <div class="hide">
			          <div class="user_role">
			              <ul class="profile_pos">
			              <li><a href="{{ url('qroak-users') }}">{{ trans('labels.qroak_users') }}</a></li>	
			              <li><a href="{{ url('roles') }}">{{ trans('labels.qroak_roles') }}</a></li>	
			              </ul>
			           </div>
			         </div>
	
				</div>
			   
		        <div class="find-truck-icns" style="float: right;">
					@if(Auth::user())
						@if(Auth::user()->hasRole('admin') || Auth::user()->can('create-role'))
					   		<a href="{{ url('/roles/create') }}" ><i class="fa fa-plus"></i> New Role</a>
						@endif
					@endif
                </div>
            </div>

		</div> 

	</div>                

	<div class="clearfix"></div>

	<div class="col-md-12 no-pad">
		<div class="qroak-div">
			<table class="footable">
                <thead>
                    <tr>
                        <th class="expand"></th>
                        <th data-hide="phone,tablet"></th>
                        <th data-hide="phone"></th>
                        <th data-hide="phone,tablet"></th>
                        <th data-hide="phone"></th>
                        <th data-hide="phone"></th>
                    </tr>
				</thead>

                <tbody>

					@foreach($roles as $role)

	                	<tr id="row_{!! $role->id !!}">
	
	                    	<td class="expand footable-first-column"><h2 class="role_h2">{{ $role->display_name }}</h2></td>
	
	                    	<td><div><span class="btm-txt">Created on <label>{{ format_date($role->created_at) }}</label> by <label>{{ $role->createdby->name }}</label> </span></td>
	                    	<td>
	                    		<span class="btm-txt"> Status : 
		                    	@if(Auth::user()->hasRole('admin') || Auth::user()->can('inactivate-role'))
			                    	<span class="styled-select2">
				   						<select class="role-status" data-id="{!! $role->id !!}" id="status_{!! $role->id !!}">
					   						@if($role->status == 1)
					   							<option selected value='1'>Active</option>
					   							<option value='0'>Inactive</option>
					   						@else
					   							<option selected value='0'>Inactive</option>
					   							<option value='1'>Active</option>
					   						@endif
				   						</select>
				   						<input type="hidden" value="{!! $role->id !!}" id="role-id-{!! $role->id !!}">
			   						</span>
	   							@else
			                    	{{ $role->status == 1 ? 'Active' : 'Inactive' }}
			                    @endif
			                    </span>
	   						</td>
	
	                    	<td>
		                    	@if(!empty($role->description))
		                    		<a href="javascript:void(0);" data-toggle="tooltip" title="{!! $role->description !!}" data-placement="bottom"><i class="fa fa-info-circle"></i></a>
		                    	@endif
	                    	</td>
	
                			<td>
	                			@if(Auth::user()->hasRole('admin') || Auth::user()->can('edit-role'))
			                    	<a href="{!! url('roles/'.$role->id.'/edit') !!}"><i class="fa fa-pencil"></i></a>
			                    @endif
	                    	</td>
	                    	
                			<td class="footable-last-column">
	                			@if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-role'))
	                    			<a href="javascript:void(0);" data-toggle="modal" data-target="#delete_role_{!! $role->id !!}"><i class="fa fa-remove"></i></a>
	                    		@endif
                    		</td>
	
	                    	<!-- delete modal -->
	                  	  	<div class="modal fade bs-example-modal-md" id="delete_role_{!! $role->id !!}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  							<div class="modal-dialog modal-md" role="document">
	 							   <div class="modal-content">
	     								 <div class="text-center modal-body">
	     								 <h5 class="" id="myModalLabel">Are you sure you want to delete <strong> {!! $role->display_name !!} </strong> ?</h5>
	     								 </div>
										<div class="modal-footer modal-footer-confirm">
	       									<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close" data-dismiss="modal">
											<button type="button" id="{!! $role->id !!}" data-href="{{ route('roles.destroy', $role->id) }}" class="btn btn-yes delete_role" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
										</div>
									</div>
	  							</div>
							</div>
							<!-- end of delete modal -->
	
	                    	<!-- status change modal -->
	                    	<div class="modal fade bs-example-modal-md" id="role_status_modal_{!! $role->id !!}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  							<div class="modal-dialog modal-md" role="document">
	 							   	<div class="modal-content">
	     								<div class="text-center modal-body">
	     								 	<h5 class="" id="myModalLabel"></h5>
	     								</div>
										<div class="modal-footer modal-footer-confirm">
       										<input type="button" value="{{ trans('labels.modal_btn_no') }}" class="btn btn-no js__p_close close_{!! $role->id !!}" data-dismiss="modal">
        									<button type="button" id="rolechange_{!! $role->id !!}" class="btn btn-yes" data-dismiss="modal">{{ trans('labels.modal_btn_yes') }}</button>
                                          </div>
   									 </div>
  								</div>
							</div>
	                    	<!-- end of status change modal -->
	                    </tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>

$(function(){
$('[rel="user_role"]').popover({
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
$('[rel="user_role"]').each(function () {
	if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
		$(this).popover('hide'); // this hides popover, but content remains
		return;
	}
});
});
	                    		

$('.role-status').change(function() {

	var roleid = $(this).attr('data-id');
	
	var status = $('#status_'+roleid).val();

	if(status == 0) {
		
		var old_val = 1;
		var model_text = 'Are you sure you want to change the status Active to Inactive ?';
		
	} else {
		
		var old_val = 0;
		var model_text = 'Are you sure you want to change the status Inactive to Active ?';
		
	}

	$('#role_status_modal_'+roleid).modal('show');

	$("#role_status_modal_"+roleid+" .modal-body #myModalLabel").html( model_text );

	$('.close_'+roleid).on('click', function (e) {

		$('#status_'+roleid).val(old_val);

	});
	

	$('#rolechange_'+roleid).click(function(){

    	$.ajax({

	        url: '{!! URL("role-change-status") !!}/'+roleid,

	        type: 'POST',

	        beforeSend: function (xhr) {
				var token = $('meta[name="csrf_token"]').attr('content');
              	if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
              	}
         	},
	        data: { status: status } ,
	        success: function (response) {
		        if(response.status == 'success') {
		        	$('.alert-success .result').text(response.msg);
			        $('.alert-success').show();
			        $('.alert-danger').hide();
		        } 
		        else {
		        	$('.alert-danger .result').text(response.msg);
			        $('.alert-success').hide();
			        $('.alert-danger').show();
			        $('#status_'+roleid).val(old_val);
		       }

	        },
	        error: function () {
	        	$('.result').text('Something went wrong!');
	        	$('.alert-success').hide();
		        $('.alert-danger').show();
		        $('#status_'+roleid).val(old_val);
	     }
	    }); 
	}); 
}); 


$('.delete_role').click(function() {

	var role_id = $(this).attr('id');
	var deleteUrl = $(this).attr('data-href');

	$('.alert').hide();

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
				$('#row_'+role_id).fadeOut(1000,function(){
					$('#row_'+role_id).remove();
	            	$('.result').text(msg.msg);
					$('.alert-success').show()
            	}); 
			}
            else
            {
				$('.result').text(msg.msg);
 	        	$('.alert-danger').show()
			}
		},
        error: function( msg ) {
        	$('.result').text(msg.msg);
        	$('.alert-danger').show()
		}
	});
});

</script>

@endsection