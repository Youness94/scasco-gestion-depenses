@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
      <div class="content container-fluid">
            <div class="page-header">
                  <div class="row align-items-center">
                        <div class="col">
                              <h3 class="page-title">Ajouter Effet Débit</h3>
                              <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('all.checks-debit')}}">Effets</a></li>
                                    <li class="breadcrumb-item active">Ajouter Effet Débit</li>
                              </ul>
                        </div>
                  </div>
            </div>

            <div class="row">
                  <div class="col-sm-12">
                        <div class="card">
                              <div class="card-body">
                                    <form method="POST" action="{{ route('update.effet-debit', ['id' => $effet_debit->id]) }}" class="forms-sample" enctype="multipart/form-data">
                                          @csrf
                                          <div class="row">
                                                <div class="col-12">
                                                      <h5 class="form-title"><span>Détails du Effet Débit</span></h5>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_id" class="form-label">Numéro du Effet: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('effet_id') is-invalid @enderror" name="effet_id[]" id="effet_id" onchange="updateFields()">
    <option value="" selected disabled>Select an effet</option>
    @foreach ($effets as $effet)
        <option value="{{ $effet->id }}" 
            {{ $effet->id == old('effet_id.' . $loop->index, $effet_debit->effet_id) ? 'selected' : '' }}
            data-effet_sie="{{ old('effet_id.' . $loop->index . '.effet_sie', $effet->carnet_effet->effet_sie) }}"
            data-banque="{{ old('effet_id.' . $loop->index . '.banque', $effet->carnet_effet->bank->nom) }}"
            data-series="{{ old('effet_id.' . $loop->index . '.carnet_series', $effet->carnet_effet->carnet_series) }}"
            data-compte="{{ old('effet_id.' . $loop->index . '.effet_compte', $effet->reglementEffet->effet_compte->nom) }}"
            data-reference="{{ old('effet_id.' . $loop->index . '.reference', $effet->reglementEffet->referance) }}"
            data-service="{{ old('effet_id.' . $loop->index . '.service', $effet->reglementEffet->service->nom) }}"
            data-beneficiaire="{{ old('effet_id.' . $loop->index . '.beneficiaire', $effet->reglementEffet->bene->nom) }}"
            data-montant="{{ old('effet_id.' . $loop->index . '.montant', $effet->reglementEffet->montant) }}">
            {{ $effet->effet_number }}
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
                                                            <label for="effet_sie_debit" class="form-label">Effet Sie:</label>
                                                            <input type="text" class="form-control" id="effet_sie_debit" name="effet_sie_debit" readonly value="{{ old('effet_sie_debit', $effet_debit->effet_sie_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_series_debit" class="form-label">Effet Series:</label>
                                                            <input type="text" class="form-control" id="effet_series_debit" name="effet_series_debit" readonly value="{{ old('effet_series_debit', $effet_debit->effet_series_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_compte_debit" class="form-label">Compte:</label>
                                                            <input type="text" class="form-control" id="effet_compte_debit" name="effet_compte_debit" readonly value="{{ old('effet_compte_debit', $effet_debit->effet_compte_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_reference_debit" class="form-label">Référence:</label>
                                                            <input type="text" class="form-control" id="effet_reference_debit" name="effet_reference_debit" readonly value="{{ old('effet_reference_debit', $effet_debit->effet_reference_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_service_debit" class="form-label">Service:</label>
                                                            <input type="text" class="form-control" id="effet_service_debit" name="effet_service_debit" readonly value="{{ old('effet_service_debit', $effet_debit->effet_service_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_beneficiare_debit" class="form-label">Bénéficiaire:</label>
                                                            <input type="text" class="form-control" id="effet_beneficiare_debit" name="effet_beneficiare_debit" readonly value="{{ old('effet_beneficiare_debit', $effet_debit->effet_beneficiare_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_banque_debit" class="form-label">Banque:</label>
                                                            <input type="text" class="form-control" id="effet_banque_debit" name="effet_banque_debit" readonly value="{{ old('effet_banque_debit', $effet_debit->effet_banque_debit) }}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_amount_debit" class="form-label">Montant:</label>
                                                            <input type="text" class="form-control" id="effet_amount_debit" name="effet_amount_debit" readonly value="{{ old('effet_amount_debit', $effet_debit->effet_amount_debit) }}">
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
            var selectElement = document.getElementById('effet_id');
            var selectedEffets = Array.from(selectElement.selectedOptions);

            if (selectedEffets.length > 0) {
                  var selectedEffet = selectedEffets[0];

                  document.getElementById('effet_sie_debit').value = selectedEffet.getAttribute('data-effet_sie');
                  document.getElementById('effet_series_debit').value = selectedEffet.getAttribute('data-series');
                  document.getElementById('effet_compte_debit').value = selectedEffet.getAttribute('data-compte');
                  document.getElementById('effet_reference_debit').value = selectedEffet.getAttribute('data-reference');
                  document.getElementById('effet_service_debit').value = selectedEffet.getAttribute('data-service');
                  document.getElementById('effet_beneficiare_debit').value = selectedEffet.getAttribute('data-beneficiaire');
                  document.getElementById('effet_amount_debit').value = selectedEffet.getAttribute('data-montant');
                  document.getElementById('effet_banque_debit').value = selectedEffet.getAttribute('data-banque');
                  console.log(document.getElementById('effet_id').value);
            } else {

            }
      }
</script>
@endsection