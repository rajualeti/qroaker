<div class="popular">
	<h2>Popular <span>-</span> <span>Hyderabad, India</span></h2>
	<div class="clearfix"></div>
 	<div class="popular-qroaks">
                    @if(isset($popular))
                    	@foreach($popular as $qroak)
	
                        	<ul>
                                <li>
	                                <a href="#" class="icon-35" data-toggle="popover" data-placement="right"  data-container="body" data-html="true">
	                                <img alt="" src="img/dummyavatar.png"></a>
	                                <div id="popover_content_wrapper" style="display: none">This is your div content</div>
                                </li>
                                <li>
                                	<!-- <a href="#">Anyone to join for <span onclick="location.href='#'" class="hash-link">#cycling</span> from <span onclick="location.href='#'" class="hash-link">#Koti</span> to <span onclick="location.href='#'" class="hash-link">#Golkonda</span> on Saturday?</a> -->
                                	{!! convert_hashtag($qroak->qroak_text) !!}
                                </li>
                            </ul>
                            <div id="popover-content" style="display:none">
                                <div class="col-xs-12 no-pad">
			                    	<div class="tagons-profile box-shaow">
			                        	<div class="tagons-profile-left text-center">
			                            	<a href="#" class="tagons-profile-icon"><img alt="" src="img/dummyavatar.png" class="center-block" /></a>
			                                <a href="#" class="tagon-btn">Tagon</a>
			                            </div>
			                            <div class="tagons-profile-right">
			                        	<p class="tagons-profile-name">{{ $qroak->user->name }} <span class="female">{{ $qroak->user->city }}, India</span></p>
			                            <p class="tagons-profile-taged"><span>34</span> Tagged</p>
			                        </div>
			                        	<div class="clearfix"></div>
			                            <div class="col-sm-12 no-pad tagons-profile-meta">
			                             	<div class="row no-mrg no-pad">
			                                	<div class="col-xs-4 metas no-mrg no-pad"><a href="#" class="current">Qroaks - <span>1239</span></a></div>
							                        <div class="col-xs-4 metas no-mrg no-pad"><a href="#">Trailing - <span>56</span></a></div>
							                        <div class="col-xs-4 metas no-mrg no-pad"><a href="#">Tagons - <span>45</span></a></div>
			                                </div>
			                             </div>
			                            </div>
			                    </div>
                           	</div>
                           @endforeach 
						@endif  
                        </div>
                    <div class="clearfix"></div>
                    <a href="#" class="sidebar-more">More <i class="fa fa-angle-down"></i></a>
                </div>