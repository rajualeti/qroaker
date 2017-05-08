@extends('home')

@section('title', 'Create Role')
@section('content')
<div class="container-fluid">
  <div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Create Role</div>
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
					
					{!! Form::open(['url'=>'roles', 'method' =>'POST', 'class' => 'form-horizontal']) !!}
						
						<div class="form-group">
							<label class="col-md-4 control-label">Role Title</label>
							<div class="col-md-6">
								{!! Form::text('name',null,['class' => 'form-control', 'required' => 'required', 'maxlength' => str_limit(Config::get("constants.input-text-limit")) , 'placeholder'=>'Write title of the role']) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label no-pad">Description</label>
							<div class="col-md-6">{!! Form::textarea('description', null, ['size' => '5x2', 'class'=>'form-control', 'maxlength' => str_limit(Config::get("constants.additional-info-limit")) , 'placeholder'=>'Write Description of the role']) !!}</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label no-pad">Select Tasks</label>
							<div class="col-md-6">
								<div class="qroak-multiselect">
									<?php $j=1; $k=1;$m=1; $n=1;?>
									<section>
										@foreach($permissions as $permission)
											<h3>
												<input type="checkbox" id="c{!! $j++ !!}" name="checked_perms[{!! $permission->id !!}]" value="{!! $permission->id !!}"/>
												<label for="c{!! $k++ !!}"><span></span>{!! $permission->display_name !!}</label>
											</h3>
											<div class="children">
												<?php 
													$letters = range('a', 'z');
													$i=0;$l=0;
												?>
												@foreach($permission->childperms as $child)
													@if($child->parent == $permission->id)
														<input type="checkbox" id="c{!! $m++ !!}{!! $letters[$i++]!!}" name="checked_perms[{!! $child->id !!}]" value="{!! $child->id !!}"/>
														<label for="c{!! $n++ !!}{!! $letters[$l++] !!}"><span></span> {!! $child->display_name !!}</label><br>
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
									<input type="radio" id="internal" name="role_type" value="1" checked="checked">
									<label for="internal"><span></span>Internal</label>
								</div>
								<div class="col-xs-4">
									<input type="radio" id="external" name="role_type" value="0">
									<label for="external"><span></span>External</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 text-right"><input type="button" value="Cancel" class="btn btn-cancel" ></div>
							<div class="col-xs-6"><button name="" class="btn btn-submit">Create</button></div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
				
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0

  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");

  if (restore) selObj.selectedIndex=0;

}
</script>


				
@endsection