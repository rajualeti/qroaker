@extends('home')

@section('title', 'Sign In To Qroaker')
@section('content')
<div class="container-fluid">
	<div class="row login-page">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
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

					<form action="{{ url('auth/login') }}" method="post">
				       <input type="hidden" value="{{ csrf_token() }}" name="_token">
				       <table width="100%">
				       	<tbody>
				        	<tr>
				            	<td valign="middle">Mobile or Email</td>
				                <td><input type="text" name="field" placeholder="Your Mobile or Email" /></td>
				            </tr>
				            <tr> <td colspan="2" height="26px"></td> </tr>
				            <tr>
				            	<td valign="middle">Secret PIN</td>
				                <td><input type="password" name="password" placeholder="Your 4 digit PIN" /></td>
				            </tr>
				            <tr> <td colspan="2" height="26px"></td> </tr>
				            <tr>
				                <td colspan="2" align="center" class="links">
				                	<a href="#">Change Mobile</a> <a href="#">Resend Secret PIN</a>
				                </td>
				            </tr>
				            <tr> <td colspan="2" height="26px"></td> </tr>
				            <tr>
				            	<td colspan="2" align="center" class="buttons">
				            	<input type="button" data-dismiss="modal" value="Cancel"> 
				            	<input type="submit" value="Create"></td>
				            </tr>
				            
				            
				        </tbody>
				       </table>
				    </form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
