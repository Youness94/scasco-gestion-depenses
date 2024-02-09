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
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Productions</h6>
                                <!-- <h3></h3> -->
                            </div>
                            <!-- <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Sinistres AT&RD</h6>
                                <!-- <h3></h3> -->
                            </div>
                            <!-- <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Sinistres Dim</h6>
                                <!-- <h3></h3> -->
                            </div>
                            <!-- <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
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
                                <h5 class="card-title">Nombre de Productions</h5>
                            </div>
                            <div class="col-6">
                                @if (Session::get('role_name') === 'Super Admin')
                                <ul class="chart-list-out">
                                    <a href="#">Plus de détails</a>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="monthlyProductionChart"></div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title">Nombre de Sinistres Dim</h5>
                                </div>
                                <div class="col-6">
                                    @if (Session::get('role_name') === 'Super Admin')
                                    <ul class="chart-list-out">
                                        <a href="#">Plus de détails</a>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="monthlySinistresDimChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title">Nombre de Sinistres AT&RD</h5>
                                </div>
                                <div class="col-6">
                                    @if (Session::get('role_name') === 'Super Admin')
                                    <ul class="chart-list-out">
                                        <a href="#">Plus de détails</a>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="monthlySinistresAtRdChart"></div>
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
                                    <h5 class="card-title">Total des courriers</h5>
                                </div>
                                <div class="col-6">
                                    <ul class="chart-list-out">
                                        <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a></li>
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
                        <h5 class="card-title">Productions</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="#">Tous les productions</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date de Réception</th>
                                        <th>Nom de police</th>
                                        <th>Numero Sinistre</th>
                                        <th>Nom Assuré</th>
                                        <th>Nom de Victime</th>
                                        <th>Branche</th>
                                        <th>Compagnie</th>
                                        <th>Acte de gestion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Sinistre AT&RD</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="#">Tous les sinistres AT&RD</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date de Réception</th>
                                        <th>Nom de police</th>
                                        <th>Numero Sinistre</th>
                                        <th>Nom Assuré</th>
                                        <th>Nom de Victime</th>
                                        <th>Branche</th>
                                        <th>Compagnie</th>
                                        <th>Acte de gestion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Sinistre DIM</h5>
                        <ul class="chart-list-out student-ellips">
                            <a href="#">Tous les sinistres DIM</a>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date de Réception</th>
                                        <th>Nom de police</th>
                                        <th>Numero Sinistre</th>
                                        <th>Nom Assuré</th>
                                        <th>Nom de Victime</th>
                                        <th>Branche</th>
                                        <th>Compagnie</th>
                                        <th>Acte de gestion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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