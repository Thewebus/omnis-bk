@extends('layouts.etudiant.master')

@section('title')Notes
    {{ $title }}
@endsection

@section('content')
	@component('components.etudiant.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Toutes les notes</h3>
		@endslot
		<li class="breadcrumb-item">Liste</li>
		<li class="breadcrumb-item active">Toutes les notes</li>
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<span style="font-size: 1rem">Toutes les notes</span>
					</div>
				</div>
			</div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="database"></i></div>
                            <div class="media-body">
                                <span class="m-0">Note 1</span>
                                <h4 class="mb-0 counter">{{ $note->note_1 ?? 'N/A' }}</h4>
                                <i class="icon-bg" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="database"></i></div>
                            <div class="media-body">
                                <span class="m-0">Note 2</span>
                                <h4 class="mb-0 counter">{{ $note->note_2 ?? 'N/A' }}</h4>
                                <i class="icon-bg" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="database"></i></div>
                            <div class="media-body">
                                <span class="m-0">Note 3</span>
                                <h4 class="mb-0 counter">{{ $note->note_3 ?? 'N/A' }}</h4>
                                <i class="icon-bg" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="database"></i></div>
                            <div class="media-body">
                                <span class="m-0">Partiel</span>
                                <h4 class="mb-0 counter">{{ $note->partiel ?? 'N/A' }}</h4>
                                <i class="icon-bg" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>

	
	@push('scripts')
	@endpush

@endsection