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
                    out += '<div class="input_fields_group_box_wrap" attr_n=".narray."><div class="cont_box"><strong>Nome Gruppo</strong> <input class="txt_custom_field_name regular-text" type="text" name="bc_settings_cf[custom_field_group][.narray.][namegroup]"/>';
                    out += ' <a href="#" class="remove_group button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a>';
                    out += "<div><br><?php   
                    $args_custom_post_types = array(
                        'public' => true,
                    );
                    $custom_post_types = get_post_types( $args_custom_post_types, 'objects' );
                    foreach ( $custom_post_types as $post_type_obj ):
                        
                        $labels = get_post_type_labels( $post_type_obj );
                        echo '<label><input type=\"checkbox\" name=\"bc_settings_cf[custom_field_group][.narray.][typepost][]\" value=\"'.esc_attr( $post_type_obj->name ).'\" > '.esc_html( $labels->name ).' </label>';
                    endforeach;
                    echo '<br><br>';
                    //print_r($this->generate_all_posts());
                    echo '<strong>Singole pagine:</strong> <select id=\"select_posts.narray.\" name=\"bc_settings_cf[custom_field_group][.narray.][select_posts][]\" multiple size=\"3\">';
                    $select_posts_option = '';
                    foreach ( $this->generate_all_posts() as $idpost ):
                        if ( filter_var($idpost, FILTER_VALIDATE_INT) === false ) {
                            if($select_posts_option != ''){
                                $select_posts_option .= '';
                            }else{
                                $select_posts_option .= '</optgroup>';
                            };
                            $select_posts_option .= '<optgroup label=\"'. $idpost. '\">';
                        }else{
                            $select_posts_option .= '<option value=\"'. $idpost. '\" >'. get_the_title($idpost). '</option>';
                        }
                    endforeach;
                    $select_posts_option .= '</optgroup>';
                    echo $select_posts_option;
                    echo '</select>';
                    //echo '<script>let mySelect.narray. = new vanillaSelectBox("#select_posts.narray.");</script>';
                    echo '<br><br><strong>Posizione:</strong> ';
                    echo '<label><input type=\"radio\" name=\"bc_settings_cf[custom_field_group][.narray.][position]\" value=\"normal\" checked >normal</label> | ';
                    echo '<label><input type=\"radio\" name=\"bc_settings_cf[custom_field_group][.narray.][position]\" value=\"side\" >side</label> | ';
                    echo '<label><input type=\"radio\" name=\"bc_settings_cf[custom_field_group][.narray.][position]\" value=\"advanced\" >advanced</label> | ';
                    echo '<label><input type=\"radio\" name=\"bc_settings_cf[custom_field_group][.narray.][position]\" value=\"after_title\" >after_title(non visibile in gutenberg)</label>';
                    echo '<br><br><a class=\"add_field_metabox_button button-secondary\"><span class=\"dashicons dashicons-plus-alt\" style=\"vertical-align: text-top;\"></span> Aggiungi campo</a><br><br><div class=\"box_field\" style=\"display: flex;flex-wrap: wrap;\">';

                    ?>";

                    out += '</div><span class=\"dashicons dashicons-sort\"></span></div></div>';
                    out = out.replace(/.narray./g, narray);
                    //narray++;
                    $(".input_fields_box_wrap").append(out); //add input box
                    new vanillaSelectBox("#select_posts"+narray);
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
                out += '<div class="cont_custom_field" attr_n=".narray2."><div class="cont_box">';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="text" checked>Testo</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="textarea">Textarea</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="editor">Editor</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="checkbox">Checkbox</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="calendario">Calendario</label> <br><br> ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="img">Immagine</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="multipleimg">Immagini multiple</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="allegato">Allegato</label> | ';
                out += '<label><input type="radio" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][type]" value="checkbox_post">Checkbox post</label>';
                out += '<br><br>Nome campo<br><input class="txt_custom_field_field_name regular-text" type="text" name="bc_settings_cf[custom_field_group][.narray.][field][.narray2.][namefield]"/>';
                out += "<?php
                echo '<div class=\"cont_get_post_type hidden\"><br><br>Checkbox post type:<br>';
                foreach ( $custom_post_types as $post_type_obj ):
                    $labels = get_post_type_labels( $post_type_obj );
                    echo '<label><input type=\"radio\" name=\"bc_settings_cf[custom_field_group][.narray.][field][.narray2.][checkbox_post]\" value=\"'.esc_attr( $post_type_obj->name ).'\" ';
                    echo '> '.esc_html( $labels->name ).' </label>';

                endforeach;
                echo '</div>';
                ?>";
                out += '<br><br><a href="#" class="remove_field button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><span style="float:right;" class="dashicons dashicons-move icondrop"></span></div></div>';
                out = out.replace(/.narray2./g, narray2);
                out = out.replace(/.narray./g, narray);
                //narray2++;
                $('.box_field',$(this).parent('div')).append(out); //add input box
                sortable_box_field($);
            });

            $(".input_fields_box_wrap").on("click",".remove_group", function(e){ //user click on remove text
                e.preventDefault(); 
                /*var c = confirm('Confermi la cancellazione?');
                if (c) $(this).parent('div').remove(); y--;*/
                var p = $(this);
                $('.cont_box').removeClass('confirm_remove');
                $('.box_remove').remove();
                p.parent('.cont_box').addClass('confirm_remove');
                p.parents('.input_fields_group_box_wrap').addClass('check_rm');
                setTimeout(function(){
                    p.parents('.input_fields_group_box_wrap').append('<div class="box_remove"><h4>Confermi la cancellazione?</h4><br><br><a href="#" class="box_remove_no">No</a><a href="#" class="box_remove_si">Si</a></div>');
                },200);
            });

            $(".input_fields_box_wrap").on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); 
                /*var c = confirm('Confermi la cancellazione?');
                if (c) $(this).parent('div').remove(); y--;*/
                var p = $(this);
                $('.cont_box').removeClass('confirm_remove');
                $('.box_remove').remove();
                p.parent('.cont_box').addClass('confirm_remove');
                p.parents('.cont_custom_field').addClass('check_rm');
                setTimeout(function(){
                    p.parents('.cont_custom_field').append('<div class="box_remove"><h4>Confermi la cancellazione?</h4><br><br><a href="#" class="box_remove_no">No</a><a href="#" class="box_remove_si">Si</a></div>');
                },200);
            });
            
            $(".input_fields_box_wrap").on("click",".box_remove_no", function(e){ 
                e.preventDefault(); 
                $(this).parents('.box_remove').remove();
                $('.confirm_remove').removeClass('confirm_remove');
                $('.check_rm').removeClass('check_rm');
            })
            $(".input_fields_box_wrap").on("click",".box_remove_si", function(e){ 
                e.preventDefault(); 
                $(this).parents('.check_rm').remove();
            })
            
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