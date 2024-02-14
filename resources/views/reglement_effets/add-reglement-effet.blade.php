@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Ajouter Réglement</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('all.reglement-effets')}}">Réglements</a></li>
                        <li class="breadcrumb-item active">Ajouter Réglement</li>
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
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.reglement-effet') }}" class="forms-sample" enctype="multipart/form-data" id="reglementForm">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du Réglement</span></h5>
                                </div>

                                <!-- Compte -->
                                <div class="col-12 col-sm-4 ">
                                    <div class="form-group local-forms">
                                        <label for="effet_compte_id" class="form-label">Compte: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('effet_compte_id') is-invalid @enderror" name="effet_compte_id" id="effet_compte_id" required>
                                            <option selected disabled>Sélectionnez un compte</option>
                                            @foreach ($effet_comptes as $compte)
                                            <option value="{{ $compte->id }}" data-nom="{{ $compte->nom }}">{{ $compte->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('effet_compte_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Date de règlement -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Date de règlement<span class="login-danger">*</span></label>
                                        <input type="date" name="date_reglement" class="form-control" required>
                                    </div>
                                </div>
                                <!-- Cheque -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="effet_id" class="form-label">Effet: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('effet_id') is-invalid @enderror" name="effet_id" id="effet_id" required>
                                            <option selected disabled>Sélectionnez</option>
                                            @foreach ($effets as $effet)
                                            <option value="{{ $effet->id }}">{{ $effet->effet_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('effet_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bénéficiaire -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="benefiiaire_id" class="form-label">Bénéficiaire: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('benefiiaire_id') is-invalid @enderror" name="benefiiaire_id" id="benefiiaire_id" required>
                                            <option selected disabled>Sélectionnez un bénéficiaire</option>
                                            @foreach ($benefiiaires as $benefiiaire)
                                            <option value="{{ $benefiiaire->id }}">{{ $benefiiaire->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('benefiiaire_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Service -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="service_id" class="form-label">Service: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('service_id') is-invalid @enderror" name="service_id" id="service_id" required>
                                            <option selected disabled>Sélectionnez un service</option>
                                            @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Référence -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="referance">Référence:</label>
                                        <input type="text" class="form-control" id="referance" name="referance" required>
                                    </div>
                                </div>
                                <!-- Échéance -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="echeance">Échéance:</label>
                                        <input type="date" class="form-control" id="echeance" name="echeance" required>
                                    </div>
                                </div>
                                <!-- Montant -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="montant">Montant:</label>
                                        <input type="number" class="form-control" id="montant" name="montant" required>
                                    </div>
                                </div>

                                <!-- reglement Fournisseur fields-->
                                <div id="regl-fournisseur-fields" style="display: none;" class='row'>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="sous_compte_id" class="form-label">Sous Compte: <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('sous_compte_id') is-invalid @enderror" name="sous_compte_id" id="sous_compte_id">
                                                <option selected disabled>Sélectionnez </option>
                                                @ @foreach($sous_comptes as $sous_compte)
                                                <option value="{{ $sous_compte->id }}">{{ $sous_compte->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('sous_compte_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <!-- ==================================== -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Images <span class="login-danger">*</span></label>
                                        <input id="images" type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple />
                                    </div>
                                </div>
                                <!-- Submit button -->
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


<script>
    $(document).ready(function() {
        $('#effet_compte_id').change(function() {
            var selectedCompte = $(this).find(":selected").data('nom');

            $('#regl-fournisseur-fields').hide();

            if (selectedCompte === 'Règlement fournisseurs') {
                $('#regl-fournisseur-fields').show();
            }
        });
    });
</script>
@endsection