jQuery(function($){

    $('.add_trigger_button').on('click', function (e) {
        e.preventDefault();
        $html = '';
        $html += '<tr>';
        $html += '<td>';
        $html += '<select class="popup_trigger_add_type" name="popup_trigger_add_type[]">';
        $html += '<option value="click_open">Fare clic su Apri</option>';
        $html += '<option value="auto_open">Ritardo / Apertura automatica</option>';
        $html += '</select>';
        $html += '</td>';
        $html += '<td class="imp">';
        $html += 'Classe <input type="text" name="class_open[]"><input type="hidden" name="ms_open[]">';
        $html += '</td>';
        $html += '<td><a href="#" class="remove_row button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></td>';
        $html += '</tr>';
        $('#cont_trigger').append($html);
    });
    $('.pupupsettings_tabs').on('click','.remove_row', function (e) {
        e.preventDefault();
        $(this).parents('tr').remove();
    });

    $('.pupupsettings_tabs').on('change','.popup_trigger_add_type', function (e) {
        e.preventDefault();
        if($(this).val() == 'auto_open'){
            $('.imp',$(this).parents('tr')).html('Tempo ms <input type="text" name="ms_open[]"><input type="hidden" name="class_open[]">');
        }else{
            $('.imp',$(this).parents('tr')).html('Classe <input type="text" name="class_open[]">');
        }
    });


    $('.add_targeting_button').on('click', function (e) {
        e.preventDefault();
        $v = $('#targeting_post').val();
        $l = $('#targeting_post option:selected').text();
        if($v > 0 ){
            $html = '';
            $html += '<tr>';
            $html += '<td>';
            $html += '<input type="hidden" name="id_trigger[]" value="' + $v + '">Pagina/post: ' + $l + ' (' + $v + ')';
            $html += '</td>';
            $html += '<td><a href="#" class="remove_row button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></td>';
            $html += '</tr>';
            $('#cont_targeting').append($html);
            $('#targeting_post').val(0);
        }
    });
});