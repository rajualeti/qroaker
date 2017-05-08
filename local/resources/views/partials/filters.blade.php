<div class="row">

	@include('partials.company')
	
	<div id="filters">
		
		@if(isset($customer))
			<input type="hidden" id="customer_id" value="{{ $customer->customer_id }}">
		@endif
		<div class="border" id="accordion">
			<div class="clear-filters">
				<h3 class="text-left">{{ trans('labels.filter_tilte') }}</h3>
				<a href="" data-original-title="Clear Filters" data-toggle="tooltip" data-placement="left">Clear Filters</a>
			</div>
			
			<div class="clearfix"></div>
			<hr class="filter-hr">
			
			<div class="position">
				<div><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#from_location_filter">{{ trans('labels.filter_from_location_title') }} <i class="fa fa-chevron-up"></i></a></div>
				<div class="collapse in" id="from_location_filter">
					@if(count($from_locations) > 10)
						<input type="text" class="txt-filter" id="from_search">
					@endif
					<div {!! count($from_locations) > 10 ? 'class="filter-list-items"' : '' !!}>
						<table class="tbl-from-searchable">
							<tbody>
								@foreach($from_locations as $from)
								<tr>
									<td><div class="tulip-checkbox">
										<input id="from_location_{{ $from->from_location_id }}" name="from_locations" type="checkbox" value="{{ $from->from_location_id }}">
										<label for="from_location_{{ $from->from_location_id }}"><span></span>{{ location($from->from_location_id) }}</label>
									</div></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<hr class="filter-hr">
			
			<div class="position">
				<div><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#to_location_filter">{{ trans('labels.filter_to_location_title') }} <i class="fa fa-chevron-up"></i></a></div>
				<div class="collapse in" id="to_location_filter">
					@if(count($to_locations) > 10)
						<input type="text" class="txt-filter" id="to_search">
					@endif
					<div {!! count($to_locations) > 10 ? 'class="filter-list-items"' : '' !!}>
						<table class="tbl-to-searchable">
							<tbody>
								@foreach($to_locations as $to)
								<tr>
									<td><div class="tulip-checkbox">
										<input id="to_location_{{ $to->to_location_id }}" name="to_locations" type="checkbox" value="{{ $to->to_location_id }}">
										<label for="to_location_{{ $to->to_location_id }}"><span></span>{{ location($to->to_location_id) }}</label>
									</div></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<hr class="filter-hr">
			
			<div class="position">
				<div><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#truck_type_filter">{{ trans('labels.filter_truck_type_title') }} <i class="fa fa-chevron-up"></i></a></div>
				<div class="collapse in" id="truck_type_filter">
					@if(count($truck_types) > 10)
						<input type="text" class="txt-filter" id="trucktype_search">
					@endif
					<div {!! count($truck_types) > 10 ? 'class="filter-list-items"' : '' !!}>
						<table class="tbl-trucktype-searchable">
							<tbody>
								@foreach($truck_types as $truck_type)
								<tr>
									<td><div class="tulip-checkbox">
										<input id="truck_type_{{ $truck_type->truck_type_id }}" name="truck_types" type="checkbox" value="{{ $truck_type->truck_type_id }}">
										<label for="truck_type_{{ $truck_type->truck_type_id }}"><span></span>{{ truck_type($truck_type->truck_type_id) }}</label>
									</div></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<hr class="filter-hr">
			
			<div class="position">
				<div><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#material_filter">{{ trans('labels.filter_material_title') }} <i class="fa fa-chevron-up"></i></a></div>
				<div class="collapse in" id="material_filter">
					@if(count($materials) > 10)
						<input type="text" class="txt-filter" id="material_search">
					@endif
					<div {!! count($materials) > 10 ? 'class="filter-list-items"' : '' !!}>
						<table class="tbl-material-searchable">
							<tbody>
								@foreach($materials as $material)
								<tr>
									<td><div class="tulip-checkbox">
										<input id="material_{{ $material->material_id }}" name="materials" type="checkbox" value="{{ $material->material_id }}">
										<label for="material_{{ $material->material_id }}"><span></span>{{ material($material->material_id) }}</label>
									</div></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<!-- <hr class="filter-hr">
			<button id="btn_search" class="btn btn_blue" onclick="search()">Search</button> -->
		</div>
	</div>
</div>