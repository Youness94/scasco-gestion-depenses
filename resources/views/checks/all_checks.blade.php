@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
      <div class="content container-fluid">

            <div class="page-header">
                  <div class="row align-items-center">
                        <div class="col">
                              <h3 class="page-title">Les Chéques non consommés</h3>
                              <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                                    <li class="breadcrumb-item active">Les Chéques non consommés</li>
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
                                                      <h3 class="page-title">Les Chéques non consommés</h3>
                                                </div>
                                                <div class="col-auto text-end float-end ms-auto download-grp">
                                                      <!-- <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a> -->
                                                </div>
                                          </div>
                                    </div>
                                    <div class="table-responsive">
                                          <table class="table border-0  table-center mb-0 datatable table-striped">
                                                <thead>
                                                      <tr>
                                                            <th>#</th>
                                                            <th>Date de réception</th>
                                                            <th>Série de Chéquier</th>
                                                            <th>Numéro de chéque</th>
                                                            <th>Service</th>
                                                            <th>Status</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      @foreach ($checks as $key => $item)
                                                      <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->checkbook->reception_date }}</td>
                                                            <td>{{ $item->checkbook->series }}</td>
                                                            <td>{{ $item->cheque_sie }} {{ $item->number }}</td>
                                                            <td>
                                                                  @if($item->checkbook && $item->checkbook->affectation && $item->checkbook->affectation->service)
                                                                  {{ $item->checkbook->affectation->service->nom }}
                                                                  @else
                                                                  N/A
                                                                  @endif
                                                            </td>

                                                            <td>{{ $item->status }}</td>
                                                      </tr>
                                                      @endforeach
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