<div class="new-qroak">
	<form method="POST" id="qroak-form" action="{{ url('qroaks') }}" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="new-qroak-left"><a class="icon-45"><img alt="" src="img/new-qroak-icon.png" /></a></div>
		<div class="new-qroak-right">
			<textarea name="qroak_text" id="new-qroak" placeholder="Ex: &quot;Anyone there for car-pooling... &quot;"></textarea>
			<div class="clearfix"></div>
			<div id="new-q-focus-block">
				<div  class="row new-qroak-settings-imgs-classified">
					<div class="col-xs-4 no-pad"><a href="#" class="add-images">Add Images</a></div>
					<div class="col-xs-8 no-pad text-right">
						<input type="checkbox" id="c1" name="is_classified" value="1" />
						<label for="c1"><span></span> This is a <em class="green-txt">Classified Qroak</em></label>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="row new-qroak-settings-pub-pri">
					<div class="col-sm-6 no-pad new-qroak-settings-pub-pri">
						<input name="is_private" id="r1" type="radio" value="0" checked />
						<label class="public-post new-qroak-settings-pub-pri-label hiding-label" for="r1"><span></span>Public Conversation</label>
						<input name="is_private" id="r2" type="radio" value="1" />
						<label class="new-qroak-settings-pub-pri-label" for="r2"><span></span>Private Conversation</label>
					</div>
					<div class="col-sm-6 no-pad text-right">
						<input type="submit" id="q_button" value="Qroak"/>
						<input type="button" id="cancel" value="Cancel" />
					</div>	
				</div>
			</div>
		</div>
	</form>
</div>