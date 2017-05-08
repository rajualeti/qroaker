@extends("app")
@section('title', 'Page Not Found')
@section('content')
<div class="container main-bg">
    	<div class="col-xs-12 text-center">
                <div class="info">
                    <h1>404!</h1>
                    <h2>Page Not Found.</h2>
                    <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
                    <a href="{!! URL('/') !!}" class="pipip-button-orange">Back to Home Page</a>
                </div>
       </div>
</div>
@endsection
