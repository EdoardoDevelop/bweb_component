

<div class="input_fields_wrap" style="display:flex;flex-wrap: wrap;">
    
    <?php


    if(isset($this->bc_custom_option_field['custom_option_field'])):
        $custom_option_field = $this->bc_custom_option_field['custom_option_field'];//get_option( 'bc_custom_option_field' )
        if(isset($custom_option_field) && is_array($custom_option_field)) {
            //print_r($custom_option_field);
            foreach($custom_option_field as $narraycustom_option_field => $v ){
                //echo $text;

                echo '<div class="custom_option_field_group_box_wrap"><div style="margin:20px;background-color: #fff;border: 1px solid #ccc;padding: 20px;"><strong>Nome:</strong><br>';
                echo '<input class="txt_custom_option_field_name" type="text" name="bc_custom_option_field[custom_option_field]['.$narraycustom_option_field.'][name]" value="' . $v['name'] . '"/>';
                echo '<a href="#" class="remove_field button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
                
                ?>
                <a href="#TB_inline?&width=360&height=400&inlineId=view_code<?php echo $narraycustom_option_field;?>" class="thickbox" style="float:right; text-decoration:none"><span class="dashicons dashicons-code-standards"></span></a>
                <div id="view_code<?php echo $narraycustom_option_field;?>" class="hidden">
                    <pre>$field = get_option('<?php echo sanitize_title($v['name']); ?>');</pre>
                </div>
                <div class="clear"></div>
                <?php

                printf(
                    '<label><input type="radio" name="bc_custom_option_field[custom_option_field][%s][type]" value="text" %s>Testo</label> | ',
                    $narraycustom_option_field,
                    ( isset( $v['type'] ) && $v['type'] === 'text' ) ? 'checked' : ''
                );
                printf(
                    '<label><input type="radio" name="bc_custom_option_field[custom_option_field][%s][type]" value="textarea" %s>Textarea</label> | ',
                    $narraycustom_option_field,
                    ( isset( $v['type'] ) && $v['type'] === 'textarea' ) ? 'checked' : ''
                );
                printf(
                    '<label><input type="radio" name="bc_custom_option_field[custom_option_field][%s][type]" value="editor" %s>Editor</label>',
                    $narraycustom_option_field,
                    ( isset( $v['type'] ) && $v['type'] === 'editor' ) ? 'checked' : ''
                );
                echo '</div>';
                echo '</div>';
                    
            }
        }
    endif;
    ?>
</div>

    
</div>