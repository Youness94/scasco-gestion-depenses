@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Chéquiers</h3>
                    
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Chéquiers</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-4 mt-2">
            <form action="{{ route('store.excel.with.checks') }}" method="POST" enctype="multipart/form-data">
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
                    <form action="{{ route('store.excel.with.checks') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-md-4 mt-2">
                            <!-- <form action="{{ route('store.excel.with.checks') }}" method="POST" enctype="multipart/form-data"> -->
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
                                    <h3 class="page-title">Chéquiers</h3>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <form action="{{ route('checkbook.search') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                            <a href="{{ route('all.checkbooks') }}" class="btn btn-outline-secondary" aria-describedby="button-addon2"><i class="fa">&#xf021;</i></a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('add.checkbook') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                        <th>Série de Chéquier</th>
                                        <th>Numéro de Départ</th>
                                        <th>Qnt des chèques</th>
                                        <th>Banque</th>
                                        <!-- <th>Status</th> -->
                                        <th>Afficher</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                        <th>Valider</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checkbooks as $key => $item)
                                    <tr>

                                        <td>{{$key+1}}</td>
                                        <td>{{$item->reception_date}}</td>
                                        <td>{{$item->series}}</td>
                                        <td>{{ $item->cheque_sie }} {{ $item->start_number }}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{ optional($item->bank)->nom ?? 'N/A' }}</td>
                                        <!-- <td>{{ $item->status }}</td> -->
                                        <td>
                                            <a href="{{route('show.checkbook',$item->id)}}" class=" btn btn-inverse-danger"><i class="feather-eye"></i></a>
                                        </td>
                                        <!-- <td>
                                            <a href="{{route('edit.checkbook',$item->id)}}" class="btn btn-inverse-warning"><i class="feather-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('delete.checkbook',$item->id)}}" class=" btn btn-inverse-danger"><i class="feather-trash"></i></a>
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
                                        <td>
                                            <button class="btn btn-inverse-danger" disabled>
                                                <i class="fa">&#xf078;</i>
                                            </button>
                                        </td>
                                        @else
                                        <td>
                                            <a href="{{route('edit.checkbook',$item->id)}}" class="btn btn-inverse-warning"><i class="feather-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('delete.checkbook',$item->id)}}" class=" btn btn-inverse-danger"><i class="feather-trash"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('checkbook.validation', $item->id) }}" class="btn btn-inverse-warning">
                                                <i class="fa">&#xf078;</i>
                                            </a>
                                        </td>
                                        @endif
                                        <!-- <td>
                                            <a href="{{ route('checkbook.validation', $item->id) }}" class="btn btn-inverse-warning">
                                            <i class="fa">&#xf078;</i>
                                            </a>
                                        </td> -->
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