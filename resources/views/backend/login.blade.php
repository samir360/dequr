@extends('backend.layouts.master_login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('asset/frontend/assets/img/logo.svg')}}" alt="Dequr">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Iniciar sesión</p>

                <form id="login" action="">
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="required email form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="required form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="loading" style="display: none">
                        <div class="col-12 text-center">
                            <img src="{{asset('asset/backend/img/loadingfrm.gif')}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            &nbsp;
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->
                <p class="mb-1">
                    <a href="forgot-password.html">Recuperar contraseña</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection