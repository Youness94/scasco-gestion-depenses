@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
      <div class="content container-fluid">

            <div class="page-header">
                  <div class="row align-items-center">
                        <div class="col">
                              <h3 class="page-title">Les Chéques Débits</h3>
                              <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                                    <li class="breadcrumb-item active">Les Chéques Débits</li>
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
                                                      <h3 class="page-title">Les Chéques Débits</h3>
                                                </div>
                                                <div class="col-auto text-end float-end ms-auto download-grp">
                                                      <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="table-responsive">
                                          <div>
                                                <h1>Show Check Debit</h1>

                                                <!-- Display Check Debit details -->
                                                <p>ID: {{ $checks_debits->id }}</p>

                                                <!-- Display Cheque Debit Images -->
                                                <h2>Cheque Debit Images</h2>
                                                @if ($checks_debits->ChequeDebitImages->isNotEmpty())
                                                @foreach ($checks_debits->ChequeDebitImages as $image)
                                                <img src="{{ asset('public/photos/cheques_debit/' . $image->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                                                @endforeach
                                                @else
                                                Aucune image disponible
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