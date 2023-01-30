<script type="text/javascript">
        jQuery(document).ready(function($) {
            sortable_input_fields_box_wrap($);
            sortable_box_field($);
            //var max_fields      = 10; //maximum input boxes allowed
            
            
            //var y = $('.txt_custom_field_name').length; //initlal text box count
            $(".add_group_metabox_button").click(function(e){ //on add input button click
                e.preventDefault();
                var narray = $('.txt_custom_field_name').length;
                if(narray>0){
                    narray = assign_n(".input_fields_box_wrap .input_fields_group_box_wrap", narray);
                }
                //if(y < max_fields){ //max input box allowed
                    //y++; //text box increment
                    var out = '';
                    out += '<div style="margin:20px 0;background-color: #fff;border: 1px solid #ccc;padding: 20px;" class="input_fields_group_box_wrap" attr_n=".narray."><strong>Nome Gruppo</strong> <input class="txt_custom_field_name regular-text" type="text" name="bc_settings_cf[custom_field_group][.narray.][namegroup]"/>';
                    out += ' <a href="#" class="remove_group button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a>';
                    out += '<div><br><?php   
                    $args_custom_post_types = array(
                        'public' => true,
                    );
                    $custom_post_types = get_post_types( $args_custom_post_types, 'objects' );
                    foreach ( $custom_post_types as $post_type_obj ):
                        
                        $labels = get_post_type_labels( $post_type_obj );
                        echo '<label><input type="checkbox" name="bc_settings_cf[custom_field_group][.narray.][typepost][]" value="'.esc_attr( $post_type_obj->name ).'" > '.esc_html( $labels->name ).' </label>';
                    endforeach;
                    echo '<br><br><strong>Posizione:</strong> ';
                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][position]" value="normal" checked >normal</label> | ';
                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][position]" value="side" >side</label> | ';
                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][position]" value="advanced" >advanced</label> | ';
                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][position]" value="after_title" >after_title(non visibile in gutenberg)</label>';
                    echo '<br><br><a class="add_field_metabox_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi campo</a><br><br><div class="box_field" style="display: flex;flex-wrap: wrap;">';

                    ?>';

                    out += '</div><span class="dashicons dashicons-sort"></span></div>';
                    out = out.replace(/.narray./g, narray);
                    //narray++;
                    $(".input_fields_box_wrap").append(out); //add input box
                    sortable_input_fields_box_wrap($);
                //}
            });
            $(".input_fields_box_wrap").delegate(".add_field_metabox_button","click",function(e){ //on add input button click
                
                e.preventDefault();
                var narray =  $(this).parents('.input_fields_group_box_wrap').attr('attr_n');
                //alert( $(this).parents('.input_fields_group_box_wrap').index());
                var narray2 = $('.cont_custom_field').length;
                if(narray2>0){
                    narray2 = assign_n(".input_fields_group_box_wrap[attr_n='"+narray+"'] .cont_custom_field", narray2);
                }
                var out = '';
                out += '<div class="cont_custom_field" attr_n=".narray2." style="margin: 10px;border: 1px solid #ccc;padding: 10px;background-color: #fff;">';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="text" checked>Testo</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="textarea">Textarea</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="editor">Editor</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="checkbox">Checkbox</label> <br><br> ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="calendario">Calendario</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="multipleimg">Immagini multiple</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="allegato">Allegato</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="checkbox_post">Checkbox post</label>';
                out += '<br><br>Nome campo<br><input class="txt_custom_field_field_name regular-text" type="text" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][namefield]"/>';
                out += '<?php
                echo '<div class="cont_get_post_type hidden"><br><br>Checkbox post type:<br>';
                foreach ( $custom_post_types as $post_type_obj ):
                    $labels = get_post_type_labels( $post_type_obj );
                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][checkbox_post]" value="'.esc_attr( $post_type_obj->name ).'" ';
                    echo '> '.esc_html( $labels->name ).' </label>';

                endforeach;
                echo '</div>';
                ?>';
                out += '<br><br><a href="#" class="remove_group button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><span style="float:right;" class="dashicons dashicons-move icondrop"></span></div>';
                out = out.replace(/.narray2./g, narray2);
                out = out.replace(/.narray./g, narray);
                //narray2++;
                $('.box_field',$(this).parent('div')).append(out); //add input box
                sortable_box_field($);
            });

            $(".input_fields_box_wrap").on("click",".remove_group", function(e){ //user click on remove text
                e.preventDefault(); 
                var c = confirm('Confermi la cancellazione?');
                if (c) $(this).parent('div').remove(); y--;
            });
            
            $(".input_fields_box_wrap").on("click",".info_button", function(e){ //user click on remove text
                e.preventDefault(); 
                $('.info_box',$(this).parent('div')).show();
            });

            $(".input_fields_box_wrap").on("click",".info_button_close", function(e){ //user click on remove text
                e.preventDefault(); 
                $(this).parent('div').hide();
            });
            $(".input_fields_box_wrap").on("change",".box_field input[type=radio]", function(e){
                if($(this).val()=='checkbox_post'){
                    $('.cont_get_post_type',$(this).parent('label').parent('div')).show();
                }else{
                    $('.cont_get_post_type',$(this).parent('label').parent('div')).hide();
                }
            });

        });

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

        function sortable_input_fields_box_wrap($){
            $('.input_fields_box_wrap').sortable({
                cursor: "move",
                handle: ".icondrop",
                axis: "y",
                opacity: 0.5,
                revert: true,
                tolerance: "pointer",
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                    ui.placeholder.css('visibility', 'visible');
                    ui.placeholder.css('background', '#f8f8f8');
                    ui.placeholder.css('margin', '20px 0');
                    ui.placeholder.css('padding', '20px');
                    ui.placeholder.css('border', '1px dashed #ccc');
                }
            });
            $(".input_fields_box_wrap").disableSelection();
        }

        function sortable_box_field($){
            $('.box_field').sortable({
                cursor: "move",
                handle: ".icondrop",
                opacity: 0.5,
                revert: true,
                tolerance: "pointer",
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
            $(".box_field").disableSelection();
        }
</script>