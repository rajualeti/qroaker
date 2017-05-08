<div class="qroaks-list">
	@if(isset($qroaks))
	@foreach($qroaks as $qroak)
	
	<div class="qroak-item">
         <div class="qroak-item-left">
         	<a href="#" class="icon-45">
         		<!-- <img alt="" src="img/dummyavatar.png"> -->
				@if(!empty($qroak->user->image))
					<img src="{{ url($qroak->user->image) }}" class="profile-image" alt="Profile Image">
				@else
					<img src="{{ url('img/default-user.png') }}" class="profile-image" alt="Profile Image">
				@endif
         	</a>
         </div>
		<div class="qroak-item-middle">
			<div class="qroak-title bold-link">{!! convert_hashtag($qroak->qroak_text) !!}</div>
			
			<div class="clearfix"></div>
			<!-- <div class="qroak-uploads">
				<ul id="flexiselDemo4">
					<li><img alt="" src="img/dimg.jpg" /></li>
					<li><img alt="" src="img/dimg.jpg" /></li>
					<li><img alt="" src="img/dimg.jpg" /></li>                                               
				</ul>
			</div> -->
			<div class="clearfix"></div>
			<div class="qroak-uploader {{ strtolower(gender($qroak->user->gender)) }}-uploader">{{ $qroak->user->name }}, {{ format_datetime($qroak->created_at) }}</div>
			
			<div class="clearfix"></div>
			<div class="qroak-filters">
				<a href="javascript:void(0);" class="likes">680</a>
				<a href="javascript:void(0);" class="comments">250</a>
				<a href="javascript:void(0);" class="share">180</a>
                                
                                
				<div class="clearfix"></div>
                                
				<div class="chat normal-chat" style="display:none;">
					<ul class="chat-thread">
						<li>
							<span class="chat-msg">Are we meeting today?</span>
							<span class="chat-time">4 Minutes</span>
						</li>
				        <li>
				            <span class="chat-msg">yes, what time suits you?</span>
				            <span class="chat-time">4 Minutes</span>
				        </li>
				        <li>
				            <span class="chat-msg">I was thinking after lunch, I have a meeting in the morning I was thinking after lunch, I have a meeting in the morning I was thinking after lunch, I have a meeting in the morning</span>
				            <span class="chat-time">4 Minutes</span>
				        </li>
				    </ul>
					<form class="chat-window">
						<input class="chat-window-message" name="chat-window-message" type="text" autocomplete="off" autofocus />
					</form>
				</div>
                                
			</div>
		</div>
		<div class="qroak-item-right">
			<div class="dropdown navbar-right text-right" style="margin-right:0 !important;">
				<a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<i class="fa fa-chevron-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
					<li><a href="#"><i class="fa fa-users"></i> Invite Qroakers</a></li>
					<li><a href="#"><i class="fa fa-stop-circle"></i> End Conversation</a></li>
				</ul>
			</div>	
		</div>
                            
	</div>
	<!-- Qroak item end -->
	@endforeach                 
    @endif    
</div>