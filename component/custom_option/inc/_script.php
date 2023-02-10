<script type="text/javascript">
jQuery(document).ready(function($) {

    /*$( "#draggable" ).draggable({ revert: "valid" });
    $( ".custom_option_field_group_box_wrap" ).droppable({
      accept: "#draggable",
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function( event, ui ) {
        add_tax_custom_option_field_button(this);
      }
    });*/


    var max_fields      = 10; //maximum input boxes allowed
    $( document ).tooltip();
    $(".add_field_button").click(function(e){ //on add input button click
    var x = $('.txt_custom_option_field_name').length; //initlal text box count
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            //alert(x)
            var out = '';
            out += '<div class="custom_option_field_group_box_wrap"><div style="margin:20px;background-color: #fff;border: 1px solid #ccc;padding: 20px;"><strong>Nome:</strong><br>';
            out += '<input class="txt_custom_option_field_name" type="text" name="bc_custom_option_field[custom_option_field][.narray.][name]"/>';
            out += '<a href="#" class="remove_field button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
            
            
            out += '<label><input type="radio" name="bc_custom_option_field[custom_option_field][.narray.][type]" value="text" checked>Testo</label> | ';
            out += '<label><input type="radio" name="bc_custom_option_field[custom_option_field][.narray.][type]" value="textarea">Textarea</label> | ';
            out += '<label><input type="radio" name="bc_custom_option_field[custom_option_field][.narray.][type]" value="editor">Editor</label>';
            out += '</div></div>';
            out = out.replace(/.narray./g, x);
            $(".input_fields_wrap").append(out);
        }
    });
        
    $(".input_fields_wrap").on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        var c = confirm('Confermi la cancellazione?');
        if (c) $(this).parent('div').remove();
    });

    


});



</script>