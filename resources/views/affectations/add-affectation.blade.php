@extends('layouts.master')

@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Ajouter affectation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('all.affectations') }}">Affectations</a></li>
                        <li class="breadcrumb-item active">Ajouter affectation</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store.affectation') }}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Détails du affectation</span></h5>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Date d'affectation <span class="login-danger">*</span></label>
                                        <input type="date" name="affectation_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>N° de chequier <span class="login-danger">*</span></label>
                                        <select name="checkbook_id" class="form-control" id="checkbookSelect" required>
                                            {{-- Populate this dropdown with your checkbooks --}}
                                            <option selected disabled>Sélectionnez un chequier</option>
                                            @foreach ($checkbooks as $checkbook)
                                            <option value="{{ $checkbook->id }}">{{ $checkbook->series }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Premier numéro de chéquier<span class="login-danger">*</span></label>
                                        <select name="start_number" class="form-control" id="startNumberSelect" required>
                                            {{-- Options will be dynamically populated based on the selected checkbook --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Dernier numéro de chéquier<span class="login-danger">*</span></label>
                                        <select name="end_number" class="form-control" id="endNumberSelect" required>
                                            {{-- Options will be dynamically populated based on the selected checkbook --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Affecter à <span class="login-danger">*</span></label>
                                        <select name="service_id" class="form-control" required>
                                            @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Récupérer par <span class="login-danger">*</span></label>
                                        <select name="courtier_id" class="form-control" required>
                                            @foreach ($courtiers as $courtier)
                                            <option value="{{ $courtier->id }}">{{ $courtier->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label>Images <span class="login-danger">*</span></label>
                                        <input id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple />
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
    // Get the checkbook data from the server
    var checkbookData = @json($checkbooks);

    // Get references to the select elements
    var checkbookSelect = document.getElementById('checkbookSelect');
    var startNumberSelect = document.getElementById('startNumberSelect');
    var endNumberSelect = document.getElementById('endNumberSelect');

    // Event listener for changes in the checkbook dropdown
    checkbookSelect.addEventListener('change', function() {
        // Get the selected checkbook ID
        var selectedCheckbookId = checkbookSelect.value;

        // Find the selected checkbook in the checkbookData array
        var selectedCheckbook = checkbookData.find(function(checkbook) {
            return checkbook.id == selectedCheckbookId;
        });

        // Populate start number dropdown
        startNumberSelect.innerHTML = '';
        for (var i = selectedCheckbook.start_number; i <= selectedCheckbook.start_number + selectedCheckbook.quantity - 1; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            startNumberSelect.add(option);
        }

        // Populate end number dropdown
        endNumberSelect.innerHTML = '';
        for (var i = selectedCheckbook.start_number; i <= selectedCheckbook.start_number + selectedCheckbook.quantity - 1; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            endNumberSelect.add(option);
        }
    });
</script>
@endsection