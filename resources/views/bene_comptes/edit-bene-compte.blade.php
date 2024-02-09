@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Modifier compte depense</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('all.compte-depenses')}}">Compte depenses</a></li>
                        <li class="breadcrumb-item active">Modifier compte depense</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('update.bene-compte')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$bene_comptes->id}}">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du service</span></h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Bénéficiaire<span class="login-danger">*</span></label>
                                        <input type="text" class="form-control" name="nom" value="{{$bene_comptes->nom}}">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                    <select class="form-control select @error('compte_depense_id') is-invalid @enderror" name="compte_depense_id" id="compte_depense_id">
                                        <option selected disabled>Sélectionnez une banque</option>
                                        @foreach ($compte_depenses as $compte_depense)
                                            <option value="{{ $compte_depense->id }}" {{ old('compte_depense_id', $bene_comptes->compte_depense_id) == $compte_depense->id ? 'selected' : '' }}>
                                                {{ $compte_depense->nom }}
                                            </option>
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