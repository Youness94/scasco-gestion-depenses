@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Ajouter Bénéficiaire</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('all.services')}}">Bénéficiaires</a></li>
                        <li class="breadcrumb-item active">Ajouter Bénéficiaire</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.bene-compte') }}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du Bénéficiaire</span></h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Bénéficiaire<span class="login-danger">*</span></label>
                                        <input type="text" class="form-control" name="nom">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label for="compte_depense_id" class="form-label">Bank: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('compte_depense_id') is-invalid @enderror" name="compte_depense_id" id="compte_depense_id">
                                            <option selected disabled>Sélectionnez une banque</option>
                                            @foreach ($compte_depenses as $compte_depense)
                                            <option value="{{ $compte_depense->id }}">{{ $compte_depense->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('compte_depense_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Soumettre</button>
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