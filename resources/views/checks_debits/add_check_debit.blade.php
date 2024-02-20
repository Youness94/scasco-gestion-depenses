@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Ajouter Chèque Débit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('all.checks-debit')}}">Chèquiers</a></li>
                        <li class="breadcrumb-item active">Ajouter Chèque Débit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.check-debit') }}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du Chèque Débit</span></h5>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="check_number" class="form-label">Numéro du Chèque:
                                            <span class="login-danger">*</span></label>
                                        <select class="form-control select @error('check_id') is-invalid @enderror" name="check_id[]" id="check_id" onchange="updateFields()">
                                            <option selected disabled>Sélectionnez un cheque</option>
                                            @foreach ($checks as $check)
                                            <option value="{{ $check->id }}" data-cheque_sie="{{ $check->checkbook->cheque_sie }}" data-banque="{{ $check->checkbook->bank->nom }}" data-series="{{ $check->checkbook->series }}" data-compte="{{ $check->reglementCheque->compte->nom }}" data-reference="{{ $check->reglementCheque->referance }}" data-service="{{ $check->reglementCheque->service->nom }}" data-beneficiaire="{{ $check->reglementCheque->bene->nom }}" data-montant="{{ $check->reglementCheque->montant }}">
                                                {{ $check->number }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('check_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="cheque_sie_debit" class="form-label">Chèque Sie:</label>
                                        <input type="text" class="form-control" id="cheque_sie_debit" name="cheque_sie_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="series_debit" class="form-label">Checkbook Series:</label>
                                        <input type="text" class="form-control" id="series_debit" name="series_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="compte_debit" class="form-label">Compte:</label>
                                        <input type="text" class="form-control" id="compte_debit" name="compte_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="reference_debit" class="form-label">Référence:</label>
                                        <input type="text" class="form-control" id="reference_debit" name="reference_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="service_debit" class="form-label">Service:</label>
                                        <input type="text" class="form-control" id="service_debit" name="service_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="beneficiaire_debit" class="form-label">Bénéficiaire:</label>
                                        <input type="text" class="form-control" id="beneficiaire_debit" name="beneficiaire_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="banque_debit" class="form-label">Banque:</label>
                                        <input type="text" class="form-control" id="banque_debit" name="banque_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label for="montant_debit" class="form-label">Montant:</label>
                                        <input type="text" class="form-control" id="montant_debit" name="montant_debit" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Photo: </label>
                                        <input id="images" type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple />
                        
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
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
    function updateFields() {
        var selectElement = document.getElementById('check_id');
        var selectedChecks = Array.from(selectElement.selectedOptions);

        if (selectedChecks.length > 0) {
            var selectedCheck = selectedChecks[0];

            document.getElementById('cheque_sie_debit').value = selectedCheck.getAttribute('data-cheque_sie');
            document.getElementById('series_debit').value = selectedCheck.getAttribute('data-series');
            document.getElementById('compte_debit').value = selectedCheck.getAttribute('data-compte');
            document.getElementById('reference_debit').value = selectedCheck.getAttribute('data-reference');
            document.getElementById('service_debit').value = selectedCheck.getAttribute('data-service');
            document.getElementById('beneficiaire_debit').value = selectedCheck.getAttribute('data-beneficiaire');
            document.getElementById('montant_debit').value = selectedCheck.getAttribute('data-montant');
            document.getElementById('banque_debit').value = selectedCheck.getAttribute('data-banque');
            console.log(document.getElementById('check_id').value);
        } else {

        }
    }
</script>
@endsection