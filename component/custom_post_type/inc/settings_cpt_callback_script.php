<script type="text/javascript">
jQuery(document).ready(function($) {

    $( document ).tooltip();
    $(".add_field_button").click(function(e){ //on add input button click
        e.preventDefault();
        var narray = $('.custompost_group_box_wrap').length;
        
        if(narray>0){
            narray = assign_n(".custompost_group_box_wrap", narray);
        }
        
            var out = '';
            out += '<?php
            echo '<div class="custompost_group_box_wrap animate" attr_n=".narray."><div class="cont_box"><strong>Nome:</strong><br>';
            echo '<input class="txt_custompost_name" type="text" name="bc_settings_cpt[custom-post-type][.narray.][name]"/>';
            echo '<a href="#" class="remove_field button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
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
            out = out.replace(/.narray./g, narray);
            $(".input_fields_wrap").append(out);
        
    });
        
    $(".input_fields_wrap").on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        /*var c = confirm('Confermi la cancellazione?');
        if (c) $(this).parent('div').remove();*/
        var p = $(this);
        $('.cont_box').removeClass('confirm_remove');
        $('.box_remove').remove();
        p.parents('.cont_box').addClass('confirm_remove');
        p.parents('.custompost_group_box_wrap').addClass('check_rm');
        setTimeout(function(){
            p.parents('.custompost_group_box_wrap').append('<div class="box_remove"><h4>Confermi la cancellazione?</h4><br><br><a href="#" class="box_remove_no">No</a><a href="#" class="box_remove_si">Si</a></div>');
        },200);
    });
    $(".input_fields_wrap").on("click",".box_remove_no", function(e){ 
        e.preventDefault(); 
        $(this).parents('.box_remove').remove();
        $('.confirm_remove').removeClass('confirm_remove');
        $('.check_rm').removeClass('check_rm');
    })
    $(".input_fields_wrap").on("click",".box_remove_si", function(e){ 
        e.preventDefault(); 
        $(this).parents('.check_rm').remove();
    })

    $(".input_fields_wrap").delegate(".add_tax_custompost_button","click",function(e){ 
        e.preventDefault();
        add_tax_custompost_button(this);
    });
    function add_tax_custompost_button(e){
        var narray =  $(e).parents('.custompost_group_box_wrap').attr('attr_n');
        
        var narray2 = $('.cont_tax',$(e).parent('div')).length;
        if(narray2>0){
            narray2 = assign_n(".custompost_group_box_wrap[attr_n='"+narray+"'] .cont_tax", narray2);
        }
        var out = '<div class="cont_tax" attr_n=".narray2."><div class="main_tax"><strong>Tipo di Tassonomia</strong><br>';
        out += '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][type]" value="tag">Tag</label> | ';
        out += '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][type]" value="category">Categoria</label>';
        out += '<br><br>Nome Tassonomia<br><input type="text" class="input_tax_custompost_name" name="bc_settings_cpt[custom-post-type][.narray.][tax][.narray2.][name]"/>';
        out += '<br><br><a href="#" class="remove_tax_custompost button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></div></div>';
        out = out.replace(/.narray2./g, narray2);
        out = out.replace(/.narray./g, narray);

        $('.box_tax',$(e).parent('div')).append(out); //add input box
    
    }

    $(".input_fields_wrap").delegate(".remove_tax_custompost","click", function(e){ 
        e.preventDefault(); 
        /*var c = confirm('Confermi la cancellazione?');
        if (c) $(this).parent('div').remove();*/
        var p = $(this);
        $('.cont_tax').removeClass('confirm_remove');
        $('.box_remove').remove();
        p.parents('.main_tax').addClass('confirm_remove');
        p.parents('.cont_tax').addClass('check_rm');
        setTimeout(function(){
            p.parents('.cont_tax').append('<div class="box_remove"><h4>Confermi la cancellazione?</h4><a href="#" class="box_remove_no">No</a><a href="#" class="box_remove_si">Si</a></div>');
        },200);
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