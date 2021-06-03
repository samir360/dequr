<script type='text/javascript'>
    $(document).ready(function () {
        $(".edit_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            var url = '{{ route("edit_rol", ":id") }}';
            url = url.replace(':id', dataId);
            window.location.href = url;
        });

        $(".delete_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            modalDelete(dataId);
        });
    });


    function refresh() {
        window.location.href = "{{ route('rol') }}";
    }

    $("body").on('submit', '#form_rol', function (event) {

        event.preventDefault()
        if ($('#form_rol').valid()) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#loading').show();
            $('.botones').attr('disabled', true);
            var ruta = $("input[name='ruta']").val();

            if (ruta == 'store') {
                var rutaController = "{{ route('storeRol') }}";
            } else {
                var rutaController = "{{ route('updateRol') }}";
            }
            var formData = new FormData(document.getElementById("form_rol"));

            $.ajax({
                type: "POST",
                url: rutaController,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                success: function (respuesta) {

                    $('#loading').hide();
                    showAlert(respuesta.alert, respuesta.status);

                    if (respuesta.status == 'success') {
                        setTimeout(function () {
                            refresh();
                        }, 2000);
                    }

                    setTimeout(function () {
                        $('.botones').attr('disabled', false);
                    }, 2000);
                }
            });
        }
    });

    function modalDelete(id) {
        $('#id_eliminar').val(id);
        $('#modal-danger').modal('show');
    }

    function deleteData() {

        var id = $('#id_eliminar').val();
        var rutaController = "{{ route('destroyRol') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: rutaController,
            cache: false,
            dataType: 'json',
            data: {id: id},
            success: function (respuesta) {
                if (respuesta.exito == 1) {
                    $('#contenidomodal').hide();
                    $('#modal-danger').modal('hide');
                    Cancel();
                }
                if (respuesta.error == 1) {
                    MensajeForm('error_sql');
                }
            }
        });
    }
</script>
