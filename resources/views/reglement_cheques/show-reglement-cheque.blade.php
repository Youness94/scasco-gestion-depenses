@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Réglements des chèques</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Réglements des chèques</li>
                    </ul>
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
                                <div class="col">
                                    <h3 class="page-title">Réglements des chèques</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                                    <a href="{{ route('add.reglement-cheque') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
            <div>
                <h1>Show Reglement Cheque</h1>

                <!-- Display Reglement Cheque details -->
                <p>ID: {{ $reglements->id }}</p>
                <!-- Add more details as needed -->

                <!-- Display Cheque details -->
                <h2>Cheque Details</h2>
                <p>Cheque Number: {{ $reglements->cheque->number }}</p>
                <!-- Add more Cheque details as needed -->

                <!-- Display Compte details -->
                <h2>Compte Details</h2>
                <p>Compte Name: {{ $reglements->compte->nom }}</p>
                <!-- Add more Compte details as needed -->

                <!-- Display Beneficiary details -->
                <h2>Beneficiary Details</h2>
                <p>Beneficiary Name: {{ $reglements->bene->nom }}</p>
                <!-- Add more Beneficiary details as needed -->

                <!-- Display Service details -->
                <h2>Service Details</h2>
                <p>Service Name: {{ $reglements->service->nom }}</p>
                <!-- Add more Service details as needed -->

                <!-- Display Reglement Cheque Images -->
                <h2>Reglement Cheque Images</h2>
                @if ($reglements->RelChequeImages->isNotEmpty())
                    <ul>
                        @foreach ($reglements->RelChequeImages as $image)
                            <li>
                            <img src="{{ asset('public/reglement_cheque_images/' . $image->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No images available.</p>
                @endif
            </div>
        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


