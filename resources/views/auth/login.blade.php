@extends('frontend.layouts.master', ['class_body' => 'login'])
@section('content')
    <div class="breadcrumbs">
        <a href="#">Inicio »</a>
        <span>Iniciar sesión</span>
    </div>

    <main class="main">
        <div class="content">
            <h1 class="title">Ingresa en <img src="{{ asset('asset/frontend/assets/img/logo.svg')}}" alt="dequr"></h1>
            <div class="flex">
                <div class="social-login">
                    <a href="#" class="social-facebook"><img src="{{ asset('asset/frontend/assets/img/icons/facebook.svg')}}" alt="facebook"> Continuar con Facebook</a>
                    <a href="#" class="social-google"><img src="{{ asset('asset/frontend/assets/img/icons/google.svg')}}" alt="google"> Continuar con Google</a>
                    <a href="#" class="social-twitter"><img src="{{ asset('asset/frontend/assets/img/icons/twitter.svg')}}" alt="twitter"> Continuar con Twitter</a>
                </div>
                <div class="box-login">
                    <form role="form" id='form_login' name='form_login'>
                        <div class="wrap-input">
                            <label>Correo electrónico</label>
                            <input type="email" id="email" name="email" class="required email">
                        </div>
                        <div class="wrap-input">
                            <label>Contraseña</label>
                            <input type="password" id="password" name="password" class="required">
                        </div>

                        <img src='{{asset('asset/backend/img/loadingfrm.gif')}}' id='loading' style='display: none; margin: auto;'/>

                        <div class="buttons">
                            <button type="submit" class="btn-login btn-form">Iniciar sesión</button>
                            <a href="#" class="recover-password">¿Olvidó su contraseña?</a>
                        </div>
                        <p class="create-account">¿No tienes una cuenta? <a href="{{route('register')}}">Regístrate aquí</a></p>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $("body").on('submit', '#form_login', function (event) {

            event.preventDefault()
            if ($('#form_login').valid()) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#loading').show();
                $('.btn-login').attr('disabled', true);

                var formData = new FormData(document.getElementById("form_login"));

                $.ajax({
                    type: "POST",
                    url: "{{route('login_user')}}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    success: function (respuesta) {

                        $('#loading').hide();

                        if (respuesta.status == 'success') {
                            window.location.href = "{{route('PostComplaint.index')}}";
                        }

                        if (respuesta.status == 'fail') {
                            showAlert(respuesta.message, respuesta.status);
                        }

                        setTimeout(function () {
                            $('.btn-login').attr('disabled', false);
                        }, 2000);
                    }
                });
            }
        });
    </script>
@endsection