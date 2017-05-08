@extends('app')
@section('title', 'Qroaker')
@section('content')

<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
	<div class="col-sm-12 pad-lr-8" id="sidebar-section">
		
		<!-- =================SIDEBAR POPULAR QROAKS SECTION STARTS HERE================= -->
		@include('qroaks.popular')
		

		<!-- =================SIDEBAR TRENDS SECTION STARTS HERE================= -->
	    @include('qroaks.trends')
	    
	</div>
</div>


<section id="page-content">
	<div class="container container-768">
    	<div class="row no-mrg-768">

		<!-- =================SIDEBAR SECTION STARTS HERE================= -->
		<div class="col-sm-4 col-md-3 pad-lr-8 hide-640" id="sidebar-section">
			
			<!-- =================SIDEBAR POPULAR QROAKS SECTION STARTS HERE================= -->
			@include('qroaks.popular')
		            
		            	
			<!-- =================SIDEBAR TRENDS SECTION STARTS HERE================= -->
		    @include('qroaks.trends')
	
		</div>

		<!-- =================QROAKS LIST SECTION STARTS HERE================= -->
            <div class="col-sm-8 col-md-9 pad-lr-8" id="qroaks-section">
            
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
					
            	<div class="qroaks-sec-bg">
                	<!-- =================NEW QROAK STARTS HERE================= -->
                	@include('qroaks.new-qroak')
                    
                    
                    <!-- =================QROAKS LIST STARTS HERE================= -->
                    @include('qroaks.index')
                    
				</div>
			</div>
		</div>
	</div>
</section>

{!! HTML::script('js/assets/classie.js') !!}

<script>
	menuRight = document.getElementById( 'cbp-spmenu-s2' ),
	showRightPush = document.getElementById( 'showRightPush' ),
	body = document.body;

			
	showRightPush.onclick = function() {
		classie.toggle( this, 'active' );
		classie.toggle( body, 'cbp-spmenu-push-toleft' );
		classie.toggle( menuRight, 'cbp-spmenu-open' );
	};


	function saveQroak() {

		var form = $("#qroak-form").serialize();
		alert(form);
		$.ajax({
			url: '{{ URL("qroaks") }}',
		    type: 'POST',
			beforeSend: function (xhr) {
	        	var token = $('meta[name="csrf_token"]').attr('content');
		        if (token) {
		        	return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			data: $("#qroak-form").serialize(),
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

