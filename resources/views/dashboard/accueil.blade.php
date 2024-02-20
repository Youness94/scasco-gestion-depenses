@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Bienvenue {{ Session::get('name') }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">{{ Session::get('position') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-6 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Réglements Par Cheques</h6>
                                <h3>{{$totalReglementCheque }}</h3>
                            </div>
                            <!-- <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Réglements Par Effets</h6>
                                <h3>{{$totalReglementEffet }}</h3>
                            </div>
                            <!-- <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>







        <!-- ===================================== -->
        <div class="row">

            <div class="col-md-12 col-lg-12">
                <div class="card card-chart">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title">Réglements par cheques</h5>
                            </div>
                            <div class="col-6">
                                @if (Session::get('role_name') === 'Super Admin')
                                <ul class="chart-list-out">
                                    <!-- <a href="#">Plus de détails</a> -->
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="monthlyReglemetCheque"></div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title">Réglements par effets</h5>
                                </div>
                                <div class="col-6">
                                    @if (Session::get('role_name') === 'Super Admin')
                                    <ul class="chart-list-out">
                                        <!-- <a href="#">Plus de détails</a> -->
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="monthlyReglemetEffet"></div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- =================================== -->
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title">Total des Réglements</h5>
                                </div>
                                <div class="col-6">
                                    <ul class="chart-list-out">
                                        <!-- <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===================================== -->


        <!-- ===================================== -->

        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Réglements par cheques</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="{{ route('all.reglement-cheques') }}">Tous les réglements par cheques</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        @if(count($reglement_cheque) > 0)
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date de règlement</th>
                                        <th scope="col">N de chèque</th>
                                        <th scope="col">Compte</th>
                                        <th scope="col">Bénéficiaire</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Échéance</th>
                                        <th scope="col">Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reglement_cheque->sortByDesc('date_reglement')->take(5) as $reglement)
                                    <tr>
                                        <td>{{ $reglement->id }}</td>
                                        <td>{{ $reglement->date_reglement }}</td>
                                        <td>{{ $reglement->cheque->number }}</td>
                                        <td>{{ $reglement->compte->nom }}</td>
                                        <td>{{ $reglement->bene->nom }}</td>
                                        <td>{{ $reglement->service->nom }}</td>
                                        <td>{{ $reglement->referance }}</td>
                                        <td>{{ $reglement->echeance }}</td>
                                        <td>{{ number_format(($reglement->montant ?? 0.00), 2) }}</td>
                                    </tr>
                                    @empty
                                    <!-- Handle the case where there are no records -->
                                    <tr>
                                        <td colspan="9">No records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                        <!-- Handle the case where there are no records -->
                        <p>No records found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Réglements par cheques</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="{{ route('all.reglement-effets') }}">Tous les réglements par cheques</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        @if(count($reglement_effet) > 0)
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date de règlement</th>
                                        <th scope="col">N de effet</th>
                                        <th scope="col">Compte</th>
                                        <th scope="col">Bénéficiaire</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Sous Compte</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Échéance</th>
                                        <th scope="col">Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reglement_effet->sortByDesc('date_reglement')->take(5) as $reglement)
                                    <tr>
                                        <td>{{ $reglement->id }}</td>
                                        <td>{{ $reglement->date_reglement }}</td>
                                        <td>{{ $reglement->effet->effet_number }}</td>
                                        <td>{{ $reglement->effet_compte->nom }}</td>
                                        <td>{{ $reglement->bene->nom }}</td>
                                        <td>{{ $reglement->service->nom }}</td>
                                        <td>
                                            @foreach ($reglement->reglementEffetFournisseur as $reglementFournisseur)
                                            {{ $reglementFournisseur->sousCompte->nom ?? 'N/V'}}
                                            @endforeach
                                        </td>
                                        <td>{{ $reglement->referance }}</td>
                                        <td>{{ $reglement->echeance }}</td>
                                        <td>{{ number_format(($reglement->montant ?? 0.00),2)}}</td>
                                    </tr>
                                    @empty
                                    <!-- Handle the case where there are no records -->
                                    <tr>
                                        <td colspan="9">No records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                        <!-- Handle the case where there are no records -->
                        <p>No records found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (Session::get('role_name') === 'Super Admin')
        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Les Utilisateurs</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="{{ route('all.users') }}">Tous les utilisateurs</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        @if(!empty($users) && count($users) > 0)
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users->sortByDesc('date_reception')->take(5) as $key => $list)
                                    <tr>
                                        <td class="user_id">{{ $list->user_id }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->role_name }}</td>
                                        <td>
                                            <div class="edit-delete-btn">
                                                @if ($list->status === 'Active')
                                                <a class="text-success">{{ $list->status }}</a>
                                                @elseif ($list->status === 'Inactive')
                                                <a class="text-warning">{{ $list->status }}</a>
                                                @elseif ($list->status === 'Disable')
                                                <a class="text-danger">{{ $list->status }}</a>
                                                @else
                                                <!-- Handle other cases if needed -->
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>Aucun utilisateur disponible.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection