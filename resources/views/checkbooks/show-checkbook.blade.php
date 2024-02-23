@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="page-title">Chéquiers</h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
            <li class="breadcrumb-item active">Chéquiers</li>
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
                  <h3 class="page-title">Chéquier</h3>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                  <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                  <a href="{{route('add.checkbook')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                </div>
              </div>
            </div>

            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
              <thead class="student-thread">
                <tr>

                  <th>Sèrie de Chèquier</th>
                  <th>Chèque Sie</th>
                  <th>Numéro de Chèque</th>
                  <!-- <th>Status</th> -->
                </tr>
              </thead>
              <tbody>
                @for ($i = $checkbooks->start_number; $i <= ($checkbooks->start_number + $checkbooks->quantity - 1); $i++)

                  <tr>
                    <td>{{ $checkbooks->series }}</td>
                    <td>{{ $checkbooks->cheque_sie }} {{ $i }}</td>
                    <td>{{ $checkbooks->cheque_sie }} {{ $i }}</td>
                    <!-- <td>{{ $checkbooks->status }}</td>  -->
                  </tr>
                  @endfor
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <!-- <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="card-text mb-3">N de départ chéquier: <p>{{ $checkbooks->series }}</p>
            </h6>
            <h6 class="card-text mb-3">N de départ chéque: <p>{{ $checkbooks->cheque_sie }} {{ $checkbooks->start_number }}</p>
            </h6>
            <h6 class="card-text mb-3">Quantity: <p>{{ $checkbooks->quantity }}</p>
            </h6>

            @if ($checkbooks->checks()->count() < $checkbooks->quantity)
              <form method="POST" action="{{ route('add.fillChecks', $checkbooks->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Fill Check Schedule Automatically</button>

              </form>
              @else
              <h4 class="card-text mb-3">Checkbook is already filled.</h4>
              @endif
             
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>

@section('script')

@endsection

@endsection