@extends("app")
@section('title', 'Access Denied')
@section('content')
<div class="container main-bg">
    	<div class="col-xs-12 text-center">
                <div class="info">
                    <h1>403!</h1>
                    <h2>Access Forbidden</h2>
                    <p>You Dont have enough permission to view this page<!--The page you are looking for was moved, removed, renamed or might never existed.--></p>
                    <a href="{!! URL('/') !!}" class="pipip-button-orange">Back to Home Page</a>
                </div>
       <!-- end Info -->
       </div>
</div>
@endsection
