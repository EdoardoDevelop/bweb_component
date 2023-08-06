<?php
/**
* ID: animsition
* Name: Animsition
* Description: Libreria di transizione di pagina
* Icon: data:image/png;base64,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
* Version: 1.0
* 
*/


class BcanimsitionSettings {
	private $bcanimsition_settings_options;

	public function __construct() {
        $this->bcanimsition_settings_options = get_option( 'bcanimsition_settings_option' );
		add_action( 'admin_menu', array( $this, 'bcanimsition_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bcanimsition_settings_page_init' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue') );
		add_action( 'admin_footer-bweb-component_page_animsition', array( $this, 'admin_js' ));
        add_action( 'wp_enqueue_scripts', array( $this, 'load_animsition') );
        add_filter( 'body_class', array( $this, 'pagetransition_body_class_names'), 100 );
        add_action( 'admin_head', function(){
            ?>
            <style>
            .jk_gif {
                position: relative;
                cursor: pointer;
                display: flex;
                width: fit-content;
                align-items: center;
                text-align: center;
                margin: 0 auto;
            }

            .jk_gif img{
                
                max-width: 150px;
                min-width: 100px;
                width: auto;
                height: auto;
                max-height: 500px;
                min-height: 100px;
                padding: 0 10px 0;
            margin-top: 10px;
            
            }

            </style>
            <?php
        },100 );
        add_action( 'wp_head', array( $this, 'pagetransition_head_scripts'),100 );
        add_action( 'wp_footer', array( $this, 'pagetransition_footer_scripts'),100 );
	}

	public function bcanimsition_settings_add_plugin_page() {
		add_submenu_page(
            'bweb-component',
			'Animsition', // page_title
			'Animsition', // menu_title
			'manage_options', // capability
			'animsition', // menu_slug
			array( $this, 'bcanimsition_settings_create_admin_page' ) // function
		);

	}

	public function bcanimsition_settings_create_admin_page() {
		 ?>

		<div class="wrap">
			<h2 class="wp-heading-inline">Animsition</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'bcanimsition_settings_option_group' );
				?>
					
						<?php
						do_settings_sections( 'bcanimsition-settings' );
						?>
					
					
					<?php
					submit_button();
				?>
				
			</form>
		</div>
	<?php }

	public function bcanimsition_settings_page_init() {
		register_setting(
			'bcanimsition_settings_option_group', // option_group
			'bcanimsition_settings_option', // option_name
			array( $this, 'bcanimsition_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bcanimsition_settings_section', // id
			'', // title
			'', // callback
			'bcanimsition-settings' // page
		);
		
		
		add_settings_field(
			'page_transition', // id
			'Page Animation', // title
			array( $this, 'page_transition_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);
		add_settings_field(
			'page_in_transition', // id
			'Page In Animation', // title
			array( $this, 'page_in_transition_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);
		add_settings_field(
			'page_out_transition', // id
			'Page Out Animation', // title
			array( $this, 'page_out_transition_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);
		add_settings_field(
			'page_in_duration', // id
			'Page In Animation Duration', // title
			array( $this, 'page_in_duration_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);
		
		add_settings_field(
			'page_out_duration', // id
			'Page Out Animation Duration', // title
			array( $this, 'page_out_duration_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);

        add_settings_field(
			'color_overlay', // id
			'Color Overlay', // title
			array( $this, 'color_overlay_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);

		add_settings_field(
			'show_loading', // id
			'Show Loading', // title
			array( $this, 'show_loading_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);

        add_settings_field(
			'color_loading', // id
			'Color Loading', // title
			array( $this, 'color_loading_callback' ), // callback
			'bcanimsition-settings', // page
			'bcanimsition_settings_section' // section
		);
		
		
	}


	public function bcanimsition_settings_sanitize($input) {
		$sanitary_values = array();
        


		if ( isset( $input['page_in_transition'] ) ) {
			$sanitary_values['page_in_transition'] = $input['page_in_transition'];
		}
		if ( isset( $input['page_out_transition'] ) ) {
			$sanitary_values['page_out_transition'] = $input['page_out_transition'];
		}
		if ( isset( $input['page_in_duration'] ) ) {
			$sanitary_values['page_in_duration'] = $input['page_in_duration'];
		}
		if ( isset( $input['page_out_duration'] ) ) {
			$sanitary_values['page_out_duration'] = $input['page_out_duration'];
		}
		if ( isset( $input['show_loading'] ) ) {
			$sanitary_values['show_loading'] = $input['show_loading'];
		}
		if ( isset( $input['color_overlay'] ) ) {
			$sanitary_values['color_overlay'] = $input['color_overlay'];
		}
		if ( isset( $input['color_loading'] ) ) {
			$sanitary_values['color_loading'] = $input['color_loading'];
		}
		

		return $sanitary_values;
	}

	
	public function page_transition_callback() {
		 
			foreach ( $this->get_page_transitions() as $key => $value ): 
				printf(
					'<div style="display:inline-block; text-align:center; margin:5px;" class="gif_page_transition" data-transition="%s" data-gif="%s"><br>%s</div>',
					$key,
					plugin_dir_url( PLUGIN_FILE_URL ) .'component/animsition/assets/gif_transition/'.$key.'.gif',
					$value
				);
			endforeach;
		
	}
	public function page_in_transition_callback() {
		?>
		
		<select name="bcanimsition_settings_option[page_in_transition]" id="page_in_transition">
			<option value=""><?php _e( 'None', 'page-transition' );?></option>
			<?php 
			foreach ( $this->get_page_in_transitions() as $key => $value ): 
				printf(
					'<option value="%s" %s>%s</option>',
					$key,
					( isset( $this->bcanimsition_settings_options['page_in_transition'] ) && $this->bcanimsition_settings_options['page_in_transition'] === $key ) ? 'selected="selected"' : '',
					$value
				);
			endforeach;
			?>
		</select>
		<?php
	}
	
	public function page_out_transition_callback() {
		?>
		<select name="bcanimsition_settings_option[page_out_transition]" id="page_out_transition">
			<option value=""><?php _e( 'None', 'page-transition' );?></option>
			<?php 
			foreach ( $this->get_page_out_transitions() as $key => $value ): 
				printf(
					'<option value="%s" %s>%s</option>',
					$key,
					( isset( $this->bcanimsition_settings_options['page_out_transition'] ) && $this->bcanimsition_settings_options['page_out_transition'] === $key ) ? 'selected="selected"' : '',
					$value
				);
			endforeach;
			?>
		</select>
		<?php
	}

	public function page_in_duration_callback(){
		printf(
			'<input type="number" name="bcanimsition_settings_option[page_in_duration]" id="page_in_duration" style="width:70px;" min="200" max="10000" value="%s">',
			( isset( $this->bcanimsition_settings_options['page_in_duration'] ) ) ? $this->bcanimsition_settings_options['page_in_duration'] : '1500'
		);
	}
	public function page_out_duration_callback(){
		printf(
			'<input type="number" name="bcanimsition_settings_option[page_out_duration]" id="page_out_duration" style="width:70px;" min="200" max="10000" value="%s">',
			( isset( $this->bcanimsition_settings_options['page_out_duration'] ) ) ? $this->bcanimsition_settings_options['page_out_duration'] : '800'
		);
	}
	public function color_overlay_callback(){
		printf(
			'<input type="text" name="bcanimsition_settings_option[color_overlay]" id="color_overlay" class="colorpicker" style="width:70px;" value="%s">',
			( isset( $this->bcanimsition_settings_options['color_overlay'] ) ) ? $this->bcanimsition_settings_options['color_overlay'] : '#ffffff'
		);
	}
	public function show_loading_callback(){
		printf(
			'<input type="checkbox" name="bcanimsition_settings_option[show_loading]" id="show_loading" value="true" %s>',
			( isset( $this->bcanimsition_settings_options['show_loading'] ) && $this->bcanimsition_settings_options['show_loading'] === 'true' ) ? 'checked' : ''
		);
				
	}
	public function color_loading_callback(){
		printf(
			'<input type="text" name="bcanimsition_settings_option[color_loading]" id="color_loading" class="colorpicker" style="width:70px;" value="%s">',
			( isset( $this->bcanimsition_settings_options['color_loading'] ) ) ? $this->bcanimsition_settings_options['color_loading'] : '#eeeeee'
		);
	}

    public function admin_enqueue(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }
	
	public function admin_js($hook){
        
		?>
		<script>
			jQuery(document).ready(function($) {
                (function($){
                    $.fn.JKGifPlayer = function(options){
                        
                        $jkgifs = [];
                        
                        let defaults = {
                            autoplay: false,
                            data: "gif",
                            autopause: false,
                            loops: 5
                        }
                        
                        var options = $.extend(defaults, options);
                        
                        function setListeners(container, options){
                            
                            $(container).addClass("jk_gif").prepend([
                                $("<img/>").data("gif", $(container).data(options.data)).data("thumb", "").attr("src", "")
                            ]);
                            
                            LoadGif(container);
                            
                            $(container).mouseover(function(e){
                            
                                $gif = $(this),
                                $img = $gif.children('img').eq(0),
                                $imgSrc = $img.attr('src'),
                                $imgThumb = $img.data('thumb'),
                                $imgGif = $img.data('gif');
                                
                                Play_Stop($gif, $img, $imgSrc, $imgThumb, $imgGif);
                                
                            });
                            $(container).mouseout(function(e){
                            
                                $gif = $(this),
                                $img = $gif.children('img').eq(0),
                                $imgSrc = $img.attr('src'),
                                $imgThumb = $img.data('thumb'),
                                $imgGif = $img.data('gif');
                                
                                Play_Stop($gif, $img, $imgSrc, $imgThumb, $imgGif);
                                
                            });
                        }
                        
                        $.fn.PlayStop_Gif = function(){
                            
                            $gif = $(this),
                            $img = $gif.children('img').eq(0),
                            $imgSrc = $img.attr('src'),
                            $imgThumb = $img.data('thumb'),
                            $imgGif = $img.data('gif');
                            
                            Play_Stop($gif, $img, $imgSrc, $imgThumb, $imgGif);
                            
                        }
                        
                        $.fn.GetSize_Gif = function(){
                            
                            return {
                                width: $(this).children('img').eq(0).data("width"),
                                height: $(this).children('img').eq(0).data("height")
                            };
                            
                        }
                        
                        $.fn.GetHeight_Gif = function(){
                            
                            return $(this).children('img').eq(0).data("height");
                            
                        }
                        
                        $.fn.GetWidth_Gif = function(){
                            
                            return $(this).children('img').eq(0).data("width");
                            
                        }
                        
                        $.fn.GetDuration_Gif = function(){
                            
                            return $(this).children('img').eq(0).data("seconds");
                            
                        }
                        
                        $.fn.GetDurationMili_Gif = function(){
                            
                            return $(this).children('img').eq(0).data("miliseconds");
                            
                        }
                        
                        function Play_Stop($gif, $img, $imgSrc, $imgThumb, $imgGif){
                            
                            if($imgThumb == '' || $imgThumb === undefined){
                                
                                $img.data("thumb", $imgSrc);
                                $img.attr("src", $imgGif);
                                $img.data("gif", "");
                                $gif.addClass('play_gif');
                                
                                $($gif).trigger('play.JK_Gif');
                                
                                if(options.autopause){
                                    DefineTimer($gif, $imgGif, $imgSrc);
                                }
                                
                            }else{
                                
                                $img.data("gif", $imgSrc);
                                $img.attr("src", $imgThumb);
                                $img.data("thumb", "");
                                $gif.removeClass('play_gif');
                                
                                $($gif).trigger('stop.JK_Gif');
                                
                                if(options.autopause){
                                    clearTimeout($jkgifs[GetObjectId($gif)]);
                                }
                                
                            }
                            
                        }
                        
                        function DefineTimer(obj, $gifn, $img, $stop = false){
                            
                            $jkgifs[GetObjectId($(obj))] = setTimeout(function(e){
                                
                                $gif = $(obj),
                                $img = $gif.children('img').eq(0);
                                
                                $img.data("gif", $img.attr("src"));
                                $img.attr("src", $img.data("thumb"));
                                $img.data("thumb", "");
                                $gif.removeClass('play_gif');
                                
                                $(obj).trigger('stop.JK_Gif');
                                
                            }, ($stop ? 0 : (Number($(obj).children('img').eq(0).data("seconds")) * options.loops) * 1000));
                            
                        }
                        
                        function GetObjectId(obj){
                            
                            return ($(obj).attr('id') ?? CreateId(obj, Math.random(50).toString()));
                            
                        }
                        
                        function CreateId(obj, $id){
                            
                            $(obj).attr('id', $id);
                            
                            return $id;
                            
                        }
                        
                        async function LoadGif(obj){
                            
                            await StaticGifImage(obj);
                            
                        }
                        
                        async function StaticGifImage(obj){
                        
                            var image = new Image();

                            image.setAttribute('crossOrigin', 'anonymous');
                            
                            image.src = $(obj).children("img").eq(0).data('gif');
                            
                            image.onload = function(){
                                
                                var canvas = document.createElement('canvas');
                                canvas.height = this.naturalHeight;
                                canvas.width = this.naturalWidth;			
                                canvas.getContext('2d').drawImage(this, 0, 0);
                                    
                                CalculateDuration($(obj).children("img").eq(0), image.src);
                                
                                $(obj).children("img").eq(0).data("width", canvas.width);
                                $(obj).children("img").eq(0).data("height", canvas.height);
                                $(obj).children("img").eq(0).attr("src", canvas.toDataURL());
                                    
                            };
                            
                            await image.decode();
                            
                        }
                        
                        function CalculateDuration(obj, base64){
                    
                        fetch(base64)
                            .then(res => res.arrayBuffer())
                            .then(ab => isGifAnimated(new Uint8Array(ab)))
                            .then(function(s){
                                
                                $duration = s;
                                
                                $(obj).data("seconds", $duration[0]);
                                $(obj).data("miliseconds", $duration[1]);
                                
                            })

                        function isGifAnimated (uint8) {
                            let duration = 0
                            for (let i = 0, len = uint8.length; i < len; i++) {
                            if (uint8[i] == 0x21
                                && uint8[i + 1] == 0xF9
                                && uint8[i + 2] == 0x04
                                && uint8[i + 7] == 0x00) 
                            {
                                const delay = (uint8[i + 5] << 8) | (uint8[i + 4] & 0xFF)
                                duration += delay < 2 ? 10 : delay
                            }
                            }
                            return [duration / 100, duration * 10];
                        }
                        
                        }
                        
                        return this.each(function(i){
                            
                            setListeners(this, options);
                            
                        });
                    };
                })(jQuery);
                $(".gif_page_transition").JKGifPlayer({
                    autoplay: true,
                    autopause: true
                });

				$('.colorpicker').wpColorPicker();
				
				$(".gif_page_transition").on("click", function(e){
					var k = $(this).data('transition');
					if(k == 'fade'){
						$("#page_in_transition").val('fade-in').change();
						$("#page_out_transition").val('fade-out').change();
					}
					if(k == 'fade_up'){
						$("#page_in_transition").val('fade-in-up-sm').change();
						$("#page_out_transition").val('fade-out-up-sm').change();
					}
					if(k == 'fade_down'){
						$("#page_in_transition").val('fade-in-down-sm').change();
						$("#page_out_transition").val('fade-out-down-sm').change();
					}
					if(k == 'slide_top'){
						$("#page_in_transition").val('overlay-slide-in-top').change();
						$("#page_out_transition").val('overlay-slide-out-top').change();
					}
					if(k == 'slide_bottom'){
						$("#page_in_transition").val('overlay-slide-in-bottom').change();
						$("#page_out_transition").val('overlay-slide-out-bottom').change();
					}
					if(k == 'zoom'){
						$("#page_in_transition").val('zoom-in-sm').change();
						$("#page_out_transition").val('zoom-out-sm').change();
					}
				});
			})
		</script>
		<?php
	}

	public function get_page_transitions() {
		return array(
			'fade' => 'Fade',
			'fade_up' => 'Fade Up',
			'fade_down' => 'Fade Down',
			'slide_top' => 'Slide Top',
			'slide_bottom' => 'Slide Bottom',
			'zoom' => 'Zoom',
				
				
		);
	}

	public function get_page_in_transitions() {
		return array(
				'fade-in' => 'Fade In',
				/*'fade-in-up' => 'Fade In Up',
				'fade-in-down' => 'Fade In Down',
				'fade-in-left' => 'Fade In Left',
				'fade-in-right' => 'Fade In Right',*/
				'fade-in-up-sm' => 'Fade In Up',
				'fade-in-down-sm' => 'Fade In Down',
				'fade-in-left-sm' => 'Fade In Left',
				'fade-in-right-sm' => 'Fade In Right',
				'rotate-in' => 'Rotate In',
				'flip-in-x' => 'Flip In X',
				'flip-in-y' => 'Flip In Y',
				//'zoom-in' => 'Zoom In',
				'zoom-in-sm' => 'Zoom In',
				'overlay-slide-in-top' => 'Overlay Slide in Top',
				'overlay-slide-in-bottom' => 'Overlay Slide in Bottom',
				'overlay-slide-in-left' => 'Overlay Slide in Left',
				'overlay-slide-in-right' => 'Overlay Slide in Right',
				'overlay-slide-in-top-bottom' => 'Overlay Slide in Top Bottom',
				
			);
	}
	public function get_page_out_transitions() {
		return array(
				'fade-out' => 'Fade Out',
				/*'fade-out-up' => 'Fade Out Up',
				'fade-out-down' => 'Fade Out Down',
				'fade-out-left' => 'Fade Out Left',
				'fade-out-right' => 'Fade Out Right',*/
				'fade-out-up-sm' => 'Fade Out Up',
				'fade-out-down-sm' => 'Fade Out Down',
				'fade-out-left-sm' => 'Fade Out Left',
				'fade-out-right-sm' => 'Fade Out Right',
				'rotate-out' => 'Rotate Out',
				'flip-out-x' => 'Flip Out X',
				'flip-out-y' => 'Flip Out Y',
				//'zoom-out' => 'Zoom Out',
				'zoom-out-sm' => 'Zoom Out',
				'overlay-slide-out-top' => 'Overlay Slide out Top',
				'overlay-slide-out-bottom' => 'Overlay Slide out Bottom',
				'overlay-slide-out-left' => 'Overlay Slide out Left',
				'overlay-slide-out-right' => 'Overlay Slide out Right',
				'overlay-slide-out-top-bottom' => 'Overlay Slide out Top Bottom',
			);
	}

    public function load_animsition(){
        wp_enqueue_script( 'pagetransition-dist-scripts', plugin_dir_url( PLUGIN_FILE_URL ) . 'component/animsition/assets/animsition.js', array( 'jquery' ),'', false );
        wp_enqueue_style( 'pagetransition-style', plugin_dir_url( PLUGIN_FILE_URL ).'component/animsition/assets/animsition.css');

    }

    public function pagetransition_body_class_names( $classes ) {
		$classes[] = 'animsition';
		return $classes;
	}

    public function pagetransition_head_scripts() {
    ?>
		<style type="text/css">
		<?php if ( empty( $this->bcanimsition_settings_options['page_in_transition'] ) ) { ?>
		    .animsition{opacity: 1;}
		<?php } ?>
        <?php if ( isset( $this->bcanimsition_settings_options['color_loading'] ) ) { ?>
            .animsition-loading {
                border-left: 5px solid <?php echo $this->bcanimsition_settings_options['color_loading']?>;
            }
        <?php }else{ ?>
            .animsition-loading {
                border-left: 5px solid #eee;
            }
        <?php } ?>
        <?php if ( isset( $this->bcanimsition_settings_options['color_overlay'] ) ) { ?>
            .animsition-overlay-slide {
                background-color: <?php echo $this->bcanimsition_settings_options['color_overlay']?>;
            }
        <?php }else{ ?>
            .animsition-overlay-slide {
                background-color: #ddd;
            }
        <?php } ?>
		</style>
		
		<?php
	}
    public function pagetransition_footer_scripts() {
		
        global $wp;
        if ( empty( $_SERVER['QUERY_STRING'] ) ){
            $current_url = trailingslashit( home_url( $wp->request ) );
        }else{
            $current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', trailingslashit( home_url( $wp->request ) ) );
        }
        $overlay = 'false';
        if (
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-top'
            ||
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-bottom'
            ||
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-left'
            ||
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-right'
            ||
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-top-bottom'
            ||
            $this->bcanimsition_settings_options['page_in_transition'] == 'overlay-slide-in-top-bottom fade-in'
            ){
                $overlay = 'true';
            }
        if (
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-top'
            ||
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-bottom'
            ||
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-left'
            ||
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-right'
            ||
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-top-bottom'
            ||
            $this->bcanimsition_settings_options['page_out_transition'] == 'overlay-slide-out-top-bottom fade-out'
            ){
                $overlay = 'true';
            }
            $loading = 'false';
            if( isset( $this->bcanimsition_settings_options['show_loading'] ) && $this->bcanimsition_settings_options['show_loading'] === 'true' ){
                $loading = 'true';
            }
        ?>
		<script type="text/javascript">
		jQuery( 'body' ).wrapInner( '<div class="animsition"></div>' ).removeClass( 'animsition' );
        jQuery(function($){
                

                jQuery( document ).ready( function($) {
                    

                    $('.animsition').animsition({
                        inClass : '<?php echo $this->bcanimsition_settings_options['page_in_transition']; ?>',
                        outClass : '<?php echo $this->bcanimsition_settings_options['page_out_transition']; ?>',
                        inDuration : <?php echo $this->bcanimsition_settings_options['page_in_duration']; ?>,
                        outDuration : <?php echo $this->bcanimsition_settings_options['page_out_duration']; ?>,
                        loading : <?php echo $loading; ?>,
                        touchSupport: false,
                        overlay : <?php echo $overlay; ?>,
                        overlayClass : 'animsition-overlay-slide',
                        linkElement: '.animsition-link, a[href]:not([target="_blank"])a[href]:not([href=""]):not([href^="<?php echo $current_url;?>#"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([class="no-animation"])'
                    });
                });
            })
		</script>
		<?php
	}
}
new BcanimsitionSettings();