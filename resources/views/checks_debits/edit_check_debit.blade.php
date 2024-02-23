@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
      <div class="content container-fluid">
            <div class="page-header">
                  <div class="row align-items-center">
                        <div class="col">
                              <h3 class="page-title">Ajouter Chèque Annulé</h3>
                              <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('all.checks-debit')}}">Chèquiers</a></li>
                                    <li class="breadcrumb-item active">Ajouter Chèque Annulé</li>
                              </ul>
                        </div>
                  </div>
            </div>

            <div class="row">
                  <div class="col-sm-12">
                        <div class="card">
                              <div class="card-body">
                                    <form method="POST" action="{{ route('update.check-debit', ['id' => $check_debit->id]) }}" class="forms-sample" enctype="multipart/form-data">
                                          @csrf
                                          <div class="row">
                                                <div class="col-12">
                                                      <h5 class="form-title"><span>Détails du Chèque Débit</span></h5>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="check_number" class="form-label">Numéro du Chèque: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('check_id') is-invalid @enderror" name="check_id[]" id="check_id" onchange="updateFields()">
                                                                  <option selected disabled>Sélectionnez un cheque</option>
                                                                  @foreach ($checks as $check)
                                                                  <option value="{{ $check->id }}" {{ $check->id == $check_debit -> check_id ? 'selected' : '' }} data-cheque_sie="{{ old('check_id.' . $loop->index . '.cheque_sie', $check->checkbook->cheque_sie) }}" data-banque="{{ old('check_id.' . $loop->index . '.banque', $check->checkbook->bank->nom) }}" data-series="{{ old('check_id.' . $loop->index . '.series', $check->checkbook->series) }}" data-compte="{{ old('check_id.' . $loop->index . '.compte', $check->reglementCheque->compte->nom) }}" data-reference="{{ old('check_id.' . $loop->index . '.reference', $check->reglementCheque->referance) }}" data-service="{{ old('check_id.' . $loop->index . '.service', $check->reglementCheque->service->nom) }}" data-beneficiaire="{{ old('check_id.' . $loop->index . '.beneficiaire', $check->reglementCheque->bene->nom) }}" data-montant="{{ old('check_id.' . $loop->index . '.montant', $check->reglementCheque->montant) }}" {{ old('check_id.' . $loop->index) == $check_debit -> check_id ? 'selected' : '' }}>

                                                                        {{ $check->number }}
                                                                  </option>
                                                                  @endforeach
                                                            </select>
                                                            @error('check_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="date_debit" class="form-label">Date de debit:</label>
                                                            <input type="date" class="form-control" id="date_debit" name="date_debit" value="{{$check_debit->date_debit}}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="cheque_sie_debit" class="form-label">Chèque Sie:</label>
                                                            <input type="text" class="form-control" id="cheque_sie_debit" name="cheque_sie_debit" readonly value="{{ old('cheque_sie_debit', $check_debit->cheque_sie_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="series_debit" class="form-label">Checkbook Series:</label>
                                                            <input type="text" class="form-control" id="series_debit" name="series_debit" readonly value="{{ old('series_debit', $check_debit->series_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="compte_debit" class="form-label">Compte:</label>
                                                            <input type="text" class="form-control" id="compte_debit" name="compte_debit" readonly value="{{ old('compte_debit', $check_debit->compte_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="reference_debit" class="form-label">Référence:</label>
                                                            <input type="text" class="form-control" id="reference_debit" name="reference_debit" readonly value="{{ old('reference_debit', $check_debit->reference_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="service_debit" class="form-label">Service:</label>
                                                            <input type="text" class="form-control" id="service_debit" name="service_debit" readonly value="{{ old('service_debit', $check_debit->service_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="beneficiaire_debit" class="form-label">Bénéficiaire:</label>
                                                            <input type="text" class="form-control" id="beneficiaire_debit" name="beneficiaire_debit" readonly value="{{ old('beneficiaire_debit', $check_debit->beneficiare_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="banque_debit" class="form-label">Banque:</label>
                                                            <input type="text" class="form-control" id="banque_debit" name="banque_debit" readonly value="{{ old('banque_debit', $check_debit->banque_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="montant_debit" class="form-label">Montant:</label>
                                                            <input type="text" class="form-control" id="montant_debit" name="montant_debit" readonly value="{{ old('amount_debit', $check_debit->amount_debit) }}">
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