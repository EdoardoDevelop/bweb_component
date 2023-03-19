

<div class="input_fields_wrap" style="display:flex;flex-wrap: wrap;">
    
    <?php


    if(isset($this->bc_custom_post_type_options['custom-post-type'])):
        $custompost = $this->bc_custom_post_type_options['custom-post-type'];//get_option( 'bc_settings_cpt' )
        if(isset($custompost) && is_array($custompost)) {
            //print_r($custompost);
            foreach($custompost as $narraycustompost => $v ){
                //echo $text;

                echo '<div class="custompost_group_box_wrap" attr_n="'.$narraycustompost.'"><div class="cont_box"><strong>Nome:</strong><br>';
                echo '<input class="txt_custompost_name" type="text" name="bc_settings_cpt[custom-post-type]['.$narraycustompost.'][name]" value="' . $v['name'] . '"/>';
                echo '<a href="#" class="remove_field button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
                echo '<strong>Gutenberg:</strong> ';
                printf(
                    '<label><input type="radio" name="bc_settings_cpt[custom-post-type][%s][show_in_rest]" value="false" %s>NO</label> | ',
                    $narraycustompost,
                    ( isset( $v['show_in_rest'] ) && $v['show_in_rest'] === 'false' ) ? 'checked' : ''
                );
                printf(
                    '<label><input type="radio" name="bc_settings_cpt[custom-post-type][%s][show_in_rest]" value="true" %s>SI</label>',
                    $narraycustompost,
                    ( isset( $v['show_in_rest'] ) && $v['show_in_rest'] === 'true' ) ? 'checked' : ''
                );
                echo '<br><br><strong>Icona:</strong><br><div id="view_icon_'.$narraycustompost.'" style="display:inline-block;vertical-align: bottom;">';
                if (str_contains($v['icon'], 'dashicons-')) {
                ?>
                    <span class="dashicons <?php echo $v['icon'];?>" style="font-size: 22px; width: 22px; height: 22px; margin: 3px; vertical-align: top;"></span>
                <?php
                }elseif (str_contains($v['icon'], 'data:image/svg+xml')) {
                ?>
                    <img src="<?php echo $v['icon'];?>" style="height: 22px; margin: 3px; vertical-align: top;"/>
                <?php
                }else{
                ?>
                    <span class="dashicons dashicons-admin-post" style="font-size: 22px; width: 22px; height: 22px; margin: 3px; vertical-align: top;"></span>
                <?php
                }
                echo '</div><input class="txt_custompost_icon " type="text" name="bc_settings_cpt[custom-post-type]['.$narraycustompost.'][icon]" value="' . $v['icon'] . '"/>';
                ?>
                    <input type="radio" name="chk_icon" id="chk_icon<?php echo $narraycustompost;?>" value="<?php echo $narraycustompost;?>" style="display:none;">
                    <a href="#TB_inline?&width=360&height=400&inlineId=select_dashicons_cpt" onclick="chk_icon('<?php echo $narraycustompost;?>');" class="thickbox button-secondary" style="vertical-align: top;"><span class="dashicons dashicons-art" style="vertical-align: text-top;"></span>Icone</a>
                        

                <?php                    
                echo '<br><br><hr>';
                echo '<a class="add_tax_custompost_button button-secondary" style="display:block; text-align:center"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi Tassonomia</a>';
                echo '<div class="box_tax">';
                if(isset($v['tax']) && is_array($v['tax'])) {
                    foreach($v['tax'] as $narray2 => $v2 ){
                        echo '<div class="cont_tax" attr_n="'.$narray2.'"><div class="main_tax"><strong>Tipo di Tassonomia</strong><br>';
                        printf(
                            '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][%s][tax][%s][type]" value="tag" %s>Tag</label> | ',
                            $narraycustompost,
                            $narray2,
                            ( $v2['type'] == 'tag' ) ? 'checked' : ''
                        );
                        printf(
                            '<label><input type="radio" class="radio_tx_type" name="bc_settings_cpt[custom-post-type][%s][tax][%s][type]" value="category" %s>Categoria</label>',
                            $narraycustompost,
                            $narray2,
                            ( $v2['type'] == 'category' ) ? 'checked' : ''
                        );
                        echo '<br><br>Nome Tassonomia<br><input type="text" class="input_tax_custompost_name" name="bc_settings_cpt[custom-post-type]['.$narraycustompost.'][tax]['.$narray2.'][name]" value="' . $v2['name'] . '"/>';
                        echo '<br><br><a href="#" class="remove_tax_custompost button-secondary delete"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a></div></div>';
                    }
                }
                echo '</div><br><span class="dashicons dashicons-move icondrop"></span>';
                ?>
                <a href="#TB_inline?&width=360&height=400&inlineId=view_code<?php echo $narraycustompost;?>" class="thickbox" style="float:right; text-decoration:none"><span class="dashicons dashicons-code-standards"></span></a>
                <div id="view_code<?php echo $narraycustompost;?>" class="hidden">
                    <pre>
$args = array(
'post_type'        => '<?php echo $v['name']; ?>',
'post_status' => 'publish',
'numberposts' => -1
);
$cpt_loop = new WP_Query( $args );
if ($cpt_loop -> have_posts()) :
    while($cpt_loop -> have_posts()) : $cpt_loop -> the_post();
        the_content();
    endwhile; 
    wp_reset_query();
    wp_reset_postdata();
endif;
                    </pre>
                </div>
                <div class="clear"></div>
                <?php
                echo '</div>';
                echo '</div>';
                    
            }
        }
    endif;
    ?>
</div>

<div class="select_dashicons_cpt" id="select_dashicons_cpt" style="display:none;">           
<?php
$icons_json = json_decode(file_get_contents(plugin_dir_path( __FILE__ ) .'icons.json'), false);
foreach($icons_json->icon as $icon) {
    
    if ($icon->type=='dashicons') {
    ?>
        <span class="dashicons <?php echo $icon->class;?>" onclick="select_icon_cpt('<?php echo $icon->class;?>');" style="font-size: 36px; width: 36px; height: 36px; margin: 3px; cursor:pointer;"></span>
    <?php
    }elseif ($icon->type=='fontawesome') {
    ?>
        <i class="<?php echo $icon->styles.'_'.$icon->unicode;?> <?php 
            if($icon->styles=='regular') echo 'far fa-regular';
            if($icon->styles=='solid') echo 'fas fa-solid';
            if($icon->styles=='brands') echo 'fab fa-brands';
            ?>" onclick="select_icon_cpt('<?php echo $icon->svg;?>');" style="font-size: 28px; width: 36px; height: 36px; margin: 3px; cursor:pointer;">&#x<?php echo $icon->unicode;?></i>
    <?php
    }
    

    
}
?>
    
</div>