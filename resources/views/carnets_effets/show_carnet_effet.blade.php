@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="page-title">Carnet Effets</h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
            <li class="breadcrumb-item active">Carnet Effets</li>
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
                  <h3 class="page-title">Carnet Effet</h3>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                  <!-- <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Télécharger</a> -->
                  
                  <a href="{{route('add.carnet-effet')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                </div>
                
            </div>

            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
              <thead class="student-thread">
                <tr>

                  <th>Sèrie d'effet</th>
                  <th>Effet Sie</th>
                  <th>Numéro d'effet</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @for ($i = $carnet_effet->effet_start_number; $i <= ($carnet_effet->effet_start_number + $carnet_effet->effet_quantity - 1); $i++)

                  <tr>
                    <td>{{ $carnet_effet->carnet_series }}</td>
                    <td>{{ $carnet_effet->effet_sie }}</td>
                    <td>{{ $i }}</td>
                    <td>
                      @foreach ($carnet_effet->effets as $effet)
                      @if ($effet->effet_number == $i)
                      {{ $effet->status }}
                      @endif
                      @endforeach
                    </td>
                  </tr>
                  @endfor
              </tbody>
            </table>
          </div>
        </div>
      </div>



    </div>
  </div>
</div>

@section('script')

@endsection

@endsection