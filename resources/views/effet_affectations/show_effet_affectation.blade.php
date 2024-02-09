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

                        <div class="card-body">
                            <p><strong>Affectation Date:</strong> {{ $effet_affectation->affectation_date }}</p>
                            <p><strong>Checkbook:</strong> {{ $effet_affectation->carnet_effet->carnet_series }}</p>
                            <p><strong>Start Number:</strong> {{ $effet_affectation->start_number }}</p>
                            <p><strong>End Number:</strong> {{ $effet_affectation->end_number }}</p>
                            <p><strong>Service:</strong> {{ $effet_affectation->service->nom }}</p>
                            <p><strong>Courtier:</strong> {{ $effet_affectation->courtier->nom }}</p>


                            
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
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection