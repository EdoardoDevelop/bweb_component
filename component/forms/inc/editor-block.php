<?php
class BcFormsBlock {
	private $bc_forms_options;

    public function __construct() {
		$this->bc_forms_options = get_option( 'bc_settings_forms' ); 
        add_action('wp_ajax_process_contact_form', array($this, 'process_contact_form'));
        add_action('wp_ajax_nopriv_process_contact_form', array($this, 'process_contact_form'));
        add_action( 'wp_enqueue_scripts', array($this, 'action_style_bc_forms' ));
        if(isset($this->bc_forms_options['forms'])){
            add_action( 'init', array($this, 'bc_forms_gutenberg_block' ));
        }
        if(isset($this->bc_forms_options['log'])){
            if($this->bc_forms_options['log'] == 'on'){
                add_action( 'wp_mail_failed', array($this,'onMailError'), 10, 1 );
            }
        }
    }

    public function bc_forms_gutenberg_block() {
        // Skip block registration if Gutenberg is not enabled/merged.
        if (!function_exists('register_block_type')) {
            return;
        }
        
        wp_register_script( 'forms-gutenberg-block', plugin_dir_url( PLUGIN_FORMS_DIR ) . 'forms/inc/forms-block.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ) );
        wp_localize_script( 'forms-gutenberg-block', 'forms', get_option( 'bc_settings_forms' )['forms'] );
        register_block_type('bc/forms-block', array(
            'editor_script' => 'forms-gutenberg-block',
            'render_callback' => array($this,'bc_render_forms_block'),
            'attributes'  => array(
                'idforms' => array(
                    'type' => 'string'
                )
            ),
        ));
    }

    public function bc_render_forms_block($atts){
        return $this->get_html($atts[ 'idforms' ]);
    }
    public function get_html($idform){
        add_action('wp_footer', array($this, 'script_bc_forms'));
        $html = '';
        global $post;
        
        if(isset($this->bc_forms_options['forms'])):
            $option_forms = $this->bc_forms_options['forms'];
            if(isset($option_forms) && is_array($option_forms)) :
                $fieldform = $option_forms[$idform];
                
                $html .= '<form name="bc_contactForm'.$idform.'" class="bc_contactForm" id="bc_contactForm'.$idform.'" method="post" onsubmit="return processContactSubmit('.$idform.')" action="">';
                $html .= '<div class="bcform_wrap">';
                $html .= '<input type="hidden" name="var_idpagina" value="'.$post->ID.'">';
                $html .= '<input type="hidden" name="var_urlpagina" value="'.get_permalink( $post->ID ).'">';
                $html .= '<input type="hidden" name="var_titolopagina" value="'.$post->post_title.'">';
                $html .= '<input type="hidden" name="var_slugpagina" value="'.$post->post_name.'">';
                $html .= '<input type="hidden" name="var_nomesito" value="'.get_bloginfo().'">';
                $html .= '<input type="hidden" name="var_urlsito" value="'.get_site_url().'">';
                    
                if(isset($fieldform['field']) && is_array($fieldform['field'])) : 
                    foreach($fieldform['field'] as $field ): 
                        $t = $field['template'];
                        if($field['type']!='testo'){
                            $t = str_replace('$name',$field['name'],$t);
                            $t = str_replace('$label',$field['label'],$t);
                        }

                        $t = str_replace('$idpagina',$post->ID,$t);
                        $t = str_replace('$urlpagina',get_permalink( $post->ID ),$t);
                        $t = str_replace('$titolopagina',$post->post_title,$t);
                        $t = str_replace('$slugpagina',$post->post_name,$t);
                        $t = str_replace('$nomesito',get_bloginfo(),$t);
                        $t = str_replace('$urlsito',get_site_url(),$t);

                        $html .= $t;
                    endforeach; 
                endif; 
                $html .= '<div class="form-group"><div class="box_captcha">';
                $html .= '<label for="captcha">Please Enter the Captcha Text</label><br>';
                $html .= '<img src="'.plugin_dir_url( PLUGIN_FORMS_DIR ).'forms/inc/captcha.php" alt="CAPTCHA" id="captcha_'.$idform.'" class="captcha-image"><a href="#" onclick="refresh_captcha('.$idform.')"><svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24.75 30.56">
                    <g id="refresh" transform="translate(-5.625 -2.487)">
                      <path id="Tracciato_924" data-name="Tracciato 924" d="M22.5,10.266s1.713-.844-4.5-.844a11.25,11.25,0,1,0,11.25,11.25" fill="none" stroke="#111" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2.25"/>
                      <path id="Tracciato_925" data-name="Tracciato 925" d="M18,4.078,23.625,9.7,18,15.328" fill="none" stroke="#111" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25"/>
                    </g>
                  </svg></a>
                  <br>';
                
                $html .= '<input type="text" id="txt_captcha_'.$idform.'" name="captcha_challenge">';
                $html .= '</div></div>';
                $html .= '<div class="form-group">';
                $html .= '<input type="submit" id="submit'.$idform.'" class="btn" value="Invia"> <span id="bc_contactForm_status'.$idform.'"></span>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</form>';

                
            endif;
        endif;
        return $html;
    }


    public function action_style_bc_forms(){
        
        wp_enqueue_style( 'bc_forms_public-css', plugin_dir_url( PLUGIN_FORMS_DIR ).'forms/assets/public/style.css' );

    }

    public function script_bc_forms(){
        ?>
        <script>
            function processContactSubmit(idform) {
                document.getElementById("bc_contactForm"+idform).classList.add("loading");
                document.getElementById("submit"+idform).disabled = true;

                var request = new XMLHttpRequest();
                request.open("POST", "<?php echo admin_url( 'admin-ajax.php?action=process_contact_form' )?>");
                request.onreadystatechange = function() {
                    if(this.readyState === 4 && this.status === 200) {
                        //document.getElementById("bc_contactForm_status"+idform).innerHTML = this.responseText;
                        if(this.responseText == "ERRORCAPTCHA"){
                            refresh_captcha(idform);
                            document.getElementById("bc_contactForm_status"+idform).innerHTML = "<span class='error'>Captcha non valido.</span>";
                        }
                        if(this.responseText == "EMPTYCAPTCHA"){
                            refresh_captcha(idform);
                            document.getElementById("bc_contactForm_status"+idform).innerHTML = "<span class='error'>Captcha non valido.</span>";
                        }
                        if(this.responseText == "ERROR"){
                            refresh_captcha(idform);
                            document.getElementById("bc_contactForm_status"+idform).innerHTML = "<span class='error'>Problema nell'invio dell'email.</span>";
                        }
                        if(this.responseText == "SUCCESS"){
                            refresh_captcha(idform);
                            document.getElementById("bc_contactForm_status"+idform).innerHTML = "<span class='success'>Messaggio inviato.</span>";
                        }
                        document.getElementById("bc_contactForm"+idform).classList.remove("loading");
                        document.getElementById("submit"+idform).disabled = false;
                        
                    }
                };
                var contactForm = document.getElementById("bc_contactForm"+idform);
                var formData = new FormData(contactForm);
                formData.append( "security", '<?php echo wp_create_nonce( "secure_nonce_bc_contactForm" ); ?>' );
                formData.append( "idf", idform );
                request.send(formData);
                return false;
            }
            
            function refresh_captcha(idform){
                var refreshButton = document.getElementById("captcha_"+idform);
                refreshButton.src = '<?php echo plugin_dir_url( PLUGIN_FORMS_DIR ).'forms/inc/captcha.php'; ?>?' + Date.now();
                document.getElementById("txt_captcha_"+idform).value="";
                return false;
            }

        </script>
        <?php
    }


    public function process_contact_form(){
        check_ajax_referer( 'secure_nonce_bc_contactForm', 'security' );
        session_start();
        $valid = false;
        $cap = false;

        $to = '';
        $subject = '';
        $from = '';
        $reply = '';
        $message = '';
        $header = '';

        $to2 = '';
        $subject2 = '';
        $from2 = '';
        $reply2 = '';
        $message2 = '';
        $header2 = '';

        $mail2 = false;

        $save_db = false;
        $db_title = '';
        $db_body = '';
        $db_cpt = '';

        $response = 'ERROR';

        if(isset($this->bc_forms_options['forms'])):
            $option_forms = $this->bc_forms_options['forms'];
            if(isset($option_forms) && is_array($option_forms)):
                $fieldform = $option_forms[$_POST["idf"]];
                if(isset($fieldform['email']) && is_array($fieldform['email'])): 
                    $setting_email = $fieldform['email'];
                    $to = $setting_email['to'];
                    $from = $setting_email['from'];
                    $header = $setting_email['header'];
                    $reply = $setting_email['reply'];
                    $subject = $setting_email['subject'];
                    $message = $setting_email['msg'];
                    $message = str_replace('$idpagina',$_POST['var_idpagina'],$message);
                    $message = str_replace('$urlpagina',$_POST['var_urlpagina'],$message);
                    $message = str_replace('$titolopagina',$_POST['var_titolopagina'],$message);
                    $message = str_replace('$slugpagina',$_POST['var_slugpagina'],$message);
                    $message = str_replace('$nomesito',$_POST['var_nomesito'],$message);
                    $message = str_replace('$urlsito',$_POST['var_urlsito'],$message);
                endif;

                if(isset($fieldform['email2']) && is_array($fieldform['email2'])): 
                    if(isset($fieldform['email2']['active']) && $fieldform['email2']['active'] == 'on'): 
                        $setting_email2 = $fieldform['email2'];
                        $to2 = $setting_email2['to'];
                        $from2 = $setting_email2['from'];
                        $header2 = $setting_email2['header'];
                        $reply2 = $setting_email2['reply'];
                        $subject2 = $setting_email2['subject'];
                        $message2 = $setting_email2['msg'];
                        $message2 = str_replace('$idpagina',$_POST['var_idpagina'],$message2);
                        $message2 = str_replace('$urlpagina',$_POST['var_urlpagina'],$message2);
                        $message2 = str_replace('$titolopagina',$_POST['var_titolopagina'],$message2);
                        $message2 = str_replace('$slugpagina',$_POST['var_slugpagina'],$message2);
                        $message2 = str_replace('$nomesito',$_POST['var_nomesito'],$message2);
                        $message2 = str_replace('$urlsito',$_POST['var_urlsito'],$message2);
                        $mail2 = true;
                    endif;
                endif;
                if(isset($fieldform['db']) && is_array($fieldform['db'])):
                    if(isset($fieldform['db']['active']) && $fieldform['db']['active'] == 'on'){
                        $save_db = true;
                        $db_title = $fieldform['db']['titolo'];
                        $db_body = $fieldform['db']['body'];
                        $db_cpt = 'forms_'.sanitize_title($fieldform['name']);
                    }
                endif;

                if(isset($_POST['captcha_challenge']) && $_POST['captcha_challenge'] == $_SESSION['captcha_text']) {
                    $cap = true;
                    if(isset($fieldform['field']) && is_array($fieldform['field'])): 
                        foreach($fieldform['field'] as $field ):
                            if(isset($_POST[$field['name']])):

                                $to = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$to);
                                $subject = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$subject);
                                $message = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$message);
                                $reply = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$reply);
                                $header = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$header);

                                $to2 = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$to2);
                                $subject2 = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$subject2);
                                $message2 = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$message2);
                                $reply2 = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$reply2);
                                $header2 = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$header2);

                                $db_title = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$db_title);
                                $db_body = str_replace('['.$field['name'].']',sanitize_text_field($_POST[$field['name']]),$db_body);

                                if($field['required'] == 'on' && empty($_POST[$field['name']]) ):
                                    $valid = false;
                                else:
                                    $valid = true;
                                endif;
                                if($field['type'] == 'email' ):
                                    if( is_email( $_POST[$field['name']] ) ){
                                        $valid = true;
                                    }else{
                                        $valid = false;
                                    }
                                
                                endif;

                            endif;
                        endforeach;
                    endif;
                }else{
                    $valid = false;
                    $cap = false;
                }
                
                
                
                if($valid): 
                    
                    $attachments = "";
                    if(is_email( $to ) && is_email( $from )){
                        $headers[] = 'From: '.$header.' <'.$from.'>';
                        $headers[] = 'Reply-To: '.$reply;
                        $sent = wp_mail($to, $subject, $message, $headers, $attachments);
                        //$sent = false;
                        if (! $sent) {
                            //echo "<span class='error'>Problema nell'invio dell'email.</span>";
                            $response = 'ERROR';
                            $db_title = 'Send error - '. $db_title;
                            //print_r(array($to, $subject, $message, $headers, $attachments));
                        } else {
                            $response = 'SUCCESS';
                            //echo "<span class='success'>Messaggio inviato</span>";
                        }
                        if($mail2){
                            $headers2[] = 'From: '.$header2.' <'.$from2.'>';
                            $headers2[] = 'Reply-To: '.$reply2;
                                $sent2 = wp_mail($to2, $subject2, $message2, $headers2, $attachments);
                            //$sent = false;
                            if (! $sent2) {
                                $response = 'ERROR';
                                //echo "<span class='error'>Problema nell'invio dell'email.</span>";
                                //print_r(array($to, $subject, $message, $headers, $attachments));
                            } else {
                                $response = 'SUCCESS';
                                //echo "<span class='success'>Messaggio inviato</span>";
                            }
                        }
                        if($save_db){
                            
                            wp_insert_post( array(
                                'post_title'    => $db_title,
                                'post_content'  => $db_body,
                                'post_author'   => 1,
                                'post_type'     => $db_cpt,
                                'post_status'   => 'publish'
                            ) );
                        }
                    }else{
                        $response = 'ERROR';
                        //echo "<span class='error'>Problema nell'invio dell'email.</span>";
                    }
                else:
                    if(!$cap){
                        $response = "ERRORCAPTCHA";
                    }else{
                        $response = "EMPTYCAPTCHA";
                    }
                endif;
            endif;
        endif;
        echo $response;
        session_destroy();
        wp_die();
    }

    public function onMailError($wp_error){
        
        echo "<pre>";
        print_r($wp_error);
        echo "</pre>";

    }
}
$bc_forms = new BcFormsBlock();

/*
add_action( 'wp_mail_failed', 'onMailError', 10, 1 );
function onMailError( $wp_error ) {
	echo "<pre>";
    print_r($wp_error);
    echo "</pre>";
}  */