
<div class="input_fields_wrap">

    <?php //print_r($this->bc_forms_options);
    if(isset($this->bc_forms_options['forms'])):
        $option_forms = $this->bc_forms_options['forms'];//get_option( 'bc_settings_cpt' )
        if(isset($option_forms) && is_array($option_forms)) {
            //print_r($array_forms);
            foreach($option_forms as $narray => $v ){
                echo '<div class="forms_group_box_wrap" attr_n="'.$narray.'">';
                    echo '<div style="margin:20px;background-color: #f1f1f1;border: 1px solid #ccc;padding: 20px;">';
                        echo '<strong>Nome Form:</strong><br><input class="txt_forms_name" type="text" name="bc_settings_forms[forms]['.$narray.'][name]" value="' . $v['name'] . '"/>';
                        echo '<a href="#" class="remove_field button-secondary" style="float:right"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a><br><br>';
                        
                        echo '<div class="bc-form-bar" style="display: block;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-top: 1px solid #ccc">
                                <a href="#" class="bc-form-bar-item" attr_form_bar=".bar_form" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none; ">Form</a>
                                <a href="#" class="bc-form-bar-item" attr_form_bar=".bar_email" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none;background-color: #eee;">Email</a>
                                <a href="#" class="bc-form-bar-item" attr_form_bar=".bar_db" style="display: inline-block; color: #444;padding: 10px 30px;font-size: 15px;text-decoration: none;background-color: #eee;">Database</a>
                                
                            </div>';
                        echo '<div class="bar_cont bar_form" style="padding:10px;background-color: #fff; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc">';
                            echo '<a class="add_field_forms_button button-secondary"><span class="dashicons dashicons-plus-alt" style="vertical-align: text-top;"></span> Aggiungi Campo</a><br>';
                            echo '<div class="box_field">';
                            $var_field = '';
                                if(isset($v['field']) && is_array($v['field'])) {
                                    foreach($v['field'] as $narray2 => $v2 ){
                                        echo '<div class="cont_forms_field" attr_n="'.$narray2.'" style="margin:20px;background-color: #ffffff;border: 1px solid #ccc;padding: 20px;">';
                                            echo '<strong>Tipo di Campo</strong><br>';
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="text" %s>Text</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'text' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="email" %s>Email</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'email' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="phone" %s>Phone</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'phone' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="textarea" %s>Textarea</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'textarea' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="checkbox" %s>Checkbox</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'checkbox' ) ? 'checked' : ''
                                            );
                                            
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="num" %s>Numerico</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'num' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="radio" %s>Radio</label> | ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'checkbox' ) ? 'checked' : ''
                                            );
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="select" %s>Select</label> <br> ',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'checkbox' ) ? 'checked' : ''
                                            );
                                            
                                            printf(
                                                '<label><input type="radio" class="radio_field_type" name="bc_settings_forms[forms][%s][field][%s][type]" value="testo" %s>Solo testo</label>',
                                                $narray,
                                                $narray2,
                                                ( $v2['type'] == 'testo' ) ? 'checked' : ''
                                            );
                                            echo '<br><br>';
                                            printf(
                                                '<div style="display:inline-block">Name<br><input type="text" class="input_field_forms_name" name="bc_settings_forms[forms][%s][field][%s][name]" value="%s" %s/></div>',
                                                $narray,
                                                $narray2,
                                                $v2['name'],
                                                ( $v2['type'] == 'testo' )? 'readonly' : ''
                                            );
                                            printf(
                                                '<div style="display:inline-block">Label<br><input type="text" class="input_field_forms_name" name="bc_settings_forms[forms][%s][field][%s][label]" value="%s" %s/></div>',
                                                $narray,
                                                $narray2,
                                                $v2['label'],
                                                ( $v2['type'] == 'testo' )? 'readonly' : ''
                                            );
                                            echo '<br><br>';
                                            echo '<a href="#" class="collapsible" style="display: block;background-color: #eee;color: #444;padding: 10px;font-size: 15px;text-decoration: none;">Impostazioni aggiuntive <span style="float: right;font-weight: bold;">+</span></a>';
                                            echo '<div style="max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out; border: 1px solid #eee">';
                                                echo '<div style="padding:15px"> ';
                                                    echo 'Template<br><textarea class="input_field_forms_template html_template" name="bc_settings_forms[forms]['.$narray.'][field]['.$narray2.'][template]" rows="10" cols="80">'.htmlspecialchars($v2['template']).'</textarea>';
                                                    echo '<br>Variabili: $name, $label<br>';
                                                    echo 'Variabili generici: $idpagina, $urlpagina, $titolopagina, $slugpagina, $nomesito, $urlsito<br><br>';
                                                    printf(
                                                        '<label><input type="checkbox" class="input_field_forms_req" name="bc_settings_forms[forms][%s][field][%s][required]" %s %s> Required</label>',
                                                        $narray,
                                                        $narray2,
                                                        ( isset($v2['required']) && $v2['required'] == 'on' ) ? 'checked' : '',
                                                        ( $v2['type'] == 'testo' )? 'disabled' : ''
                                                    );
                                                echo '</div>';
                                            echo '</div>';
                                            echo '<br><br>';
                                            echo '<a href="#" class="remove_field_forms button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-top;"></span> Rimuovi</a>';
                                            echo '<span style="float:right;" class="dashicons dashicons-move icondrop"></span>';
                                        echo '</div>';
                                        if(!empty($var_field)){
                                            $var_field .= ', ';
                                        }
                                        $var_field .= '['.$v2['name'].']';
                                    }
                                }
                            echo '</div>';
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
                                    echo '<label>Campi</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<div class="box_var_'.$narray.'">'.$var_field.'</div>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>A</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][to]" value="'.$v['email']['to'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Da</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][from]" value="'.$v['email']['from'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Oggetto</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][subject]" value="'.$v['email']['subject'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Header</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][header]" value="'.$v['email']['header'].'"/>';
                                echo '</td>';
                            echo '</tr>';

                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Reply-To</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][reply]" value="'.$v['email']['reply'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo '<label>Corpo del messaggio</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms" name="bc_settings_forms[forms]['.$narray.'][email][msg]" rows="10" cols="80" >'.htmlspecialchars($v['email']['msg']).'</textarea>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Seconda mail ';
                                    printf(
                                        '<label><input type="checkbox" class="input_field_forms_email2" name="bc_settings_forms[forms][%s][email2][active]" %s></label>',
                                        $narray,
                                        ( isset($v['email2']['active']) && $v['email2']['active'] == 'on' ) ? 'checked' : ''
                                    );
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                echo '</td>';
                            echo '</tr>';
                            $email2_disabled = 'readonly="true"';
                            if(isset($v['email2']['active']) && $v['email2']['active'] == 'on'){
                                $email2_disabled = '';
                            }
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>A</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][to]" '.$email2_disabled.' value="'.$v['email2']['to'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Da</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][from]" '.$email2_disabled.' value="'.$v['email2']['from'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Oggetto</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][subject]" '.$email2_disabled.' value="'.$v['email2']['subject'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Header</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][header]" '.$email2_disabled.' value="'.$v['email2']['header'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Reply-To</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][reply]" '.$email2_disabled.' value="'.$v['email2']['reply'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo '<label>Corpo del messaggio</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms field_email2" name="bc_settings_forms[forms]['.$narray.'][email2][msg]" '.$email2_disabled.' rows="10" cols="80" >'.htmlspecialchars($v['email2']['msg']).'</textarea>';
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
                                    printf(
                                        '<label><input type="checkbox" class="form_save_db" name="bc_settings_forms[forms][%s][db][active]" %s></label>',
                                        $narray,
                                        ( isset($v['db']['active']) && $v['db']['active'] == 'on' ) ? 'checked' : ''
                                    );
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<label>Campi</label>';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<div class="box_var_'.$narray.'">'.$var_field.'</div>';
                                echo '</td>';
                            echo '</tr>';
                            $db_disabled = 'readonly="true"';
                            if(isset($v['db']['active']) && $v['db']['active'] == 'on'){
                                $db_disabled = '';
                            }
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Titolo';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<input type="text" class="input_field_forms field_db" name="bc_settings_forms[forms]['.$narray.'][db][titolo]" '.$db_disabled.' value="'.$v['db']['titolo'].'"/>';
                                echo '</td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td style="vertical-align: middle;">';
                                    echo 'Body';
                                echo '</td>';
                                echo '<td style="vertical-align: baseline;">';
                                    echo '<textarea class="input_field_forms field_db" name="bc_settings_forms[forms]['.$narray.'][db][body]" '.$db_disabled.' rows="10" cols="80" >'.htmlspecialchars($v['db']['body']).'</textarea>';
                                echo '</td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</div>';
                    echo '<br><code>Funzione php: echo $bc_forms->get_html(' . $narray . ');</code><br><br>';
                echo '</div>';
            }


        }
    endif;
    ?>

</div>
<div>
    <?php
printf(
    '<label><input type="checkbox" class="input_log_send" name="bc_settings_forms[log]" %s> Log if error</label>',
    ( isset($this->bc_forms_options['log']) && $this->bc_forms_options['log'] == 'on' ) ? 'checked' : ''
);
    ?>
</div>