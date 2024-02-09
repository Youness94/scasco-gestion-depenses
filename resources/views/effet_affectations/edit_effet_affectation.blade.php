@extends('layouts.master')

@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Modifier affectation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('all.effet-affectations') }}">Affectations</a></li>
                        <li class="breadcrumb-item active">Modifier affectation</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('update.effet-affectation') }}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$effet_affectations->id}}">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du affectation</span></h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Date d'affectation <span class="login-danger">*</span></label>
                                        <input type="date" name="affectation_date" class="form-control" value="{{ $effet_affectations->affectation_date }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>N° de chequier <span class="login-danger">*</span></label>
                                        <select name="carnet_effet_id" class="form-control" id="carnetEffetSelect" required>
                                            {{-- Populate this dropdown with your checkbooks --}}
                                            <option selected disabled>Sélectionnez un chequier</option>
                                            @foreach ($carnet_effets as $carnet_effet)
                                            <option value="{{ $carnet_effet->id }}" {{ $effet_affectations->carnet_effet_id == $carnet_effet->id ? 'selected' : '' }}>{{ $carnet_effet->carnet_series }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Premier numéro de chéquier<span class="login-danger">*</span></label>
                                        <select name="start_number" class="form-control" id="startNumberSelect" required>
                                            {{-- Options will be dynamically populated based on the selected checkbook --}}
                                            {{-- Make sure to set the selected attribute for the current start_number --}}
                                            @foreach (range($effet_affectations->start_number, $effet_affectations->end_number) as $number)
                                            <option value="{{ $number }}" {{ $effet_affectations->start_number == $number ? 'selected' : '' }}>{{ $number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Dernier numéro de chéquier<span class="login-danger">*</span></label>
                                        <select name="end_number" class="form-control" id="endNumberSelect" required>
                                            {{-- Options will be dynamically populated based on the selected checkbook --}}
                                            {{-- Make sure to set the selected attribute for the current end_number --}}
                                            @foreach (range($effet_affectations->start_number, $effet_affectations->end_number) as $number)
                                            <option value="{{ $number }}" {{ $effet_affectations->end_number == $number ? 'selected' : '' }}>{{ $number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Affecter à <span class="login-danger">*</span></label>
                                        <select name="service_id" class="form-control" required>
                                            @foreach ($effet_services as $service)
                                            <option value="{{ $service->id }}" {{ $effet_affectations->service_id == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Récupérer par <span class="login-danger">*</span></label>
                                        <select name="courtier_id" class="form-control" required>
                                            @foreach ($courtiers as $courtier)
                                            <option value="{{ $courtier->id }}" {{ $effet_affectations->courtier_id == $courtier->id ? 'selected' : '' }}>{{ $courtier->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label>Images <span class="login-danger">*</span></label>
                                        <input id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" multiple />
                                        @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

<script>
   

    var carnetEffetData = @json($carnet_effets);

    
var carnetEffetSelect = document.getElementById('carnetEffetSelect');
var startNumberSelect = document.getElementById('startNumberSelect');
var endNumberSelect = document.getElementById('endNumberSelect');


carnetEffetSelect.addEventListener('change', function() {
   
    var selectedCarnetEffetId = carnetEffetSelect.value;

    
    var selectedCarneteffet = carnetEffetData.find(function(carnet_effet) {
        return carnet_effet.id == selectedCarnetEffetId;
    });

    
    startNumberSelect.innerHTML = '';
    for (var i = selectedCarneteffet.effet_start_number; i <= selectedCarneteffet.effet_start_number + selectedCarneteffet.effet_quantity - 1; i++) {
        var option = document.createElement('option');
        option.value = i;
        option.text = i;
        startNumberSelect.add(option);
    }

    
    endNumberSelect.innerHTML = '';
    for (var i = selectedCarneteffet.effet_start_number; i <= selectedCarneteffet.effet_start_number + selectedCarneteffet.effet_quantity - 1; i++) {
        var option = document.createElement('option');
        option.value = i;
        option.text = i;
        endNumberSelect.add(option);
    }
});
    // Trigger the change event to populate the start and end number dropdowns initially
    carnetEffetSelect.dispatchEvent(new Event('change'));
</script>
@endsection