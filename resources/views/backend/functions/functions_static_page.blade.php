<script type='text/javascript'>

    $(document).ready(function () {
        $(".edit_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            var url = '{{ route("StaticPage.edit", ":id") }}';
            url = url.replace(':id', dataId);
            window.location.href = url;
        });

        $(".delete_register").on("click", function () {
            var dataId = $(this).attr("data-id");
            modalDelete(dataId);
        });
    });

    function refresh() {
        window.location.href = "{{ route('StaticPage.index') }}";
    }

    $("body").on('submit', '#form-static-page', function (event) {

        event.preventDefault()
        if ($('#form-static-page').valid()) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#loading').show();
            $('.btn-frm').attr('disabled', true);

            var formData = new FormData(document.getElementById("form-static-page"));
            var ruta = $("input[name='ruta']").val();

            if (ruta == 'store') {
                var route = "{{ route('StaticPage.store') }}";
            } else {
                var route = "{{ route('StaticPage.update') }}";
            }

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
                    $('.btn-frm').attr('disabled', false);
                    showAlert(respuesta.alert, respuesta.status);

                    if (respuesta.status == 'success') {

                        if (respuesta.update) {

                            setTimeout(function () {
                                refresh();
                            }, 3000);

                        } else {
                            location.reload();
                        }

                    }
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
        var route = "{{ route('StaticPage.delete') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: route,
            cache: false,
            dataType: 'json',
            data: {id: id},
            success: function () {

                $('#contenidomodal').hide();
                $('#modal-danger').modal('hide');
                refresh();
            }
        });
    }

</script>
