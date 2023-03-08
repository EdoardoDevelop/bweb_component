<script type="text/javascript">
jQuery(document).ready(function($) {

    /*$( "#draggable" ).draggable({ revert: "valid" });
    $( ".custompost_group_box_wrap" ).droppable({
      accept: "#draggable",
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function( event, ui ) {
        add_tax_custompost_button(this);
      }
    });*/


    var max_fields      = 10; //maximum input boxes allowed
    $( document ).tooltip();
    $(".add_field_button").click(function(e){ //on add input button click
    var x = $('.txt_custompost_name').length; //initlal text box count
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            //alert(x)
            var out = '';
            out += '<?php
            echo '<div class="custompost_group_box_wrap"><div style="margin:20px;background-color: #fff;border: 1px solid #ccc;padding: 20px;"><strong>Nome:</strong><br>';
            echo '<input class="txt_custompost_name" type="text" name="bc_settings_cpt[custom-post-type][.narray.][name]"/>';
            echo '<a href="#" class="remove_field button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
            echo '<strong>Gutenberg:</strong> ';
            echo '<label><input type="radio" name="bc_settings_cpt[custom-post-type][.narray.][show_in_rest]" value="false" checked>NO</label> | ';
            echo '<label><input type="radio" name="bc_settings_cpt[custom-post-type][.narray.][show_in_rest]" value="true">SI</label>';
                
            echo '<br><br><strong>Icona:</strong><br><div id="view_icon_.narray." style="display:inline-block;vertical-align: bottom;">';
            echo '<span class="dashicons dashicons-admin-post" style="font-size: 22px; width: 22px; height: 22px; margin: 3px; vertical-align: top;"></span>';        
            echo '</div><input class="txt_custompost_icon " type="text" name="bc_settings_cpt[custom-post-type][.narray.][icon]"/>';


            echo '<input type="radio" name="chk_icon" id="chk_icon.narray." value=".narray." style="display:none;">';
            echo '<a href="#TB_inline?&width=360&height=400&inlineId=select_dashicons_cpt" onclick="chk_icon(.narray.);" class="thickbox button-secondary" style="vertical-align: top;"><span class="dashicons dashicons-art" style="vertical-align: text-top;"></span>Icone</a>';
            


            echo '<br><br><hr>';
            echo '<a class="add_tax_custompost_button button-secondary" style="display:block; text-align:center"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi Tassonomia</a>';
            echo '<div class="box_tax"></div><br><span class="dashicons dashicons-move icondrop"></span>';
            echo '</div></div>';
            ?>';
            out = out.replace(/.narray./g, x);
            $(".input_fields_wrap").append(out);
        }
    });
        
    $(".input_fields_wrap").on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        var c = confirm('Confermi la cancellazione?');
        if (c) $(this).parent('div').remove();
    });

    $(".input_fields_wrap").delegate(".add_tax_custompost_button","click",function(e){ 
        e.preventDefault();
        add_tax_custompost_button(this);
    });
    function add_tax_custompost_button(e){
        var narray =  $(e).parents('.custompost_group_box_wrap').index();
        var narray2 = $('.input_tax_custompost_name',$(e).parent('div')).length;
        var out = '<div style="margin:20px 20px 0;background-color: #ffffff;border: 1px solid #ccc;padding: 20px;"><strong>Tipo di Tassonomia</strong><br>';
        out += '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][type]" value="tag">Tag</label> | ';
        out += '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][type]" value="category">Categoria</label>';
        out += '<br><br>Nome Tassonomia<br><input type="text" class="input_tax_custompost_name" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][name]"/>';
        out += '<br><br><a href="#" class="remove_tax_custompost button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></div>';
        out = out.replace(/.narray2./g, narray2);
        out = out.replace(/.narray./g, narray);

        $('.box_tax',$(e).parent('div')).append(out); //add input box
    
    }

    $(".input_fields_wrap").delegate(".remove_tax_custompost","click", function(e){ 
        e.preventDefault(); 
        var c = confirm('Confermi la cancellazione?');
        if (c) $(this).parent('div').remove();
    });
    $('.input_fields_wrap').sortable({
        cursor: "move",
        handle: ".icondrop",
        opacity: 0.5,
        revert: true,
        tolerance: "pointer",
        start: function(e, ui){
            ui.placeholder.height(ui.item.height());
            ui.placeholder.width(ui.item.width());
            ui.placeholder.css('visibility', 'visible');
            ui.placeholder.css('background', '#f8f8f8');
            ui.placeholder.css('border', '1px dashed #ccc');
        }
    });
    $(".input_fields_box_wrap").disableSelection();

    $('#pre_bg').hide();
});

function select_icon_cpt(icon){
    jQuery(document).ready(function($) {
        var n = $("input[name~='chk_icon']:checked").val();
        $("input[name~='bc_settings_cpt[custom-post-type]["+n+"][icon]']").val(icon);
        if( icon.includes('dashicons')){
            $("#view_icon_" + n ).html('<span class="dashicons '+icon+'" style="font-size: 22px; width: 22px; height: 22px; margin: 3px; vertical-align: top;"></span>');
        }else{
            $("#view_icon_"+n).html('<img src="'+icon+'" style="height: 22px; margin: 3px; vertical-align: top;"/>');
        }
        tb_remove();
    });
}

function chk_icon(n){
    jQuery(document).ready(function($) {
        $('#chk_icon'+n).attr('checked','checked');
    });
}


</script>