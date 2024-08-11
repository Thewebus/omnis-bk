@extends("layouts.informatique.master")

@section('title')2e Session
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chartist.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@livewireStyles
<style>
    .right-divider {
        border-right: 3px dotted #0d6efd
    }

	.my-custom-scrollbar {
		position: relative;
		height: 850px;
		overflow: auto;
	}
	.table-wrapper-scroll-y {
		display: block;
	}
</style>
@endpush

@section('content')
	@component("components.informatique.breadcrumb")
		@slot('breadcrumb_title')
			<h3>2nd Session</h3>
		@endslot
		{{-- <li class="breadcrumb-item">classes</li> --}}
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">2nd Session</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <!-- Feature Unable /Disable Order Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Notes Session 2</h5>
	                    {{-- <span>Disabling features that you don't wish to use for a particular table is easily done by setting a variable in the initialisation object</span>
	                    <span>In the following example only the search feature is left enabled (which it is by default).</span> --}}
	                </div>
	                <div class="card-body">
                        <div class="row">
                            <livewire:deliberation-classe-liste>
							
							<livewire:deliberation-matiere-liste :action="$action">
                            
                            <livewire:liste-etudiant-session2>						
                        </div>
	                </div>
	            </div>
	        </div>
	        <!-- Feature Unable /Disable Ends-->
	    </div>
	</div>

	
	@push('scripts')
    @livewireScripts
	@livewireChartsScripts
	<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
	
	<script>
		$(document).ready(function () {
			$('#dtVerticalScrollExample').DataTable({
				"scrollY": "200px",
				"scrollCollapse": true,
			});
			$('.dataTables_length').addClass('bs-select');
		});
	</script>

	<script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>
	<script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
	<script src="{{ asset('assets/js/chart/chartist/chartist-custom.js') }}"></script>
	@endpush

@endsection