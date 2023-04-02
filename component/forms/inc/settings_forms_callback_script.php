<script type="text/javascript">
jQuery(document).ready(function($) {
    sortable($);

    $(".add_field_button").click(function(e){ //on add input button click
        var x = $('.txt_forms_name').length; //initlal text box count
        var narray = $('.txt_custom_field_name').length;
        if(x>0){
            x = assign_n(".forms_group_box_wrap", x);
        }

        e.preventDefault();
            var out = '';
            out += '<?php
            echo '<div class="forms_group_box_wrap" attr_n=".narray."><div style="margin:20px;background-color: #f1f1f1;border: 1px solid #ccc;padding: 20px;"><strong>Nome Form:</strong><br>';
            echo '<input class="txt_forms_name" type="text" name="bc_settings_forms[forms][.narray.][name]"/>';
            echo '<a href="#" class="remove_field button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
            echo '<div class="bc-form-bar" style="display: block;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-top: 1px solid #ccc">';
            echo '<a href="#" class="bc-form-bar-item" attr_form_bar=".bar_form" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none; border-right:1px solid #ccc">Form</a>';
            echo '<a href="#" class="bc-form-bar-item" attr_form_bar=".bar_email" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none; border-right:1px solid #ccc;background-color: #eee;">Email</a>';
            echo '<a href="#" class="bc-form-bar-item" attr_form_bar=".bar_db" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none; border-right:1px solid #ccc;background-color: #eee;">Database</a>';
            echo '</div>';
            echo '<div class="bar_cont bar_form" style="padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">';
            echo '<a class="add_field_forms_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi Campo</a><br>';
            echo '<div class="box_field"></div>';
            echo '</div>';
            echo '<div class="bar_cont bar_email" style="display:none;padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">';
            echo '<table>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Variabili generici</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '$idpagina, $urlpagina, $titolopagina, $slugpagina, $nomesito, $urlsito';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>A</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][to]" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Da</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][from]" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Oggetto</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][subject]" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Header</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][header]" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Reply-To</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][reply]" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo '<label>Corpo del messaggio</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms" name="bc_settings_forms[forms][.narray.][email][msg]" rows="10" cols="80" >Da: [nome] <[email]>&#13;&#10;&#13;&#10;Corpo del messaggio:&#13;&#10;[messaggio]&#13;&#10;&#13;&#10;--&#13;&#10;Questa e-mail è stata inviata dal modulo di contatto su $nomesito</textarea>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Seconda mail ';
                                    echo '<label><input type="checkbox" class="input_field_forms_email2" name="bc_settings_forms[forms][.narray.][email2][active]"></label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>A</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][to]" readonly/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Da</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][from]" readonly/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Oggetto</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][subject]" readonly/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Header</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][header]" readonly/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Reply-To</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][reply]" readonly/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo '<label>Corpo del messaggio</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms field_email2" name="bc_settings_forms[forms][.narray.][email2][msg]"  rows="10" cols="80" readonly></textarea>';
                                echo '</td>';
                            echo '</tr>';
                        echo '</table>';
            echo '</div>';
            echo '<div class="bar_cont bar_db" style="display:none;padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">';
            echo '<table>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Salva su database';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                echo '<label><input type="checkbox" class="form_save_db" name="bc_settings_forms[forms][.narray.][db][active]"></label>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Titolo';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_db" name="bc_settings_forms[forms][.narray.][db][titolo]" readonly="true" />';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Body';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms field_db" name="bc_settings_forms[forms][.narray.][db][body]" readonly="true" rows="10" cols="80" ></textarea>';
                                echo '</td>';
                            echo '</tr>';
                        echo '</table>';
            echo '</div>';
            echo '</div></div>';
            ?>';
            out = out.replace(/.narray./g, x);
            $(".input_fields_wrap").append(out);
            var el = $(".forms_group_box_wrap[attr_n='"+x+"']");
            $("html,body").animate({scrollTop: el.offset().top, scrollLeft: 0},300);
    });

    $(".input_fields_wrap").on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        $(this).parent('div').remove();
    });

    $(".input_fields_wrap").delegate(".add_field_forms_button","click",function(e){ 
        e.preventDefault();
        var narray =  $(this).parents('.forms_group_box_wrap').attr('attr_n');
        var narray2 = $(".forms_group_box_wrap[attr_n='"+narray+"'] .cont_forms_field").length;
        if(narray2>0){
            narray2 = assign_n(".forms_group_box_wrap[attr_n='"+narray+"'] .cont_forms_field", narray2);
        }
        
    var out = '<div class="cont_forms_field" attr_n=".narray2." style="margin:20px;background-color: #ffffff;border: 1px solid #ccc;padding: 20px;">';
        out += '<strong>Tipo di Campo</strong><br>';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="text">Text</label> | ';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="email">Email</label> | ';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="phone">Phone</label> | ';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="textarea">Textarea</label> | ';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="checkbox">Checkbox</label> | ';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="num">Numerico</label><br>';
        out += '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][.narray.][field][.narray2.][type]" value="testo">Solo testo</label>';
        out += '<br><br><div style="display:inline-block">Name<br><input type="text" class="input_field_forms_name" name="bc_settings_forms[forms][.narray.][field][.narray2.][name]"/></div> ';
        out += '<div style="display:inline-block">Label<br><input type="text" class="input_field_forms_label" name="bc_settings_forms[forms][.narray.][field][.narray2.][label]"/></div><br><br> ';
        out += '<a href="#" class="collapsible" style="display: block;background-color: #eee;color: #444;padding: 10px;font-size: 15px;text-decoration: none;">Impostazioni aggiuntive <span style="float: right;font-weight: bold;">+</span></a>';
        out += '<div style="max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out; border: 1px solid #eee"><div style="padding:15px"> ';
        out += 'Template<br><textarea class="input_field_forms_template html_template" name="bc_settings_forms[forms][.narray.][field][.narray2.][template]" rows="10" cols="80">';
        out += '<div class="form-group">\n<div class="label">$label</div>\n<input type="text" id="bc_name" name="$name">\n</div>';
        out += '</textarea>';
        out += '<br>Variabili: $name, $label<br>';
        out += 'Variabili generici: $idpagina, $urlpagina, $titolopagina, $slugpagina, $nomesito, $urlsito<br><br>';
        out += '<input type="checkbox" class="input_field_forms_req" name="bc_settings_forms[forms][.narray.][field][.narray2.][required]"/> Required<br> ';
        out += '</div></div><br><br><a href="#" class="remove_field_forms button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><span style="float:right;" class="dashicons dashicons-move icondrop"></span></div>';
        out = out.replace(/.narray2./g, narray2);
        out = out.replace(/.narray./g, narray);

        $('.box_field',$(this).parent('div')).append(out); //add input box
        sortable($); 
    });

    
    $(".input_fields_wrap").delegate(".remove_field_forms","click", function(e){ 
        e.preventDefault(); 
        $(this).parent('div').remove();
    });

    $(".input_fields_wrap").delegate(".collapsible","click", function(e){ 
        e.preventDefault(); 
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight != '0px'){
            content.style.maxHeight = '0px';
            $('span', this).html('+')
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
            $('span', this).html('-')
        }
    });

    $(".input_fields_wrap").delegate(".radio_field_type","change", function(e){ 
        var text = '';
        
        $('.input_field_forms_name',$(this).parents('.cont_forms_field')).removeAttr('readonly');
        $('.input_field_forms_label',$(this).parents('.cont_forms_field')).removeAttr('readonly');
        $('.input_field_forms_req',$(this).parents('.cont_forms_field')).removeAttr('disabled');
        if($(this).val()=='text'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<input type="text" name="$name">\n</div>';
        }else if($(this).val()=='email'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<input type="email" name="$name">\n</div>';
        }else if($(this).val()=='phone'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<input type="phone" name="$name">\n</div>';
        }else if($(this).val()=='textarea'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<textarea type="text" name="$name"></textarea>\n</div>';
        }else if($(this).val()=='checkbox'){
            text = '<div class="form-group">\n<label><input type="checkbox" name="$name">$label</label>\n</div>';
        }else if($(this).val()=='num'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<input type="number" name="$name">\n</div>';
        }else if($(this).val()=='radio'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<label><input type="radio" name="$name" value="...">testo</label>\n<label><input type="radio" name="$name" value="...">testo</label>\n</div>';
        }else if($(this).val()=='select'){
            text = '<div class="form-group">\n<div class="label">$label</div>\n<select name="$name">\n<option value="...">testo</option>\n<option value="...">testo</option>\n</select>\n</div>';
        }else if($(this).val()=='testo'){
            text = '<div class="form-group">\n<p>Lorem ipsum è un testo segnaposto</p>\n</div>';
            $('.input_field_forms_name',$(this).parents('.cont_forms_field')).val('');
            $('.input_field_forms_label',$(this).parents('.cont_forms_field')).val('');
            $('.input_field_forms_name',$(this).parents('.cont_forms_field')).attr('readonly','readonly');
            $('.input_field_forms_label',$(this).parents('.cont_forms_field')).attr('readonly','readonly');
            $('.input_field_forms_req',$(this).parents('.cont_forms_field')).attr('disabled','true');
            $('.input_field_forms_req',$(this).parents('.cont_forms_field')).removeAttr('checked');
        }

        $('.html_template',$(this).parents('.cont_forms_field')).val(text);
    });

    $(".input_fields_wrap").delegate(".bc-form-bar-item","click", function(e){ 
        e.preventDefault(); 
        var i;
        var x = $('.bar_cont', $(this).parents('.forms_group_box_wrap'));
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        var div = $(this).attr('attr_form_bar');
        $(div, $(this).parents('.forms_group_box_wrap')).show();
        $('.bc-form-bar-item', $(this).parents('.forms_group_box_wrap')).css('background-color','#eee');
        $(this).css('background-color','#fff');
    });

    $(".input_fields_wrap").delegate(".input_field_forms_email2","change", function(e){ 
        if(this.checked){
            $('.field_email2', $(this).parents('.bar_email')).removeAttr('readonly');
        }else{
            $('.field_email2', $(this).parents('.bar_email')).attr('readonly', 'true');
        }
    });
    $(".input_fields_wrap").delegate(".form_save_db","change", function(e){ 
        if(this.checked){
            $('.field_db', $(this).parents('.bar_db')).removeAttr('readonly');
        }else{
            $('.field_db', $(this).parents('.bar_db')).attr('readonly', 'true');
        }
    });

});

function sortable($){
    $('.box_field').sortable({
        cursor: "move",
        handle: ".icondrop",
        opacity: 0.5,
        revert: true,
        tolerance: "pointer",
        axis: "y",
        start: function(e, ui){
            ui.placeholder.height(ui.item.height());
            ui.placeholder.width(ui.item.width());
            ui.placeholder.css('visibility', 'visible');
            ui.placeholder.css('background', '#fff');
            ui.placeholder.css('margin', '10px');
            ui.placeholder.css('padding', '10px');
            ui.placeholder.css('border', '1px dashed #ccc');
        }
    });
    //$(".box_field").disableSelection();
}

function assign_n(el, n){
    if(jQuery( el+"[attr_n='"+n+"']" ).length){
        n++;
        //alert('esiste')
        return assign_n(el, n);
    }else{
        //alert('non esiste-'+n)
        return n;
    }
}
</script>