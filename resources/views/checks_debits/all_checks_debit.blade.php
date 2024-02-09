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
                                                      <h3 class="page-title">Les Chéques Débits</h3>
                                                </div>
                                                <div class="col-auto text-end float-end ms-auto download-grp">
                                                      <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="table-responsive">
                                          <table class="table border-0  table-center mb-0 datatable table-striped">
                                                <thead>
                                                      <tr>
                                                            <th>#</th>
                                                            <th>Numéro de chéque</th>
                                                            <th>Série de Chéquier</th>
                                                            <th>Compte</th>
                                                            <th>Service</th>
                                                            <th>Beneficiare</th>
                                                            <th>Montant</th>
                                                            <th>Banque</th>
                                                            <th scope="col">Justification</th>
                                                            <th>Modifier</th>
                                                            <th>Display</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      @foreach ($checks as $key => $item)
                                                      <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->cheque_sie_debit }}{{ $item->check->number }}</td>
                                                            <td>{{ $item->series_debit }}</td>
                                                            <td>{{ $item->compte_debit }}</td>
                                                            <td>{{ $item->service_debit }}</td>
                                                            <td>{{ $item->beneficiare_debit }}</td>
                                                            <td>{{ $item->amount_debit }}</td>
                                                            <td>{{ $item->banque_debit }}</td>
                                                            <td>
                                                                  @if ($item->ChequeDebitImages->isNotEmpty())
                                                                  @foreach ($item->ChequeDebitImages as $image)
                                                                  <img src="{{ asset('public/photos/cheques_debit/' . $image->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                                                                  @endforeach
                                                                  @else
                                                                  Aucune image disponible
                                                                  @endif
                                                            </td>
                                                            <td class="text-end">
                                                                  <div class="actions">
                                                                        @if (Session::get('role_name') === 'Super Admin')
                                                                        <a href="{{route('edit.check-debit',$item->id)}}" class="btn btn-sm bg-danger-light">
                                                                              <i class="feather-edit"></i>
                                                                        </a>
                                                                        @endif
                                                                  </div>
                                                            </td>
                                                            <td class="text-end">
                                                                  <div class="actions">
                                                                        @if (Session::get('role_name') === 'Super Admin')
                                                                        <a href="{{route('show.check-debit',$item->id)}}" class="btn btn-sm bg-danger-light">
                                                                              <i class="feather-eye"></i>
                                                                        </a>
                                                                        @endif
                                                                  </div>
                                                            </td>

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