@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Carnet des Effets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Carnet des Effets</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4 mt-2">
            <form action="{{ route('store.excel.with.effets') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit">Import</button>
                </div>
            </form>
        </div> -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">File Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('store.excel.with.effets') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-md-4 mt-2">
                            <!-- <form action="{{ route('store.excel.with.effets') }}" method="POST" enctype="multipart/form-data"> -->
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h5 class="card-title"></h5> -->
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="fileInput" name="file" required>
                                                <!-- <label class="custom-file-label" for="fileInput">Choose file</label> -->
                                            </div>
                                            <!-- <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                    </form>
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
                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                            <div class="col-md-5">
                                    <h3 class="page-title">Effets</h3>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <form action="{{ route('carnet_effet.search') }}" method="GET" >
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                            <a href="{{ route('all.carnets-effets') }}" class="btn btn-outline-secondary" aria-describedby="button-addon2"><i class="fa">&#xf021;</i></a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('add.carnet-effet') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        import
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table border-0  table-center mb-0 datatable table-striped">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>Date de réception</th>
                                        <th>Série d'effet</th>
                                        <th>Numéro de départ</th>
                                        <th>Qnt des effets</th>
                                        <th>Banque</th>
                                        <th>Afficher</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                        <th>Valider</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carnets_effets as $key => $item)
                                    <tr>

                                        <td>{{$key+1}}</td>
                                        <td>{{$item->reception_date}}</td>
                                        <td>{{$item->carnet_series}}</td>
                                        <td>{{ $item->effet_sie }} {{ $item->effet_start_number }}</td>
                                        <td>{{$item->effet_quantity}}</td>
                                        <td>{{ optional($item->bank)->nom ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{route('show.carnet-effet',$item->id)}}" class=" btn btn-inverse-danger"><i class="feather-eye"></i></a>
                                        </td>
                                        <!-- <td>
                                            <a href="{{route('edit.carnet-effet',$item->id)}}" class="btn btn-inverse-warning"><i class="feather-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('delete.carnet-effet',$item->id)}}" class=" btn btn-inverse-danger"><i class="feather-trash"></i></a>
                                        </td> -->
                                        @if ($item->validation ?? false)
                                        <td>
                                            <button class="btn btn-inverse-warning" disabled>
                                                <i class="feather-edit"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-inverse-danger" disabled>
                                                <i class="feather-trash"></i>
                                            </button>
                                        </td>
                                        @else
                                        <td>
                                            <a href="{{route('edit.carnet-effet',$item->id)}}" class="btn btn-inverse-warning">
                                                <i class="feather-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('delete.carnet-effet',$item->id)}}" class="btn btn-inverse-danger">
                                                <i class="feather-trash"></i>
                                            </a>
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('update.validation', $item->id) }}" class="btn btn-inverse-warning">
                                            <i class="fa">&#xf078;</i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




@endsection