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
                                    <li class="breadcrumb-item"><a href="{{route('all.checks-non-consommes')}}">Chèquiers</a></li>
                                    <li class="breadcrumb-item active">Ajouter Chèque Annulé</li>
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
                              <form method="POST" action="{{ route('update.check-cancelled', ['id' => $check_annules->id]) }}" class="forms-sample" enctype="multipart/form-data">
                                          @csrf
                                          <div class="row">
                                                <div class="col-12">
                                                      <h5 class="form-title"><span>Détails du Chèque Annulé</span></h5>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="check_id" class="form-label">Numéro du Chèque:
                                                                  <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('check_id') is-invalid @enderror" name="check_id[]" id="check_id" onchange="updateFields()">
                                                                  <option selected disabled>Sélectionnez un cheque</option>
                                                                  @foreach ($checks as $check)
                                                                  <option value="{{ $check->id }}" {{ $check->id == $check_annules -> check_id ? 'selected' : '' }} data-cheque_sie="{{ old('check_id.' . $loop->index . '.cheque_sie', $check->checkbook->cheque_sie) }}" data-banque="{{ old('check_id.' . $loop->index . '.banque', $check->checkbook->bank->nom) }}" data-series="{{ old('check_id.' . $loop->index . '.series', $check->checkbook->series) }}" {{ in_array($check->id, old('check_id', [])) ? 'selected' : '' }}>
                                                                        {{ $check->number }}
                                                                  </option>
                                                                  @endforeach
                                                            </select>
                                                            @error('check_id.0') {{-- Use 'check_id.0' because it's an array --}}
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="cheque_sie_annule" class="form-label">Cheque SIE:</label>
                                                            <input type="text" class="form-control" id="cheque_sie_annule" name="cheque_sie_annule" value="{{ old('cheque_sie_annule', $check_annules->cheque_sie_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="series_checkbook_annule" class="form-label">Checkbook Series:</label>
                                                            <input type="text" class="form-control" id="series_checkbook_annule" name="series_checkbook_annule" value="{{ old('series_checkbook_annule', $check_annules->series_checkbook_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="bank_check_annule" class="form-label">Banque:</label>
                                                            <input type="text" class="form-control" id="bank_check_annule" name="bank_check_annule" value="{{ old('bank_check_annule', $check_annules->bank_check_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="benefiiaire_id" class="form-label">Bénéficiaire: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('benefiiaire_id') is-invalid @enderror" name="benefiiaire_id" id="benefiiaire_id">
                                                                  <option selected disabled>Sélectionnez un bénéficiaire</option>
                                                                  @foreach ($beneficiares as $beneficiaire)
                                                                  <option value="{{ $beneficiaire->id }}" {{ $beneficiaire->id == $check_annules -> benefiiaire_id ? 'selected' : '' }}>
                                                                        {{ $beneficiaire->nom }}
                                                                  </option>
                                                                  @endforeach
                                                            </select>
                                                            @error('beneficiaire_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                      </div>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="compte_id" class="form-label">Compte: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('compte_id') is-invalid @enderror" name="compte_id" id="compte_id">
                                                                  <option selected disabled>Sélectionnez un bénéficiaire</option>
                                                                  @foreach ($comptes as $compte)
                                                                  <option value="{{ $compte->id }}" {{ $compte->id == $check_annules -> compte_id ? 'selected' : '' }}>{{ $compte->nom }}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('compte_id')
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
                                                            <select class="form-control select @error('service_id') is-invalid @enderror" name="service_id" id="service_id">
                                                                  <option selected disabled>Select a service</option>
                                                                  @foreach ($services as $service)
                                                                  <option value="{{ $service->id }}" {{ $service->id == $check_annules -> service_id ? 'selected' : '' }}>{{ $service->nom }}</option>
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
                                                            <label for="refe_check_annule">Référence:</label>
                                                            <input type="text" class="form-control" id="refe_check_annule" name="refe_check_annule" value="{{$check_annules->refe_check_annule}}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="montant_annule">Monatant:</label>
                                                            <input type="text" class="form-control" id="montant_annule" name="montant_annule" value="{{$check_annules->montant_annule}}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="retour_check_annule" class="form-label">RETOUR CHEQUE PHYSIQUE: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('retour_check_annule') is-invalid @enderror" name="retour_check_annule" id="retour_check_annule">
                                                                  <option value="Oui" {{ old('retour_check_annule') == 'Oui' ? 'selected' : '' }}>Oui</option>
                                                                  <option value="Non" {{ old('retour_check_annule') == 'Non' ? 'selected' : '' }}>Non</option>
                                                            </select>
                                                            @error('retour_check_annule')
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
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

                  document.getElementById('cheque_sie_annule').value = selectedCheck.getAttribute('data-cheque_sie');
                  document.getElementById('series_checkbook_annule').value = selectedCheck.getAttribute('data-series');
                  document.getElementById('bank_check_annule').value = selectedCheck.getAttribute('data-banque');
                  // document.getElementById('compte').value = selectedCheck.getAttribute('data-compte');
                  // document.getElementById('reference').value = selectedCheck.getAttribute('data-reference');
                  // document.getElementById('service').value = selectedCheck.getAttribute('data-service');
                  // document.getElementById('beneficiaire').value = selectedCheck.getAttribute('data-beneficiaire');
                  // document.getElementById('montant').value = selectedCheck.getAttribute('data-montant');
                  console.log(document.getElementById('bank_check_annule').value);
            } else {

            }
      }
</script>
@endsection