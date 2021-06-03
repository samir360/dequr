@extends('frontend.layouts.master', ['class_body' => 'register'])
@section('content')
    <div class="breadcrumbs">
        <a href="#">Inicio »</a>
        <span>Regístrate</span>
    </div>

    <main class="main">
        <div class="content">
            <h1 class="title">Únete hoy <img src="{{ asset('asset/frontend/assets/img/logo.svg')}}" alt="dequr"></h1>
            <div class="flex">
                <div class="social-login">
                    <a href="#" class="social-facebook"><img src="{{ asset('asset/frontend/assets/img/icons/facebook.svg')}}" alt="facebook"> Continuar con Facebook</a>
                    <a href="#" class="social-google"><img src="{{ asset('asset/frontend/assets/img/icons/google.svg')}}" alt="google"> Continuar con Google</a>
                    <a href="#" class="social-twitter"><img src="{{ asset('asset/frontend/assets/img/icons/twitter.svg')}}" alt="twitter"> Continuar con Twitter</a>
                </div>
                <div class="box-register">
                    <form role="form" id='form_register' name='form_register'>

                        <div class="wrap-input">
                            <label>Nombres</label>
                            <input type="text" name="firstname" id="firstname" class="required" maxlength="50" autocomplete="false">

                            <label>Apellidos</label>
                            <input type="text" name="lastname" id="lastname" class="required" maxlength="50" autocomplete="false">

                            <label>Correo electrónico</label>
                            <input type="email" name="email" id="email" class="required email">

                            <label>Contraseña</label>
                            <input type="password" name="password" id="password" class="required">
                        </div>

                        <img src='{{asset('asset/backend/img/loadingfrm.gif')}}' id='loading' style='display: none; margin: auto;'/>

                        <div class="buttons">
                            <button type="submit" class="btn-register">Regístrate</button>
                            <div class="accept-terms">
                                <input type="checkbox" name="" id="terms" required="true">
                                <label for="terms"><span>Acepto los <a href="#">Términos, Condiciones y Políticas</a> de Dequr</span></label>
                            </div>
                        </div>
                        <p class="login">¿Ya tienes una cuenta? <a href="{{route('login')}}">Inicia sesión</a></p>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $("body").on('submit', '#form_register', function (event) {

            event.preventDefault()
            if ($('#form_register').valid()) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#loading').show();
                $('.btn-register').attr('disabled', true);

                var formData = new FormData(document.getElementById("form_register"));

                $.ajax({
                    type: "POST",
                    url: "{{route('register.create')}}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    success: function (respuesta) {

                        $('#loading').hide();
                        showAlert(respuesta.alert, respuesta.status);

                        if (respuesta.status == 'success') {
                            window.location.href = "{{route('PostComplaint.index')}}";
                        }

                        setTimeout(function () {
                            $('.btn-register').attr('disabled', false);
                        }, 2000);
                    }
                });
            }
        });
    </script>
@endsection