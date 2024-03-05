@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Réglements des effets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Réglements des effets</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">File Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('store.excel.reglement.effet') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-md-4 mt-2">
                            <!-- <form action="{{ route('store.excel.reglement.effet') }}" method="POST" enctype="multipart/form-data"> -->
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h5 class="card-title"></h5> -->
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="fileInput" name="file" required>
                                                <!-- <label class="custom-file-label" for="fileInput">Choose file</label> -->
                                            </div>
                                            <!-- <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <h3 class="page-title">Réglements des effets</h3>
                                </div>
                                <div class="col-md-5 mt-1">
                                    <form action="{{ route('reglement_effet.search') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                            <a href="{{ route('all.reglement-effets') }}" class="btn btn-outline-secondary" aria-describedby="button-addon2"><i class="fa">&#xf021;</i></a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                                    <a href="{{ route('add.reglement-effet') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        import
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date de règlement</th>
                                        <th scope="col">N de effet</th>
                                        <th scope="col">Compte</th>
                                        <th scope="col">Bénéficiaire</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Sous Compte</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Échéance</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Justification</th>
                                        <!-- <th scope="col">Status</th> -->
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reglements as $reglement)
                                    <tr>
                                        <td>{{ $reglement->id }}</td>
                                        <td>{{ $reglement->date_reglement }}</td>
                                        <td>{{ $reglement->effet->effet_number }}</td>
                                        <td>{{ $reglement->effet_compte->nom }}</td>
                                        <td>{{ $reglement->bene->nom }}</td>
                                        <td>{{ $reglement->service->nom }}</td>
                                        <td>
                                            @foreach ($reglement->reglementEffetFournisseur as $reglementFournisseur)
                                            {{ $reglementFournisseur->sousCompte->nom ?? 'N/V'}}
                                            @endforeach
                                        </td>
                                        <td>{{ $reglement->referance }}</td>
                                        <td>{{ $reglement->echeance }}</td>
                                        <td>{{ number_format(($reglement->montant ?? 0.00),2)}}</td>

                                        <td>
                                            @if ($reglement->RelEffetImages->isNotEmpty())
                                            <img src="{{ asset('public/reglement_effet_images/' . $reglement->RelEffetImages[0]->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                                            @else
                                            Aucune image disponible
                                            @endif
                                        </td>
                                        <!-- <td>
                                            <div class="edit-delete-btn">
                                                @if ($reglement->status === 'Active')
                                                <a class="text-success">{{ $reglement->status }}</a>
                                                @else ($reglement->status === 'Inactive')
                                                <a class="text-warning">{{ $reglement->status }}</a>
                                                @endif
                                            </div>
                                        </td> -->
                                        <td class="text-end">
                                            <div class="actions">
                                                @if (Session::get('role_name') === 'Super Admin')
                                                <a href="{{route('edit.reglement-effet',$reglement->id)}}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                <!-- @endif
                                                @if (Session::get('role_name') === 'Super Admin') -->
                                                <a href="{{route('show.reglement-effet',$reglement->id)}}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-eye"></i>
                                                </a>
                                                <a href="{{ route('download.reglement.effet.pdf', ['id' => $reglement->id]) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10">Aucun chèque de règlement trouvé.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection