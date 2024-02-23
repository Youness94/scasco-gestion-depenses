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
                                    <li class="breadcrumb-item"><a href="{{route('all.effets-non-consommes')}}">Chèquiers</a></li>
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
                              <form method="POST" action="{{ route('update.effet-cancelled', ['id' => $effet_annules->id]) }}" class="forms-sample" enctype="multipart/form-data">
                                          @csrf
                                          <div class="row">
                                                <div class="col-12">
                                                      <h5 class="form-title"><span>Détails du Effet Annulé</span></h5>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_id" class="form-label">Numéro du Effet:
                                                                  <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('effet_id') is-invalid @enderror" name="effet_id[]" id="effet_id" onchange="updateFields()">
                                                                  <option selected disabled>Sélectionnez un effet</option>
                                                                  @foreach ($effets as $effet)
                                                                  <option value="{{ $effet->id }}" {{ $effet->id == $effet_annules -> effet_id ? 'selected' : '' }} data-effet_sie="{{ old('effet_id.' . $loop->index . '.effet_sie', $effet->carnet_effet->effet_sie) }}" data-banque="{{ old('effet_id.' . $loop->index . '.banque', $effet->carnet_effet->bank->nom) }}" data-series="{{ old('effet_id.' . $loop->index . '.carnet_series', $effet->carnet_effet->carnet_series) }}" {{ in_array($effet->id, old('effet_id', [])) ? 'selected' : '' }}>
                                                                        {{ $effet->effet_number }}
                                                                  </option>
                                                                  @endforeach
                                                            </select>
                                                            @error('effet_id.0') {{-- Use 'effet_id.0' because it's an array --}}
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="effet_sie_annule" class="form-label">Effet SIE:</label>
                                                            <input type="text" class="form-control" id="effet_sie_annule" name="effet_sie_annule" value="{{ old('effet_sie_annule', $effet_annules->effet_sie_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="series_effet_annule" class="form-label">Carnet Series:</label>
                                                            <input type="text" class="form-control" id="series_effet_annule" name="series_effet_annule" value="{{ old('series_effet_annule', $effet_annules->series_effet_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="bank_effet_annule" class="form-label">Banque:</label>
                                                            <input type="text" class="form-control" id="bank_effet_annule" name="bank_effet_annule" value="{{ old('bank_effet_annule', $effet_annules->bank_effet_annule) }}" readonly>
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="benefiiaire_id" class="form-label">Bénéficiaire: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('benefiiaire_id') is-invalid @enderror" name="benefiiaire_id" id="benefiiaire_id">
                                                                  <option selected disabled>Sélectionnez un bénéficiaire</option>
                                                                  @foreach ($beneficiares as $beneficiaire)
                                                                  <option value="{{ $beneficiaire->id }}" {{ $beneficiaire->id == $effet_annules -> benefiiaire_id ? 'selected' : '' }}>
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
                                                            <label for="effet_compte_id" class="form-label">Compte: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('effet_compte_id') is-invalid @enderror" name="effet_compte_id" id="effet_compte_id">
                                                                  <option selected disabled>Sélectionnez un compte</option>
                                                                  @foreach ($effet_comptes as $compte)
                                                                  <option value="{{ $compte->id }}" {{ $compte->id == $effet_annules -> effet_compte_id ? 'selected' : '' }}>{{ $compte->nom }}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('effet_compte_id')
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
                                                                  <option value="{{ $service->id }}" {{ $service->id == $effet_annules -> service_id ? 'selected' : '' }}>{{ $service->nom }}</option>
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
                                                            <label for="refe_effet_annule">Référence:</label>
                                                            <input type="text" class="form-control" id="refe_effet_annule" name="refe_effet_annule" value="{{$effet_annules->refe_effet_annule}}">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="montant_annule">Monatant:</label>
                                                            <input type="number" class="form-control" id="montant_annule" name="montant_annule" value="{{$effet_annules->montant_annule}}" step="0.01">
                                                      </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                      <div class="form-group local-forms">
                                                            <label for="retour_effet_annule" class="form-label">RETOUR CHEQUE PHYSIQUE: <span class="login-danger">*</span></label>
                                                            <select class="form-control select @error('retour_effet_annule') is-invalid @enderror" name="retour_effet_annule" id="retour_effet_annule">
                                                                  <option value="Oui" {{ old('retour_effet_annule') == 'Oui' ? 'selected' : '' }}>Oui</option>
                                                                  <option value="Non" {{ old('retour_effet_annule') == 'Non' ? 'selected' : '' }}>Non</option>
                                                            </select>
                                                            @error('retour_effet_annule')
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
            var selectElement = document.getElementById('effet_id');
            var selectedEffets = Array.from(selectElement.selectedOptions);

            if (selectedEffets.length > 0) {
                  var selectedEffet = selectedEffets[0];

                  document.getElementById('effet_sie_annule').value = selectedEffet.getAttribute('data-effet_sie');
                  document.getElementById('series_effet_annule').value = selectedEffet.getAttribute('data-series');
                  document.getElementById('bank_effet_annule').value = selectedEffet.getAttribute('data-banque');
                  // document.getElementById('compte').value = selectedEffet.getAttribute('data-compte');
                  // document.getElementById('reference').value = selectedEffet.getAttribute('data-reference');
                  // document.getElementById('service').value = selectedEffet.getAttribute('data-service');
                  // document.getElementById('beneficiaire').value = selectedEffet.getAttribute('data-beneficiaire');
                  // document.getElementById('montant').value = selectedEffet.getAttribute('data-montant');
                  console.log(document.getElementById('bank_effet_annule').value);
            } else {

            }
      }
</script>
@endsection