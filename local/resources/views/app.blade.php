<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap Core CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    <!-- Custom CSS -->
    {!! HTML::style('css/custom.css') !!}
    {!! HTML::style('css/main.css') !!}
    <!-- Fontawesome CSS -->
    {!! HTML::style('css/font-awesome.min.css') !!}

    {!! HTML::style('css/assets/chosen.css') !!}
    {!! HTML::style('css/assets/bootstrap-select.css') !!}
    {!! HTML::style('css/assets/footable-0.1.css') !!}
    {!! HTML::style('css/assets/fileinput.css') !!}
    {!! HTML::style('css/assets/tooltip.css') !!}
    {!! HTML::style('css/assets/jquery-password-validator.css') !!}
    
	<!-- jQuery -->
	{!! HTML::script('js/jquery.js') !!}
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="cbp-spmenu-push">

<!-- === PAGE LOADER ANIMATION STARTS HERE === -->
<div class="loader"> </div>
<!-- === PAGE LOADER ANIMATION ENDS HERE === -->


<div class="main">

<!-- ==========================================================
				HEADER SECTION STARTS HERE
========================================================== -->

<section id="header">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-4 col-sm-6 header-logo-sec"><a href="#" class="logo"><img alt="" src="{{ url('img/logo.png') }}"></a></div>
            @if (Auth::guest())
	            <div class=" col-xs-8 col-sm-6 header-user-sec">
	            	
	            	<a href="#" data-toggle="modal" data-target=".login-popup"><i class="fa fa-user hidden-320"></i><span>Login</span></a> <span>
	            	|</span> <a href="#" data-toggle="modal" data-target=".signup-popup"><i class="fa fa-lock hidden-320"></i><span>Join Qroaker</span></a>
	            </div>
            @else
				<div class="col-xs-6 header-user-login-sec">
	                <div class="dropdown">
	                	<a id="login-user" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	                		<span class="user-avatar"></span> {{ $Name }} <span class="caret"></span>
	                	</a>
	                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="login-user">
	                    	<li><a href="{{ url($ProfileLink) }}/edit"><i class="fa fa-pencil"></i> Edit Profile</a></li>
	                    	<li><a href="{{ url('change-password') }}" ><i class="fa fa-key"></i>Change Password</a></li>
	                    	<li><a href="{{ url('/auth/logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
	                    </ul>
	                </div>
	            </div>
            @endif
        </div>
    </div>
</section>


<!-- ==========================================================
				TOP NAV SECTION STARTS HERE
========================================================== -->
<section id="top-nav">
	<div class="container text-center hidden-nav-768">
    <div class="row">
    	<div class="col-sm-4 top-bar-nav">
        	<div class="navigation">
                <ul class="">
                	<li><a href="#"><i class="home-icon"></i> <span class="hidden-991">Home</span></a></li>
                    <li><a href="#"><i class="whatsnew-icon"></i> <span class="hidden-991">Whats New</span></a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4 top-bar-search"><input type="text" class="desk-search" placeholder="Search something..."></div>
        <div class="col-sm-3 col-sm-offset-1 top-bar-select-city">
        	<form>
                <select id="" class="selectpicker" data-live-search="true" title="Please select ...">
                    <option selected>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                    <option>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                    <option>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                </select>
        </form>
        </div>
    </div>
    </div>
    
    <div class="container no-pad visible-nav-768">
        <div class="navigation">
            <ul class="nav float-left">
            	<li><a href="#"><i class="home-icon"></i></a></li>
            	<li><a href="#"><i class="whatsnew-icon"></i></a></li>
            </ul>
            <ul class="nav navbar-right float-right">
            	<li><a href="#mbl-search"><i class="search-icon"></i></a></li>
            	<li><a href="#" data-toggle="modal" data-target=".location-popup"><i class="location-icon"></i></a></li>
            	<li><a href="javascript:void(0)" id="showRightPush"><i class="mbl-sdbar-icon"></i></a></li>
            </ul>
        </div>
    </div>

</section>

<!-- SEARCH MODAL -->
<div id="mbl-search">
    <button type="button" class="close">×</button>
    <form>
        <input type="search" value="" placeholder="type keyword(s) here" />
        <button type="submit" class="btn">Search</button>
    </form>
</div>

<!-- location MODAL -->
<div class="modal fade location-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login-modal" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <form>
                <select id="" class="selectpicker" data-live-search="true" title="Please select ...">
                    <option selected>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                    <option>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                    <option>Hyderabad, India</option>
                    <option>Bangalore, India</option>
                    <option>Chennai, India</option>
                    <option>Vijayawada, India</option>
                    <option>Guntur, India</option>
                </select>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- ==========================================================
				PAGE CONTENT SECTION STARTS HERE
