<?php
/**
 * ID: wp_login
 * Name: WP Login
 * Description: Modifica il design della pagina login di Wordpress.
 * Icon: dashicons-lock
 * Version: 1.0
 * 
 */

class BCwplogin {

	public function __construct() {	
        add_action('login_head', array($this, 'custom_login_head'));
        add_action('login_footer', array($this, 'custom_login_footer'));
        add_action( 'login_enqueue_scripts', array($this, 'custom_login_scripts'));
        add_filter( 'login_headerurl', array($this, 'custom_loginlogo_url'));
        add_filter( 'login_headertitle', array($this, 'custom_login_title'));
        add_action('wp_before_admin_bar_render', array($this, 'remove_wordpress_admin_logo'), 0);
    }

    public function custom_login_head() {
        ?>
        <style type="text/css">
            /*body{background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%); color: #444;}*/
            body{
                background-color: #fff !important;
                /*
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%235f7b91' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23577286' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%2350687a' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23485f6f' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23415564' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%233c4f5c' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23374855' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%2332424d' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%232d3b46' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%2328353e' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E")  !important;
                */
                background-image: url('<?php echo plugin_dir_url( __FILE__ )?>bg.jpg');
                background-size: cover !important;	
                background-position: center;
            }

            #login{position:relative;}
            .interim-login #login{margin: 0 auto;}
            .login form{background-color: #fff;box-shadow: 0px 0px 16px rgba(0, 0, 0, .5); }
            .login h1 a {background-image: none !important; width: auto !important; height: auto !important; text-indent: 0 !important; color: #02a1fa; }
            .icon_login{
                width: 40px;
                vertical-align: bottom;
            }
            #loginform{
              display: block;
              margin: 0 auto;
              border-radius: 3px;
            }
            
            .login #backtoblog a, .login #nav a {
                text-decoration: none;
                color: #333;
            }

            
            .loading {
              width: 50px;
              height: 50px;
              animation: animate .6s linear infinite;
              top: 0;
              left: 0;
              border-radius: 3px;
              overflow: hidden;
              padding:0;
              display: block;
              margin: 0 auto 13px auto;
              box-shadow: 0px 0px 5px rgba(0, 0, 0, 0);
              background: #3c434a;
            }

            @keyframes animate {
              17% { border-bottom-right-radius: 3px; }
              25% { transform: translateY(9px) rotate(22.5deg); }
              50% {
                transform: translateY(18px) scale(1,.9) rotate(45deg) ;
                border-bottom-right-radius: 40px;
              }
              75% { transform: translateY(9px) rotate(67.5deg); }
              100% { transform: translateY(0) rotate(90deg); }
            } 
            #shadow { 
              width: 50px;
              height: 5px;
              left: 0;
              border-radius: 50%;
              animation: shadow .6s linear infinite;
              display: block;
              margin: 0 auto ;
              background: rgba(0,0,0,0.3);
            }
            @keyframes shadow {
              50% {
                transform: scale(1.2,1);
              }
            }
            
