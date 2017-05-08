<div id="logo_bg">
	@if($CustomerID)
		@if($Logo)
			<img class="pos_mainlogo center-block" src="{{ url('/images/'.$Logo) }}" alt="Logo" style="width: 70px;">
		@else
			<img class="pos_mainlogo center-block" src="{{ url('/img/company_logo.png') }}" alt="Logo">
		@endif
		<div class="align-center"><h3>{{ $CompanyName }}</h3><h4 class="color">{{ $CompanyCity }}</h4></div>
	@else
		<img class="pos_mainlogo center-block" src="{{ url('/img/company_logo.png') }}" alt="Logo">
		<div class="align-center"><h3>Qroaker</h3><h4 class="color">Hyderabad, India</h4></div>
	@endif
</div>