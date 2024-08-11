@extends("layouts.$master.master")

@section('title')Liste classes
 {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
@component("components.$master.breadcrumb")
        @slot('breadcrumb_title')
			<h3>Liste classes</h3>
		@endslot
		<li class="breadcrumb-item">classes</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		<li class="breadcrumb-item active">Liste des classes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card">
                    <div class="cal-date-widget card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p class="f-16">Progression des cours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($progressions as $progression)
                <div class="col-sm-6 col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="cal-date-widget card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="f-16">{{ $progression['nom_matiere'] }} {{ $progression['nom_classe'] }} - {{ round($progression['pourcentage'], 2) }}% ({{ $progression['progression'] }}h / {{ $progression['volume_horaire'] }}h)</p>
                                    <div class="progress">
                                        <div class="progress-bar-animated progress-bar-striped bg-info" role="progressbar" style="width: {{ round($progression['pourcentage'], 2) }}%" aria-valuenow="{{ round($progression['pourcentage'], 2) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <br> Professeur : <span>{{ $progression['nom_prof'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
	    </div>
	</div>

	
	@push('scripts')
	@endpush

@endsection