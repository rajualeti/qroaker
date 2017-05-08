@extends('home')

@section('title', 'Edit Role')
@section('content')
<div class="container-fluid">
  <div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Edit Role</div>
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
			
					{!! Form::open(['url'=>'roles/'.$role->id, 'class' => 'form-horizontal', 'method' =>'PATCH']) !!}
					
						<input type="hidden" name="role_id" value="{!! $role->id !!}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PATCH">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Role Title</label>
							<div class="col-md-6">{!! Form::text('name', $role->display_name, ['class' => 'form-control', 'required' => 'required', 'maxlength' => str_limit(Config::get("constants.input-text-limit")) , 'placeholder'=>'Write title of the role']) !!}</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label no-pad">Description</label>
							<div class="col-md-6">{!! Form::textarea('description', $role->description, ['size' => '5x2', 'class'=>'form-control', 'maxlength' => str_limit(Config::get("constants.additional-info-limit")) , 'placeholder'=>'Write Description of the role']) !!}</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label no-pad">Select Tasks</label>
							<div class="col-md-6">
								<div class="qroak-multiselect">
									<?php $a=1; $b=1;$c=1; $e=1;?>
									<section>
									@foreach($permissions as $permission)
										@if(in_array($permission->id, $role_permissions))
										<h3>
											<input type="checkbox" id="{!! $role->id !!}t{!! $a++ !!}" name="tt[{!! $permission->id !!}]" value='{!! $permission->id !!}' checked="checked"/>
											<label for="{!! $role->id !!}t{!! $b++ !!}"><span></span>{!! $permission->display_name !!}</label>
										</h3>
										@else
										<h3>
											<input type="checkbox" id="{!! $role->id !!}t{!! $a++ !!}" name="checked_perms[{!! $permission->id !!}]" value='{!! $permission->id !!}'/>
											<label for="{!! $role->id !!}t{!! $b++ !!}"><span></span>{!! $permission->display_name !!}</label>
										</h3>
										@endif
										<div class="children">
											<?php $letters = range('a', 'z'); $d=0;$f=0; ?>
											@foreach($permission->childperms as $child)
												@if($child->parent == $permission->id)
													@if(in_array($child->id, $role_permissions))
														<input type="checkbox" id="{!! $role->id !!}t{!! $c++ !!}{!! $letters[$d++]!!}" name="checked_perms[{!! $child->id !!}]" value='{!! $child->id !!}'checked="checked"/><label for="{!! $role->id !!}t{!! $e++ !!}{!! $letters[$f++] !!}"><span></span> {!! $child->display_name !!}</label><br>
													@else
														<input type="checkbox" id="{!! $role->id !!}t{!! $c++ !!}{!! $letters[$d++]!!}" name="checked_perms[{!! $child->id !!}]" value='{!! $child->id !!}'/><label for="{!! $role->id !!}t{!! $e++ !!}{!! $letters[$f++] !!}"><span></span> {!! $child->display_name !!}</label><br>
													@endif
												@endif
											@endforeach
										</div>
									@endforeach
								</section>
							</div>
						</div>
					</div>
					<div class="form-group tulip-radio">
						<label class="col-md-4 control-label no-pad">Role Type</label>
						<div class="col-md-6">
							<div class="col-xs-4">
								<input type="radio" id="internal" name="role_type" value="1" {!! $role->role_type == 1 ? 'checked' : '' !!}>
								<label for="internal"><span></span>Internal</label>
							</div>
							<div class="col-xs-4">
								<input type="radio" id="external" name="role_type" value="0" {!! $role->role_type == 0 ? 'checked' : '' !!}>
								<label for="external"><span></span>External</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-6 text-right"><a href="{{ url('roles') }}" class="btn btn-cancel">Cancel</a></div>
						<div class="col-xs-6"><button class="btn btn-submit">Update</button></div>
					</div>
				{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
			
@endsection