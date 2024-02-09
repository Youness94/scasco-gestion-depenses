
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ajouter Carnet des effets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('all.carnets-effets')}}">Carnet des effets</a></li>
                            <li class="breadcrumb-item active">Ajouter Carnet des effets</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" action="{{route('store.carnet-effet')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Détails du Carnet des effets</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                        <label for="reception_date">Reception Date:</label>
                                        <input type="date" class="form-control @error('reception_date') is-invalid @enderror" id="reception_date" name="reception_date" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                        <label for="new_password" class="form-label">Bank: <span class="login-danger">*</span></label>
                                        <select class="form-control select  @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id">
                                            <option selected disabled>Sélectionnez une bank</option>
                                            @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                        <label for="effet_sie">Chèque Sie:</label>
                                        <input type="text" class="form-control" id="effet_sie" name="effet_sie" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                        <label for="effet_start_number">N de départ chéque:</label>
                                        <input type="number" class="form-control" id="effet_start_number" name="effet_start_number" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                        <label for="effet_quantity" class="form-label">Qnt des chèques</label>
                                        <input type="number"  class="form-control" id="effet_quantity" name="effet_quantity" required autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Ajouetr</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