            #bg_preload_top{
              position: fixed;
              top: 0;
              left: 0;
              width: 100vw;
              height: 0vh;
              background-color: #fff;
              transition: all 0.5s cubic-bezier(.215, .61, .355, 1);
              z-index: 8;
            }
            #bg_preload_bottom{
              position: fixed;
              bottom: 0;
              left: 0;
              width: 100vw;
              height: 0vh;
              background-color: #fff;
              transition: all 0.5s cubic-bezier(.215, .61, .355, 1);
              z-index: 8;
            }
            #line{
              height: 1px;
              background-color: #b3b3b3;
              width: 0vw;
              margin: 0 auto;
              transition: all 10s linear;
            }
            #cont_l{
              opacity: 0;
              height: 0;
              overflow: hidden;
              position: fixed;
              top: 50vh;
              left: 50vw;
              transform: translate(-50%,-105px);
              transition: all 0.5s cubic-bezier(.215, .61, .355, 1);
              z-index: 9;
            }
            #cont_l .text{
              font-size: 18px;
              margin-bottom: 20px;
              color: #3c434a;
              animation: text 3s linear infinite;
            }
            @keyframes text {
              50% {
              color: #ccc;
              }
            }
            body.initloading #bg_preload_top,
            body.initloading #bg_preload_bottom{
              height: 50vh;
            }
            body.initloading #line{
              width: 100vw;
              transition-delay: 0.5s;
            }
            body.initloading #cont_l{
              opacity: 1;
              height: 115px;
              transition-delay: 0.5s;
            }
        </style>
        <?php
    }

    public function custom_login_scripts( $page ) {
        
        wp_enqueue_script( 'wplogin_scripts', plugin_dir_url( __FILE__ ).'wplogin.js', array( 'jquery' ), null, true );
    }
    public function custom_loginlogo_url($url) {
        return home_url();
    }
    //* Personalizzare title tag image
    public function custom_login_title() {
        return '<img class="icon_login" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF8xXyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIyNTYiIHkxPSI1MTQiIHgyPSIyNTYiIHkyPSIyIiBncmFkaWVudFRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIC0xIDAgNTE0KSI+DQoJPHN0b3AgIG9mZnNldD0iMCIgc3R5bGU9InN0b3AtY29sb3I6IzJBRjU5OCIvPg0KCTxzdG9wICBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiMwMDlFRkQiLz4NCjwvbGluZWFyR3JhZGllbnQ+DQo8cGF0aCBzdHlsZT0iZmlsbDp1cmwoI1NWR0lEXzFfKTsiIGQ9Ik00MDAsMTg4SDE4Ny45NjN2LTgyLjIzYzAtMzYuMjY2LDMwLjUwNS02NS43Nyw2OC02NS43N3M2OCwyOS41MDQsNjgsNjUuNzdWMTQ0aDQwdi0zOC4yMw0KCWMwLTU4LjMyMi00OC40NDktMTA1Ljc3LTEwOC0xMDUuNzdzLTEwOCw0Ny40NDgtMTA4LDEwNS43N1YxODhIMTEyYy0zMy4wODQsMC02MCwyNi45MTYtNjAsNjB2MjA0YzAsMzMuMDg0LDI2LjkxNiw2MCw2MCw2MGgyODgNCgljMzMuMDg0LDAsNjAtMjYuOTE2LDYwLTYwVjI0OEM0NjAsMjE0LjkxNiw0MzMuMDg0LDE4OCw0MDAsMTg4eiBNNDIwLDQ1MmMwLDExLjAyOC04Ljk3MiwyMC0yMCwyMEgxMTJjLTExLjAyOCwwLTIwLTguOTcyLTIwLTIwDQoJVjI0OGMwLTExLjAyOCw4Ljk3Mi0yMCwyMC0yMGgyODhjMTEuMDI4LDAsMjAsOC45NzIsMjAsMjBWNDUyeiBNMjkzLDMyM0wyOTMsMzIzYzAsMTMuMDgtNi43OTMsMjQuNTY1LTE3LjAzNywzMS4xNDVWMzk4DQoJYzAsMTEuMDQ1LTguOTU1LDIwLTIwLDIwYy0xMS4wNDYsMC0yMC04Ljk1NS0yMC0yMHYtNDMuOTAyQzIyNS43NiwzNDcuNTEsMjE5LDMzNi4wNDgsMjE5LDMyM2wwLDBjMC0yMC40MzUsMTYuNTY1LTM3LDM3LTM3bDAsMA0KCUMyNzYuNDM1LDI4NiwyOTMsMzAyLjU2NSwyOTMsMzIzeiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />Login';
    }
    //* rimuovo logo wp nella admin bar
	public function remove_wordpress_admin_logo() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
  }
  
  public function custom_login_footer(){
    ?>

      <div id="bg_preload_top"></div>
      <div id="bg_preload_bottom">
        <div id="line"></div>
      </div>
      <div id="cont_l">
        <div class="text">Caricamento</div>
        <div class="loading"></div>
        <div id="shadow"></div>
      </div>

    <?php
  }

}
$BCwplogin = new BCwplogin();
