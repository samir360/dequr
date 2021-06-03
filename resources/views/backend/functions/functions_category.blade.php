<script type='text/javascript'>

    $(document).ready(function () {
        $(".edit_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            var url = '{{ route("category.edit", ":id") }}';
            url = url.replace(':id', dataId);
            window.location.href = url;
        });

        $(".delete_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            modalDelete(dataId);
        });
    });

    function refresh() {
        window.location.href = "{{ route('categories') }}";
    }

    $("body").on('submit', '#form_category', function (event) {

        event.preventDefault()
        if ($('#form_category').valid()) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#loading').show();
            $('.botones').attr('disabled', true);

            var formData = new FormData(document.getElementById("form_category"));
            var route = $("input[name='route']").val();

            $.ajax({
                type: "POST",
                url: route,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                success: function (respuesta) {

                    $('#loading').hide();
                    showAlert(respuesta.alert, respuesta.status);

                    if (respuesta.create) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }

                    if (respuesta.update) {
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
        var rutaController = "{{ route('category.destroy') }}";

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

                if (respuesta.status == 'success') {
                    $('#contenidomodal').hide();
                    $('#modal-danger').modal('hide');
                    Cancel();
                }
                if (respuesta.status == 'fail') {
                    MensajeForm('error_sql');
                }
            }
        });
    }
</script>
