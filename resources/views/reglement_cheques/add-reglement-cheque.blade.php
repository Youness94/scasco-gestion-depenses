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
                        <li class="breadcrumb-item"><a href="{{route('all.reglement-cheques')}}">Réglements</a></li>
                        <li class="breadcrumb-item active">Ajouter Réglement</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.reglement-cheque') }}" class="forms-sample" enctype="multipart/form-data" id="reglementForm">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du Réglement</span></h5>
                                </div>

                                <!-- Compte -->
                                <div class="col-12 col-sm-4 ">
                                    <div class="form-group local-forms">
                                        <label for="compte_id" class="form-label">Compte: <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('compte_id') is-invalid @enderror" name="compte_id" id="compte_id" required>
                                            <option selected disabled>Sélectionnez un compte</option>
                                            @foreach ($comptes as $compte)
                                            <option value="{{ $compte->id }}" data-nom="{{ $compte->nom }}">{{ $compte->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('compte_id')
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
                                        <label for="chaque_id" class="form-label">Chèque: <span class="login-danger">*</span></label>
                                        <select class="js-example-basic-single form-control form-control select @error('cheque_id') is-invalid @enderror" name="cheque_id" id="cheque_id" required>
                                            <option selected disabled>Sélectionnez</option>
                                            @foreach ($checks as $check)
                                            <option value="{{ $check->id }}">{{ $check->number }}</option>
                                            @endforeach
                                        </select>
                                        @error('chaque_id')
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
                                        <input type="number" class="form-control" id="montant" name="montant" step="0.01" required>
                                    </div>
                                </div>
                                <!--  -->
                                <div id="regl-automobiles-fields" style="display: none;" class="row">

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="companier_id" class="form-label">Compagnie: <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('companier_id') is-invalid @enderror" name="companier_id" id="companier_id">
                                                <option selected disabled>Sélectionnez </option>
                                                @foreach($compagnies as $companie)
                                                <option value="{{ $companie->id }}">{{ $companie->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('companier_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Réferance dossier -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_dossier_auto">Réferance dossier: </label>
                                            <input type="text" class="form-control" id="referance_dossier_auto" name="referance_dossier_auto">
                                        </div>
                                    </div>
                                    <!-- Réferance quittance -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_quittance_auto">Réferance quittance:</label>
                                            <input type="text" class="form-control" id="referance_quittance_auto" name="referance_quittance_auto">
                                        </div>
                                    </div>
                                </div>
                                <!-- ================ -->

                                <!-- reglement RDP fields-->
                                <div id="regl-rdp-fields" style="display: none;" class='row'>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="companier_id" class="form-label">Compagnie: <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('companier_id') is-invalid @enderror" name="companier_id" id="companier_id">
                                                <option selected disabled>Sélectionnez </option>
                                                @foreach($compagnies as $companie)
                                                <option value="{{ $companie->id }}">{{ $companie->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('companier_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Réferance dossier -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_dossier">Réferance dossier: </label>
                                            <input type="text" class="form-control" id="referance_dossier" name="referance_dossier">
                                        </div>
                                    </div>
                                    <!-- Réferance quittance -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_quittance">Réferance quittance:</label>
                                            <input type="text" class="form-control" id="referance_quittance" name="referance_quittance">
                                        </div>
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


                                <!-- reglement clt-ristournes fields-->
                                <div id="regl-clt-ristournes-fields" style="display: none;" class='row'>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="companier_id" class="form-label">Compagnie: <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('companier_id') is-invalid @enderror" name="companier_id" id="companier_id">
                                                <option selected disabled>Sélectionnez </option>
                                                @foreach($compagnies as $companie)
                                                <option value="{{ $companie->id }}">{{ $companie->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('companier_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Réferance dossier -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_diam">Réferance DIAM:</label>
                                            <input type="text" class="form-control" id="referance_diam" name="referance_diam">
                                        </div>
                                    </div>
                                    <!-- Réferance quittance -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label for="referance_cie">Réferance CIE:</label>
                                            <input type="text" class="form-control" id="referance_cie" name="referance_cie">
                                        </div>
                                    </div>
                                </div>
                                <!-- ==================================== -->
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Images <span class="login-danger">*</span></label>
                                        <input id="images" type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple />
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
        $('#compte_id').change(function() {
            var selectedCompte = $(this).find(":selected").data('nom');

            $('#regl-automobiles-fields, #regl-rdp-fields, #regl-fournisseur-fields, #regl-clt-ristournes-fields').hide();

            if (selectedCompte === 'Règlement sinistres automobiles') {
                $('#regl-automobiles-fields').show();
            } else if (selectedCompte === 'Règlement sinistres RDP') {
                $('#regl-rdp-fields').show();
            } else if (selectedCompte === 'Règlement fournisseurs') {
                $('#regl-fournisseur-fields').show();
            } else if (selectedCompte === 'Règlement clients - Ristournes') {
                $('#regl-clt-ristournes-fields').show();
            }
        });

        $('.js-example-basic-single').select2();

        
        // function checkIfSelected() {
        //     var selectedChequeId = $('#cheque_id').val();
        //     $.ajax({

        //         url: '/checkIfChequeSelected',
        //         method: 'GET',
        //         data: {
        //             cheque_id: selectedChequeId
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if (data.selected) {
        //                 $('#relatedDiv').hide();

        //                 $('#cheque_id option[value="' + selectedChequeId + '"]').remove();
        //                 $('#cheque_id').val('');
        //             } else {
        //                 $('#relatedDiv').show();
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // }

        // checkIfSelected();


        // $('#cheque_id').change(function() {
        //     checkIfSelected();
        // });

        // ============         // =====

        // $('#reglementForm').submit(function (event) {
        //     var compteId = $('#compte_id').val();
        //     if (!compteId || compteId === 'disabled') {
        //         alert('Veuillez sélectionner un compte.');
        //         event.preventDefault();
        //     }
        // });
    });
</script>
@endsection