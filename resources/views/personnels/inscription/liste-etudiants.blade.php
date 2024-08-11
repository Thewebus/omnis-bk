@extends('layouts.personnel.master')

@section('title')Liste Etudiants
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
  @component('components.personnel.breadcrumb')
    @slot('breadcrumb_title')
      <h3>Liste Etudiants</h3>
    @endslot
    {{-- <li class="breadcrumb-item">Resultats</li> --}}
    <li class="breadcrumb-item active">Liste Etudiants</li>
  @endcomponent

  <div class="container-fluid">
      <div class="row">
          <!-- Default ordering (sorting) Starts-->
	        <div class="col-sm-12">
	            <div class="card">
	                <div class="card-header">
	                    <h5>Liste des étudiants inscrits</h5>
	                    {{-- <span>
	                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum odio pariatur mollitia sunt temporibus dicta inventore asperiores praesentium quae, autem velit assumenda non exercitationem laborum. Distinctio sed architecto dolorem alias. <br>
	                    </span> --}}
	                    {{-- <span>
	                        The<code class="option" title="DataTables initialisation option">order:Option</code> parameter is an array of arrays where the first value of the inner array is the column to order on, and the second is
	                        <code class="string" title="String">'asc':String</code> (ascending ordering) or <code class="string" title="String">'desc':String</code> (descending ordering) as required.
	                        <code class="option" title="DataTables initialisation option">order:String</code> is a 2D array to allow multi-column ordering to be defined.
	                    </span> --}}
	                </div>
	                <div class="card-body">
	                    <div class="table-responsive">
	                        <table class="display dataTable" id="basic-3">
	                            <thead>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Classe</th>
	                                    <th>Filière</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                    @foreach ($etudiants as $etudiant)
	                                <tr>
                                        <td>{{ $loop->iteration }}</td>
	                                    <td>{{ $etudiant->fullname }}</td>
	                                    <td>{{ $etudiant->classe->nom ?? 'NONE'}}</td>
	                                    <td>{{ $etudiant->niveauFaculte->faculte->nom  ?? $etudiant->classe->niveauFaculte->faculte->nom}}</td>
                                        <td><a href="{{ route('admin.scolarite-inscritpion-detail', $etudiant->inscriptions->last()->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    @endforeach
	                            </tbody>
	                            <tfoot>
	                                <tr>
                                        <th>N°</th>
	                                    <th>Nom & Prénoms</th>
	                                    <th>Filière</th>
	                                    <th>Cursus</th>
	                                    <th>Actions</th>
	                                </tr>
	                            </tfoot>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- Default ordering (sorting) Ends-->
      </div>
  </div>


  @push('scripts')
  <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
  @endpush

@endsection
