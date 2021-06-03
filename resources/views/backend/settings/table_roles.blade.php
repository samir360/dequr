@extends('backend.layouts.master')@section('content')    @include('backend.layouts.modal_delete')    <div class="content-wrapper">        <!-- Content Header (Page header) -->        <div class="content-header">            <div class="container-fluid">                <div class="row mb-2">                    <div class="col-sm-6">                        <h1 class="m-0 text-dark">Dashboard</h1>                    </div><!-- /.col -->                    <div class="col-sm-6">                        <ol class="breadcrumb float-sm-right">                            <li class="breadcrumb-item"><a href="{{route('backend')}}">Inicio</a></li>                            <li class="breadcrumb-item active">Roles</li>                        </ol>                    </div><!-- /.col -->                </div><!-- /.row -->            </div><!-- /.container-fluid -->        </div>        <!-- /.content-header -->        <!-- Main content -->        <section class="content">            <div class="container-fluid">                <div class="row">                    <div class="col-12">                        <div class="card">                            <div class="card-header">                                <h3 class="card-title">Lista de registros</h3>                                <div class="card-tools">                                    <a href="{{route('create_rol')}}" class="btn btn-success">Nuevo</a>                                </div>                            </div>                            <!-- /.card-header -->                            <div class="card-body table-responsive p-0">                                <table class="table table-hover text-nowrap">                                    <thead>                                    <tr>                                        <th>Acci&oacute;n</th>                                        <th>Nombre</th>                                        <th class="text-center">Creado</th>                                    </tr>                                    </thead>                                    <tbody>                                    @if(count($dataRol)>0)                                        @foreach($dataRol AS $items)                                            <tr>                                                <td>                                                    <div class="btn-group">                                                        <button type="button" class="btn btn-secondary btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">                                                            <span class="sr-only">Toggle Dropdown</span>                                                            <div class="dropdown-menu" role="menu" id="{{$items->id}}">                                                                <a class="dropdown-item edit_register" data-id="{{$items->id}}"> <i class="fa fa-edit"></i> Editar</a>                                                                <a class="dropdown-item delete_register" data-id="{{$items->id}}"> <i class="fa fa-trash"></i> Eliminar</a>                                                            </div>                                                        </button>                                                    </div>                                                </td>                                                <td>{{$items->name }}</td>                                                <td class="text-center">{{date('d/m/Y',strtotime($items->created_at))}}</td>                                            </tr>                                        @endforeach()                                    @else                                        <tr>                                            <td colspan="3">                                                @foreach ($errors->all() as $error)                                                    <div class="alert alert-dismissable alert-info">                                                        <button type="button" class="close" data-dismiss="alert">×</button>                                                        <p>{{ $error }}</p>                                                    </div>                                                @endforeach                                            </td>                                        </tr>                                    @endif                                    </tbody>                                </table>                            </div>                            <!-- /.card-body -->                        </div>                        <!-- /.card -->                    </div>                </div>                <!-- /.row -->            </div><!-- /.container-fluid -->        </section>        <!-- /.content -->    </div>    @include('backend.functions.functions_roles')@endsection