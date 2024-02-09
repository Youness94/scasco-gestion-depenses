@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Effet Affectations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Tableau de Bord</a></li>
                        <li class="breadcrumb-item active">Effet Affectations</li>
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
                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Effet Affectations</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Télécharger</a> -->
                                    <a href="{{ route('add.effet-affectation') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                            <thead class="student-thread">
                                <tr>
                                    <th>ID</th>
                                    <th>Date d'affectation</th>
                                    <th>Justification</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                    <th>Afficher</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($effet_affectations as $key => $item)
                                <tr>

                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{$item -> affectation_date}}
                                    </td>

                                    <td class="flex gap-4 px-6 py-4">
                                        @if ($item->effet_images->isNotEmpty())
                                        @foreach ($item->effet_images as $image)
                                        <img src="{{ asset('public/photos/effet_affectation/' . $image->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;">
                                        @endforeach
                                        @else
                                        Aucune image disponible
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('edit.effet-affectation',$item->id)}}" class="btn btn-inverse-warning"><i class="feather-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{route('delete.effet-affectation',$item->id)}}" class="btn btn-inverse-danger"><i class="feather-trash"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{route('show.effet-affectation',$item->id)}}" class="btn btn-inverse-danger"><i class="feather-eye"></i></a>
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

@section('script')

@endsection

@endsection