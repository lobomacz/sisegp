<h6 class="text-uppercase">
	{{ $proyecto->codigo }}
</h6>
<p class="lead mt-3 text-uppercase">
	{{ $proyecto->descripcion }}
</p>

<input class="d-none" type="hidden" name="proyecto_id" id="proyecto_id" value="{{ $proyecto->id }}">

@component('components.select', ['field' => 'comunidad_id', 'size' => 'small', 'label' => __('community'), 'required' => true])

	@include('partials.select_option_empty')

	@foreach($comunidades as $item)

		@include('partials.select_option', ['value_field' => 'id', 'text_field' => 'nombre'])

	@endforeach

@endcomponent



<div class="d-table">
	<div class="d-table-row">

		@component('components.input_cell', ['type' => 'number', 'label' => __('beneficiaries'), 'placeholder' => '0000', 'field' => 'beneficiarios', 'required' => true, 'help' => ucfirst(__('messages.total_beneficiaries'))])
		@endcomponent
		
		@component('components.input_cell', ['type' => 'number', 'field' => 'familias', 'label' => __('families'), 'placeholder' => '0000', 'required' => true, 'help' => ucfirst(__('messages.total_families'))])
		@endcomponent
		
	</div>

	<div class="d-table-row">

		@component('components.input_cell', ['type' => 'number', 'field' => 'ninos', 'label' => __('boys'), 'required' => true, 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_boys'))])
		@endcomponent


		@component('components.input_cell', ['type' => 'number', 'field' => 'ninas', 'label' => ucfirst(__('girls')), 'required' => true, 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_girls'))])
		@endcomponent

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'field' => 'adolescentes_masculinos', 'label' => __('male teenagers'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_male_teen'))])
		@endcomponent

		@component('components.input_cell', ['type' => 'number', 'field' => 'adolescentes_femeninos', 'label' => __('female teenagers'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_female_teen'))])
		@endcomponent

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'field' => 'jovenes_masculinos', 'label' => __('young male'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_young_male'))])
		@endcomponent

		@component('components.input_cell', ['type' => 'number', 'field' => 'jovenes_femeninos', 'label' => __('young female'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_young_female'))])
		@endcomponent

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'field' => 'hombres', 'label' => __('men'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_men')), 'group' => true, 'prepend_icon' => 'mars'])
		@endcomponent

		@component('components.input_cell', ['type' => 'number', 'field' => 'mujeres', 'label' => __('women'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_women')), 'group' => true, 'prepend_icon' => 'venus'])
		@endcomponent

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'field' => 'ancianos', 'label' => __('elders'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_elders'))])
		@endcomponent

		@component('components.input_cell', ['type' => 'number', 'field' => 'discapacitados', 'label' => __('handicapped'), 'placeholder' => '0000', 'help' => ucfirst(__('messages.total_handicapped'))])
		@endcomponent

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'miskitu'])
		@endcomponent 

		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'mestizo'])
		@endcomponent 

	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'rama'])
		@endcomponent 

		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'creole'])
		@endcomponent 
		
	</div>

	<div class="d-table-row">
		
		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'garifuna'])
		@endcomponent 

		@component('components.input_cell', ['type' => 'number', 'placeholder' => '0000', 'field' => 'ulwa'])
		@endcomponent 
		
	</div>

</div>