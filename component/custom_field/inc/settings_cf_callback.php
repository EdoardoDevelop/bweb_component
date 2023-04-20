<?php
        //print_r($custom_field_group);
        ?>
        <div class="input_fields_box_wrap">
            
            <?php
                if(isset($this->bc_custom_field_options['custom_field_group'])):
                $custom_field_group = $this->bc_custom_field_options['custom_field_group'];
                if(isset($custom_field_group) && is_array($custom_field_group)) {
                    
                    
                    foreach($custom_field_group as $narray => $v ){
                        //print_r($text);
                    ?>
                    <div class="input_fields_group_box_wrap" attr_n="<?php echo $narray; ?>">
                    <div class="cont_box">
                        <strong>Nome Gruppo</strong> <input class="txt_custom_field_name regular-text" type="text"  value="<?php echo $v['namegroup']; ?>" name="bc_settings_cf[custom_field_group][<?php echo $narray; ?>][namegroup]"/>
                        <a href="#" class="remove_group button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span>Rimuovi</a>
                        <div><br><?php   
                        $args_custom_post_types = array(
                            'public' => true,
                        );
                        $custom_post_types = get_post_types( $args_custom_post_types, 'objects' );
                        foreach ( $custom_post_types as $post_type_obj ):
                            
                            $labels = get_post_type_labels( $post_type_obj );
                            echo '<label><input type="checkbox" name="bc_settings_cf[custom_field_group]['.$narray.'][typepost][]" value="'.esc_attr( $post_type_obj->name ).'" ';
                            echo ( isset( $v['typepost'] ) && in_array(esc_attr( $post_type_obj->name ), $v['typepost']) ) ? 'checked' : '';
                            echo '> '.esc_html( $labels->name ).' </label>';
                        endforeach;
                        echo '<br><br>';
                        //print_r($this->generate_all_posts());
                        echo '<strong>Singole pagine:</strong> <select id="select_posts'.$narray.'" name="bc_settings_cf[custom_field_group]['.$narray.'][select_posts][]" multiple size="3">';
                        $select_posts_option = '';
                        foreach ( $this->generate_all_posts() as $idpost ):
                            if ( filter_var($idpost, FILTER_VALIDATE_INT) === false ) {
                                if($select_posts_option != ''){
                                    $select_posts_option .= '';
                                }else{
                                    $select_posts_option .= '</optgroup>';
                                };
                                $select_posts_option .= '<optgroup label="'. $idpost. '">';
                            }else{
                                $select_posts_option .= '<option value="'. $idpost. '" '.((isset( $v['select_posts'] ) && in_array($idpost, $v['select_posts']) ) ? 'selected' : '').'>'. get_the_title($idpost). '</option>';
                            }
                        endforeach;
                        $select_posts_option .= '</optgroup>';
                        echo $select_posts_option;
                        echo '</select>';
                        echo '<script>let mySelect'.$narray.' = new vanillaSelectBox("#select_posts'.$narray.'");</script>';
                        
                        echo '<br><br><strong>Posizione:</strong>';
                        $valuepos = $v['position'];
                        printf(
                            '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][position]" value="normal" %s>normal</label> | ',
                            $narray,
                            ( isset( $valuepos ) && $valuepos === 'normal' ) ? 'checked' : ''
                        );
                        printf(
                            '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][position]" value="side" %s>side</label> | ',
                            $narray,
                            ( isset( $valuepos ) && $valuepos === 'side' ) ? 'checked' : ''
                        );
                        printf(
                            '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][position]" value="advanced" %s>advanced</label> | ',
                            $narray,
                            ( isset( $valuepos ) && $valuepos === 'advanced' ) ? 'checked' : ''
                        );
                        printf(
                            '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][position]" value="after_title" %s>after_title(non visibile in gutenberg)</label>',
                            $narray,
                            ( isset( $valuepos ) && $valuepos === 'after_title' ) ? 'checked' : ''
                        );
                        echo '<br><br><a class="add_field_metabox_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi campo</a><br><br><div class="box_field" style="display: flex;flex-wrap: wrap;">';
                        //print_r($custom_field_group[$narray]['field']);
                        if(isset($custom_field_group[$narray]['field']) && is_array($custom_field_group[$narray]['field'])) {
                            foreach($custom_field_group[$narray]['field'] as $narray2 => $v2 ){
                                $valuetype = $v2['type'];
                                echo '<div class="cont_custom_field" attr_n="'.$narray2.'"><div class="cont_box">';
                                echo '<a href="#TB_inline?&inlineId=Coden'.$narray2.'" class="thickbox" style="float:right; text-decoration:none"><span class="dashicons dashicons-code-standards"></span></a>';
                                echo '<div id="Coden'.$narray2.'" class="hidden"><pre>';
                                $txtinfo_field = sanitize_title($v['namegroup']) . '_' . sanitize_title($v2['namefield']);
                                echo '$field = get_post_meta( $post->ID, \''.$txtinfo_field.'\', true );<br>';
                                if(isset( $valuetype ) && $valuetype === 'multipleimg'){
                                    echo 'if(isset($field) && is_array($field_'.$txtinfo_field.')):<br>';
                                    echo '  foreach ($field as $key => $value) : <br>';
                                    echo '      $urlimage = wp_get_attachment_image_src($value, $size)[0];<br>';
                                    echo '      echo \'&#60;img class="image-preview" src="\'.$urlimage.\'"&#62;\';<br>';
                                    echo '  endforeach;<br>';
                                    echo 'endif;';
                                }
                                if(isset( $valuetype ) && $valuetype === 'allegato'){
                                    echo 'if(isset($field) && is_array($field)):<br>';
                                    echo '  for( $i = 0; $i < count( $field ); $i++ ):<br>';
                                    echo '      $file_documenti = $field[$i];<br>';
                                    echo '      $ext = substr($file_documenti, -4);<br>';
                                    echo '      $arrtype = explode("/", $file_documenti);<br>';
                                    echo '      $arrtype_more = explode(".", $arrtype[count($arrtype)-1]);<br>';
                                    echo '      if(is_array($arrtype_more)) {<br>';
                                    echo '          $arrtype = $arrtype_more;<br>';
                                    echo '      }<br>';
                                    echo '      $type = "file";<br>';
                                    echo '      if(is_array($arrtype)){<br>';
                                    echo '          $type = $arrtype[count($arrtype)-1];<br>';
                                    echo '      }<br>';
                                    echo '      $ptitle = str_replace("-", " ", basename($file_documenti, $ext));<br>';
                                    echo '      $ptitle = str_replace("_", " ", $ptitle);<br>';
                                    echo '      echo &apos;&lt;a target="_blank" href="&apos;.$file_documenti.&apos;">&apos;.$ptitle.&apos;&lt;/a&gt;&apos;;<br>';
                                    echo '  endfor;<br>';
                                    echo 'endif;';
                                }
                                if(isset( $valuetype ) && $valuetype === 'checkbox_post'){
                                    echo 'if(isset($field) && is_array($field)):<br>';
                                    echo '  for( $i = 0; $i < count( $field ); $i++ ):<br>';
                                    echo '      $ID = $field[$i];<br>';
                                    echo '  endfor;<br>';
                                    echo 'endif;';
                                    echo '<br><hr>OPPURE<hr><br>';
                                    echo '$field = get_post_meta( $post->ID, \''.$txtinfo_field.'\', true );<br>';
                                    echo 'if(isset($field) && is_array($field)):<br>';
                                    echo '  $args = array(<br>';
                                    //echo '      &apos;post_type&apos; => array( &apos;post&apos; ),<br>';
                                    echo '      &apos;orderby&apos; => &apos;ASC&apos;,<br>';
                                    echo '      &apos;post__in&apos; => $field<br>';
                                    echo '      );<br>';
                                    echo '  $query = new WP_Query( $args );<br>';
                                    echo '  if ( $query -> have_posts() ) :<br>';
                                    echo '      while ( $query -> have_posts() ) :<br>';
                                    echo '          $query -> the_post();<br>';
                                    echo '          $url = get_the_permalink();<br>';
                                    echo '          $title = get_the_title();<br>';
                                    echo '          $excerpt = get_the_excerpt();<br>';
                                    echo '          $content = get_the_content();<br>';
                                    echo '  endif;<br>';
                                    echo 'endif;';
                                }
                                if(isset( $valuetype ) && $valuetype === 'calendario'){
                                    echo '<br>$dateD = date(" j", strtotime($field_'.$txtinfo_field.'));<br>';
                                    echo '$dateM = date(" M", strtotime($field_'.$txtinfo_field.'));<br>';
                                    echo '$dateY = date(" Y", strtotime($field_'.$txtinfo_field.'));<br>';
                                }
                                echo '</pre></div>';
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="text" %s>Testo</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'text' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="textarea" %s>Textarea</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'textarea' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="editor" %s>Editor</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'editor' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="checkbox" %s>Checkbox</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'checkbox' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="calendario" %s>Calendario</label> <br><br> ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'calendario' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="img" %s>Immagine</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'img' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="multipleimg" %s>Immagini multiple</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'multipleimg' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="allegato" %s>Allegato</label> | ',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'allegato' ) ? 'checked' : ''
                                );
                                printf(
                                    '<label><input type="radio" name="bc_settings_cf[custom_field_group][%s][field][%s][type]" value="checkbox_post" %s>Checkbox post</label>',
                                    $narray, $narray2,
                                    ( isset( $valuetype ) && $valuetype === 'checkbox_post' ) ? 'checked' : ''
                                );
                                echo '<br><br>Nome campo<br><input class="txt_custom_field_field_name regular-text" type="text" name="bc_settings_cf[custom_field_group]['.$narray.'][field]['.$narray2.'][namefield]"  value="'.$v2['namefield'].'"/>';
                                $class_cont_get_post_type = 'hidden';
                                if( isset( $valuetype ) && $valuetype === 'checkbox_post' ){
                                    $class_cont_get_post_type = 'show';
                                }
                                echo '<div class="cont_get_post_type '.$class_cont_get_post_type.'"><br><br>Checkbox post type:<br>';
                                foreach ( $custom_post_types as $post_type_obj ):
                                    $labels = get_post_type_labels( $post_type_obj );
                                    echo '<label><input type="radio" name="bc_settings_cf[custom_field_group]['.$narray.'][field]['.$narray2.'][checkbox_post]" value="'.esc_attr( $post_type_obj->name ).'" ';
                                    echo ( isset( $v2['checkbox_post'] ) && $v2['checkbox_post'] === esc_attr( $post_type_obj->name ) ) ? 'checked' : '';
                                    echo '> '.esc_html( $labels->name ).' </label>';
        
                                endforeach;
                                echo '</div>';
                                echo '<br><br><a href="#" class="remove_field button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><span style="float:right;" class="dashicons dashicons-move icondrop"></span></div></div>';
                            }
                        }
                        echo '</div><span class="dashicons dashicons-sort icondrop"></span></div>';
                        
                        ?>
                        <!--<div style="margin:5px 0;">Nome campo<br><input class="txt_custom_field_name regular-text" type="text"  value="<?php  ?>" name="bc_settings_cf[custom_field_group][<?php //echo $narray; ?>]['field']['name']"/></div>-->
                    </div>
                    </div>
                    <?php
                        
                        
                        
                    }
                } 
            endif;
            ?>


        </div>