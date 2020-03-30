<table class="table table-striped">
	<thead class="bg-info text-white">
		<tr>
			{{-- 

				<th>#</th>
				<th class="text-uppercase"></th>
				<th class="text-uppercase"></th>
				<th class="text-uppercase"></th>
				<th class="text-uppercase"></th>

				--}}

			{{ $table_header }}
			
		</tr>
	</thead>
	<tbody>
	{{--
				<tr class="rounded">
					<th scope="row"></th>
					<td class="text-uppercase"></td>
					<td class="text-uppercase"></td>
					<td class="text-uppercase">
						<a href="#" class="btn btn-primary text-capitalize">{{ __('view') }}</a>
					</td>
					<td class="text-uppercase">
						<a href="#" class="btn btn-success text-capitalize">{{ __('edit') }}</a>
					</td>
				</tr>
			--}}

		{{ $slot }}
	</tbody>
	
</table>