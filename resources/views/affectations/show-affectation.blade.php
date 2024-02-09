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
                            <p><strong>Affectation Date:</strong> {{ $affectation->affectation_date }}</p>
                            <p><strong>Checkbook:</strong> {{ $affectation->checkbook->series }}</p>
                            <p><strong>Start Number:</strong> {{ $affectation->start_number }}</p>
                            <p><strong>End Number:</strong> {{ $affectation->end_number }}</p>
                            <p><strong>Service:</strong> {{ $affectation->service->nom }}</p>
                            <p><strong>Courtier:</strong> {{ $affectation->courtier->nom }}</p>


                            @if($affectation->images && count($affectation->images) > 0)
                            <div class="mt-4">
                                <p><strong>Images:</strong></p>
                                <div class="row" onclick="window.location='{{ asset('/storage/' . $affectation->images[0]) }}';" style="cursor:pointer;">
                                    @foreach($affectation->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset('/storage/' . $image) }}" alt="Affectation Image" class="img-fluid" style="max-width: 300px; max-height: 300px;">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
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