========================================================== -->
{!! header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');!!}

@yield('content')



<div class="modal fade login-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login</h4>
      </div>
      <div class="modal-body">
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



<div class="modal fade signup-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog signup-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel-signup">Join Qroaker</h4>
      </div>
      <div class="modal-body">
      <form>
       <table width="100%">
       	<tbody>
        	<tr>
            	<td valign="middle">Display Name</td>
                <td><input type="text" placeholder="Ex: John Smith" /></td>
            </tr>
            <tr> <td colspan="2" height="16px"></td> </tr>
            <tr>
            	<td valign="middle">Mobile No.</td>
                <td><input type="text" placeholder="" /></td>
            </tr>
            <tr> <td colspan="2" height="16px"></td> </tr>
            <tr>
            	<td valign="middle">Email</td>
                <td><input type="text" placeholder="" /></td>
            </tr>
            <tr> <td colspan="2" height="20px"></td> </tr>
            <tr>
            	<td valign="middle">Gender</td>
                <td>
                <input name="rr1" id="male" type="radio" value="" />
    <label class="new-qroak-settings-pub-pri-label" for="male"><span></span>Male</label>
    <input name="rr1" id="female" type="radio" value="" />
    <label class="new-qroak-settings-pub-pri-label" for="female"><span></span>Female</label>
                </td>
            </tr>
            <tr> <td colspan="2" height="24px"></td> </tr>
            <tr>
            	<td valign="middle">Location</td>
                <td></td>
            </tr>
            <tr> <td colspan="2" height="30px"></td> </tr>
            
            <tr>
            	<td colspan="2" align="center" class="tabs">
                    <div>
                    
                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#caricature" aria-controls="caricature" role="tab" data-toggle="tab">Pick Caricature</a></li>
                            <li><span class="tab-seperator">|</span></li>
                            <li role="presentation"><a href="#browse" aria-controls="Browse" role="tab" data-toggle="tab">Browse Picture</a></li>
                        </ul>
                    
                    <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="caricature">
                                    <input name="avatar-icons" id="av1" type="radio" value="" />
                                    <label for="av1"><span><img src="{{ url('img/avatars/avatar1.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av2" type="radio" value="" />
                                    <label for="av2"><span><img src="{{ url('img/avatars/avatar2.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av3" type="radio" value="" />
                                    <label for="av3"><span><img src="{{ url('img/avatars/avatar3.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av4" type="radio" value="" />
                                    <label for="av4"><span><img src="{{ url('img/avatars/avatar4.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av5" type="radio" value="" />
                                    <label for="av5"><span><img src="{{ url('img/avatars/avatar5.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av6" type="radio" value="" />
                                    <label for="av6"><span><img src="{{ url('img/avatars/avatar6.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av7" type="radio" value="" />
                                    <label for="av7"><span><img src="{{ url('img/avatars/avatar7.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av8" type="radio" value="" />
                                    <label for="av8"><span><img src="{{ url('img/avatars/avatar8.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av9" type="radio" value="" />
                                    <label for="av9"><span><img src="{{ url('img/avatars/avatar9.png') }}" alt="" class="avatar-img" /></span></label>
                                    
                                    <input name="avatar-icons" id="av10" type="radio" value="" />
                                    <label for="av10"><span><img src="{{ url('img/avatars/avatar10.png') }}" alt="" class="avatar-img" /></span></label>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="browse">browse</div>
                        </div>
                    
                    </div>
            	</td>
            </tr>
            
            
            <tr> <td colspan="2" height="20px"></td> </tr>
            <tr>
            	<td colspan="2" align="center" class="buttons"><input name="" type="button" data-dismiss="modal" value="Cancel"> <input name="" type="submit" value="Create"></td>
            </tr>
            
            
        </tbody>
       </table>
       </form>
      </div>
    </div>
  </div>
</div>



<!-- ==========================================================
				FOOTER SECTION STARTS HERE
========================================================== -->
<!--<section id="footer">
	<div class="container text-center">
    	<div class="row">
        	<div class="col-sm-6">Footer Left</div>
            <div class="col-sm-6">Footer Right</div>
        </div>
    </div>
</section>-->


</div>


<!-- Bootstrap Core JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}

<script>
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>

<!-- Scrolling Nav JavaScript -->
{!! HTML::script('js/assets/jquery.easing.min.js') !!}
{!! HTML::script('js/assets/scrolling-nav.js') !!}

<!-- PROFILE POPOVERS JavaScript -->
{!! HTML::script('js/assets/ct-paper.js') !!}

<script>
// POPOVER FOR USER PROFILE ON AVATAR CLICK
$(function(){
    $('[data-toggle="popover"]').popover({ 
        html : true, 
        content: function() {
          return $('#popover_content_wrapper').html();
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).attr("value")=="classified"){
            $(".public-post").toggle();
        }
    });
});
</script>

<script type="text/javascript">
$(function() {
	$("#new-qroak").focus(function() {
		$(this).animate({"height": "85px",}, "fast" );
		$("#new-q-focus-block").slideDown("fast");
		return false;
	});

	$("#cancel").click(function() {
		$("#new-qroak").animate({"height": "40px",}, "fast" );
		$("#new-q-focus-block").slideUp("fast");
		return false;
	});

});
</script>

<script>
$(document).ready(function() {
	  $(".comments").click(function() {
	    $(".chat").slideToggle("fast");
	  });
	});
</script>

<script>
$("[data-toggle=popover]").popover({
    html: true, 
	content: function() {
		return $('#popover-content').html();
	}
});
</script>

{!! HTML::script('js/assets/jquery.flexisel.js') !!}

<script type="text/javascript">

$(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo2").flexisel({
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });

    $("#flexiselDemo3").flexisel({
        visibleItems: 5,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });

    $("#flexiselDemo4").flexisel({
        clone:false
    });
	
    
});
</script>

<script>
$(function () {
    $('a[href="#mbl-search"]').on('click', function(event) {
        event.preventDefault();
        $('#mbl-search').addClass('open');
        $('#mbl-search > form > input[type="search"]').focus();
    });
    
    $('#mbl-search, #mbl-search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    
});
</script>

{!! HTML::script('js/assets/bootstrap-select.min.js') !!}
{!! HTML::script('js/assets/cbFamily.js') !!}
{!! HTML::script('js/assets/tooltip.js') !!}
{!! HTML::script('js/assets/footable.js') !!}
{!! HTML::script('js/assets/fileinput.js') !!}
{!! HTML::script('js/assets/jquery.password-validator.js') !!}
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCK2bYXLPDUyb_2Ct90QaBRa5-4dxeB3yw"></script>
{!! HTML::script('js/custom.js') !!}
</body>
</html>
