<script type='text/javascript'>

    $(document).ready(function () {
        $(".view_properties").on("click", function () {
            var dataId = $(this).attr("data-id");
            showDetails(dataId);
        });
    });

    function Cancel() {
        window.location.href = "{{ route('activity_log') }}";
    }

    $(document).ready(function () {
        $(".fecha").datepicker({
            changeYear: true,
            //minDate: 0,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            //yearRange: "-100:+0"
        });
    });

    function modalDelete(id) {
        $('#id_eliminar').val(id);
        $('#modal-danger').modal('show');
    }

    function deleteData() {

        var id = $('#id_eliminar').val();
        var rutaController = "{{ route('destroyActivityLog') }}";

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
