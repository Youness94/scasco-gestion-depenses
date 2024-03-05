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
                                    <h3 class="page-title"></h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                                    <a href="{{ route('add.reglement-effet') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-10">
                            <div class="card-header bg-black"></div>
                            <div class="card-body">

                                <div class="container mt-10 pt-100">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <!-- <i class="far fa-building text-danger fa-6x float-start"></i> -->
                                        </div>
                                    </div>


                                    <div class="row mt-10 pt-100">
                                        <div class="col-xl-12">

                                            <ul class="list-unstyled float-end">
                                                <li style="font-size: 30px; color: red;">Détails d'un règlement</li>
                                                <li>Mode: Effet</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- <div class="row text-center">
                              <h3 class="text-uppercase text-center mt-10" style="font-size: 10px;">Règlement par Chèque</h3>
                              <p></p>
                        </div> -->

                                    <div class="row mx-3 mt-10 pt-100">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Date de reglement</td>
                                                    <td>{{ $reglements->date_reglement }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Effet</td>
                                                    <td>{{ $reglements->effet->effet_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nom de compte</td>
                                                    <td>{{ $reglements->effet_compte->nom }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bénéficiaire</td>
                                                    <td>{{ $reglements->bene->nom }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Service</td>
                                                    <td>{{ $reglements->service->nom }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Référance</td>
                                                    <td>{{ $reglements->referance  }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Echeance</td>
                                                    <td>{{ $reglements->echeance  }}</td>
                                                </tr>
                                                @foreach($reglements->reglementEffetFournisseur as $reglementEffetFournisseur)
                                                <tr>
                                                    <td>Sous Compte</td>
                                                    <td> {{ $reglementEffetFournisseur->sousCompte->nom }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td>Montant</td>
                                                    <td>{{ number_format($reglements->montant ?? 0.00)  }} Dh</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-8" style="margin-left:60px">
                                            <p class="float-end" style="font-size: 30px; color: red; font-weight: 400;font-family: Arial, Helvetica, sans-serif;">
                                                Total:
                                                <span>{{ number_format($reglements->montant ?? 0.00)  }} Dh</span>
                                            </p>
                                        </div>

                                    </div>

                                </div>
                                @if($reglements->RelEffetImages && count($reglements->RelEffetImages) > 0)
                                <div class="mt-4">
                                    <p><strong>Images:</strong></p>
                                    <div class="row" onclick="window.location='{{ asset('/public/' . $reglements->RelEffetImages[0]) }}';" style="cursor:pointer;">
                                        @foreach($reglements->RelEffetImages as $image)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('public/reglement_effet_images/' . $image->images) }}" alt=" Image" class="img-fluid" style="max-width: 300px; max-height: 300px;">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="card-footer bg-black"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection