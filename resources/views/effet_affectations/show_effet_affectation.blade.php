@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Affectations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Affectations</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Affectations</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                                    <a href="{{ route('add.affectation') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
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
                                        <td>Date d'affectation</td>
                                        <td>{{$effet_affectation->affectation_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Série de chequier</td>
                                        <td> {{ $effet_affectation->carnet_effet->carnet_series }}</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de premier chèque</td>
                                        <td>{{ $effet_affectation->start_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de dernier chèque</td>
                                        <td>{{ $effet_affectation->end_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Service</td>
                                        <td>{{ $effet_affectation->service->nom }}</td>
                                    </tr>
                                    <tr>
                                        <td>Courtier</td>
                                        <td>{{ $effet_affectation->courtier->nom }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                        <div class="mt-4">
                                <p><strong>Images:</strong></p>
                                <div class="row" style="cursor:pointer;">
                                    @foreach($effet_affectation->images as $image)
                                    <div class="col-md-3 mb-3">
                                    @if ($item->effet_images->isNotEmpty())
                                        @foreach ($item->effet_images as $image)
                                        <img src="{{ asset('public/photos/effet_affectation/' . $image->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                                        @endforeach
                                        @else
                                        Aucune image disponible
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        <div class="card-footer bg-black"></div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection