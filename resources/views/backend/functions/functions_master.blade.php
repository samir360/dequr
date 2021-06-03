<script type='text/javascript'>

    function showAlert(text, option) {

        if(option=='success'){
            toastr.success(text)
        }

        if(option=='fail') {
            toastr.error(text)
        }
    }

    function showDetails(i) {
        $('#IconoVerDet' + i).removeClass('fa-search-plus');
        $('#Trboton' + i).show();
        $('#BotonVerDet' + i).attr('onclick', 'closeDetails(' + i + ')');
        $('#IconoVerDet' + i).addClass('fa-search-minus');
    }

    function closeDetails(i) {
        $('#IconoVerDet' + i).removeClass('fa-search-minus');
        $('#Trboton' + i).hide();
        $('#BotonVerDet' + i).removeAttr('onclick');
        $('#IconoVerDet' + i).addClass('fa-search-plus');
    }

</script>