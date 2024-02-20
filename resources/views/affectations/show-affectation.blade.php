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


                        <div class="row mt-10 pt-100">
                            <div class="col-xl-12">

                                <ul class="list-unstyled float-end">
                                    <li style="font-size: 30px; color: red;">Détails d'affectation</li>
                                    <!-- <li>Mode: Chèque</li> -->
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
                                        <td>Date d'affectation</td>
                                        <td>{{ $affectation->affectation_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Série de chequier</td>
                                        <td>{{ $affectation->checkbook->series }}</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de premier chèque</td>
                                        <td>{{ $affectation->start_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de dernier chèque</td>
                                        <td>{{ $affectation->end_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Service</td>
                                        <td>{{ $affectation->service->nom }}</td>
                                    </tr>
                                    <tr>
                                        <td>Courtier</td>
                                        <td>{{ $affectation->courtier->nom }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
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